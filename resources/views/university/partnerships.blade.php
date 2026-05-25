@extends('layouts.app')

@section('title', 'Kemitraan - CareerBridge')

@section('content')
    <div class="mb-8 flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="cb-section-label">Kemitraan</p>
            <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">Proposal kerja sama kampus dan perusahaan.</h1>
        </div>
        @if (auth()->user()->hasRole('perusahaan') || auth()->user()->hasRole('staf'))
            <button type="button" data-modal-target="#partnership-create-modal" class="cb-primary inline-flex px-5 py-3 text-sm">Ajukan Kemitraan</button>
        @endif
    </div>

    <div class="grid gap-6 lg:grid-cols-[380px_1fr]">
        <aside>
            @if (auth()->user()->hasRole('perusahaan'))
                <div class="cb-card p-6">
                    <div class="grid h-12 w-12 place-items-center rounded-xl bg-[#0D1B2A] text-white">
                        @include('partials.icon', ['name' => 'handshake', 'class' => 'h-6 w-6'])
                    </div>
                    <h2 class="mt-5 text-xl font-bold text-[#0D1B2A]">Ajukan kemitraan</h2>
                    <p class="mt-2 text-sm leading-6 text-[#6B7E94]">Pilih universitas tujuan sebelum mengirim posisi magang.</p>
                    <button type="button" data-modal-target="#partnership-create-modal" class="cb-dark-button mt-5 w-full px-4 py-3 text-sm">Buka Form Proposal</button>
                </div>
            @else
                <div class="cb-card p-6">
                    <div class="grid h-12 w-12 place-items-center rounded-xl bg-[#FDF3DC] text-[#0D1B2A]">
                        @include('partials.icon', ['name' => 'university', 'class' => 'h-6 w-6'])
                    </div>
                    <h2 class="mt-5 text-xl font-bold text-[#0D1B2A]">Kelola kemitraan</h2>
                    <p class="mt-2 text-sm leading-6 text-[#6B7E94]">Tinjau proposal masuk atau ajukan kerja sama ke perusahaan pilihan kampus.</p>
                    <button type="button" data-modal-target="#partnership-create-modal" class="cb-dark-button mt-5 w-full px-4 py-3 text-sm">Ajukan ke Perusahaan</button>
                </div>
            @endif
        </aside>

        <section class="space-y-4">
            @forelse ($partnerships as $partnership)
                @php
                    $canReview = $partnership->status === 'menunggu'
                        && $partnership->requested_by !== auth()->id()
                        && (
                            (auth()->user()->hasRole('staf') && $partnership->university_id === auth()->user()->university_id)
                            || (auth()->user()->hasRole('perusahaan') && $partnership->company_id === auth()->user()->company_id)
                        );
                @endphp
                <article class="cb-card p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-semibold text-[#0D1B2A]">{{ $partnership->company->nama }}</p>
                            <p class="mt-1 text-sm text-[#6B7E94]">{{ $partnership->university->nama }}</p>
                            @if ($partnership->pesan)
                                <p class="mt-4 text-sm leading-6 text-[#3D526B]">{{ $partnership->pesan }}</p>
                            @endif
                        </div>
                        <span class="rounded-full bg-[#FDF3DC] px-3 py-1 text-xs font-semibold text-[#0D1B2A]">{{ ucfirst($partnership->status) }}</span>
                    </div>

                    @if ($partnership->catatan_review)
                        <p class="mt-4 rounded-xl bg-[#F7F3ED] p-3 text-sm text-[#6B7E94]">Catatan: {{ $partnership->catatan_review }}</p>
                    @endif

                    @if ($canReview)
                        <button type="button" data-modal-target="#partnership-review-{{ $partnership->id }}" class="cb-dark-button mt-4 px-4 py-2 text-sm">Tinjau Proposal</button>

                        @component('partials.modal-shell', [
                            'id' => 'partnership-review-'.$partnership->id,
                            'title' => 'Tinjau proposal '.$partnership->company->nama,
                            'eyebrow' => 'Review Kemitraan',
                            'description' => 'Berikan keputusan dan catatan agar perusahaan memahami hasil tinjauan.',
                        ])
                            <form method="POST" action="{{ route('partnerships.update', $partnership) }}" class="grid gap-4">
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
                                    <textarea name="catatan_review" rows="4" placeholder="Catatan untuk perusahaan" class="cb-input mt-2 text-sm"></textarea>
                                </label>
                                <button class="cb-dark-button px-4 py-3 text-sm">Simpan Keputusan</button>
                            </form>
                        @endcomponent
                    @endif
                </article>
            @empty
                <div class="cb-card border-dashed p-10 text-center text-[#6B7E94]">Belum ada proposal kemitraan.</div>
            @endforelse

            {{ $partnerships->links() }}
        </section>
    </div>

    @if (auth()->user()->hasRole('perusahaan') || auth()->user()->hasRole('staf'))
        @component('partials.modal-shell', [
            'id' => 'partnership-create-modal',
            'title' => auth()->user()->hasRole('perusahaan') ? 'Ajukan kemitraan kampus' : 'Ajukan kemitraan perusahaan',
            'eyebrow' => 'Proposal Baru',
            'description' => 'Pilih tujuan proposal dan tuliskan konteks kerja sama yang ingin diajukan.',
        ])
            <form method="POST" action="{{ route('partnerships.store') }}" class="grid gap-4">
                @csrf
                @if (auth()->user()->hasRole('perusahaan'))
                    <label class="block">
                        <span class="text-sm font-medium">Universitas</span>
                        <select name="university_id" required class="cb-input mt-2">
                            @foreach ($universities as $university)
                                <option value="{{ $university->id }}">{{ $university->nama }}</option>
                            @endforeach
                        </select>
                    </label>
                @else
                    <label class="block">
                        <span class="text-sm font-medium">Perusahaan</span>
                        <select name="company_id" required class="cb-input mt-2">
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->nama }}</option>
                            @endforeach
                        </select>
                    </label>
                @endif
                <label class="block">
                    <span class="text-sm font-medium">Pesan Proposal</span>
                    <textarea name="pesan" rows="5" class="cb-input mt-2">{{ auth()->user()->hasRole('perusahaan') ? 'Kami ingin membuka program magang untuk mahasiswa dan berkolaborasi dengan kampus.' : 'Universitas kami tertarik menjalin kerja sama magang dengan perusahaan Anda.' }}</textarea>
                </label>
                <button class="cb-dark-button px-4 py-3 text-sm">Kirim Proposal</button>
            </form>
        @endcomponent
    @endif
@endsection
