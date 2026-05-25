@extends('layouts.app')

@section('title', 'Ringkasan - CareerBridge')

@section('content')
    @php
        $user = auth()->user();
        $hero = match (true) {
            $user->hasRole('staf') => ['Konsol Universitas', 'Pantau kemitraan, lowongan, dan hasil magang kampus.', 'university', route('partnerships.index'), 'Tinjau Kemitraan'],
            $user->hasRole('perusahaan') => ['Portal Perusahaan', 'Bangun jalur talenta dari kampus partner.', 'company', route('partnerships.index'), 'Ajukan Kemitraan'],
            $user->hasRole('mahasiswa') => ['Ruang Mahasiswa', 'Temukan lowongan resmi dan pantau lamaranmu.', 'student', route('offers.index'), 'Cari Lowongan'],
            $user->hasRole('university_supervisor') => ['Meja Pembimbing Kampus', 'Pantau tugas, progres, dan evaluasi akademik mahasiswa bimbingan.', 'mentor', route('logbooks.index'), 'Tinjau Progress'],
            default => ['Meja Pembimbing', 'Tinjau tugas dan evaluasi mahasiswa bimbingan.', 'mentor', route('logbooks.index'), 'Tinjau Tugas'],
        };
    @endphp

    <section class="relative overflow-hidden rounded-2xl bg-[#0D1B2A] p-8 text-white shadow-xl">
        <div class="cb-grid-bg absolute inset-0 opacity-[0.04]"></div>
        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#E8A020]">{{ $hero[0] }}</p>
                <h1 class="cb-display mt-3 max-w-3xl text-5xl font-light leading-none">{{ $hero[1] }}</h1>
            </div>
            <a href="{{ $hero[3] }}" class="cb-primary inline-flex items-center justify-center gap-2 px-5 py-3 text-sm">
                @include('partials.icon', ['name' => $hero[2], 'class' => 'h-4 w-4'])
                {{ $hero[4] }}
            </a>
        </div>
    </section>

    <section class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['Lowongan', $totalOffers, 'Total posisi dalam sistem', 'clipboard'],
            ['Terbit', $publishedOffers, 'Disetujui dan aktif', 'check'],
            ['Mahasiswa Bimbingan', $students, 'Mahasiswa yang ditugaskan', 'users'],
            ['Lamaran', $totalApplications, 'Aktivitas kandidat', 'inbox'],
        ] as [$label, $value, $desc, $icon])
            <div class="cb-card p-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-[#6B7E94]">{{ $label }}</p>
                        <p class="cb-display mt-2 text-4xl font-bold text-[#0D1B2A]">{{ $value }}</p>
                    </div>
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-[#FDF3DC] text-[#0D1B2A]">
                        @include('partials.icon', ['name' => $icon, 'class' => 'h-5 w-5'])
                    </span>
                </div>
                <p class="mt-2 text-sm text-[#6B7E94]">{{ $desc }}</p>
            </div>
        @endforeach
    </section>

    <section class="mt-8 grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
        <div class="cb-card overflow-hidden">
            <div class="border-b border-[#0D1B2A]/10 p-5">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#E8A020]">Aktivitas</p>
                <h2 class="mt-1 font-semibold text-[#0D1B2A]">
                    Mahasiswa terbaru
                </h2>
            </div>
            <div class="divide-y divide-[#0D1B2A]/10">
                @forelse ($applications as $application)
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold text-[#0D1B2A]">{{ $application->student->name }}</p>
                                <p class="mt-1 text-sm text-[#6B7E94]">{{ $application->offer->judul }} di {{ $application->offer->company->nama }}</p>
                            </div>
                            <span class="rounded-full bg-[#FDF3DC] px-3 py-1 text-xs font-semibold text-[#0D1B2A]">{{ ucfirst($application->status) }}</span>
                        </div>
                        <p class="mt-3 text-sm text-[#6B7E94]">Pembimbing kampus: {{ $application->campusSupervisor->name ?? 'Belum ditentukan' }}</p>
                    </div>
                @empty
                    <p class="p-5 text-sm text-[#6B7E94]">Belum ada aktivitas lamaran.</p>
                @endforelse
            </div>
        </div>

        <div class="cb-card overflow-hidden">
            <div class="border-b border-[#0D1B2A]/10 p-5">
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#E8A020]">Prioritas</p>
                <h2 class="mt-1 font-semibold text-[#0D1B2A]">{{ $user->hasRole('perusahaan') ? 'Posisi perusahaan' : 'Batas lamaran terdekat' }}</h2>
            </div>
            <div class="divide-y divide-[#0D1B2A]/10">
                @forelse ($upcomingOffers as $offer)
                    <a href="{{ route('offers.show', $offer) }}" class="block p-5 transition hover:bg-[#F7F3ED]">
                        <p class="font-semibold text-[#0D1B2A]">{{ $offer->judul }}</p>
                        <p class="mt-1 text-sm text-[#6B7E94]">{{ $offer->company->nama }}</p>
                        <p class="mt-3 text-sm font-semibold text-[#E8A020]">Batas {{ $offer->batas_lamaran?->translatedFormat('d F Y') ?? 'Belum ditentukan' }}</p>
                    </a>
                @empty
                    <p class="p-5 text-sm text-[#6B7E94]">Tidak ada lowongan.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
