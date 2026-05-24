<x-layouts.app title="Daftar - CareerBridge">
    <div class="mx-auto max-w-5xl">
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Registrasi akun</p>
            <h1 class="mt-2 text-3xl font-bold">Pilih jalur onboarding CareerBridge.</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">Universitas, perusahaan, dan mahasiswa memiliki data awal yang berbeda. Pilih jenis akun yang sesuai, lalu lengkapi data di bawah.</p>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="grid gap-6 lg:grid-cols-[320px_1fr]">
            @csrf
            <aside class="space-y-3">
                @foreach ([
                    ['mahasiswa', 'Mahasiswa', 'Melamar posisi resmi dari kampus.'],
                    ['universitas', 'Universitas', 'Mendaftarkan tenant kampus dan akun staf.'],
                    ['perusahaan', 'Perusahaan', 'Mendaftarkan perusahaan dan akun HR.'],
                ] as [$value, $label, $description])
                    <label class="block cursor-pointer rounded-lg border border-slate-200 bg-white p-4 shadow-sm has-[:checked]:border-emerald-500 has-[:checked]:ring-2 has-[:checked]:ring-emerald-100">
                        <input type="radio" name="account_type" value="{{ $value }}" class="sr-only" @checked(old('account_type', 'mahasiswa') === $value)>
                        <span class="block font-semibold">{{ $label }}</span>
                        <span class="mt-1 block text-sm leading-6 text-slate-600">{{ $description }}</span>
                    </label>
                @endforeach
            </aside>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-lg border border-cyan-100 bg-cyan-50 p-4 sm:col-span-2">
                        <p class="font-semibold text-cyan-950">Data universitas</p>
                        <p class="mt-1 text-sm text-cyan-800">Diisi ketika kampus ingin menggunakan layanan CareerBridge.</p>
                        <div class="mt-3 grid gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span class="text-sm font-medium">Nama Universitas</span>
                                <input name="university_name" value="{{ old('university_name') }}" class="mt-1 w-full rounded-lg border border-cyan-200 px-3 py-2">
                            </label>
                            <label class="block">
                                <span class="text-sm font-medium">Kode Universitas</span>
                                <input name="university_code" value="{{ old('university_code') }}" class="mt-1 w-full rounded-lg border border-cyan-200 px-3 py-2">
                            </label>
                        </div>
                    </div>

                    <div class="rounded-lg border border-amber-100 bg-amber-50 p-4 sm:col-span-2">
                        <p class="font-semibold text-amber-950">Data perusahaan</p>
                        <p class="mt-1 text-sm text-amber-800">Diisi ketika perusahaan ingin membuat proposal kemitraan ke kampus.</p>
                        <div class="mt-3 grid gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span class="text-sm font-medium">Nama Perusahaan</span>
                                <input name="company_name" value="{{ old('company_name') }}" class="mt-1 w-full rounded-lg border border-amber-200 px-3 py-2">
                            </label>
                            <label class="block">
                                <span class="text-sm font-medium">Industri</span>
                                <input name="industry" value="{{ old('industry') }}" class="mt-1 w-full rounded-lg border border-amber-200 px-3 py-2">
                            </label>
                            <label class="block sm:col-span-2">
                                <span class="text-sm font-medium">Website</span>
                                <input name="website" value="{{ old('website') }}" class="mt-1 w-full rounded-lg border border-amber-200 px-3 py-2">
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
                        <span class="text-sm font-medium">NIM / Nomor Induk</span>
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
                    <button class="sm:col-span-2 rounded-lg bg-slate-950 px-4 py-3 font-semibold text-white hover:bg-slate-800">Kirim Registrasi</button>
                </div>
            </section>
        </form>
    </div>
</x-layouts.app>
