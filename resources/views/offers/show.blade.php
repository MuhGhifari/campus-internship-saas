<x-layouts.app title="{{ $offer->judul }} - CareerBridge">
    <div class="grid gap-6 lg:grid-cols-[1fr_380px]">
        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="font-semibold text-emerald-700">{{ $offer->company->nama }}</p>
                    <h1 class="mt-1 text-3xl font-bold">{{ $offer->judul }}</h1>
                    <p class="mt-3 text-slate-600">{{ $offer->bidang }} • {{ ucfirst($offer->tipe_kerja) }} • {{ $offer->lokasi }}</p>
                </div>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium">{{ ucfirst($offer->status) }}</span>
            </div>

            <div class="mt-6 grid gap-3 text-sm sm:grid-cols-3">
                <div class="rounded-lg bg-slate-50 p-4"><p class="text-slate-500">Kuota</p><p class="font-semibold">{{ $offer->kuota }} mahasiswa</p></div>
                <div class="rounded-lg bg-slate-50 p-4"><p class="text-slate-500">Periode</p><p class="font-semibold">{{ $offer->tanggal_mulai?->format('d/m/Y') ?? '-' }} - {{ $offer->tanggal_selesai?->format('d/m/Y') ?? '-' }}</p></div>
                <div class="rounded-lg bg-slate-50 p-4"><p class="text-slate-500">Batas</p><p class="font-semibold">{{ $offer->batas_lamaran?->format('d/m/Y') ?? '-' }}</p></div>
            </div>

            <div class="prose prose-slate mt-6 max-w-none">
                <h2>Deskripsi</h2>
                <p>{{ $offer->deskripsi }}</p>
                <h2>Persyaratan</h2>
                <p>{{ $offer->persyaratan ?: 'Belum ada persyaratan khusus.' }}</p>
                <h2>Benefit</h2>
                <p>{{ $offer->benefit ?: 'Belum dicantumkan.' }}</p>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="font-semibold">Review Universitas</h2>
                <div class="mt-4 space-y-3">
                    @foreach ($offer->universityRequests as $offerRequest)
                        <div class="rounded-lg border border-slate-200 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold">{{ $offerRequest->university->nama }}</p>
                                    <p class="text-sm text-slate-500">{{ $offerRequest->catatan_review ?: 'Belum ada catatan.' }}</p>
                                </div>
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium">{{ ucfirst($offerRequest->status) }}</span>
                            </div>
                            @if (auth()->user()->hasRole('staf') && auth()->user()->university_id === $offerRequest->university_id && $offerRequest->status === 'menunggu')
                                <form method="POST" action="{{ route('offers.review', $offerRequest) }}" class="mt-3 grid gap-3">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                        <option value="diterima">Terima</option>
                                        <option value="ditolak">Tolak</option>
                                    </select>
                                    <input name="catatan_review" placeholder="Catatan review" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                    <button class="rounded-lg bg-slate-900 px-3 py-2 text-sm font-semibold text-white hover:bg-slate-700">Simpan Review</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            @if (auth()->user()->hasRole('mahasiswa') && $offer->status === 'terbit')
                <form method="POST" action="{{ route('applications.store', $offer) }}" enctype="multipart/form-data" class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    @csrf
                    <h2 class="font-semibold">Lamar Posisi Ini</h2>
                    <label class="mt-4 block">
                        <span class="text-sm font-medium">Motivasi</span>
                        <textarea name="motivasi" rows="5" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('motivasi') }}</textarea>
                    </label>
                    <label class="mt-4 block">
                        <span class="text-sm font-medium">Resume</span>
                        <input name="resume" type="file" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    </label>
                    <label class="mt-4 block">
                        <span class="text-sm font-medium">Surat Pengantar</span>
                        <input name="surat_pengantar" type="file" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                    </label>
                    <button class="mt-4 w-full rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Kirim Lamaran</button>
                </form>
            @endif

            @if (auth()->user()->hasRole('staf') || auth()->user()->hasRole('perusahaan'))
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h2 class="font-semibold">Pelamar</h2>
                        <a href="{{ route('offers.edit', $offer) }}" class="text-sm font-semibold text-emerald-700">Edit</a>
                    </div>
                    <div class="mt-4 space-y-4">
                        @forelse ($offer->applications as $application)
                            <form method="POST" action="{{ route('applications.update', $application) }}" class="rounded-lg border border-slate-200 p-4">
                                @csrf
                                @method('PATCH')
                                <p class="font-semibold">{{ $application->student->name }}</p>
                                <p class="text-sm text-slate-500">{{ $application->student->program_studi }}</p>
                                <select name="status" class="mt-3 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                    @foreach (['diajukan','diseleksi','wawancara','diterima','ditolak','berjalan','selesai'] as $status)
                                        <option value="{{ $status }}" @selected($application->status === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                <select name="campus_supervisor_id" class="mt-3 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                    <option value="">Pilih pembimbing kampus</option>
                                    @foreach ($lecturers as $lecturer)
                                        <option value="{{ $lecturer->id }}" @selected($application->campus_supervisor_id === $lecturer->id)>{{ $lecturer->name }}</option>
                                    @endforeach
                                </select>
                                <select name="company_supervisor_id" class="mt-3 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                    <option value="">Pilih penanggung jawab perusahaan</option>
                                    @foreach ($companySupervisors as $supervisor)
                                        <option value="{{ $supervisor->id }}" @selected($application->company_supervisor_id === $supervisor->id)>{{ $supervisor->name }}</option>
                                    @endforeach
                                </select>
                                <div class="mt-3 grid gap-3 sm:grid-cols-2">
                                    <input name="tanggal_mulai" type="date" value="{{ $application->tanggal_mulai?->format('Y-m-d') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                    <input name="tanggal_selesai" type="date" value="{{ $application->tanggal_selesai?->format('Y-m-d') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                </div>
                                <button class="mt-3 rounded-lg bg-slate-900 px-3 py-2 text-sm font-semibold text-white hover:bg-slate-700">Perbarui</button>
                            </form>
                        @empty
                            <p class="text-sm text-slate-500">Belum ada pelamar.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </aside>
    </div>
</x-layouts.app>
