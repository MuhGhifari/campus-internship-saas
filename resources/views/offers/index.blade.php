@extends('layouts.app')

@section('title', 'Lowongan Magang - CareerBridge')

@section('content')
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="cb-section-label">Lowongan</p>
            <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">Peluang magang resmi dari jaringan partner.</h1>
            <p class="mt-3 text-[#6B7E94]">Setiap posisi melewati tinjauan universitas sebelum tampil ke mahasiswa.</p>
        </div>
        @if (auth()->user()->hasRole('staf') || auth()->user()->hasRole('perusahaan'))
            <a href="{{ route('offers.create') }}" class="cb-primary inline-flex px-5 py-3 text-sm">Buat Lowongan</a>
        @endif
    </div>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($offers as $offer)
            <a href="{{ route('offers.show', $offer) }}" class="cb-card group block p-6 transition hover:-translate-y-1 hover:border-[#E8A020] hover:shadow-xl">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#E8A020]">{{ $offer->company->nama }}</p>
                        <h2 class="mt-2 text-xl font-bold text-[#0D1B2A]">{{ $offer->judul }}</h2>
                    </div>
                    <span class="rounded-full bg-[#FDF3DC] px-3 py-1 text-xs font-semibold text-[#0D1B2A]">{{ ucfirst($offer->status) }}</span>
                </div>
                <p class="mt-4 text-sm text-[#6B7E94]">{{ $offer->bidang }} • {{ ucfirst($offer->tipe_kerja) }} • {{ $offer->lokasi }}</p>
                <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
                    <div class="rounded-xl bg-[#F7F3ED] p-3">
                        <p class="font-semibold text-[#0D1B2A]">{{ $offer->kuota }}</p>
                        <p class="text-[#6B7E94]">Kuota</p>
                    </div>
                    <div class="rounded-xl bg-[#F7F3ED] p-3">
                        <p class="font-semibold text-[#0D1B2A]">{{ $offer->applications_count ?? $offer->applications->count() }}</p>
                        <p class="text-[#6B7E94]">Pelamar</p>
                    </div>
                </div>
                <p class="mt-5 text-sm font-semibold text-[#0D1B2A]">Batas: {{ $offer->batas_lamaran?->translatedFormat('d F Y') ?? 'Belum ditentukan' }}</p>
            </a>
        @empty
            <div class="cb-card border-dashed p-10 text-center text-[#6B7E94] md:col-span-2 xl:col-span-3">Belum ada lowongan magang.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $offers->links() }}</div>
@endsection
