@php
    $user = auth()->user();

    $roleMeta = match ($user->role) {
        'mahasiswa' => ['Ruang Mahasiswa', 'Kelola lamaran dan tugas magang'],
        'staf' => ['Konsol Universitas', 'Pantau kemitraan dan progres mahasiswa'],
        'perusahaan' => ['Portal Perusahaan', 'Kelola partner, lowongan, dan kandidat'],
        'company_supervisor' => ['Meja PJ Perusahaan', 'Pantau mahasiswa yang ditugaskan'],
        'university_supervisor', 'dosen' => ['Meja Pembimbing Kampus', 'Pantau mahasiswa bimbingan'],
        default => ['CareerBridge', 'Platform magang kampus'],
    };

    $links = match ($user->role) {
        'mahasiswa' => [
            ['dashboard', 'Ringkasan', 'dashboard'],
            ['offers.index', 'Cari Magang', 'offers.*'],
            ['applications.index', 'Lamaran Saya', 'applications.*'],
            ['logbooks.index', 'Magang Aktif', 'logbooks.*'],
            ['profile.edit', 'Profil', 'profile.*'],
        ],
        'staf' => [
            ['dashboard', 'Ringkasan', 'dashboard'],
            ['directories.companies', 'Jelajah Perusahaan', 'directories.companies'],
            ['partnerships.index', 'Kemitraan', 'partnerships.*'],
            ['offers.index', 'Listing Magang', 'offers.*'],
            ['supervisors.index', 'Pembimbing', 'supervisors.*'],
            ['profile.edit', 'Profil', 'profile.*'],
        ],
        'perusahaan' => [
            ['dashboard', 'Ringkasan', 'dashboard'],
            ['directories.universities', 'Jelajah Universitas', 'directories.universities'],
            ['partnerships.index', 'Kemitraan', 'partnerships.*'],
            ['offers.index', 'Magang', 'offers.*'],
            ['applications.index', 'Aplikasi', 'applications.*'],
            ['supervisors.index', 'PJ Magang', 'supervisors.*'],
            ['profile.edit', 'Profil', 'profile.*'],
        ],
        'company_supervisor' => [
            ['dashboard', 'Ringkasan', 'dashboard'],
            ['applications.index', 'Mahasiswa', 'applications.*'],
            ['logbooks.index', 'Tugas', 'logbooks.*'],
            ['evaluations.index', 'Evaluasi', 'evaluations.*'],
            ['profile.edit', 'Profil', 'profile.*'],
        ],
        'university_supervisor', 'dosen' => [
            ['dashboard', 'Ringkasan', 'dashboard'],
            ['applications.index', 'Mahasiswa', 'applications.*'],
            ['logbooks.index', 'Progress', 'logbooks.*'],
            ['evaluations.index', 'Nilai Akademik', 'evaluations.*'],
            ['profile.edit', 'Profil', 'profile.*'],
        ],
        default => [
            ['dashboard', 'Ringkasan', 'dashboard'],
        ],
    };
@endphp

<header class="sticky top-0 z-50 border-b border-[#0D1B2A]/10 bg-[#0D1B2A] text-white shadow-sm">
    <div class="px-5 lg:px-16">
        <div class="flex min-h-[76px] flex-col gap-4 py-4 xl:flex-row xl:items-center xl:justify-between">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-lg bg-[#E8A020] text-sm font-black text-[#0D1B2A]">CB</span>
                    <span>
                        <span class="cb-display block text-2xl font-semibold leading-none text-white">Career<span class="text-[#E8A020]">Bridge</span>.</span>
                        <span class="mt-1 block text-xs font-semibold uppercase tracking-[0.16em] text-white/45">{{ $roleMeta[0] }}</span>
                    </span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="xl:hidden">
                    @csrf
                    <button class="rounded-lg border border-white/15 px-4 py-2 text-sm font-semibold text-white/80 transition hover:border-[#E8A020] hover:text-[#F5B84A]">Keluar</button>
                </form>
            </div>

            <div class="flex min-w-0 flex-1 flex-col gap-4 xl:max-w-5xl xl:flex-row xl:items-center xl:justify-end">
                <nav class="-mx-1 flex gap-2 overflow-x-auto pb-1 text-sm xl:mx-0 xl:justify-end xl:overflow-visible xl:pb-0">
                    @foreach ($links as [$route, $label, $active])
                        @php($isActive = request()->routeIs($active))
                        <a href="{{ route($route) }}" class="shrink-0 rounded-lg px-4 py-2 font-semibold transition {{ $isActive ? 'bg-[#E8A020] text-[#0D1B2A]' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </nav>

                <div class="hidden items-center gap-4 border-l border-white/10 pl-5 xl:flex">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-white">{{ $user->name }}</p>
                        <p class="text-xs text-white/45">{{ $roleMeta[1] }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="rounded-lg border border-white/15 px-4 py-2 text-sm font-semibold text-white/80 transition hover:border-[#E8A020] hover:text-[#F5B84A]">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
