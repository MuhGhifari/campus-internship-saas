<?php

namespace App\Http\Controllers;

use App\Models\CompanyPartnership;
use App\Models\University;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnershipController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('partnerships.index', [
            'partnerships' => CompanyPartnership::with(['company', 'university', 'requester', 'reviewer'])
                ->when($user->hasRole('perusahaan'), fn ($query) => $query->where('company_id', $user->company_id))
                ->when($user->hasRole('staf'), fn ($query) => $query->where('university_id', $user->university_id))
                ->latest()
                ->paginate(12),
            'universities' => University::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->hasRole('perusahaan'), 403);

        $attributes = $request->validate([
            'university_id' => ['required', 'exists:universities,id'],
            'pesan' => ['nullable', 'string'],
        ]);

        CompanyPartnership::updateOrCreate([
            'company_id' => $request->user()->company_id,
            'university_id' => $attributes['university_id'],
        ], [
            'requested_by' => $request->user()->id,
            'status' => 'menunggu',
            'pesan' => $attributes['pesan'] ?? null,
            'reviewed_by' => null,
            'catatan_review' => null,
            'reviewed_at' => null,
        ]);

        return back()->with('success', 'Proposal kerja sama berhasil dikirim ke universitas.');
    }

    public function update(Request $request, CompanyPartnership $partnership): RedirectResponse
    {
        abort_unless($request->user()->hasRole('staf') && $partnership->university_id === $request->user()->university_id, 403);

        $attributes = $request->validate([
            'status' => ['required', 'in:diterima,ditolak'],
            'catatan_review' => ['nullable', 'string'],
        ]);

        $partnership->update([
            ...$attributes,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Status proposal kerja sama berhasil diperbarui.');
    }
}
