<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'CareerBridge' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <div class="min-h-screen">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-lg bg-emerald-600 font-bold text-white">CB</span>
                    <span>
                        <span class="block text-sm font-semibold uppercase tracking-wide text-emerald-700">CareerBridge</span>
                        <span class="block text-xs text-slate-500">SaaS Magang Kampus</span>
                    </span>
                </a>

                <nav class="flex items-center gap-3 text-sm">
                    @auth
                        <a class="rounded-md px-3 py-2 hover:bg-slate-100" href="{{ route('dashboard') }}">Dashboard</a>
                        <a class="rounded-md px-3 py-2 hover:bg-slate-100" href="{{ route('partnerships.index') }}">Kemitraan</a>
                        <a class="rounded-md px-3 py-2 hover:bg-slate-100" href="{{ route('offers.index') }}">Lowongan</a>
                        <a class="rounded-md px-3 py-2 hover:bg-slate-100" href="{{ route('applications.index') }}">Lamaran</a>
                        <a class="rounded-md px-3 py-2 hover:bg-slate-100" href="{{ route('logbooks.index') }}">Logbook</a>
                        <a class="rounded-md px-3 py-2 hover:bg-slate-100" href="{{ route('evaluations.index') }}">Evaluasi</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded-md bg-slate-900 px-3 py-2 font-medium text-white hover:bg-slate-700">Keluar</button>
                        </form>
                    @else
                        <a class="rounded-md px-3 py-2 hover:bg-slate-100" href="{{ route('login') }}">Masuk</a>
                        <a class="rounded-md bg-emerald-600 px-3 py-2 font-medium text-white hover:bg-emerald-700" href="{{ route('register') }}">Daftar Mahasiswa</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
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
    </div>
</body>
</html>
