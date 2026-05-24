<x-layouts.app title="Dashboard - CareerBridge">
    @php($user = auth()->user())

    @if ($user->hasRole('staf'))
        <section class="rounded-lg bg-slate-950 p-6 text-white shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-cyan-300">Konsol universitas</p>
            <h1 class="mt-2 text-3xl font-bold">Pantau kemitraan dan penempatan magang kampus.</h1>
            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-300">Gunakan dashboard ini untuk mengawasi perusahaan partner, review posisi, lamaran mahasiswa, dan evaluasi akhir.</p>
        </section>

        <section class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['Lowongan Masuk', $totalOffers, 'Perlu review kampus'],
                ['Lowongan Terbit', $publishedOffers, 'Sudah terlihat mahasiswa'],
                ['Perusahaan Partner', $companies, 'Kemitraan diterima'],
                ['Evaluasi', $acceptedApplications, 'Mahasiswa ditempatkan'],
            ] as [$label, $value, $desc])
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-bold">{{ $value }}</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $desc }}</p>
                </div>
            @endforeach
        </section>
    @elseif ($user->hasRole('perusahaan'))
        <section class="grid gap-5 lg:grid-cols-[1fr_360px]">
            <div class="rounded-lg bg-zinc-950 p-6 text-white shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-wide text-amber-300">Portal perusahaan</p>
                <h1 class="mt-2 text-3xl font-bold">Kelola pipeline kampus dan kandidat magang.</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-zinc-300">Ajukan kemitraan, kirim posisi ke kampus partner, lalu review CV mahasiswa dari satu ruang kerja.</p>
                <a href="{{ route('partnerships.index') }}" class="mt-5 inline-flex rounded-lg bg-amber-400 px-4 py-2 text-sm font-semibold text-zinc-950 hover:bg-amber-300">Ajukan Kemitraan</a>
            </div>
            <div class="rounded-lg border border-amber-200 bg-amber-50 p-5">
                <p class="text-sm font-semibold text-amber-900">Fokus HR</p>
                <p class="mt-2 text-3xl font-bold text-amber-950">{{ $totalApplications }}</p>
                <p class="mt-1 text-sm text-amber-800">Lamaran masuk untuk posisi perusahaan Anda.</p>
            </div>
        </section>

        <section class="mt-6 grid gap-4 sm:grid-cols-3">
            @foreach ([
                ['Posisi Dibuat', $totalOffers],
                ['Disetujui Kampus', $publishedOffers],
                ['Kemitraan Aktif', $companies],
            ] as [$label, $value])
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-bold">{{ $value }}</p>
                </div>
            @endforeach
        </section>
    @elseif ($user->hasRole('mahasiswa'))
        <section class="rounded-lg bg-emerald-950 p-6 text-white shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-200">Ruang mahasiswa</p>
            <h1 class="mt-2 text-3xl font-bold">Temukan peluang magang yang sudah disetujui kampus.</h1>
            <p class="mt-3 max-w-2xl text-sm leading-6 text-emerald-100/80">Lihat posisi resmi, kirim CV, pantau status lamaran, dan isi logbook ketika magang sudah berjalan.</p>
            <a href="{{ route('offers.index') }}" class="mt-5 inline-flex rounded-lg bg-emerald-400 px-4 py-2 text-sm font-semibold text-emerald-950 hover:bg-emerald-300">Cari Lowongan</a>
        </section>

        <section class="mt-6 grid gap-4 sm:grid-cols-3">
            @foreach ([
                ['Lamaran Saya', $totalApplications],
                ['Diterima', $acceptedApplications],
                ['Logbook Review', $logbooksWaiting],
            ] as [$label, $value])
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-bold">{{ $value }}</p>
                </div>
            @endforeach
        </section>
    @else
        <section class="rounded-lg bg-indigo-950 p-6 text-white shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wide text-indigo-200">Meja pembimbing</p>
            <h1 class="mt-2 text-3xl font-bold">Review progres mahasiswa bimbingan.</h1>
            <p class="mt-3 max-w-2xl text-sm leading-6 text-indigo-100/80">Pantau lamaran yang sudah ditempatkan, tinjau logbook, dan berikan evaluasi akademik.</p>
            <a href="{{ route('logbooks.index') }}" class="mt-5 inline-flex rounded-lg bg-indigo-400 px-4 py-2 text-sm font-semibold text-indigo-950 hover:bg-indigo-300">Review Logbook</a>
        </section>
    @endif

    <section class="mt-8 grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="font-semibold">
                    @if ($user->hasRole('perusahaan'))
                        Kandidat Terbaru
                    @elseif ($user->hasRole('mahasiswa'))
                        Riwayat Lamaran Saya
                    @else
                        Aktivitas Lamaran Terbaru
                    @endif
                </h2>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($applications as $application)
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold">{{ $application->student->name }}</p>
                                <p class="text-sm text-slate-600">{{ $application->offer->judul }} di {{ $application->offer->company->nama }}</p>
                            </div>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium">{{ ucfirst($application->status) }}</span>
                        </div>
                        <p class="mt-2 text-sm text-slate-500">
                            Pembimbing kampus: {{ $application->campusSupervisor->name ?? 'Belum ditentukan' }}
                        </p>
                    </div>
                @empty
                    <p class="p-5 text-sm text-slate-500">Belum ada aktivitas lamaran.</p>
                @endforelse
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="font-semibold">{{ $user->hasRole('perusahaan') ? 'Posisi Perusahaan' : 'Batas Lamaran Terdekat' }}</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($upcomingOffers as $offer)
                    <a href="{{ route('offers.show', $offer) }}" class="block p-5 hover:bg-slate-50">
                        <p class="font-semibold">{{ $offer->judul }}</p>
                        <p class="text-sm text-slate-600">{{ $offer->company->nama }}</p>
                        <p class="mt-2 text-sm text-emerald-700">
                            Deadline {{ $offer->batas_lamaran?->translatedFormat('d F Y') ?? 'Belum ditentukan' }}
                        </p>
                    </a>
                @empty
                    <p class="p-5 text-sm text-slate-500">Tidak ada lowongan.</p>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.app>
