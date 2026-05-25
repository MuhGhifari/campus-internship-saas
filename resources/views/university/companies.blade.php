@extends('layouts.app')

@section('title', 'Jelajah Perusahaan - CareerBridge')

@section('content')
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="cb-section-label">Jelajah Perusahaan</p>
            <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">Cari perusahaan untuk kerja sama magang.</h1>
            <p class="mt-3 max-w-2xl text-[#6B7E94]">Staf universitas bisa melihat profil perusahaan dan mengirim proposal kemitraan terlebih dahulu.</p>
        </div>
    </div>

    <form method="GET" class="cb-card mb-6 grid gap-4 p-5 md:grid-cols-[1fr_220px_auto]">
        <input name="q" value="{{ request('q') }}" class="cb-input" placeholder="Cari nama perusahaan atau industri">
        <select name="status" class="cb-input">
            <option value="">Semua status</option>
            @foreach (['menunggu' => 'Menunggu', 'diterima' => 'Partner Aktif', 'ditolak' => 'Ditolak'] as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="cb-dark-button px-5 py-3 text-sm">Terapkan</button>
    </form>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($companies as $company)
            @php($partnership = $company->partnerships->first())
            <article class="cb-card p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#E8A020]">{{ $company->industri ?: 'Industri belum diisi' }}</p>
                        <h2 class="mt-2 text-xl font-bold text-[#0D1B2A]">{{ $company->nama }}</h2>
                    </div>
                    <span class="rounded-full bg-[#FDF3DC] px-3 py-1 text-xs font-semibold text-[#0D1B2A]">{{ $partnership ? ucfirst($partnership->status) : 'Belum partner' }}</span>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
                    <div class="rounded-lg bg-[#F7F3ED] p-3">
                        <p class="font-bold text-[#0D1B2A]">{{ $company->offers_count }}</p>
                        <p class="text-[#6B7E94]">Posisi ditawarkan</p>
                    </div>
                    <div class="rounded-lg bg-[#F7F3ED] p-3">
                        <p class="font-bold text-[#0D1B2A]">{{ $company->partnerships_count }}</p>
                        <p class="text-[#6B7E94]">Kemitraan</p>
                    </div>
                </div>

                <p class="mt-4 text-sm leading-6 text-[#6B7E94]">{{ $company->alamat ?: 'Alamat belum dicantumkan.' }}</p>

                @if (! $partnership || $partnership->status === 'ditolak')
                    <form method="POST" action="{{ route('partnerships.store') }}" class="mt-5">
                        @csrf
                        <input type="hidden" name="company_id" value="{{ $company->id }}">
                        <input type="hidden" name="pesan" value="Universitas kami tertarik menjalin kerja sama magang dengan perusahaan Anda.">
                        <button class="cb-primary w-full px-4 py-3 text-sm">Kirim Proposal</button>
                    </form>
                @else
                    <a href="{{ route('partnerships.index') }}" class="mt-5 inline-flex w-full items-center justify-center rounded-lg border border-[#0D1B2A]/15 px-4 py-3 text-sm font-bold text-[#0D1B2A] hover:bg-[#F7F3ED]">Lihat Kemitraan</a>
                @endif
            </article>
        @empty
            <div class="cb-card border-dashed p-10 text-center text-[#6B7E94] md:col-span-2 xl:col-span-3">Tidak ada perusahaan yang cocok.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $companies->links() }}</div>
@endsection
