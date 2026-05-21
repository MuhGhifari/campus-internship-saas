<x-layouts.app title="Evaluasi - CareerBridge">
    <h1 class="text-3xl font-bold">Evaluasi Magang</h1>
    <p class="mt-2 text-slate-600">Penilaian dari pembimbing kampus dan penanggung jawab perusahaan.</p>

    <div class="mt-6 space-y-5">
        @forelse ($applications as $application)
            <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <p class="font-semibold">{{ $application->student->name }}</p>
                        <p class="text-sm text-slate-600">{{ $application->offer->judul }} · {{ $application->offer->company->nama }}</p>
                        <p class="mt-2 text-sm text-slate-500">Status: {{ ucfirst($application->status) }}</p>
                    </div>
                    @if ($application->evaluation)
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700">
                            Rata-rata {{ $application->evaluation->rataRata() }}
                        </span>
                    @endif
                </div>

                @if (auth()->user()->hasRole('dosen') || auth()->user()->hasRole('perusahaan'))
                    <form method="POST" action="{{ route('evaluations.store', $application) }}" class="mt-5 grid gap-4 sm:grid-cols-4">
                        @csrf
                        @foreach ([
                            'nilai_komunikasi' => 'Komunikasi',
                            'nilai_kedisiplinan' => 'Kedisiplinan',
                            'nilai_teknis' => 'Teknis',
                            'nilai_kerja_sama' => 'Kerja Sama',
                        ] as $field => $label)
                            <label class="block">
                                <span class="text-sm font-medium">{{ $label }}</span>
                                <input name="{{ $field }}" type="number" min="0" max="100" value="{{ old($field, $application->evaluation->{$field} ?? 80) }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                            </label>
                        @endforeach
                        <label class="block sm:col-span-4">
                            <span class="text-sm font-medium">Catatan</span>
                            <textarea name="catatan" rows="3" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('catatan', $application->evaluation->catatan ?? '') }}</textarea>
                        </label>
                        <button class="sm:col-span-4 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Simpan Evaluasi</button>
                    </form>
                @endif
            </section>
        @empty
            <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">Belum ada peserta magang untuk dievaluasi.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $applications->links() }}</div>
</x-layouts.app>
