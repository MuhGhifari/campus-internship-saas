<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
            'university_id' => ['required', 'exists:universities,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nomor_induk' => ['nullable', 'string', 'max:50'],
            'program_studi' => ['nullable', 'string', 'max:120'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            ...$attributes,
            'role' => 'mahasiswa',
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
