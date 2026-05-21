<x-layouts.app title="Lowongan Magang - CareerBridge">
    <div class="flex items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Lowongan Magang</h1>
            <p class="mt-2 text-slate-600">Peluang magang dari perusahaan mitra kampus.</p>
        </div>
        @if (auth()->user()->hasRole('staf') || auth()->user()->hasRole('perusahaan'))
            <a href="{{ route('offers.create') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Buat Lowongan</a>
        @endif
    </div>

    <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($offers as $offer)
            <a href="{{ route('offers.show', $offer) }}" class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm hover:border-emerald-300">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm text-emerald-700">{{ $offer->company->nama }}</p>
                        <h2 class="mt-1 text-lg font-bold">{{ $offer->judul }}</h2>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium">{{ ucfirst($offer->status) }}</span>
                </div>
                <p class="mt-3 text-sm text-slate-600">{{ $offer->bidang }} • {{ ucfirst($offer->tipe_kerja) }} • {{ $offer->lokasi }}</p>
                <p class="mt-3 text-sm text-slate-500">Kuota {{ $offer->kuota }} mahasiswa · {{ $offer->applications_count ?? $offer->applications->count() }} pelamar</p>
                <p class="mt-4 text-sm font-medium text-slate-900">Batas: {{ $offer->batas_lamaran?->translatedFormat('d F Y') ?? 'Belum ditentukan' }}</p>
            </a>
        @empty
            <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500 md:col-span-2 xl:col-span-3">
                Belum ada lowongan magang.
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $offers->links() }}</div>
</x-layouts.app>
