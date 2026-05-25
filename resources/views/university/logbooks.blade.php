@extends('layouts.app')

@section('title', 'Catatan Harian - CareerBridge')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[380px_1fr]">
        <aside>
            @if (auth()->user()->hasRole('mahasiswa'))
                <div class="cb-card p-6">
                    <div class="grid h-12 w-12 place-items-center rounded-xl bg-[#0D1B2A] text-white">
                        @include('partials.icon', ['name' => 'note', 'class' => 'h-6 w-6'])
                    </div>
                    <h1 class="mt-5 text-xl font-bold text-[#0D1B2A]">Isi Catatan Harian</h1>
                    @if ($activeApplication)
                        <p class="mt-2 text-sm leading-6 text-[#6B7E94]">{{ $activeApplication->offer->judul }} · {{ $activeApplication->offer->company->nama }}</p>
                        <button type="button" data-modal-target="#logbook-create-modal" class="cb-dark-button mt-5 w-full px-4 py-3 text-sm">Tulis Catatan</button>
                    @else
                        <p class="mt-4 text-sm text-[#6B7E94]">Belum ada lamaran diterima atau berjalan.</p>
                    @endif
                </div>
            @else
                <div class="cb-card p-6">
                    <div class="grid h-12 w-12 place-items-center rounded-xl bg-[#FDF3DC] text-[#0D1B2A]">
                        @include('partials.icon', ['name' => 'eye', 'class' => 'h-6 w-6'])
                    </div>
                    <h1 class="mt-5 text-xl font-bold text-[#0D1B2A]">Tinjau Catatan Harian</h1>
                    <p class="mt-2 text-sm leading-6 text-[#6B7E94]">Setujui progres mahasiswa atau minta revisi dengan catatan.</p>
                </div>
            @endif
        </aside>

        <section class="space-y-4">
            @forelse ($logbooks as $logbook)
                <article class="cb-card p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm text-[#6B7E94]">{{ $logbook->tanggal->format('d/m/Y') }} · {{ $logbook->student->name }}</p>
                            <h2 class="mt-1 text-lg font-bold text-[#0D1B2A]">{{ $logbook->judul_kegiatan }}</h2>
                            <p class="mt-2 text-sm text-[#6B7E94]">{{ $logbook->application->offer->judul }} di {{ $logbook->application->offer->company->nama }}</p>
                        </div>
                        <span class="rounded-full bg-[#FDF3DC] px-3 py-1 text-xs font-semibold text-[#0D1B2A]">{{ ucfirst($logbook->status) }}</span>
                    </div>
                    <p class="mt-4 leading-7 text-[#3D526B]">{{ $logbook->deskripsi }}</p>
                    @if ($logbook->kendala)
                        <p class="mt-3 text-sm text-[#6B7E94]">Kendala: {{ $logbook->kendala }}</p>
                    @endif
                    @if ($logbook->catatan_pembimbing)
                        <p class="mt-3 rounded-xl bg-[#FDF3DC] p-3 text-sm text-[#0D1B2A]">Catatan: {{ $logbook->catatan_pembimbing }}</p>
                    @endif

                    @if (auth()->user()->hasRole('dosen') || auth()->user()->hasRole('perusahaan'))
                        <button type="button" data-modal-target="#logbook-review-{{ $logbook->id }}" class="cb-dark-button mt-4 px-4 py-2 text-sm">Tinjau Catatan</button>
                        @component('partials.modal-shell', [
                            'id' => 'logbook-review-'.$logbook->id,
                            'title' => 'Tinjau catatan harian',
                            'eyebrow' => $logbook->student->name,
                            'description' => $logbook->judul_kegiatan,
                        ])
                            <form method="POST" action="{{ route('logbooks.update', $logbook) }}" class="grid gap-4">
                                @csrf
                                @method('PATCH')
                                <label class="block">
                                    <span class="text-sm font-medium">Status</span>
                                    <select name="status" class="cb-input mt-2 text-sm">
                                        @foreach (['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'revisi' => 'Revisi'] as $value => $label)
                                            <option value="{{ $value }}" @selected($logbook->status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <label class="block">
                                    <span class="text-sm font-medium">Catatan pembimbing</span>
                                    <textarea name="catatan_pembimbing" rows="4" placeholder="Catatan pembimbing" class="cb-input mt-2 text-sm">{{ $logbook->catatan_pembimbing }}</textarea>
                                </label>
                                <button class="cb-dark-button px-4 py-3 text-sm">Simpan Tinjauan</button>
                            </form>
                        @endcomponent
                    @endif
                </article>
            @empty
                <div class="cb-card border-dashed p-10 text-center text-[#6B7E94]">Belum ada catatan harian.</div>
            @endforelse
            {{ $logbooks->links() }}
        </section>
    </div>

    @if (auth()->user()->hasRole('mahasiswa') && $activeApplication)
        @component('partials.modal-shell', [
            'id' => 'logbook-create-modal',
            'title' => 'Isi catatan harian',
            'eyebrow' => 'Logbook',
            'description' => $activeApplication->offer->judul.' · '.$activeApplication->offer->company->nama,
        ])
            <form method="POST" action="{{ route('logbooks.store') }}" class="grid gap-4">
                @csrf
                <input type="hidden" name="internship_application_id" value="{{ $activeApplication->id }}">
                <label class="block">
                    <span class="text-sm font-medium">Tanggal</span>
                    <input name="tanggal" type="date" value="{{ now()->format('Y-m-d') }}" required class="cb-input mt-2">
                </label>
                <label class="block">
                    <span class="text-sm font-medium">Judul Kegiatan</span>
                    <input name="judul_kegiatan" required class="cb-input mt-2">
                </label>
                <label class="block">
                    <span class="text-sm font-medium">Deskripsi</span>
                    <textarea name="deskripsi" rows="5" required class="cb-input mt-2"></textarea>
                </label>
                <label class="block">
                    <span class="text-sm font-medium">Kendala</span>
                    <textarea name="kendala" rows="3" class="cb-input mt-2"></textarea>
                </label>
                <button class="cb-dark-button px-4 py-3 text-sm">Kirim Catatan</button>
            </form>
        @endcomponent
    @endif
@endsection
