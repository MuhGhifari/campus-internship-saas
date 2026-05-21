<x-layouts.app title="Daftar Mahasiswa - CareerBridge">
    <div class="mx-auto max-w-3xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold">Daftar Akun CareerBridge</h1>
        <p class="mt-2 text-sm text-slate-600">Universitas, perusahaan, dan mahasiswa dapat mendaftar mandiri sesuai alur layanan SaaS.</p>

        <form method="POST" action="{{ route('register.store') }}" class="mt-6 grid gap-4 sm:grid-cols-2">
            @csrf
            <label class="block sm:col-span-2">
                <span class="text-sm font-medium">Jenis Akun</span>
                <select name="account_type" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                    <option value="mahasiswa" @selected(old('account_type') === 'mahasiswa')>Mahasiswa</option>
                    <option value="universitas" @selected(old('account_type') === 'universitas')>Universitas / Staf Kampus</option>
                    <option value="perusahaan" @selected(old('account_type') === 'perusahaan')>Perusahaan / HR</option>
                </select>
            </label>

            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 sm:col-span-2">
                <p class="font-semibold">Data universitas</p>
                <p class="mt-1 text-sm text-slate-600">Diisi jika mendaftarkan kampus baru.</p>
                <div class="mt-3 grid gap-4 sm:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-medium">Nama Universitas</span>
                        <input name="university_name" value="{{ old('university_name') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Kode Universitas</span>
                        <input name="university_code" value="{{ old('university_code') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                    </label>
                </div>
            </div>

            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 sm:col-span-2">
                <p class="font-semibold">Data perusahaan</p>
                <p class="mt-1 text-sm text-slate-600">Diisi jika mendaftarkan perusahaan baru.</p>
                <div class="mt-3 grid gap-4 sm:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-medium">Nama Perusahaan</span>
                        <input name="company_name" value="{{ old('company_name') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                    </label>
                    <label class="block">
                        <span class="text-sm font-medium">Industri</span>
                        <input name="industry" value="{{ old('industry') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                    </label>
                    <label class="block sm:col-span-2">
                        <span class="text-sm font-medium">Website</span>
                        <input name="website" value="{{ old('website') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                    </label>
                </div>
            </div>

            <label class="block sm:col-span-2">
                <span class="text-sm font-medium">Kampus Mahasiswa</span>
                <select name="university_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                    <option value="">Pilih kampus jika mendaftar sebagai mahasiswa</option>
                    @foreach ($universities as $university)
                        <option value="{{ $university->id }}" @selected(old('university_id') == $university->id)>{{ $university->nama }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="text-sm font-medium">Nama Lengkap</span>
                <input name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">Email</span>
                <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">NIM</span>
                <input name="nomor_induk" value="{{ old('nomor_induk') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">Program Studi</span>
                <input name="program_studi" value="{{ old('program_studi') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">Telepon</span>
                <input name="telepon" value="{{ old('telepon') }}" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
            </label>
            <div></div>
            <label class="block">
                <span class="text-sm font-medium">Kata Sandi</span>
                <input name="password" type="password" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">Konfirmasi Kata Sandi</span>
                <input name="password_confirmation" type="password" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
            </label>
            <button class="sm:col-span-2 rounded-lg bg-emerald-600 px-4 py-2 font-semibold text-white hover:bg-emerald-700">Buat Akun</button>
        </form>
    </div>
</x-layouts.app>
