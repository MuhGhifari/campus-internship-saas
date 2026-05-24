@csrf
@if (($method ?? 'POST') !== 'POST')
    @method($method)
@endif

@php
    $selectedUniversityIds = collect(old('university_ids', $selectedUniversities ?? []))->map(fn ($id) => (int) $id)->all();
@endphp

<div class="grid gap-8">
    <section>
        <div class="mb-5 flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#0D1B2A] text-white">
                @include('partials.icon', ['name' => 'company', 'class' => 'h-5 w-5'])
            </span>
            <div>
                <h2 class="font-bold text-[#0D1B2A]">Tujuan dan status</h2>
                <p class="text-sm text-[#6B7E94]">Pilih perusahaan pengirim dan kampus partner yang akan meninjau posisi ini.</p>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <label class="block">
                <span class="text-sm font-semibold text-[#0D1B2A]">Perusahaan</span>
                <select name="company_id" required class="cb-input mt-2">
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" @selected(old('company_id', $offer->company_id ?? auth()->user()->company_id) == $company->id)>
                            {{ $company->nama }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-[#0D1B2A]">Status publikasi</span>
                <select name="status" class="cb-input mt-2">
                    @foreach (['draft' => 'Draf', 'menunggu' => 'Menunggu Tinjauan', 'terbit' => 'Terbit', 'ditutup' => 'Ditutup'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $offer->status ?? 'menunggu') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <div class="mt-5">
            <span class="text-sm font-semibold text-[#0D1B2A]">Kirim ke universitas partner</span>
            <div class="mt-3 grid gap-3 md:grid-cols-2">
                @forelse ($universities as $university)
                    <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-[#0D1B2A]/10 bg-[#F7F3ED] p-4 transition hover:border-[#E8A020]">
                        <input type="checkbox" name="university_ids[]" value="{{ $university->id }}" @checked(in_array($university->id, $selectedUniversityIds)) class="mt-1 rounded border-[#0D1B2A]/20 text-[#E8A020] focus:ring-[#E8A020]">
                        <span>
                            <span class="block font-semibold text-[#0D1B2A]">{{ $university->nama }}</span>
                            <span class="mt-1 block text-xs text-[#6B7E94]">Kampus partner yang dapat menerima permintaan lowongan.</span>
                        </span>
                    </label>
                @empty
                    <div class="rounded-lg border border-dashed border-[#0D1B2A]/20 bg-[#F7F3ED] p-5 text-sm text-[#6B7E94] md:col-span-2">
                        Belum ada universitas partner yang disetujui untuk perusahaan ini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="border-t border-[#0D1B2A]/10 pt-8">
        <div class="mb-5 flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#E8A020] text-[#0D1B2A]">
                @include('partials.icon', ['name' => 'briefcase', 'class' => 'h-5 w-5'])
            </span>
            <div>
                <h2 class="font-bold text-[#0D1B2A]">Detail posisi</h2>
                <p class="text-sm text-[#6B7E94]">Buat informasi singkat, jelas, dan mudah dipahami mahasiswa.</p>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <label class="block lg:col-span-2">
                <span class="text-sm font-semibold text-[#0D1B2A]">Judul posisi</span>
                <input name="judul" value="{{ old('judul', $offer->judul ?? '') }}" required class="cb-input mt-2" placeholder="Contoh: Asisten Pengembang Backend">
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-[#0D1B2A]">Bidang</span>
                <input name="bidang" value="{{ old('bidang', $offer->bidang ?? '') }}" required class="cb-input mt-2" placeholder="Teknologi, Akuntansi, Pemasaran">
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-[#0D1B2A]">Lokasi</span>
                <input name="lokasi" value="{{ old('lokasi', $offer->lokasi ?? '') }}" required class="cb-input mt-2" placeholder="Jakarta, Bandung, Jarak Jauh">
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-[#0D1B2A]">Tipe kerja</span>
                <select name="tipe_kerja" class="cb-input mt-2">
                    @foreach (['onsite' => 'Luring', 'remote' => 'Jarak Jauh', 'hybrid' => 'Campuran'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('tipe_kerja', $offer->tipe_kerja ?? 'hybrid') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-[#0D1B2A]">Kuota mahasiswa</span>
                <input name="kuota" type="number" min="1" value="{{ old('kuota', $offer->kuota ?? 1) }}" required class="cb-input mt-2">
            </label>
        </div>
    </section>

    <section class="border-t border-[#0D1B2A]/10 pt-8">
        <div class="mb-5 flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#0D1B2A] text-white">
                @include('partials.icon', ['name' => 'calendar', 'class' => 'h-5 w-5'])
            </span>
            <div>
                <h2 class="font-bold text-[#0D1B2A]">Jadwal</h2>
                <p class="text-sm text-[#6B7E94]">Atur periode kerja dan batas pengiriman lamaran.</p>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-3">
            <label class="block">
                <span class="text-sm font-semibold text-[#0D1B2A]">Tanggal mulai</span>
                <input name="tanggal_mulai" type="date" value="{{ old('tanggal_mulai', isset($offer) ? $offer->tanggal_mulai?->format('Y-m-d') : '') }}" class="cb-input mt-2">
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-[#0D1B2A]">Tanggal selesai</span>
                <input name="tanggal_selesai" type="date" value="{{ old('tanggal_selesai', isset($offer) ? $offer->tanggal_selesai?->format('Y-m-d') : '') }}" class="cb-input mt-2">
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-[#0D1B2A]">Batas lamaran</span>
                <input name="batas_lamaran" type="date" value="{{ old('batas_lamaran', isset($offer) ? $offer->batas_lamaran?->format('Y-m-d') : '') }}" class="cb-input mt-2">
            </label>
        </div>
    </section>

    <section class="border-t border-[#0D1B2A]/10 pt-8">
        <div class="mb-5 flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-lg bg-[#E8A020] text-[#0D1B2A]">
                @include('partials.icon', ['name' => 'note', 'class' => 'h-5 w-5'])
            </span>
            <div>
                <h2 class="font-bold text-[#0D1B2A]">Informasi untuk mahasiswa</h2>
                <p class="text-sm text-[#6B7E94]">Tuliskan konteks pekerjaan, syarat, dan manfaat yang akan diterima.</p>
            </div>
        </div>

        <div class="grid gap-4">
            <label class="block">
                <span class="text-sm font-semibold text-[#0D1B2A]">Deskripsi</span>
                <textarea name="deskripsi" required rows="5" class="cb-input mt-2">{{ old('deskripsi', $offer->deskripsi ?? '') }}</textarea>
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-[#0D1B2A]">Persyaratan</span>
                <textarea name="persyaratan" rows="4" class="cb-input mt-2">{{ old('persyaratan', $offer->persyaratan ?? '') }}</textarea>
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-[#0D1B2A]">Benefit</span>
                <textarea name="benefit" rows="3" class="cb-input mt-2">{{ old('benefit', $offer->benefit ?? '') }}</textarea>
            </label>
        </div>
    </section>
</div>

<div class="mt-8 flex flex-wrap gap-3 border-t border-[#0D1B2A]/10 pt-6">
    <button class="cb-dark-button px-5 py-3 text-sm">Simpan Lowongan</button>
    <a href="{{ route('offers.index') }}" class="rounded-lg border border-[#0D1B2A]/15 px-5 py-3 text-sm font-semibold text-[#0D1B2A] hover:bg-[#F7F3ED]">Batal</a>
</div>
