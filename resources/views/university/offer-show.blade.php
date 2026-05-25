@extends('layouts.app')

@section('title', $offer->judul . ' - CareerBridge')

@section('content')
    @php
        $statusLabels = [
            'draft' => 'Draf',
            'menunggu' => 'Menunggu Tinjauan',
            'terbit' => 'Terbit',
            'ditutup' => 'Ditutup',
            'diajukan' => 'Diajukan',
            'diseleksi' => 'Diseleksi',
            'wawancara' => 'Wawancara',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            'berjalan' => 'Berjalan',
            'selesai' => 'Selesai',
        ];
    @endphp

    <button type="button" data-back-button data-fallback="{{ route('offers.index') }}" class="mb-5 inline-flex items-center gap-2 rounded-lg border border-[#0D1B2A]/15 bg-white px-4 py-2 text-sm font-semibold text-[#0D1B2A] hover:bg-[#F7F3ED]">
        @include('partials.icon', ['name' => 'arrow-left', 'class' => 'h-4 w-4'])
        Kembali ke Lowongan
    </button>

    <div class="mb-8 grid gap-6 lg:grid-cols-[1fr_340px]">
        <section class="cb-card overflow-hidden">
            <div class="bg-[#0D1B2A] p-6 text-white lg:p-8">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#E8A020]">{{ $offer->company->nama }}</p>
                        <h1 class="cb-display mt-3 text-5xl font-light">{{ $offer->judul }}</h1>
                        <p class="mt-4 text-white/65">{{ $offer->bidang }} • {{ ucfirst($offer->tipe_kerja) }} • {{ $offer->lokasi }}</p>
                    </div>
                    <span class="rounded-full bg-white/10 px-4 py-2 text-xs font-bold text-[#F5B84A]">{{ $statusLabels[$offer->status] ?? ucfirst($offer->status) }}</span>
                </div>
            </div>

            <div class="grid gap-3 p-6 text-sm sm:grid-cols-3 lg:p-8">
                <div class="rounded-lg bg-[#F7F3ED] p-4">
                    <p class="text-[#6B7E94]">Kuota</p>
                    <p class="mt-1 font-bold text-[#0D1B2A]">{{ $offer->kuota }} mahasiswa</p>
                </div>
                <div class="rounded-lg bg-[#F7F3ED] p-4">
                    <p class="text-[#6B7E94]">Periode</p>
                    <p class="mt-1 font-bold text-[#0D1B2A]">{{ $offer->tanggal_mulai?->translatedFormat('d M Y') ?? '-' }} - {{ $offer->tanggal_selesai?->translatedFormat('d M Y') ?? '-' }}</p>
                </div>
                <div class="rounded-lg bg-[#F7F3ED] p-4">
                    <p class="text-[#6B7E94]">Batas lamaran</p>
                    <p class="mt-1 font-bold text-[#0D1B2A]">{{ $offer->batas_lamaran?->translatedFormat('d M Y') ?? '-' }}</p>
                </div>
            </div>
        </section>

        <aside class="cb-card p-6">
            <div class="grid h-12 w-12 place-items-center rounded-lg bg-[#E8A020] text-[#0D1B2A]">
                @include('partials.icon', ['name' => 'compass', 'class' => 'h-6 w-6'])
            </div>
            <h2 class="mt-5 font-bold text-[#0D1B2A]">Ringkasan alur</h2>
            <p class="mt-2 text-sm leading-6 text-[#6B7E94]">Lowongan ini hanya terlihat oleh mahasiswa kampus yang sudah menyetujui permintaan posisi.</p>
        </aside>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1fr_420px]">
        <section class="space-y-6">
            <article class="cb-card p-6 lg:p-8">
                <p class="cb-section-label">Detail Posisi</p>
                <div class="mt-6 grid gap-6">
                    <div>
                        <h2 class="font-bold text-[#0D1B2A]">Deskripsi</h2>
                        <p class="mt-3 leading-8 text-[#6B7E94]">{{ $offer->deskripsi }}</p>
                    </div>
                    <div>
                        <h2 class="font-bold text-[#0D1B2A]">Persyaratan</h2>
                        <p class="mt-3 leading-8 text-[#6B7E94]">{{ $offer->persyaratan ?: 'Belum ada persyaratan khusus.' }}</p>
                    </div>
                    <div>
                        <h2 class="font-bold text-[#0D1B2A]">Benefit</h2>
                        <p class="mt-3 leading-8 text-[#6B7E94]">{{ $offer->benefit ?: 'Belum dicantumkan.' }}</p>
                    </div>
                </div>
            </article>

            @if (auth()->user()->hasRole('perusahaan'))
                <article class="cb-card p-6 lg:p-8">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="cb-section-label">Kandidat</p>
                            <h2 class="mt-3 text-2xl font-bold text-[#0D1B2A]">Pelamar posisi ini</h2>
                        </div>
                        <span class="rounded-full bg-[#FDF3DC] px-4 py-2 text-xs font-bold text-[#0D1B2A]">{{ $offer->applications->count() }} lamaran</span>
                    </div>

                    <div class="mt-6 grid gap-4">
                        @forelse ($offer->applications as $application)
                            <div class="rounded-lg border border-[#0D1B2A]/10 bg-[#F7F3ED] p-5">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <p class="font-bold text-[#0D1B2A]">{{ $application->student->name }}</p>
                                        <p class="text-sm text-[#6B7E94]">{{ $application->student->program_studi }}</p>
                                    </div>
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-[#0D1B2A]">{{ $statusLabels[$application->status] ?? ucfirst($application->status) }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-lg border border-dashed border-[#0D1B2A]/20 bg-[#F7F3ED] p-8 text-center text-sm text-[#6B7E94]">Belum ada mahasiswa yang melamar posisi ini.</div>
                        @endforelse
                    </div>
                </article>
            @endif
        </section>

        <aside class="space-y-6">
            <section class="cb-card p-6">
                <p class="cb-section-label">Tinjauan Kampus</p>
                <div class="mt-5 space-y-3">
                    @foreach ($offer->universityRequests as $offerRequest)
                        <div class="rounded-lg border border-[#0D1B2A]/10 bg-[#F7F3ED] p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-bold text-[#0D1B2A]">{{ $offerRequest->university->nama }}</p>
                                    <p class="mt-1 text-sm text-[#6B7E94]">{{ $offerRequest->catatan_review ?: 'Belum ada catatan.' }}</p>
                                </div>
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-[#0D1B2A]">{{ $statusLabels[$offerRequest->status] ?? ucfirst($offerRequest->status) }}</span>
                            </div>

                            @if (auth()->user()->hasRole('staf') && auth()->user()->university_id === $offerRequest->university_id && $offerRequest->status === 'menunggu')
                                <button type="button" data-modal-target="#offer-review-{{ $offerRequest->id }}" class="cb-dark-button mt-4 px-3 py-2 text-sm">Simpan Tinjauan</button>
                                @component('partials.modal-shell', [
                                    'id' => 'offer-review-'.$offerRequest->id,
                                    'title' => 'Tinjau lowongan untuk kampus',
                                    'eyebrow' => $offerRequest->university->nama,
                                    'description' => $offer->judul,
                                ])
                                    <form method="POST" action="{{ route('offers.review', $offerRequest) }}" class="grid gap-4">
                                        @csrf
                                        @method('PATCH')
                                        <label class="block">
                                            <span class="text-sm font-medium">Keputusan</span>
                                            <select name="status" class="cb-input mt-2 text-sm">
                                                <option value="diterima">Terima</option>
                                                <option value="ditolak">Tolak</option>
                                            </select>
                                        </label>
                                        <label class="block">
                                            <span class="text-sm font-medium">Catatan</span>
                                            <input name="catatan_review" placeholder="Catatan untuk perusahaan" class="cb-input mt-2 text-sm">
                                        </label>
                                        <button class="cb-dark-button px-3 py-3 text-sm">Simpan Tinjauan</button>
                                    </form>
                                @endcomponent
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>

            @if (auth()->user()->hasRole('mahasiswa') && $offer->status === 'terbit')
                <div class="cb-card p-6">
                    <p class="cb-section-label">Lamar</p>
                    <h2 class="mt-3 text-2xl font-bold text-[#0D1B2A]">Kirim CV untuk posisi ini</h2>
                    <p class="mt-2 text-sm leading-6 text-[#6B7E94]">Kirim motivasi, CV, dan surat pengantar Anda.</p>
                    <button type="button" data-modal-target="#application-create-modal" class="cb-dark-button mt-5 w-full px-4 py-3 text-sm">Buka Form Lamaran</button>
                </div>

                @component('partials.modal-shell', [
                    'id' => 'application-create-modal',
                    'title' => 'Kirim lamaran',
                    'eyebrow' => 'Lamaran Mahasiswa',
                    'description' => $offer->judul.' · '.$offer->company->nama,
                ])
                    <form method="POST" action="{{ route('applications.store', $offer) }}" enctype="multipart/form-data" class="grid gap-4">
                        @csrf
                        <label class="block">
                            <span class="text-sm font-semibold text-[#0D1B2A]">Motivasi</span>
                            <textarea name="motivasi" rows="5" required class="cb-input mt-2">{{ old('motivasi') }}</textarea>
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-[#0D1B2A]">CV</span>
                            <input name="resume" type="file" class="cb-input mt-2 text-sm">
                        </label>
                        <label class="block">
                            <span class="text-sm font-semibold text-[#0D1B2A]">Surat pengantar</span>
                            <input name="surat_pengantar" type="file" class="cb-input mt-2 text-sm">
                        </label>
                        <button class="cb-dark-button px-4 py-3 text-sm">Kirim Lamaran</button>
                    </form>
                @endcomponent
            @endif
        </aside>
    </div>
@endsection
