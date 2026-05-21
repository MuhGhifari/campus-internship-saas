<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\InternshipApplication;
use App\Models\InternshipOffer;
use App\Models\LogbookEntry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $universityId = $user->university_id;

        $applications = InternshipApplication::query()
            ->with(['offer.company', 'student', 'campusSupervisor', 'companySupervisor'])
            ->when($user->is('mahasiswa'), fn ($query) => $query->where('student_id', $user->id))
            ->when($user->is('dosen'), fn ($query) => $query->where('campus_supervisor_id', $user->id))
            ->when($user->is('perusahaan'), fn ($query) => $query->whereHas('offer', fn ($offer) => $offer->where('company_id', $user->company_id)))
            ->when($user->is('staf'), fn ($query) => $query->whereHas('offer', fn ($offer) => $offer->where('university_id', $universityId)))
            ->latest()
            ->limit(8)
            ->get();

        return view('dashboard', [
            'totalOffers' => InternshipOffer::where('university_id', $universityId)->count(),
            'publishedOffers' => InternshipOffer::where('university_id', $universityId)->where('status', 'terbit')->count(),
            'totalApplications' => InternshipApplication::whereHas('offer', fn ($offer) => $offer->where('university_id', $universityId))->count(),
            'acceptedApplications' => InternshipApplication::whereHas('offer', fn ($offer) => $offer->where('university_id', $universityId))->where('status', 'diterima')->count(),
            'companies' => Company::where('university_id', $universityId)->count(),
            'students' => User::where('university_id', $universityId)->where('role', 'mahasiswa')->count(),
            'logbooksWaiting' => LogbookEntry::whereHas('application.offer', fn ($offer) => $offer->where('university_id', $universityId))->where('status', 'menunggu')->count(),
            'applications' => $applications,
            'upcomingOffers' => InternshipOffer::with('company')
                ->where('university_id', $universityId)
                ->where('status', 'terbit')
                ->orderBy('batas_lamaran')
                ->limit(5)
                ->get(),
        ]);
    }
}
