<?php

namespace App\Http\Controllers;

use App\Models\InternshipApplication;
use App\Models\LogbookEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogbookEntryController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('logbooks.index', [
            'logbooks' => LogbookEntry::with(['application.offer.company', 'student'])
                ->when($user->hasRole('mahasiswa'), fn ($query) => $query->where('student_id', $user->id))
                ->when($user->hasRole('dosen'), fn ($query) => $query->whereHas('application', fn ($application) => $application->where('campus_supervisor_id', $user->id)))
                ->when($user->hasRole('perusahaan'), fn ($query) => $query->whereHas('application.offer', fn ($offer) => $offer->where('company_id', $user->company_id)))
                ->latest('tanggal')
                ->paginate(12),
            'activeApplication' => InternshipApplication::with('offer.company')
                ->where('student_id', $user->id)
                ->whereIn('status', ['diterima', 'berjalan'])
                ->latest()
                ->first(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->hasRole('mahasiswa'), 403);

        $attributes = $request->validate([
            'internship_application_id' => ['required', 'exists:internship_applications,id'],
            'tanggal' => ['required', 'date'],
            'judul_kegiatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'min:10'],
            'kendala' => ['nullable', 'string'],
        ]);

        $application = InternshipApplication::findOrFail($attributes['internship_application_id']);
        abort_unless($application->student_id === $request->user()->id, 403);

        LogbookEntry::create([
            ...$attributes,
            'student_id' => $request->user()->id,
            'status' => 'menunggu',
        ]);

        return back()->with('success', 'Logbook harian berhasil dikirim.');
    }

    public function update(Request $request, LogbookEntry $logbook): RedirectResponse
    {
        $user = $request->user();
        abort_unless(
            ($user->hasRole('dosen') && $logbook->application->campus_supervisor_id === $user->id) ||
            ($user->hasRole('perusahaan') && $logbook->application->offer->company_id === $user->company_id),
            403
        );

        $attributes = $request->validate([
            'status' => ['required', 'in:menunggu,disetujui,revisi'],
            'catatan_pembimbing' => ['nullable', 'string'],
        ]);

        $logbook->update($attributes);

        return back()->with('success', 'Logbook berhasil ditinjau.');
    }
}
