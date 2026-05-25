@php($user = auth()->user()->loadMissing(['university', 'company']))

<div class="mb-8">
    <p class="cb-section-label">Profil</p>
    <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">Pengaturan akun dan profil.</h1>
    <p class="mt-3 max-w-2xl text-[#6B7E94]">Perbarui informasi dasar, kontak, dan kata sandi akun CareerBridge.</p>
</div>

<form method="POST" action="{{ route('profile.update') }}" class="grid gap-6 xl:grid-cols-[1fr_420px]">
    @csrf
    @method('PATCH')

    <section class="cb-card p-6">
        <p class="cb-section-label">Akun</p>
        <div class="mt-6 grid gap-4 sm:grid-cols-2">
            <label class="block">
                <span class="text-sm font-medium">Nama</span>
                <input name="name" value="{{ old('name', $user->name) }}" required class="cb-input mt-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">Email</span>
                <input name="email" type="email" value="{{ old('email', $user->email) }}" required class="cb-input mt-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">Telepon</span>
                <input name="telepon" value="{{ old('telepon', $user->telepon) }}" class="cb-input mt-2">
            </label>
            @if ($user->hasRole('mahasiswa') || $user->hasRole('dosen'))
                <label class="block">
                    <span class="text-sm font-medium">{{ $user->hasRole('mahasiswa') ? 'NIM' : 'Nomor Induk' }}</span>
                    <input name="nomor_induk" value="{{ old('nomor_induk', $user->nomor_induk) }}" class="cb-input mt-2">
                </label>
                <label class="block sm:col-span-2">
                    <span class="text-sm font-medium">Program Studi / Departemen</span>
                    <input name="program_studi" value="{{ old('program_studi', $user->program_studi) }}" class="cb-input mt-2">
                </label>
            @endif
        </div>
    </section>

    <aside class="space-y-6">
        @if ($user->hasRole('staf') && $user->university)
            <section class="cb-card p-6">
                <p class="cb-section-label">Universitas</p>
                <div class="mt-6 grid gap-4">
                    <label class="block">
                        <span class="text-sm font-medium">Nama Universitas</span>
                        <input name="university_nama" value="{{ old('university_nama', $user->university->nama) }}" class="cb-input mt-2">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Alamat</span>
                        <textarea name="university_alamat" rows="3" class="cb-input mt-2">{{ old('university_alamat', $user->university->alamat) }}</textarea>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Email Kontak</span>
                        <input name="university_email" type="email" value="{{ old('university_email', $user->university->email) }}" class="cb-input mt-2">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Telepon Kampus</span>
                        <input name="university_telepon" value="{{ old('university_telepon', $user->university->telepon) }}" class="cb-input mt-2">
                    </label>
                </div>
            </section>
        @endif

        @if ($user->hasRole('perusahaan') && $user->company)
            <section class="cb-card p-6">
                <p class="cb-section-label">Perusahaan</p>
                <div class="mt-6 grid gap-4">
                    <label class="block">
                        <span class="text-sm font-medium">Nama Perusahaan</span>
                        <input name="company_nama" value="{{ old('company_nama', $user->company->nama) }}" class="cb-input mt-2">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Industri</span>
                        <input name="company_industri" value="{{ old('company_industri', $user->company->industri) }}" class="cb-input mt-2">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Website</span>
                        <input name="company_website" value="{{ old('company_website', $user->company->website) }}" class="cb-input mt-2">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Alamat</span>
                        <textarea name="company_alamat" rows="3" class="cb-input mt-2">{{ old('company_alamat', $user->company->alamat) }}</textarea>
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Email Kontak</span>
                        <input name="company_kontak_email" type="email" value="{{ old('company_kontak_email', $user->company->kontak_email) }}" class="cb-input mt-2">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Telepon Kontak</span>
                        <input name="company_kontak_telepon" value="{{ old('company_kontak_telepon', $user->company->kontak_telepon) }}" class="cb-input mt-2">
                    </label>
                </div>
            </section>
        @endif

        <section class="cb-card p-6">
            <p class="cb-section-label">Kata Sandi</p>
            <div class="mt-6 grid gap-4">
                <label class="block">
                    <span class="text-sm font-medium">Kata sandi saat ini</span>
                    <input name="current_password" type="password" class="cb-input mt-2">
                </label>
                <label class="block">
                    <span class="text-sm font-medium">Kata sandi baru</span>
                    <input name="password" type="password" class="cb-input mt-2">
                </label>
                <label class="block">
                    <span class="text-sm font-medium">Konfirmasi kata sandi baru</span>
                    <input name="password_confirmation" type="password" class="cb-input mt-2">
                </label>
                <button class="cb-dark-button px-4 py-3 text-sm">Simpan Profil</button>
            </div>
        </section>
    </aside>
</form>
