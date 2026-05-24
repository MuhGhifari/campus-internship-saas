<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'CareerBridge' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $role = auth()->user()->role ?? 'guest';
    $roleConfig = [
        'staf' => [
            'bg' => 'bg-slate-950',
            'accent' => 'bg-cyan-400',
            'text' => 'text-cyan-600',
            'sideText' => 'text-cyan-200',
            'label' => 'Konsol Universitas',
            'tagline' => 'Kemitraan, review posisi, dan evaluasi mahasiswa',
        ],
        'perusahaan' => [
            'bg' => 'bg-zinc-950',
            'accent' => 'bg-amber-400',
            'text' => 'text-amber-600',
            'sideText' => 'text-amber-200',
            'label' => 'Portal Perusahaan',
            'tagline' => 'Kemitraan kampus, lowongan, dan seleksi kandidat',
        ],
        'mahasiswa' => [
            'bg' => 'bg-emerald-950',
            'accent' => 'bg-emerald-400',
            'text' => 'text-emerald-700',
            'sideText' => 'text-emerald-200',
            'label' => 'Ruang Mahasiswa',
            'tagline' => 'Cari peluang, lamar, dan pantau progres magang',
        ],
        'dosen' => [
            'bg' => 'bg-indigo-950',
            'accent' => 'bg-indigo-400',
            'text' => 'text-indigo-700',
            'sideText' => 'text-indigo-200',
            'label' => 'Meja Pembimbing',
            'tagline' => 'Monitoring logbook dan evaluasi akademik',
        ],
        'guest' => [
            'bg' => 'bg-white',
            'accent' => 'bg-emerald-600',
            'text' => 'text-emerald-700',
            'sideText' => 'text-emerald-700',
            'label' => 'CareerBridge',
            'tagline' => 'SaaS kemitraan magang kampus',
        ],
    ][$role] ?? null;
@endphp
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <div class="min-h-screen">
        @guest
            <header class="border-b border-slate-200 bg-white">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="grid h-10 w-10 place-items-center rounded-lg bg-emerald-600 font-bold text-white">CB</span>
                        <span>
                            <span class="block text-sm font-semibold uppercase tracking-wide text-emerald-700">CareerBridge</span>
                            <span class="block text-xs text-slate-500">SaaS Magang Kampus</span>
                        </span>
                    </a>

                    <nav class="flex items-center gap-3 text-sm">
                        <a class="hidden rounded-md px-3 py-2 hover:bg-slate-100 sm:inline-flex" href="{{ route('home') }}#layanan">Layanan</a>
                        <a class="hidden rounded-md px-3 py-2 hover:bg-slate-100 sm:inline-flex" href="{{ route('home') }}#kontak">Kontak</a>
                        <a class="rounded-md px-3 py-2 hover:bg-slate-100" href="{{ route('login') }}">Masuk</a>
                        <a class="rounded-md bg-emerald-600 px-3 py-2 font-medium text-white hover:bg-emerald-700" href="{{ route('register') }}">Daftar</a>
                    </nav>
                </div>
            </header>

            <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @else
            <div class="grid min-h-screen lg:grid-cols-[280px_1fr]">
                <aside class="{{ $roleConfig['bg'] }} px-5 py-6 text-white">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <span class="grid h-11 w-11 place-items-center rounded-lg {{ $roleConfig['accent'] }} font-bold text-slate-950">CB</span>
                        <span>
                            <span class="block text-sm font-semibold uppercase tracking-wide {{ $roleConfig['sideText'] }}">{{ $roleConfig['label'] }}</span>
                            <span class="block text-xs text-white/60">CareerBridge</span>
                        </span>
                    </a>

                    <div class="mt-7 rounded-lg border border-white/10 bg-white/5 p-4">
                        <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                        <p class="mt-1 text-xs text-white/60">{{ $roleConfig['tagline'] }}</p>
                    </div>

                    <nav class="mt-7 space-y-1 text-sm">
                        <a class="block rounded-lg px-3 py-2 text-white/80 hover:bg-white/10 hover:text-white" href="{{ route('dashboard') }}">Dashboard</a>
                        @if (auth()->user()->hasRole('perusahaan') || auth()->user()->hasRole('staf'))
                            <a class="block rounded-lg px-3 py-2 text-white/80 hover:bg-white/10 hover:text-white" href="{{ route('partnerships.index') }}">Kemitraan</a>
                        @endif
                        <a class="block rounded-lg px-3 py-2 text-white/80 hover:bg-white/10 hover:text-white" href="{{ route('offers.index') }}">
                            {{ auth()->user()->hasRole('mahasiswa') ? 'Cari Lowongan' : 'Manajemen Lowongan' }}
                        </a>
                        <a class="block rounded-lg px-3 py-2 text-white/80 hover:bg-white/10 hover:text-white" href="{{ route('applications.index') }}">
                            {{ auth()->user()->hasRole('perusahaan') ? 'Kandidat' : 'Lamaran' }}
                        </a>
                        @if (! auth()->user()->hasRole('staf'))
                            <a class="block rounded-lg px-3 py-2 text-white/80 hover:bg-white/10 hover:text-white" href="{{ route('logbooks.index') }}">Logbook</a>
                        @endif
                        <a class="block rounded-lg px-3 py-2 text-white/80 hover:bg-white/10 hover:text-white" href="{{ route('evaluations.index') }}">Evaluasi</a>
                    </nav>

                    <form method="POST" action="{{ route('logout') }}" class="mt-8">
                        @csrf
                        <button class="w-full rounded-lg border border-white/15 px-3 py-2 text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white">Keluar</button>
                    </form>
                </aside>

                <div>
                    <header class="border-b border-slate-200 bg-white">
                        <div class="flex items-center justify-between px-5 py-4 sm:px-8">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide {{ $roleConfig['text'] }}">{{ $roleConfig['label'] }}</p>
                                <p class="text-sm text-slate-500">{{ $roleConfig['tagline'] }}</p>
                            </div>
                            <a href="{{ route('home') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold hover:bg-slate-50">Situs Publik</a>
                        </div>
                    </header>

                    <main class="px-5 py-8 sm:px-8">
        @endguest
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <p class="font-semibold">Ada data yang perlu diperbaiki.</p>
                    <ul class="mt-2 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>
        @auth
                </div>
            </div>
        @endauth
    </div>
</body>
</html>
