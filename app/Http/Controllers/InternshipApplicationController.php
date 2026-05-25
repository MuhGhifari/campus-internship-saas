<?php

namespace App\Http\Controllers;

use App\Models\InternshipApplication;
use App\Models\InternshipOffer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InternshipApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return $this->workspaceView($request, 'applications', [
            'applications' => InternshipApplication::with(['offer.company', 'student', 'campusSupervisor', 'companySupervisor'])
                ->when($user->hasRole('mahasiswa'), fn ($query) => $query->where('student_id', $user->id))
                ->when($user->hasRole('dosen'), fn ($query) => $query->where('campus_supervisor_id', $user->id))
                ->when($user->hasRole('company_supervisor'), fn ($query) => $query->where('company_supervisor_id', $user->id))
                ->when($user->hasRole('perusahaan'), fn ($query) => $query->whereHas('offer', fn ($offer) => $offer->where('company_id', $user->company_id)))
                ->when($user->hasRole('staf'), fn ($query) => $query->whereHas('offer.universityRequests', fn ($offerRequest) => $offerRequest->where('university_id', $user->university_id)))
                ->latest()
                ->paginate(10),
            'lecturers' => $user->hasRole('staf')
                ? User::where('university_id', $user->university_id)->whereIn('role', ['university_supervisor', 'dosen'])->orderBy('name')->get()
                : collect(),
        ]);
    }

    public function store(Request $request, InternshipOffer $offer): RedirectResponse
    {
        abort_unless($request->user()->hasRole('mahasiswa'), 403);
        abort_unless($offer->universityRequests()->where('university_id', $request->user()->university_id)->where('status', 'diterima')->exists(), 403);

        if (InternshipApplication::where('internship_offer_id', $offer->id)->where('student_id', $request->user()->id)->exists()) {
            return back()->withErrors(['offer' => 'Anda sudah mengirim lamaran untuk posisi ini.']);
        }

        $attributes = $request->validate([
            'motivasi' => ['required', 'string', 'min:20'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:4096'],
            'surat_pengantar' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:4096'],
        ], [
            'motivasi.min' => 'Motivasi minimal harus berisi 20 karakter.',
            'resume.mimes' => 'CV harus berupa PDF, Word, JPG, atau PNG.',
            'surat_pengantar.mimes' => 'Surat pengantar harus berupa PDF, Word, JPG, atau PNG.',
        ]);

        $application = InternshipApplication::create([
            'internship_offer_id' => $offer->id,
            'student_id' => $request->user()->id,
            'status' => 'diajukan',
            'motivasi' => $attributes['motivasi'],
            'resume_path' => $request->file('resume')?->store('dokumen-magang', 'public'),
            'surat_pengantar_path' => $request->file('surat_pengantar')?->store('dokumen-magang', 'public'),
        ]);

        $this->notifyUsers(
            User::where('company_id', $offer->company_id)->where('role', 'perusahaan')->get(),
            'Lamaran magang baru',
            $request->user()->name.' mengirim lamaran untuk "'.$offer->judul.'".',
            route('applications.index'),
            'Tinjau Lamaran'
        );

        return redirect()->route('applications.index')->with('success', 'Lamaran berhasil dikirim.');
    }

    public function update(Request $request, InternshipApplication $application): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasRole('staf')) {
            return $this->assignCampusSupervisor($request, $application);
        }

        abort_unless($user->hasRole('perusahaan') && $application->offer->company_id === $user->company_id, 403);

        $supervisorIds = User::where('company_id', $application->offer->company_id)
            ->where('role', 'company_supervisor')
            ->pluck('id');
        $targetNeedsCompanySupervisor = in_array($request->input('status'), ['diterima', 'berjalan', 'selesai'], true)
            && in_array($application->status, ['diterima', 'berjalan', 'selesai'], true);

        $attributes = $request->validate([
            'status' => ['required', 'in:diajukan,diseleksi,wawancara,diterima,ditolak,berjalan,selesai'],
            'company_supervisor_id' => [
                Rule::requiredIf($targetNeedsCompanySupervisor),
                'nullable',
                Rule::in($supervisorIds->all()),
            ],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        if (! $targetNeedsCompanySupervisor) {
            unset($attributes['company_supervisor_id']);
        }

        if ($attributes['status'] === 'diterima' && $application->diterima_pada === null) {
            $attributes['diterima_pada'] = now();
        }

        $application->update($attributes);

        $application->load(['student', 'offer.company', 'campusSupervisor', 'companySupervisor']);

        if ($attributes['status'] === 'diterima') {
            $this->notifyUsers(
                [$application->student],
                'Selamat, lamaran magang Anda diterima',
                'Lamaran Anda untuk posisi "'.$application->offer->judul.'" di '.$application->offer->company->nama.' sudah diterima. Silakan cek detail periode dan pembimbing di dashboard CareerBridge.',
                route('applications.index'),
                'Lihat Lamaran'
            );

            $this->notifyUsers(
                [$application->campusSupervisor, $application->companySupervisor],
                'Mahasiswa bimbingan baru',
                $application->student->name.' diterima untuk posisi "'.$application->offer->judul.'" di '.$application->offer->company->nama.'.',
                route('applications.index'),
                'Lihat Mahasiswa'
            );
        } else {
            $this->notifyUsers(
                [$application->student, $application->campusSupervisor, $application->companySupervisor],
                'Status lamaran diperbarui',
                'Status lamaran '.$application->student->name.' untuk "'.$application->offer->judul.'" berubah menjadi '.$attributes['status'].'.',
                route('applications.index'),
                'Lihat Lamaran'
            );
        }

        return back()->with('success', 'Status lamaran berhasil diperbarui.');
    }

    private function assignCampusSupervisor(Request $request, InternshipApplication $application): RedirectResponse
    {
        $user = $request->user();

        abort_unless(
            $application->student->university_id === $user->university_id
            && $application->offer->universityRequests()->where('university_id', $user->university_id)->exists(),
            403
        );

        $lecturerIds = User::where('university_id', $user->university_id)
            ->whereIn('role', ['university_supervisor', 'dosen'])
            ->pluck('id');

        $attributes = $request->validate([
            'campus_supervisor_id' => ['required', Rule::in($lecturerIds->all())],
        ]);

        $application->update($attributes);
        $application->load(['student', 'offer.company', 'campusSupervisor']);

        $this->notifyUsers(
            [$application->student, $application->campusSupervisor],
            'Pembimbing kampus ditugaskan',
            $application->campusSupervisor->name.' ditugaskan sebagai pembimbing kampus untuk lamaran '.$application->student->name.'.',
            route('applications.index'),
            'Lihat Lamaran'
        );

        return back()->with('success', 'Pembimbing kampus berhasil ditugaskan.');
    }
}
