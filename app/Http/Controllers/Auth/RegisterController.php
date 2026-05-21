<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register', [
            'universities' => University::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $attributes = $request->validate([
            'account_type' => ['required', 'in:universitas,perusahaan,mahasiswa'],
            'university_id' => ['required_if:account_type,mahasiswa', 'nullable', 'exists:universities,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nomor_induk' => ['nullable', 'string', 'max:50'],
            'program_studi' => ['nullable', 'string', 'max:120'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'university_name' => ['required_if:account_type,universitas', 'nullable', 'string', 'max:255'],
            'university_code' => ['required_if:account_type,universitas', 'nullable', 'string', 'max:30', 'unique:universities,kode'],
            'company_name' => ['required_if:account_type,perusahaan', 'nullable', 'string', 'max:255'],
            'industry' => ['required_if:account_type,perusahaan', 'nullable', 'string', 'max:120'],
            'website' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if ($attributes['account_type'] === 'universitas') {
            $university = University::create([
                'nama' => $attributes['university_name'],
                'kode' => strtoupper($attributes['university_code']),
                'email' => $attributes['email'],
                'telepon' => $attributes['telepon'] ?? null,
            ]);

            $user = User::create([
                'university_id' => $university->id,
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'role' => 'staf',
                'telepon' => $attributes['telepon'] ?? null,
                'password' => $attributes['password'],
            ]);

            Auth::login($user);

            return redirect()->route('dashboard');
        }

        if ($attributes['account_type'] === 'perusahaan') {
            $company = Company::create([
                'nama' => $attributes['company_name'],
                'industri' => $attributes['industry'],
                'website' => $attributes['website'] ?? null,
                'kontak_email' => $attributes['email'],
                'kontak_telepon' => $attributes['telepon'] ?? null,
                'status' => 'aktif',
            ]);

            $user = User::create([
                'company_id' => $company->id,
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'role' => 'perusahaan',
                'telepon' => $attributes['telepon'] ?? null,
                'password' => $attributes['password'],
            ]);

            Auth::login($user);

            return redirect()->route('dashboard');
        }

        $user = User::create([
            'university_id' => $attributes['university_id'],
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'nomor_induk' => $attributes['nomor_induk'] ?? null,
            'program_studi' => $attributes['program_studi'] ?? null,
            'telepon' => $attributes['telepon'] ?? null,
            'password' => $attributes['password'],
            'role' => 'mahasiswa',
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
