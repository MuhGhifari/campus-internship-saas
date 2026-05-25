@extends('layouts.app')

@section('title', 'Masuk — CareerBridge')

@section('content')
    <section class="relative min-h-[calc(100vh-68px)] overflow-hidden bg-[#0D1B2A] px-5 py-16 text-white">
        <div class="cb-grid-bg absolute inset-0 opacity-[0.03]"></div>
        <div class="relative mx-auto grid max-w-6xl overflow-hidden rounded-2xl border border-white/15 bg-white/[0.06] shadow-2xl lg:grid-cols-[1fr_430px]">
            <section class="p-8 lg:p-12">
                <p class="inline-flex rounded-full border border-[#E8A020]/30 bg-[#E8A020]/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-[#F5B84A]">Ruang Kerja CareerBridge</p>
                <h1 class="cb-display mt-7 max-w-2xl text-5xl font-light leading-none sm:text-7xl">Masuk sesuai peran, lanjutkan alur magang.</h1>
                <div class="mt-10 grid gap-4 md:grid-cols-3">
                    @foreach ([
                        ['university', 'Kampus', 'Tinjau partner dan posisi.'],
                        ['company', 'Perusahaan', 'Kelola kandidat magang.'],
                        ['student', 'Mahasiswa', 'Lamar lowongan resmi.'],
                    ] as [$icon, $title, $desc])
                        <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                            <div class="grid h-10 w-10 place-items-center rounded-lg bg-[#E8A020]/15 text-[#E8A020]">
                                @include('partials.icon', ['name' => $icon, 'class' => 'h-5 w-5'])
                            </div>
                            <p class="mt-3 font-semibold">{{ $title }}</p>
                            <p class="mt-1 text-sm leading-6 text-white/55">{{ $desc }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="bg-[#F7F3ED] p-7 text-[#0D1B2A] lg:p-8">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#E8A020]">Masuk</p>
                <h2 class="cb-display mt-3 text-4xl font-light">Selamat datang kembali.</h2>

                <form method="POST" action="{{ route('login.store') }}" class="mt-7 space-y-4">
                    @csrf
                    <label class="block">
                        <span class="text-sm font-medium">Email</span>
                        <input name="email" type="email" value="{{ old('email') }}" required class="cb-input mt-1">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Kata Sandi</span>
                        <input name="password" type="password" required class="cb-input mt-1">
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input name="remember" type="checkbox" class="rounded border-[#0D1B2A]/20">
                        Ingat saya
                    </label>
                    <button class="cb-dark-button w-full px-4 py-3">Masuk</button>
                </form>

                <div class="mt-7 rounded-xl border border-[#0D1B2A]/10 bg-white p-4 text-sm text-[#3D526B]">
                    <p class="font-semibold text-[#0D1B2A]">Akun demo</p>
                    <div class="mt-3 space-y-1">
                        <p>staf@careerbridge.test / password</p>
                        <p>hr@careerbridge.test / password</p>
                        <p>pj-perusahaan@careerbridge.test / password</p>
                        <p>mahasiswa@careerbridge.test / password</p>
                        <p>pembimbing-kampus@careerbridge.test / password</p>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection
