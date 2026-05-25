<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return $this->workspaceView($request, 'profile');
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'telepon' => ['nullable', 'string', 'max:40'],
            'nomor_induk' => ['nullable', 'string', 'max:80'],
            'program_studi' => ['nullable', 'string', 'max:160'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user->update([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'telepon' => $attributes['telepon'] ?? null,
            'nomor_induk' => $attributes['nomor_induk'] ?? $user->nomor_induk,
            'program_studi' => $attributes['program_studi'] ?? $user->program_studi,
            ...(filled($attributes['password'] ?? null) ? ['password' => Hash::make($attributes['password'])] : []),
        ]);

        if ($user->hasRole('staf') && $user->university) {
            $university = $request->validate([
                'university_nama' => ['nullable', 'string', 'max:255'],
                'university_alamat' => ['nullable', 'string'],
                'university_email' => ['nullable', 'email', 'max:255'],
                'university_telepon' => ['nullable', 'string', 'max:40'],
            ]);

            $user->university->update([
                'nama' => $university['university_nama'] ?: $user->university->nama,
                'alamat' => $university['university_alamat'] ?? null,
                'email' => $university['university_email'] ?? null,
                'telepon' => $university['university_telepon'] ?? null,
            ]);
        }

        if ($user->hasRole('perusahaan') && $user->company) {
            $company = $request->validate([
                'company_nama' => ['nullable', 'string', 'max:255'],
                'company_industri' => ['nullable', 'string', 'max:160'],
                'company_alamat' => ['nullable', 'string'],
                'company_website' => ['nullable', 'string', 'max:255'],
                'company_kontak_email' => ['nullable', 'email', 'max:255'],
                'company_kontak_telepon' => ['nullable', 'string', 'max:40'],
            ]);

            $user->company->update([
                'nama' => $company['company_nama'] ?: $user->company->nama,
                'industri' => $company['company_industri'] ?? null,
                'alamat' => $company['company_alamat'] ?? null,
                'website' => $company['company_website'] ?? null,
                'kontak_email' => $company['company_kontak_email'] ?? null,
                'kontak_telepon' => $company['company_kontak_telepon'] ?? null,
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
