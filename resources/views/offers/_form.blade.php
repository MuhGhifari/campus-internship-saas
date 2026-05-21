@csrf
@if (($method ?? 'POST') !== 'POST')
    @method($method)
@endif

<div class="grid gap-4 sm:grid-cols-2">
    <label class="block">
        <span class="text-sm font-medium">Perusahaan</span>
        <select name="company_id" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" @selected(old('company_id', $offer->company_id ?? auth()->user()->company_id) == $company->id)>
                    {{ $company->nama }}
                </option>
            @endforeach
        </select>
    </label>
    <label class="block">
        <span class="text-sm font-medium">Status</span>
        <select name="status" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
            @foreach (['draft' => 'Draft', 'menunggu' => 'Menunggu Review', 'terbit' => 'Terbit', 'ditutup' => 'Ditutup'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $offer->status ?? 'menunggu') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </label>
    <label class="block sm:col-span-2">
        <span class="text-sm font-medium">Kirim ke Universitas Partner</span>
        <select name="university_ids[]" multiple required class="mt-1 min-h-32 w-full rounded-lg border border-slate-300 px-3 py-2">
            @foreach ($universities as $university)
                <option value="{{ $university->id }}" @selected(in_array($university->id, old('university_ids', $selectedUniversities ?? [])))>
                    {{ $university->nama }}
                </option>
            @endforeach
        </select>
        <span class="mt-1 block text-xs text-slate-500">Tahan Cmd/Ctrl untuk memilih lebih dari satu universitas. Hanya universitas dengan kemitraan diterima yang dapat dipilih.</span>
    </label>
    <label class="block sm:col-span-2">
        <span class="text-sm font-medium">Judul Posisi</span>
        <input name="judul" value="{{ old('judul', $offer->judul ?? '') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
    </label>
    <label class="block">
        <span class="text-sm font-medium">Bidang</span>
        <input name="bidang" value="{{ old('bidang', $offer->bidang ?? '') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
    </label>
    <label class="block">
        <span class="text-sm font-medium">Lokasi</span>
        <input name="lokasi" value="{{ old('lokasi', $offer->lokasi ?? '') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
    </label>
    <label class="block">
        <span class="text-sm font-medium">Tipe Kerja</span>
        <select name="tipe_kerja" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
            @foreach (['onsite' => 'On-site', 'remote' => 'Remote', 'hybrid' => 'Hybrid'] as $value => $label)
                <option value="{{ $value }}" @selected(old('tipe_kerja', $offer->tipe_kerja ?? 'hybrid') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </label>
    <label class="block">
        <span class="text-sm font-medium">Kuota</span>
        <input name="kuota" type="number" min="1" value="{{ old('kuota', $offer->kuota ?? 1) }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
    </label>
    <label class="block">
        <span class="text-sm font-medium">Tanggal Mulai</span>
        <input name="tanggal_mulai" type="date" value="{{ old('tanggal_mulai', isset($offer) ? $offer->tanggal_mulai?->format('Y-m-d') : '') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
    </label>
    <label class="block">
        <span class="text-sm font-medium">Tanggal Selesai</span>
        <input name="tanggal_selesai" type="date" value="{{ old('tanggal_selesai', isset($offer) ? $offer->tanggal_selesai?->format('Y-m-d') : '') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
    </label>
    <label class="block">
        <span class="text-sm font-medium">Batas Lamaran</span>
        <input name="batas_lamaran" type="date" value="{{ old('batas_lamaran', isset($offer) ? $offer->batas_lamaran?->format('Y-m-d') : '') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
    </label>
    <div></div>
    <label class="block sm:col-span-2">
        <span class="text-sm font-medium">Deskripsi</span>
        <textarea name="deskripsi" required rows="5" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('deskripsi', $offer->deskripsi ?? '') }}</textarea>
    </label>
    <label class="block sm:col-span-2">
        <span class="text-sm font-medium">Persyaratan</span>
        <textarea name="persyaratan" rows="4" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('persyaratan', $offer->persyaratan ?? '') }}</textarea>
    </label>
    <label class="block sm:col-span-2">
        <span class="text-sm font-medium">Benefit</span>
        <textarea name="benefit" rows="3" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('benefit', $offer->benefit ?? '') }}</textarea>
    </label>
</div>

<div class="mt-6 flex gap-3">
    <button class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Simpan Lowongan</button>
    <a href="{{ route('offers.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-50">Batal</a>
</div>
