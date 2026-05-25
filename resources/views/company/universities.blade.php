@extends('layouts.app')

@section('title', 'Jelajah Universitas - CareerBridge')

@section('content')
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="cb-section-label">Jelajah Universitas</p>
            <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">Temukan kampus partner untuk program magang.</h1>
            <p class="mt-3 max-w-2xl text-[#6B7E94]">Perusahaan bisa melihat profil universitas dan mengirim proposal kemitraan sebelum membuka posisi.</p>
        </div>
    </div>

    <form method="GET" class="cb-card mb-6 grid gap-4 p-5 md:grid-cols-[1fr_220px_auto]">
        <input name="q" value="{{ request('q') }}" class="cb-input" placeholder="Cari nama universitas, kode, atau kota">
        <select name="status" class="cb-input">
            <option value="">Semua status</option>
            @foreach (['menunggu' => 'Menunggu', 'diterima' => 'Partner Aktif', 'ditolak' => 'Ditolak'] as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="cb-dark-button px-5 py-3 text-sm">Terapkan</button>
    </form>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($universities as $university)
            @php($partnership = $university->partneredCompanies->first()?->pivot)
            <article class="cb-card p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#E8A020]">{{ $university->kode }}</p>
                        <h2 class="mt-2 text-xl font-bold text-[#0D1B2A]">{{ $university->nama }}</h2>
                    </div>
                    <span class="rounded-full bg-[#FDF3DC] px-3 py-1 text-xs font-semibold text-[#0D1B2A]">{{ $partnership ? ucfirst($partnership->status) : 'Belum partner' }}</span>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
                    <div class="rounded-lg bg-[#F7F3ED] p-3">
                        <p class="font-bold text-[#0D1B2A]">{{ $university->students_count }}</p>
                        <p class="text-[#6B7E94]">Mahasiswa</p>
                    </div>
                    <div class="rounded-lg bg-[#F7F3ED] p-3">
                        <p class="font-bold text-[#0D1B2A]">{{ $university->offer_requests_count }}</p>
                        <p class="text-[#6B7E94]">Listing diterima</p>
                    </div>
                </div>

                <p class="mt-4 text-sm leading-6 text-[#6B7E94]">{{ $university->alamat ?: 'Alamat belum dicantumkan.' }}</p>

                @if (! $partnership || $partnership->status === 'ditolak')
                    <button type="button" data-modal-target="#proposal-university-{{ $university->id }}" class="cb-primary mt-5 w-full px-4 py-3 text-sm">Buka Proposal</button>
                @else
                    <a href="{{ route('partnerships.index') }}" class="mt-5 inline-flex w-full items-center justify-center rounded-lg border border-[#0D1B2A]/15 px-4 py-3 text-sm font-bold text-[#0D1B2A] hover:bg-[#F7F3ED]">Lihat Kemitraan</a>
                @endif
            </article>

            @if (! $partnership || $partnership->status === 'ditolak')
                @component('partials.modal-shell', [
                    'id' => 'proposal-university-'.$university->id,
                    'title' => 'Kirim proposal ke '.$university->nama,
                    'eyebrow' => 'Proposal Kemitraan',
                    'description' => 'Tulis konteks kerja sama sebelum proposal dikirim ke staf universitas.',
                ])
                    <form method="POST" action="{{ route('partnerships.store') }}" class="grid gap-4">
                        @csrf
                        <input type="hidden" name="university_id" value="{{ $university->id }}">
                        <label class="block">
                            <span class="text-sm font-medium">Pesan proposal</span>
                            <textarea name="pesan" rows="5" required class="cb-input mt-2">Perusahaan kami tertarik membuka jalur magang untuk mahasiswa {{ $university->nama }}.</textarea>
                        </label>
                        <button class="cb-dark-button px-4 py-3 text-sm">Kirim Proposal</button>
                    </form>
                @endcomponent
            @endif
        @empty
            <div class="cb-card border-dashed p-10 text-center text-[#6B7E94] md:col-span-2 xl:col-span-3">Tidak ada universitas yang cocok.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $universities->links() }}</div>
@endsection
