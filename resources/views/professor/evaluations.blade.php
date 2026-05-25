@extends('layouts.app')

@section('title', 'Evaluasi - CareerBridge')

@section('content')
    <div class="mb-8">
        <p class="cb-section-label">Evaluasi</p>
        <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">Nilai akhir program magang.</h1>
        <p class="mt-3 text-[#6B7E94]">Penilaian dari pembimbing kampus dan penanggung jawab perusahaan.</p>
    </div>

    <div class="space-y-5">
        @forelse ($applications as $application)
            <section class="cb-card p-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <p class="font-semibold text-[#0D1B2A]">{{ $application->student->name }}</p>
                        <p class="mt-1 text-sm text-[#6B7E94]">{{ $application->offer->judul }} · {{ $application->offer->company->nama }}</p>
                        <p class="mt-2 text-sm text-[#6B7E94]">Status: {{ ucfirst($application->status) }}</p>
                    </div>
                    @if ($application->evaluation)
                        <span class="rounded-full bg-[#FDF3DC] px-4 py-2 text-sm font-bold text-[#0D1B2A]">Rata-rata {{ $application->evaluation->rataRata() }}</span>
                    @endif
                </div>

                @if (auth()->user()->hasRole('dosen') || auth()->user()->hasRole('company_supervisor'))
                    <button type="button" data-modal-target="#evaluation-{{ $application->id }}" class="cb-dark-button mt-6 px-4 py-3 text-sm">Isi Evaluasi</button>
                    @component('partials.modal-shell', [
                        'id' => 'evaluation-'.$application->id,
                        'title' => 'Evaluasi '.$application->student->name,
                        'eyebrow' => 'Nilai Magang',
                        'description' => $application->offer->judul.' · '.$application->offer->company->nama,
                    ])
                        <form method="POST" action="{{ route('evaluations.store', $application) }}" class="grid gap-4 sm:grid-cols-4">
                            @csrf
                            @foreach ([
                                'nilai_komunikasi' => 'Komunikasi',
                                'nilai_kedisiplinan' => 'Kedisiplinan',
                                'nilai_teknis' => 'Teknis',
                                'nilai_kerja_sama' => 'Kerja Sama',
                            ] as $field => $label)
                                <label class="block">
                                    <span class="text-sm font-medium">{{ $label }}</span>
                                    <input name="{{ $field }}" type="number" min="0" max="100" value="{{ old($field, $application->evaluation->{$field} ?? 80) }}" class="cb-input mt-2">
                                </label>
                            @endforeach
                            <label class="block sm:col-span-4">
                                <span class="text-sm font-medium">Catatan</span>
                                <textarea name="catatan" rows="3" class="cb-input mt-2">{{ old('catatan', $application->evaluation->catatan ?? '') }}</textarea>
                            </label>
                            <button class="cb-dark-button sm:col-span-4 px-4 py-3 text-sm">Simpan Evaluasi</button>
                        </form>
                    @endcomponent
                @endif
            </section>
        @empty
            <div class="cb-card border-dashed p-10 text-center text-[#6B7E94]">Belum ada peserta magang untuk dievaluasi.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $applications->links() }}</div>
@endsection
