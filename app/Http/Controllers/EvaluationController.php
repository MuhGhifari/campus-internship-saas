<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\InternshipApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EvaluationController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return $this->workspaceView($request, 'evaluations', [
            'applications' => InternshipApplication::with(['offer.company', 'student', 'campusSupervisor', 'companySupervisor', 'evaluation'])
                ->whereIn('status', ['berjalan', 'selesai', 'diterima'])
                ->when($user->hasRole('dosen'), fn ($query) => $query->where('campus_supervisor_id', $user->id))
                ->when($user->hasRole('perusahaan'), fn ($query) => $query->whereHas('offer', fn ($offer) => $offer->where('company_id', $user->company_id)))
                ->when($user->hasRole('staf'), fn ($query) => $query->whereHas('offer.universityRequests', fn ($offerRequest) => $offerRequest->where('university_id', $user->university_id)))
                ->when($user->hasRole('mahasiswa'), fn ($query) => $query->where('student_id', $user->id))
                ->latest()
                ->paginate(10),
        ]);
    }

    public function store(Request $request, InternshipApplication $application): RedirectResponse
    {
        $user = $request->user();
        abort_unless(
            ($user->hasRole('dosen') && $application->campus_supervisor_id === $user->id) ||
            ($user->hasRole('perusahaan') && $application->offer->company_id === $user->company_id),
            403
        );

        $attributes = $request->validate([
            'nilai_komunikasi' => ['required', 'integer', 'min:0', 'max:100'],
            'nilai_kedisiplinan' => ['required', 'integer', 'min:0', 'max:100'],
            'nilai_teknis' => ['required', 'integer', 'min:0', 'max:100'],
            'nilai_kerja_sama' => ['required', 'integer', 'min:0', 'max:100'],
            'catatan' => ['nullable', 'string'],
        ]);

        Evaluation::updateOrCreate([
            'internship_application_id' => $application->id,
            'evaluator_id' => $user->id,
            'tipe' => $user->hasRole('dosen') ? 'kampus' : 'perusahaan',
        ], $attributes);

        return back()->with('success', 'Evaluasi magang berhasil disimpan.');
    }
}
