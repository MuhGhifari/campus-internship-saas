@extends('layouts.app')

@section('title', 'Buat Lowongan - CareerBridge')

@section('content')
    <div class="mb-8 grid gap-6 lg:grid-cols-[1fr_320px]">
        <div>
            <p class="cb-section-label">Lowongan Baru</p>
            <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">Kirim posisi magang ke kampus partner.</h1>
            <p class="mt-3 max-w-2xl text-[#6B7E94]">Lengkapi informasi posisi, pilih universitas tujuan, lalu kampus akan meninjau sebelum lowongan tampil ke mahasiswa.</p>
        </div>
        <div class="cb-card bg-[#0D1B2A] p-6 text-white">
            <div class="grid h-12 w-12 place-items-center rounded-lg bg-[#E8A020] text-[#0D1B2A]">
                @include('partials.icon', ['name' => 'megaphone', 'class' => 'h-6 w-6'])
            </div>
            <h2 class="mt-5 font-semibold">Alur publikasi</h2>
            <p class="mt-2 text-sm leading-6 text-white/65">Perusahaan mengirim posisi, universitas memberi persetujuan, mahasiswa melamar dari daftar resmi kampus.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('offers.store') }}" class="cb-card p-6 lg:p-8">
        @include('offers._form')
    </form>
@endsection
