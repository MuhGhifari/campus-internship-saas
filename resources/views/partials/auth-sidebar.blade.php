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
        <a class="block rounded-lg px-3 py-2 text-white/80 hover:bg-white/10 hover:text-white" href="{{ route('dashboard') }}">Ringkasan</a>
        @if (auth()->user()->hasRole('perusahaan') || auth()->user()->hasRole('staf'))
            <a class="block rounded-lg px-3 py-2 text-white/80 hover:bg-white/10 hover:text-white" href="{{ route('partnerships.index') }}">Kemitraan</a>
        @endif
        <a class="block rounded-lg px-3 py-2 text-white/80 hover:bg-white/10 hover:text-white" href="{{ route('offers.index') }}">
            {{ auth()->user()->hasRole('mahasiswa') ? 'Cari Lowongan' : 'Kelola Lowongan' }}
        </a>
        <a class="block rounded-lg px-3 py-2 text-white/80 hover:bg-white/10 hover:text-white" href="{{ route('applications.index') }}">
            {{ auth()->user()->hasRole('perusahaan') ? 'Kandidat' : 'Lamaran' }}
        </a>
        @if (! auth()->user()->hasRole('staf'))
            <a class="block rounded-lg px-3 py-2 text-white/80 hover:bg-white/10 hover:text-white" href="{{ route('logbooks.index') }}">Catatan Harian</a>
        @endif
        <a class="block rounded-lg px-3 py-2 text-white/80 hover:bg-white/10 hover:text-white" href="{{ route('evaluations.index') }}">Evaluasi</a>
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="mt-8">
        @csrf
        <button class="w-full rounded-lg border border-white/15 px-3 py-2 text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white">Keluar</button>
    </form>
</aside>
