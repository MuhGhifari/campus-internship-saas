@extends('layouts.app')

@section('title', 'Ubah Lowongan - CareerBridge')

@section('content')
    <button type="button" data-back-button data-fallback="{{ route('offers.show', $offer) }}" class="mb-5 inline-flex items-center gap-2 rounded-lg border border-[#0D1B2A]/15 bg-white px-4 py-2 text-sm font-semibold text-[#0D1B2A] hover:bg-[#F7F3ED]">
        @include('partials.icon', ['name' => 'arrow-left', 'class' => 'h-4 w-4'])
        Kembali ke Detail
    </button>

    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="cb-section-label">Ubah Lowongan</p>
            <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">{{ $offer->judul }}</h1>
            <p class="mt-3 max-w-2xl text-[#6B7E94]">Perbarui detail posisi atau universitas tujuan. Perubahan dari perusahaan akan kembali masuk antrean tinjauan kampus.</p>
        </div>
        <a href="{{ route('offers.show', $offer) }}" class="inline-flex rounded-lg border border-[#0D1B2A]/15 px-5 py-3 text-sm font-semibold text-[#0D1B2A] hover:bg-white">Lihat Detail</a>
    </div>

    <button type="button" data-modal-target="#offer-form-modal" class="cb-primary px-5 py-3 text-sm">Buka Form Perubahan</button>

    @component('partials.modal-shell', [
        'id' => 'offer-form-modal',
        'title' => 'Ubah lowongan magang',
        'eyebrow' => 'Perubahan Lowongan',
        'description' => 'Perbarui detail posisi atau kampus tujuan.',
        'width' => 'max-w-5xl',
        'open' => true,
    ])
        <form method="POST" action="{{ route('offers.update', $offer) }}">
            @include('offers._form', ['method' => 'PATCH'])
        </form>
    @endcomponent
@endsection
