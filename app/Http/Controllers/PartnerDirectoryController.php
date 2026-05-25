<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnerDirectoryController extends Controller
{
    public function companies(Request $request): View
    {
        $user = $request->user();
        abort_unless($user->hasRole('staf'), 403);

        $companies = Company::withCount(['offers', 'partnerships'])
            ->with(['partnerships' => fn ($query) => $query->where('university_id', $user->university_id)])
            ->when($request->filled('q'), fn ($query) => $query->where(function ($company) use ($request) {
                $company->where('nama', 'like', '%'.$request->q.'%')
                    ->orWhere('industri', 'like', '%'.$request->q.'%');
            }))
            ->when($request->filled('status'), fn ($query) => $query->whereHas('partnerships', fn ($partnership) => $partnership
                ->where('university_id', $user->university_id)
                ->where('status', $request->status)))
            ->orderBy('nama')
            ->paginate(9)
            ->withQueryString();

        return $this->workspaceView($request, 'companies', [
            'companies' => $companies,
        ]);
    }

    public function universities(Request $request): View
    {
        $user = $request->user();
        abort_unless($user->hasRole('perusahaan'), 403);

        $universities = University::withCount([
            'users as students_count' => fn ($query) => $query->where('role', 'mahasiswa'),
            'offerRequests',
        ])
            ->with(['offerRequests', 'partneredCompanies' => fn ($query) => $query->where('companies.id', $user->company_id)])
            ->when($request->filled('q'), fn ($query) => $query->where(function ($university) use ($request) {
                $university->where('nama', 'like', '%'.$request->q.'%')
                    ->orWhere('kode', 'like', '%'.$request->q.'%')
                    ->orWhere('alamat', 'like', '%'.$request->q.'%');
            }))
            ->when($request->filled('status'), fn ($query) => $query->whereHas('partneredCompanies', fn ($partnership) => $partnership
                ->where('companies.id', $user->company_id)
                ->where('company_partnerships.status', $request->status)))
            ->orderBy('nama')
            ->paginate(9)
            ->withQueryString();

        return $this->workspaceView($request, 'universities', [
            'universities' => $universities,
        ]);
    }
}
