<?php

namespace App\Http\Controllers;

use App\Models\InternshipApplication;
use App\Models\InternshipOffer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
                ->when($user->hasRole('perusahaan'), fn ($query) => $query->whereHas('offer', fn ($offer) => $offer->where('company_id', $user->company_id)))
                ->when($user->hasRole('staf'), fn ($query) => $query->whereHas('offer.universityRequests', fn ($offerRequest) => $offerRequest->where('university_id', $user->university_id)))
                ->latest()
                ->paginate(10),
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
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
            'surat_pengantar' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
        ]);

        InternshipApplication::create([
            'internship_offer_id' => $offer->id,
            'student_id' => $request->user()->id,
            'status' => 'diajukan',
            'motivasi' => $attributes['motivasi'],
            'resume_path' => $request->file('resume')?->store('dokumen-magang', 'public'),
            'surat_pengantar_path' => $request->file('surat_pengantar')?->store('dokumen-magang', 'public'),
        ]);

        return redirect()->route('applications.index')->with('success', 'Lamaran berhasil dikirim.');
    }

    public function update(Request $request, InternshipApplication $application): RedirectResponse
    {
        $user = $request->user();
        abort_unless(
            ($user->hasRole('staf') && $application->offer->universityRequests()->where('university_id', $user->university_id)->exists()) ||
            ($user->hasRole('perusahaan') && $application->offer->company_id === $user->company_id),
            403
        );

        $attributes = $request->validate([
            'status' => ['required', 'in:diajukan,diseleksi,wawancara,diterima,ditolak,berjalan,selesai'],
            'campus_supervisor_id' => ['nullable', 'exists:users,id'],
            'company_supervisor_id' => ['nullable', 'exists:users,id'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        if ($attributes['status'] === 'diterima' && $application->diterima_pada === null) {
            $attributes['diterima_pada'] = now();
        }

        $application->update($attributes);

        return back()->with('success', 'Status lamaran berhasil diperbarui.');
    }
}
