<?php

namespace App\Http\Controllers;

use App\Models\CompanyPartnership;
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
            ->when($user->hasRole('mahasiswa'), fn ($query) => $query->where('student_id', $user->id))
            ->when($user->hasRole('dosen'), fn ($query) => $query->where('campus_supervisor_id', $user->id))
            ->when($user->hasRole('company_supervisor'), fn ($query) => $query->where('company_supervisor_id', $user->id))
            ->when($user->hasRole('perusahaan'), fn ($query) => $query->whereHas('offer', fn ($offer) => $offer->where('company_id', $user->company_id)))
            ->when($user->hasRole('staf'), fn ($query) => $query->whereHas('offer.universityRequests', fn ($offerRequest) => $offerRequest->where('university_id', $universityId)))
            ->latest()
            ->limit(8)
            ->get();

        if ($user->hasRole('company_supervisor')) {
            $assignedApplications = InternshipApplication::where('company_supervisor_id', $user->id);
            $assignedOfferIds = (clone $assignedApplications)->pluck('internship_offer_id');

            return $this->workspaceView($request, 'dashboard', [
                'totalOffers' => $assignedOfferIds->unique()->count(),
                'publishedOffers' => InternshipOffer::whereIn('id', $assignedOfferIds)->whereHas('universityRequests', fn ($offerRequest) => $offerRequest->where('status', 'diterima'))->count(),
                'totalApplications' => (clone $assignedApplications)->count(),
                'acceptedApplications' => (clone $assignedApplications)->where('status', 'diterima')->count(),
                'companies' => 1,
                'students' => (clone $assignedApplications)->distinct('student_id')->count('student_id'),
                'logbooksWaiting' => LogbookEntry::whereHas('application', fn ($application) => $application->where('company_supervisor_id', $user->id))->where('status', 'done')->whereNull('score')->count(),
                'applications' => $applications,
                'upcomingOffers' => InternshipOffer::with('company')
                    ->whereIn('id', $assignedOfferIds)
                    ->orderBy('batas_lamaran')
                    ->limit(5)
                    ->get(),
            ]);
        }

        if ($user->hasRole('university_supervisor')) {
            $assignedApplications = InternshipApplication::where('campus_supervisor_id', $user->id);
            $assignedOfferIds = (clone $assignedApplications)->pluck('internship_offer_id');

            return $this->workspaceView($request, 'dashboard', [
                'totalOffers' => $assignedOfferIds->unique()->count(),
                'publishedOffers' => InternshipOffer::whereIn('id', $assignedOfferIds)->whereHas('universityRequests', fn ($offerRequest) => $offerRequest->where('status', 'diterima'))->count(),
                'totalApplications' => (clone $assignedApplications)->count(),
                'acceptedApplications' => (clone $assignedApplications)->where('status', 'diterima')->count(),
                'companies' => InternshipOffer::whereIn('id', $assignedOfferIds)->distinct('company_id')->count('company_id'),
                'students' => (clone $assignedApplications)->distinct('student_id')->count('student_id'),
                'logbooksWaiting' => LogbookEntry::whereHas('application', fn ($application) => $application->where('campus_supervisor_id', $user->id))->where('status', 'done')->whereNull('score')->count(),
                'applications' => $applications,
                'upcomingOffers' => InternshipOffer::with('company')
                    ->whereIn('id', $assignedOfferIds)
                    ->orderBy('batas_lamaran')
                    ->limit(5)
                    ->get(),
            ]);
        }

        if ($user->hasRole('perusahaan')) {
            return $this->workspaceView($request, 'dashboard', [
                'totalOffers' => InternshipOffer::where('company_id', $user->company_id)->count(),
                'publishedOffers' => InternshipOffer::where('company_id', $user->company_id)->whereHas('universityRequests', fn ($offerRequest) => $offerRequest->where('status', 'diterima'))->count(),
                'totalApplications' => InternshipApplication::whereHas('offer', fn ($offer) => $offer->where('company_id', $user->company_id))->count(),
                'acceptedApplications' => InternshipApplication::whereHas('offer', fn ($offer) => $offer->where('company_id', $user->company_id))->where('status', 'diterima')->count(),
                'companies' => CompanyPartnership::where('company_id', $user->company_id)->where('status', 'diterima')->count(),
                'students' => InternshipApplication::whereHas('offer', fn ($offer) => $offer->where('company_id', $user->company_id))->distinct('student_id')->count('student_id'),
                'logbooksWaiting' => LogbookEntry::whereHas('application.offer', fn ($offer) => $offer->where('company_id', $user->company_id))->where('status', 'done')->whereNull('score')->count(),
                'applications' => $applications,
                'upcomingOffers' => InternshipOffer::with('company')
                    ->where('company_id', $user->company_id)
                    ->orderBy('batas_lamaran')
                    ->limit(5)
                    ->get(),
            ]);
        }

        return $this->workspaceView($request, 'dashboard', [
            'totalOffers' => InternshipOffer::whereHas('universityRequests', fn ($offerRequest) => $offerRequest->where('university_id', $universityId))->count(),
            'publishedOffers' => InternshipOffer::whereHas('universityRequests', fn ($offerRequest) => $offerRequest->where('university_id', $universityId)->where('status', 'diterima'))->count(),
            'totalApplications' => InternshipApplication::whereHas('offer.universityRequests', fn ($offerRequest) => $offerRequest->where('university_id', $universityId))->count(),
            'acceptedApplications' => InternshipApplication::whereHas('offer.universityRequests', fn ($offerRequest) => $offerRequest->where('university_id', $universityId))->where('status', 'diterima')->count(),
            'companies' => CompanyPartnership::where('university_id', $universityId)->where('status', 'diterima')->count(),
            'students' => User::where('university_id', $universityId)->where('role', 'mahasiswa')->count(),
            'logbooksWaiting' => LogbookEntry::whereHas('application.offer.universityRequests', fn ($offerRequest) => $offerRequest->where('university_id', $universityId))->where('status', 'done')->whereNull('score')->count(),
            'applications' => $applications,
            'upcomingOffers' => InternshipOffer::with('company')
                ->whereHas('universityRequests', fn ($offerRequest) => $offerRequest->where('university_id', $universityId)->where('status', 'diterima'))
                ->orderBy('batas_lamaran')
                ->limit(5)
                ->get(),
        ]);
    }
}
