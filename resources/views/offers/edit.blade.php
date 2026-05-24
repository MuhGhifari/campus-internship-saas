@extends('layouts.app')

@section('title', 'Ubah Lowongan - CareerBridge')

@section('content')
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="cb-section-label">Ubah Lowongan</p>
            <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">{{ $offer->judul }}</h1>
            <p class="mt-3 max-w-2xl text-[#6B7E94]">Perbarui detail posisi atau universitas tujuan. Perubahan dari perusahaan akan kembali masuk antrean tinjauan kampus.</p>
        </div>
        <a href="{{ route('offers.show', $offer) }}" class="inline-flex rounded-lg border border-[#0D1B2A]/15 px-5 py-3 text-sm font-semibold text-[#0D1B2A] hover:bg-white">Lihat Detail</a>
    </div>

    <form method="POST" action="{{ route('offers.update', $offer) }}" class="cb-card p-6 lg:p-8">
        @include('offers._form', ['method' => 'PATCH'])
    </form>
@endsection
