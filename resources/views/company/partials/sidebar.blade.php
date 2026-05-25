@php
    $links = [
        ['dashboard', 'Ringkasan', 'dashboard'],
        ['partnerships.index', 'Kemitraan Kampus', 'partnerships.*'],
        ['offers.index', 'Lowongan', 'offers.*'],
        ['applications.index', 'Kandidat', 'applications.*'],
        ['logbooks.index', 'Logbook Kandidat', 'logbooks.*'],
        ['evaluations.index', 'Evaluasi', 'evaluations.*'],
    ];
@endphp

<aside class="bg-zinc-950 px-5 py-6 text-white">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
        <span class="grid h-11 w-11 place-items-center rounded-lg bg-amber-400 font-bold text-zinc-950">CB</span>
        <span>
            <span class="block text-sm font-semibold uppercase tracking-wide text-amber-200">Portal Perusahaan</span>
            <span class="block text-xs text-white/60">CareerBridge</span>
        </span>
    </a>
    <div class="mt-7 rounded-lg border border-white/10 bg-white/5 p-4">
        <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
        <p class="mt-1 text-xs text-white/60">Kelola jalur talenta kampus</p>
    </div>
    <nav class="mt-7 space-y-1 text-sm">
        @foreach ($links as [$route, $label, $active])
            @php($isActive = request()->routeIs($active))
            <a class="block rounded-lg px-3 py-2 {{ $isActive ? 'bg-amber-400 text-zinc-950 font-bold' : 'text-white/75 hover:bg-white/10 hover:text-white' }}" href="{{ route($route) }}">{{ $label }}</a>
        @endforeach
    </nav>
    <form method="POST" action="{{ route('logout') }}" class="mt-8">
        @csrf
        <button class="w-full rounded-lg border border-white/15 px-3 py-2 text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white">Keluar</button>
    </form>
</aside>
