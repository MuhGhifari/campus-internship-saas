<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyPartnership;
use App\Models\InternshipOffer;
use App\Models\InternshipOfferUniversity;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InternshipOfferController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        abort_unless($user->hasRole('mahasiswa') || $user->hasRole('staf') || $user->hasRole('perusahaan'), 403);

        $data = [
            'offers' => InternshipOffer::with(['company', 'applications', 'universityRequests.university'])
                ->when($user->hasRole('mahasiswa'), fn ($query) => $query->whereHas('universityRequests', fn ($request) => $request
                    ->where('university_id', $user->university_id)
                    ->where('status', 'diterima')))
                ->when($user->hasRole('staf'), fn ($query) => $query->whereHas('universityRequests', fn ($request) => $request
                    ->where('university_id', $user->university_id)))
                ->when($user->hasRole('perusahaan'), fn ($query) => $query->where('company_id', $user->company_id))
                ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
                ->latest()
                ->paginate(9),
        ];

        if ($user->hasRole('perusahaan')) {
            $data = [...$data, ...$this->formData($request)];
        }

        return $this->workspaceView($request, 'offers', $data);
    }

    public function create(Request $request): RedirectResponse
    {
        abort_unless($request->user()->hasRole('perusahaan'), 403);

        return redirect()->route('offers.index')->with('open_modal', 'offer-create-modal');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->hasRole('perusahaan'), 403);

        $attributes = $this->validatedOffer($request);
        $user = $request->user();

        $offer = InternshipOffer::create([
            ...$attributes,
            'company_id' => $user->company_id ?: $attributes['company_id'],
            'created_by' => $user->id,
            'status' => $user->hasRole('perusahaan') ? 'menunggu' : $attributes['status'],
        ]);

        $this->syncUniversityRequests($offer, $request, $user);

        $this->notifyUsers(
            User::whereIn('university_id', $offer->universityRequests()->pluck('university_id'))->where('role', 'staf')->get(),
            'Lowongan magang baru perlu ditinjau',
            $offer->company->nama.' mengirim lowongan "'.$offer->judul.'" ke universitas Anda.',
            route('offers.show', $offer),
            'Tinjau Lowongan'
        );

        return redirect()->route('offers.show', $offer)->with('success', 'Lowongan magang berhasil dibuat dan dikirim ke universitas tujuan.');
    }

    public function show(Request $request, InternshipOffer $offer): View
    {
        $user = $request->user();
        abort_unless(
            ($user->hasRole('perusahaan') && $offer->company_id === $user->company_id) ||
            ($user->hasRole('company_supervisor') && $offer->applications()->where('company_supervisor_id', $user->id)->exists()) ||
            ($user->hasRole('university_supervisor') && $offer->applications()->where('campus_supervisor_id', $user->id)->exists()) ||
            ($user->hasRole('staf') && $offer->universityRequests()->where('university_id', $user->university_id)->exists()) ||
            ($user->hasRole('mahasiswa') && $offer->universityRequests()->where('university_id', $user->university_id)->where('status', 'diterima')->exists()),
            403
        );

        $offer->load([
            'company',
            'universityRequests.university',
            'applications' => fn ($query) => $query
                ->with(['student', 'campusSupervisor', 'companySupervisor'])
                ->when($user->hasRole('company_supervisor'), fn ($application) => $application->where('company_supervisor_id', $user->id))
                ->when($user->hasRole('university_supervisor'), fn ($application) => $application->where('campus_supervisor_id', $user->id)),
        ]);

        return $this->workspaceView($request, 'offer-show', [
            'offer' => $offer,
            'lecturers' => User::whereIn('university_id', $offer->universityRequests()->pluck('university_id'))->whereIn('role', ['university_supervisor', 'dosen'])->orderBy('name')->get(),
            'companySupervisors' => User::where('company_id', $offer->company_id)->where('role', 'company_supervisor')->orderBy('name')->get(),
        ]);
    }

    public function edit(Request $request, InternshipOffer $offer): View
    {
        abort_unless($this->canManageOffer($request, $offer), 403);

        return $this->workspaceView($request, 'offer-edit', [
            'offer' => $offer,
            ...$this->formData($request, $offer),
        ]);
    }

    public function update(Request $request, InternshipOffer $offer): RedirectResponse
    {
        abort_unless($this->canManageOffer($request, $offer), 403);

        $attributes = $this->validatedOffer($request);

        if ($request->user()->hasRole('perusahaan')) {
            $attributes['company_id'] = $request->user()->company_id;
            $attributes['status'] = 'menunggu';
        }

        $offer->update($attributes);
        $this->syncUniversityRequests($offer, $request, $request->user());

        $this->notifyUsers(
            User::whereIn('university_id', $offer->universityRequests()->pluck('university_id'))->where('role', 'staf')->get(),
            'Lowongan magang diperbarui',
            $offer->company->nama.' memperbarui lowongan "'.$offer->judul.'".',
            route('offers.show', $offer),
            'Lihat Lowongan'
        );

        return redirect()->route('offers.show', $offer)->with('success', 'Lowongan magang berhasil diperbarui.');
    }

    public function destroy(Request $request, InternshipOffer $offer): RedirectResponse
    {
        abort_unless($this->canManageOffer($request, $offer), 403);

        $offer->delete();

        return redirect()->route('offers.index')->with('success', 'Lowongan magang dihapus.');
    }

    public function reviewUniversityRequest(Request $request, InternshipOfferUniversity $offerRequest): RedirectResponse
    {
        abort_unless($request->user()->hasRole('staf') && $offerRequest->university_id === $request->user()->university_id, 403);

        $attributes = $request->validate([
            'status' => ['required', 'in:diterima,ditolak'],
            'catatan_review' => ['nullable', 'string'],
        ]);

        $offerRequest->update([
            ...$attributes,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        if ($attributes['status'] === 'diterima') {
            $offerRequest->offer->update(['status' => 'terbit']);
        }

        $offerRequest->load(['offer.company', 'university']);
        $this->notifyUsers(
            User::where('company_id', $offerRequest->offer->company_id)->where('role', 'perusahaan')->get(),
            'Status review lowongan diperbarui',
            $offerRequest->university->nama.' '.$attributes['status'].' lowongan "'.$offerRequest->offer->judul.'".',
            route('offers.show', $offerRequest->offer),
            'Lihat Lowongan'
        );

        if ($attributes['status'] === 'diterima') {
            $this->notifyUsers(
                User::where('university_id', $offerRequest->university_id)->where('role', 'mahasiswa')->get(),
                'Lowongan magang baru tersedia',
                'Lowongan "'.$offerRequest->offer->judul.'" dari '.$offerRequest->offer->company->nama.' sekarang tersedia untuk kampus Anda.',
                route('offers.show', $offerRequest->offer),
                'Lihat Lowongan'
            );
        }

        return back()->with('success', 'Status review posisi berhasil diperbarui.');
    }

    private function validatedOffer(Request $request): array
    {
        return $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'university_ids' => ['required', 'array', 'min:1'],
            'university_ids.*' => ['exists:universities,id'],
            'judul' => ['required', 'string', 'max:255'],
            'bidang' => ['required', 'string', 'max:120'],
            'lokasi' => ['required', 'string', 'max:160'],
            'tipe_kerja' => ['required', 'in:onsite,remote,hybrid'],
            'kuota' => ['required', 'integer', 'min:1', 'max:200'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'batas_lamaran' => ['nullable', 'date'],
            'deskripsi' => ['required', 'string'],
            'persyaratan' => ['nullable', 'string'],
            'benefit' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,menunggu,terbit,ditutup'],
        ]);
    }

    private function formData(Request $request, ?InternshipOffer $offer = null): array
    {
        $user = $request->user();
        $companyId = $user->company_id ?: $offer?->company_id;

        return [
            'companies' => $user->hasRole('perusahaan')
                ? Company::where('id', $user->company_id)->get()
                : Company::orderBy('nama')->get(),
            'universities' => $companyId
                ? University::whereHas('partneredCompanies', fn ($query) => $query->where('companies.id', $companyId)->where('company_partnerships.status', 'diterima'))->orderBy('nama')->get()
                : University::orderBy('nama')->get(),
            'selectedUniversities' => $offer?->universityRequests->pluck('university_id')->all() ?? [],
        ];
    }

    private function canManageOffer(Request $request, InternshipOffer $offer): bool
    {
        $user = $request->user();

        if ($user->hasRole('perusahaan')) {
            return $offer->company_id === $user->company_id;
        }

        return false;
    }

    private function syncUniversityRequests(InternshipOffer $offer, Request $request, User $user): void
    {
        $universityIds = collect($request->input('university_ids', []))->map(fn ($id) => (int) $id)->unique();
        $companyId = $offer->company_id;

        $allowedUniversityIds = CompanyPartnership::where('company_id', $companyId)
            ->where('status', 'diterima')
            ->whereIn('university_id', $universityIds)
            ->pluck('university_id');

        foreach ($allowedUniversityIds as $universityId) {
            InternshipOfferUniversity::firstOrCreate([
                'internship_offer_id' => $offer->id,
                'university_id' => $universityId,
            ], [
                'requested_by' => $user->id,
                'status' => 'menunggu',
            ]);
        }
    }
}
