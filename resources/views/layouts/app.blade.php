<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CareerBridge')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
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
            'tagline' => 'Kemitraan, tinjauan posisi, dan evaluasi mahasiswa',
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
            'tagline' => 'Monitoring catatan harian dan evaluasi akademik',
        ],
        'guest' => [
            'bg' => 'bg-white',
            'accent' => 'bg-emerald-600',
            'text' => 'text-emerald-700',
            'sideText' => 'text-emerald-700',
            'label' => 'CareerBridge',
            'tagline' => 'SaaS kemitraan magang kampus',
        ],
    ][$role];
@endphp
<body class="min-h-screen cb-page antialiased">
    @guest
        @include('partials.guest-nav')

        <main class="pt-[68px]">
            <div class="mx-auto max-w-none">
                @include('partials.flash')
                @yield('content')
            </div>
        </main>
    @else
        <div class="grid min-h-screen bg-[#F7F3ED] lg:grid-cols-[280px_1fr]">
            @include('partials.auth-sidebar', ['roleConfig' => $roleConfig])

            <div>
                @include('partials.auth-header', ['roleConfig' => $roleConfig])

                <main class="px-5 py-8 sm:px-8">
                    @include('partials.flash')
                    @yield('content')
                </main>
            </div>
        </div>
    @endguest

    @yield('scripts')
</body>
</html>
