@extends('layouts.app')

@section('title', 'Pembimbing Kampus - CareerBridge')

@section('content')
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="cb-section-label">Pembimbing Kampus</p>
            <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">Kelola dosen pembimbing magang.</h1>
            <p class="mt-3 max-w-2xl text-[#6B7E94]">Akun pembimbing hanya bisa melihat mahasiswa yang ditugaskan oleh staf universitas.</p>
        </div>
        <button type="button" data-modal-target="#supervisor-create-modal" class="cb-primary inline-flex items-center justify-center gap-2 px-5 py-3 text-sm">
            @include('partials.icon', ['name' => 'mentor', 'class' => 'h-4 w-4'])
            Tambah Pembimbing
        </button>
    </div>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($supervisors as $supervisor)
            <article class="cb-card p-5">
                <div class="flex items-start gap-4">
                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-[#FDF3DC] text-[#0D1B2A]">
                        @include('partials.icon', ['name' => 'mentor', 'class' => 'h-6 w-6'])
                    </span>
                    <div class="min-w-0">
                        <h2 class="font-bold text-[#0D1B2A]">{{ $supervisor->name }}</h2>
                        <p class="mt-1 break-words text-sm text-[#6B7E94]">{{ $supervisor->email }}</p>
                        <p class="mt-3 text-sm text-[#3D526B]">{{ $supervisor->program_studi ?: 'Departemen belum diisi' }}</p>
                    </div>
                </div>
            </article>
        @empty
            <div class="cb-card border-dashed p-10 text-center text-[#6B7E94] md:col-span-2 xl:col-span-3">Belum ada akun pembimbing kampus.</div>
        @endforelse
    </section>

    <div class="mt-6">{{ $supervisors->links() }}</div>

    @component('partials.modal-shell', [
        'id' => 'supervisor-create-modal',
        'title' => 'Tambah pembimbing kampus',
        'eyebrow' => 'Akun Pembimbing',
        'description' => 'Pembimbing hanya melihat mahasiswa yang ditetapkan ke akunnya.',
    ])
        <form method="POST" action="{{ route('supervisors.store') }}" class="grid gap-4 sm:grid-cols-2">
            @csrf
            <label class="block">
                <span class="text-sm font-medium">Nama</span>
                <input name="name" value="{{ old('name') }}" required class="cb-input mt-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">Email</span>
                <input name="email" type="email" value="{{ old('email') }}" required class="cb-input mt-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">Nomor induk</span>
                <input name="nomor_induk" value="{{ old('nomor_induk') }}" class="cb-input mt-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">Program studi / departemen</span>
                <input name="program_studi" value="{{ old('program_studi') }}" class="cb-input mt-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">Telepon</span>
                <input name="telepon" value="{{ old('telepon') }}" class="cb-input mt-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">Kata sandi</span>
                <input name="password" type="password" required class="cb-input mt-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">Konfirmasi kata sandi</span>
                <input name="password_confirmation" type="password" required class="cb-input mt-2">
            </label>
            <button class="cb-dark-button px-4 py-3 text-sm sm:col-span-2">Buat Akun Pembimbing</button>
        </form>
    @endcomponent
@endsection
