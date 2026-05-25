<?php

namespace App\Http\Controllers;

use App\Models\CompanyPartnership;
use App\Models\Company;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnershipController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        abort_unless($user->hasRole('perusahaan') || $user->hasRole('staf'), 403);

        return $this->workspaceView($request, 'partnerships', [
            'partnerships' => CompanyPartnership::with(['company', 'university', 'requester', 'reviewer'])
                ->when($user->hasRole('perusahaan'), fn ($query) => $query->where('company_id', $user->company_id))
                ->when($user->hasRole('staf'), fn ($query) => $query->where('university_id', $user->university_id))
                ->latest()
                ->paginate(12),
            'companies' => Company::orderBy('nama')->get(),
            'universities' => University::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user->hasRole('perusahaan') || $user->hasRole('staf'), 403);

        $rules = [
            'pesan' => ['nullable', 'string'],
        ];

        if ($user->hasRole('perusahaan')) {
            $rules['university_id'] = ['required', 'exists:universities,id'];
        } else {
            $rules['company_id'] = ['required', 'exists:companies,id'];
        }

        $attributes = $request->validate($rules);
        $companyId = $user->hasRole('perusahaan') ? $user->company_id : (int) $attributes['company_id'];
        $universityId = $user->hasRole('staf') ? $user->university_id : (int) $attributes['university_id'];

        $partnership = CompanyPartnership::updateOrCreate([
            'company_id' => $companyId,
            'university_id' => $universityId,
        ], [
            'requested_by' => $user->id,
            'status' => 'menunggu',
            'pesan' => $attributes['pesan'] ?? null,
            'reviewed_by' => null,
            'catatan_review' => null,
            'reviewed_at' => null,
        ]);

        if ($user->hasRole('perusahaan')) {
            $this->notifyUsers(
                User::where('university_id', $universityId)->where('role', 'staf')->get(),
                'Proposal kemitraan baru',
                $user->company->nama.' mengirim proposal kerja sama ke universitas Anda.',
                route('partnerships.index'),
                'Tinjau Proposal'
            );
        } else {
            $this->notifyUsers(
                User::where('company_id', $companyId)->where('role', 'perusahaan')->get(),
                'Proposal kemitraan baru',
                $user->university->nama.' mengirim proposal kerja sama ke perusahaan Anda.',
                route('partnerships.index'),
                'Tinjau Proposal'
            );
        }

        return redirect()
            ->route('partnerships.index')
            ->with('success', $user->hasRole('perusahaan')
                ? 'Proposal kerja sama berhasil dikirim ke staf universitas.'
                : 'Proposal kerja sama berhasil dikirim ke perusahaan.');
    }

    public function update(Request $request, CompanyPartnership $partnership): RedirectResponse
    {
        $user = $request->user();
        abort_unless(
            ($user->hasRole('staf') && $partnership->university_id === $user->university_id) ||
            ($user->hasRole('perusahaan') && $partnership->company_id === $user->company_id),
            403
        );

        $attributes = $request->validate([
            'status' => ['required', 'in:diterima,ditolak'],
            'catatan_review' => ['nullable', 'string'],
        ]);

        $partnership->update([
            ...$attributes,
            'reviewed_by' => $user->id,
            'reviewed_at' => now(),
        ]);

        if ($user->hasRole('staf')) {
            $this->notifyUsers(
                User::where('company_id', $partnership->company_id)->where('role', 'perusahaan')->get(),
                'Status kemitraan diperbarui',
                $user->university->nama.' '.$attributes['status'].' proposal kemitraan perusahaan Anda.',
                route('partnerships.index'),
                'Lihat Kemitraan'
            );
        } else {
            $this->notifyUsers(
                User::where('university_id', $partnership->university_id)->where('role', 'staf')->get(),
                'Status kemitraan diperbarui',
                $user->company->nama.' '.$attributes['status'].' proposal kemitraan universitas Anda.',
                route('partnerships.index'),
                'Lihat Kemitraan'
            );
        }

        return back()->with('success', 'Status proposal kerja sama berhasil diperbarui.');
    }
}
