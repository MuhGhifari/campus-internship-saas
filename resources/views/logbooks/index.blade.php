<x-layouts.app title="Logbook - CareerBridge">
    <div class="grid gap-6 lg:grid-cols-[360px_1fr]">
        <aside>
            @if (auth()->user()->hasRole('mahasiswa'))
                <form method="POST" action="{{ route('logbooks.store') }}" class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    @csrf
                    <h1 class="text-xl font-bold">Isi Logbook Harian</h1>
                    @if ($activeApplication)
                        <input type="hidden" name="internship_application_id" value="{{ $activeApplication->id }}">
                        <p class="mt-2 text-sm text-slate-600">{{ $activeApplication->offer->judul }} · {{ $activeApplication->offer->company->nama }}</p>
                        <label class="mt-4 block">
                            <span class="text-sm font-medium">Tanggal</span>
                            <input name="tanggal" type="date" value="{{ now()->format('Y-m-d') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                        </label>
                        <label class="mt-4 block">
                            <span class="text-sm font-medium">Judul Kegiatan</span>
                            <input name="judul_kegiatan" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                        </label>
                        <label class="mt-4 block">
                            <span class="text-sm font-medium">Deskripsi</span>
                            <textarea name="deskripsi" rows="5" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2"></textarea>
                        </label>
                        <label class="mt-4 block">
                            <span class="text-sm font-medium">Kendala</span>
                            <textarea name="kendala" rows="3" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2"></textarea>
                        </label>
                        <button class="mt-4 w-full rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Kirim Logbook</button>
                    @else
                        <p class="mt-4 text-sm text-slate-500">Belum ada lamaran diterima atau berjalan.</p>
                    @endif
                </form>
            @else
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <h1 class="text-xl font-bold">Review Logbook</h1>
                    <p class="mt-2 text-sm text-slate-600">Dosen dan penanggung jawab perusahaan dapat menyetujui atau meminta revisi logbook.</p>
                </div>
            @endif
        </aside>

        <section class="space-y-4">
            @forelse ($logbooks as $logbook)
                <article class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm text-slate-500">{{ $logbook->tanggal->format('d/m/Y') }} · {{ $logbook->student->name }}</p>
                            <h2 class="mt-1 text-lg font-bold">{{ $logbook->judul_kegiatan }}</h2>
                            <p class="mt-2 text-sm text-slate-600">{{ $logbook->application->offer->judul }} di {{ $logbook->application->offer->company->nama }}</p>
                        </div>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium">{{ ucfirst($logbook->status) }}</span>
                    </div>
                    <p class="mt-4 text-slate-700">{{ $logbook->deskripsi }}</p>
                    @if ($logbook->kendala)
                        <p class="mt-3 text-sm text-slate-500">Kendala: {{ $logbook->kendala }}</p>
                    @endif
                    @if ($logbook->catatan_pembimbing)
                        <p class="mt-3 rounded-lg bg-amber-50 p-3 text-sm text-amber-900">Catatan: {{ $logbook->catatan_pembimbing }}</p>
                    @endif

                    @if (auth()->user()->hasRole('dosen') || auth()->user()->hasRole('perusahaan'))
                        <form method="POST" action="{{ route('logbooks.update', $logbook) }}" class="mt-4 grid gap-3 sm:grid-cols-[180px_1fr_auto]">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                @foreach (['menunggu' => 'Menunggu', 'disetujui' => 'Disetujui', 'revisi' => 'Revisi'] as $value => $label)
                                    <option value="{{ $value }}" @selected($logbook->status === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <input name="catatan_pembimbing" value="{{ $logbook->catatan_pembimbing }}" placeholder="Catatan pembimbing" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Simpan</button>
                        </form>
                    @endif
                </article>
            @empty
                <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">Belum ada logbook.</div>
            @endforelse
            {{ $logbooks->links() }}
        </section>
    </div>
</x-layouts.app>
