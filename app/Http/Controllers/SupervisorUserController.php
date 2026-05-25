<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SupervisorUserController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        abort_unless($user->hasAnyRole(['staf', 'perusahaan']), 403);

        $supervisors = User::query()
            ->when($user->hasRole('staf'), fn ($query) => $query
                ->where('university_id', $user->university_id)
                ->whereIn('role', ['university_supervisor', 'dosen']))
            ->when($user->hasRole('perusahaan'), fn ($query) => $query
                ->where('company_id', $user->company_id)
                ->where('role', 'company_supervisor'))
            ->orderBy('name')
            ->paginate(10);

        return $this->workspaceView($request, 'supervisors', [
            'supervisors' => $supervisors,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user->hasAnyRole(['staf', 'perusahaan']), 403);

        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'nomor_induk' => ['nullable', 'string', 'max:100'],
            'program_studi' => ['nullable', 'string', 'max:150'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $supervisor = User::create([
            ...$attributes,
            'role' => $user->hasRole('staf') ? 'university_supervisor' : 'company_supervisor',
            'university_id' => $user->hasRole('staf') ? $user->university_id : null,
            'company_id' => $user->hasRole('perusahaan') ? $user->company_id : null,
        ]);

        return redirect()
            ->route('supervisors.index')
            ->with('success', $supervisor->name.' berhasil dibuat sebagai akun pembimbing.');
    }
}
