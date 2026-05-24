@extends('layouts.app')

@section('title', 'Kemitraan - CareerBridge')

@section('content')
    <div class="mb-8 flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="cb-section-label">Kemitraan</p>
            <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">Proposal kerja sama kampus dan perusahaan.</h1>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[380px_1fr]">
        <aside>
            @if (auth()->user()->hasRole('perusahaan'))
                <form method="POST" action="{{ route('partnerships.store') }}" class="cb-card p-6">
                    @csrf
                    <div class="grid h-12 w-12 place-items-center rounded-xl bg-[#0D1B2A] text-white">
                        @include('partials.icon', ['name' => 'handshake', 'class' => 'h-6 w-6'])
                    </div>
                    <h2 class="mt-5 text-xl font-bold text-[#0D1B2A]">Ajukan kemitraan</h2>
                    <p class="mt-2 text-sm leading-6 text-[#6B7E94]">Pilih universitas tujuan sebelum mengirim posisi magang.</p>
                    <label class="mt-5 block">
                        <span class="text-sm font-medium">Universitas</span>
                        <select name="university_id" required class="cb-input mt-1">
                            @foreach ($universities as $university)
                                <option value="{{ $university->id }}">{{ $university->nama }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="mt-4 block">
                        <span class="text-sm font-medium">Pesan Proposal</span>
                        <textarea name="pesan" rows="5" class="cb-input mt-1">Kami ingin membuka program magang untuk mahasiswa dan berkolaborasi dengan kampus.</textarea>
                    </label>
                    <button class="cb-dark-button mt-4 w-full px-4 py-3 text-sm">Kirim Proposal</button>
                </form>
            @else
                <div class="cb-card p-6">
                    <div class="grid h-12 w-12 place-items-center rounded-xl bg-[#FDF3DC] text-[#0D1B2A]">
                        @include('partials.icon', ['name' => 'university', 'class' => 'h-6 w-6'])
                    </div>
                    <h2 class="mt-5 text-xl font-bold text-[#0D1B2A]">Tinjau proposal</h2>
                    <p class="mt-2 text-sm leading-6 text-[#6B7E94]">Terima atau tolak perusahaan yang ingin menjadi partner magang kampus.</p>
                </div>
            @endif
        </aside>

        <section class="space-y-4">
            @forelse ($partnerships as $partnership)
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

                    @if (auth()->user()->hasRole('staf') && $partnership->status === 'menunggu')
                        <form method="POST" action="{{ route('partnerships.update', $partnership) }}" class="mt-4 grid gap-3 sm:grid-cols-[160px_1fr_auto]">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="cb-input text-sm">
                                <option value="diterima">Terima</option>
                                <option value="ditolak">Tolak</option>
                            </select>
                            <input name="catatan_review" placeholder="Catatan untuk perusahaan" class="cb-input text-sm">
                            <button class="cb-dark-button px-4 py-2 text-sm">Simpan</button>
                        </form>
                    @endif
                </article>
            @empty
                <div class="cb-card border-dashed p-10 text-center text-[#6B7E94]">Belum ada proposal kemitraan.</div>
            @endforelse

            {{ $partnerships->links() }}
        </section>
    </div>
@endsection
