<x-layouts.app title="Dashboard - CareerBridge">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Halo, {{ auth()->user()->name }}</p>
            <h1 class="text-3xl font-bold">Dashboard Magang</h1>
            <p class="mt-2 text-slate-600">Ringkasan operasional program magang kampus berbasis SaaS.</p>
        </div>
        @if (auth()->user()->hasRole('staf') || auth()->user()->hasRole('perusahaan'))
            <a href="{{ route('offers.create') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Buat Lowongan</a>
        @endif
    </div>

    <section class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            ['Lowongan', $totalOffers, 'Total lowongan di kampus'],
            ['Terbit', $publishedOffers, 'Lowongan aktif untuk mahasiswa'],
            ['Lamaran', $totalApplications, 'Total lamaran masuk'],
            ['Diterima', $acceptedApplications, 'Mahasiswa sudah ditempatkan'],
            ['Mitra', $companies, 'Perusahaan terdaftar'],
            ['Mahasiswa', $students, 'Akun mahasiswa'],
            ['Logbook', $logbooksWaiting, 'Menunggu tinjauan'],
        ] as [$label, $value, $desc])
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">{{ $label }}</p>
                <p class="mt-2 text-3xl font-bold">{{ $value }}</p>
                <p class="mt-1 text-sm text-slate-500">{{ $desc }}</p>
            </div>
        @endforeach
    </section>

    <section class="mt-8 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 p-5">
                <h2 class="font-semibold">Aktivitas Lamaran Terbaru</h2>
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
                <h2 class="font-semibold">Batas Lamaran Terdekat</h2>
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
                    <p class="p-5 text-sm text-slate-500">Tidak ada lowongan terbit.</p>
                @endforelse
            </div>
        </div>
    </section>
</x-layouts.app>
