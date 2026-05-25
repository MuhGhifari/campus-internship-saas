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
        abort_unless($user->hasAnyRole(['mahasiswa', 'staf', 'company_supervisor', 'university_supervisor']), 403);

        return $this->workspaceView($request, 'logbooks', [
            'logbooks' => LogbookEntry::with(['application.offer.company', 'application.campusSupervisor', 'application.companySupervisor', 'student', 'assignedBy'])
                ->when($user->hasRole('mahasiswa'), fn ($query) => $query->where('student_id', $user->id))
                ->when($user->hasRole('dosen'), fn ($query) => $query->whereHas('application', fn ($application) => $application->where('campus_supervisor_id', $user->id)))
                ->when($user->hasRole('company_supervisor'), fn ($query) => $query->whereHas('application', fn ($application) => $application->where('company_supervisor_id', $user->id)))
                ->when($user->hasRole('staf'), fn ($query) => $query->whereHas('application.offer.universityRequests', fn ($offerRequest) => $offerRequest->where('university_id', $user->university_id)))
                ->latest()
                ->paginate(12),
            'assignableApplications' => InternshipApplication::with(['offer.company', 'student'])
                ->whereIn('status', ['diterima', 'berjalan'])
                ->when($user->hasRole('company_supervisor'), fn ($query) => $query->where('company_supervisor_id', $user->id))
                ->when($user->hasRole('mahasiswa'), fn ($query) => $query->where('student_id', $user->id))
                ->when($user->hasRole('dosen'), fn ($query) => $query->where('campus_supervisor_id', $user->id))
                ->when($user->hasRole('staf'), fn ($query) => $query->whereHas('offer.universityRequests', fn ($offerRequest) => $offerRequest->where('university_id', $user->university_id)))
                ->latest()
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->hasRole('company_supervisor'), 403);

        $attributes = $request->validate([
            'internship_application_id' => ['required', 'exists:internship_applications,id'],
            'judul_kegiatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'min:10'],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $application = InternshipApplication::with(['offer.company', 'student', 'campusSupervisor', 'companySupervisor'])->findOrFail($attributes['internship_application_id']);
        abort_unless($application->company_supervisor_id === $request->user()->id, 403);
        abort_unless(in_array($application->status, ['diterima', 'berjalan'], true), 403);

        $task = LogbookEntry::create([
            ...$attributes,
            'student_id' => $application->student_id,
            'assigned_by_id' => $request->user()->id,
            'tanggal' => now()->toDateString(),
            'status' => 'todo',
        ]);

        $this->notifyUsers(
            [$application->student, $application->campusSupervisor],
            'Tugas magang baru',
            $request->user()->name.' menugaskan "'.$task->judul_kegiatan.'" untuk '.$application->offer->judul.'.',
            route('logbooks.index'),
            'Lihat Tugas'
        );

        return back()->with('success', 'Tugas magang berhasil diberikan ke mahasiswa.');
    }

    public function update(Request $request, LogbookEntry $logbook): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasRole('mahasiswa')) {
            abort_unless($logbook->student_id === $user->id, 403);

            $attributes = $request->validate([
                'status' => ['required', 'in:todo,in_progress,done'],
                'kendala' => ['nullable', 'string'],
            ]);

            if ($attributes['status'] === 'done' && $logbook->completed_at === null) {
                $attributes['completed_at'] = now();
            }

            if ($attributes['status'] !== 'done') {
                $attributes['completed_at'] = null;
                $attributes['score'] = null;
                $attributes['score_notes'] = null;
            }

            $logbook->update($attributes);

            $logbook->load(['application.offer', 'application.campusSupervisor', 'assignedBy']);
            $this->notifyUsers(
                [$logbook->assignedBy, $logbook->application->campusSupervisor],
                'Status tugas diperbarui',
                $user->name.' mengubah tugas "'.$logbook->judul_kegiatan.'" menjadi '.str_replace('_', ' ', $attributes['status']).'.',
                route('logbooks.index'),
                'Lihat Tugas'
            );

            return back()->with('success', 'Status tugas berhasil diperbarui.');
        }

        abort_unless($user->hasRole('company_supervisor') && $logbook->application->company_supervisor_id === $user->id, 403);

        $attributes = $request->validate([
            'score' => ['required', 'integer', 'min:0', 'max:100'],
            'score_notes' => ['nullable', 'string'],
            'catatan_pembimbing' => ['nullable', 'string'],
        ]);

        if ($logbook->status !== 'done') {
            return back()->withErrors(['score' => 'Nilai hanya bisa diberikan setelah mahasiswa menandai tugas sebagai selesai.']);
        }

        $logbook->update($attributes);

        $logbook->load(['application.offer', 'student', 'application.campusSupervisor']);
        $this->notifyUsers(
            [$logbook->student, $logbook->application->campusSupervisor],
            'Nilai tugas sudah diberikan',
            $user->name.' memberi nilai '.$attributes['score'].' untuk tugas "'.$logbook->judul_kegiatan.'".',
            route('logbooks.index'),
            'Lihat Nilai'
        );

        return back()->with('success', 'Nilai tugas berhasil disimpan.');
    }
}
