@extends('layouts.app')

@section('title', 'Daftar — CareerBridge')

@section('content')
    <section class="relative min-h-[calc(100vh-68px)] overflow-hidden bg-[#0D1B2A] px-5 py-16 text-white" data-registration-wizard>
        <div class="cb-grid-bg absolute inset-0 opacity-[0.03]"></div>
        <div class="relative mx-auto max-w-6xl">
            <div class="mb-10 text-center">
                <p class="inline-flex rounded-full border border-[#E8A020]/30 bg-[#E8A020]/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-[#F5B84A]">Buat Ruang Kerja</p>
                <h1 class="cb-display mx-auto mt-6 max-w-3xl text-5xl font-light leading-none sm:text-7xl">Mulai dari peran yang tepat.</h1>
            </div>

            <form id="registration-form" method="POST" action="{{ route('register.store') }}" class="grid gap-6 lg:grid-cols-[360px_1fr]">
                @csrf

                <aside class="space-y-4">
                    @foreach ([
                        ['mahasiswa', 'Mahasiswa', 'Akses lowongan resmi dari kampus.', 'student'],
                        ['universitas', 'Universitas', 'Tinjau partner dan terbitkan peluang.', 'university'],
                        ['perusahaan', 'Perusahaan', 'Bangun jalur talenta kampus.', 'company'],
                    ] as [$value, $label, $description, $icon])
                        <label class="group relative block cursor-pointer overflow-hidden rounded-2xl border border-white/15 bg-white/[0.06] p-6 transition hover:-translate-y-1 hover:border-[#E8A020]/50 has-[:checked]:border-[#E8A020] has-[:checked]:bg-[#E8A020] has-[:checked]:text-[#0D1B2A]">
                            <input type="radio" name="account_type" value="{{ $value }}" class="sr-only" @checked(old('account_type', 'mahasiswa') === $value)>
                            <span class="flex items-start gap-4">
                                <span class="grid h-12 w-12 place-items-center rounded-xl bg-[#E8A020] text-[#0D1B2A] group-has-[:checked]:bg-[#0D1B2A] group-has-[:checked]:text-[#E8A020]">
                                    @include('partials.icon', ['name' => $icon, 'class' => 'h-6 w-6'])
                                </span>
                                <span>
                                    <span class="block text-xs font-semibold uppercase tracking-[0.16em] text-[#F5B84A] group-has-[:checked]:text-[#0D1B2A]/70">Untuk {{ $label }}</span>
                                    <span class="mt-2 block text-xl font-semibold">{{ $label }}</span>
                                    <span class="mt-2 block text-sm leading-6 text-white/55 group-has-[:checked]:text-[#0D1B2A]/70">{{ $description }}</span>
                                </span>
                            </span>
                        </label>
                    @endforeach
                </aside>

                <section class="overflow-hidden rounded-2xl border border-white/15 bg-[#F7F3ED] text-[#0D1B2A] shadow-2xl">
                    <div class="border-b border-[#0D1B2A]/10 p-7">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#E8A020]">Detail Registrasi</p>
                        <h2 class="cb-display mt-3 text-4xl font-light" data-role-title>Daftar sebagai mahasiswa</h2>
                        <p class="mt-3 max-w-2xl text-sm leading-7 text-[#6B7E94]" data-role-description>Pilih kampus, lengkapi identitas akademik, lalu akses lowongan resmi yang sudah disetujui universitas.</p>
                    </div>

                    <div class="p-7">
                        <div data-role-panel="universitas" hidden class="mb-6 rounded-xl border border-[#0D1B2A]/10 bg-white p-5">
                            <p class="font-semibold">Profil Universitas</p>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <label class="block">
                                    <span class="text-sm font-medium">Nama Universitas</span>
                                    <input name="university_name" value="{{ old('university_name') }}" class="cb-input mt-1">
                                </label>
                                <label class="block">
                                    <span class="text-sm font-medium">Kode Universitas</span>
                                    <input name="university_code" value="{{ old('university_code') }}" class="cb-input mt-1">
                                </label>
                            </div>
                        </div>

                        <div data-role-panel="perusahaan" hidden class="mb-6 rounded-xl border border-[#0D1B2A]/10 bg-white p-5">
                            <p class="font-semibold">Profil Perusahaan</p>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <label class="block">
                                    <span class="text-sm font-medium">Nama Perusahaan</span>
                                    <input name="company_name" value="{{ old('company_name') }}" class="cb-input mt-1">
                                </label>
                                <label class="block">
                                    <span class="text-sm font-medium">Industri</span>
                                    <input name="industry" value="{{ old('industry') }}" class="cb-input mt-1">
                                </label>
                                <label class="block sm:col-span-2">
                                    <span class="text-sm font-medium">Website</span>
                                    <input name="website" value="{{ old('website') }}" class="cb-input mt-1">
                                </label>
                            </div>
                        </div>

                        <div data-role-panel="mahasiswa" class="mb-6 rounded-xl border border-[#0D1B2A]/10 bg-white p-5">
                            <p class="font-semibold">Profil Mahasiswa</p>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <label class="block sm:col-span-2">
                                    <span class="text-sm font-medium">Kampus</span>
                                    <select name="university_id" class="cb-input mt-1">
                                        <option value="">Pilih kampus</option>
                                        @foreach ($universities as $university)
                                            <option value="{{ $university->id }}" @selected(old('university_id') == $university->id)>{{ $university->nama }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <label class="block">
                                    <span class="text-sm font-medium">NIM</span>
                                    <input name="nomor_induk" value="{{ old('nomor_induk') }}" class="cb-input mt-1">
                                </label>
                                <label class="block">
                                    <span class="text-sm font-medium">Program Studi</span>
                                    <input name="program_studi" value="{{ old('program_studi') }}" class="cb-input mt-1">
                                </label>
                            </div>
                        </div>

                        <div data-role-panel="shared" class="grid gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span class="text-sm font-medium">Nama Lengkap</span>
                                <input name="name" value="{{ old('name') }}" required data-always-enabled="true" class="cb-input mt-1">
                            </label>
                            <label class="block">
                                <span class="text-sm font-medium">Email</span>
                                <input name="email" type="email" value="{{ old('email') }}" required data-always-enabled="true" class="cb-input mt-1">
                            </label>
                            <label class="block">
                                <span class="text-sm font-medium">Telepon</span>
                                <input name="telepon" value="{{ old('telepon') }}" data-always-enabled="true" class="cb-input mt-1">
                            </label>
                            <div></div>
                            <label class="block">
                                <span class="text-sm font-medium">Kata Sandi</span>
                                <input name="password" type="password" required data-always-enabled="true" class="cb-input mt-1">
                            </label>
                            <label class="block">
                                <span class="text-sm font-medium">Konfirmasi Kata Sandi</span>
                                <input name="password_confirmation" type="password" required data-always-enabled="true" class="cb-input mt-1">
                            </label>
                        </div>

                        <button data-role-submit class="cb-dark-button mt-6 w-full px-4 py-3">Buat Akun Mahasiswa</button>
                    </div>
                </section>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-registration-wizard]').forEach((wizard) => {
                const radios = wizard.querySelectorAll('input[name="account_type"]');
                const panels = wizard.querySelectorAll('[data-role-panel]');
                const title = wizard.querySelector('[data-role-title]');
                const description = wizard.querySelector('[data-role-description]');
                const submit = wizard.querySelector('[data-role-submit]');

                const copy = {
                    mahasiswa: {
                        title: 'Daftar sebagai mahasiswa',
                        description: 'Pilih kampus, lengkapi identitas akademik, lalu akses lowongan resmi yang sudah disetujui universitas.',
                        submit: 'Buat Akun Mahasiswa',
                    },
                    universitas: {
                        title: 'Daftarkan universitas',
                        description: 'Buat tenant kampus dan akun staf pertama untuk meninjau kemitraan serta posisi magang perusahaan.',
                        submit: 'Daftarkan Universitas',
                    },
                    perusahaan: {
                        title: 'Daftarkan perusahaan',
                        description: 'Buat profil perusahaan dan akun HR untuk mengajukan kemitraan ke universitas pilihan.',
                        submit: 'Daftarkan Perusahaan',
                    },
                };

                const sync = () => {
                    const selected = wizard.querySelector('input[name="account_type"]:checked')?.value || 'mahasiswa';

                    panels.forEach((panel) => {
                        const active = panel.dataset.rolePanel === selected || panel.dataset.rolePanel === 'shared';
                        panel.toggleAttribute('hidden', !active);
                        panel.querySelectorAll('input, select, textarea').forEach((field) => {
                            if (field.dataset.alwaysEnabled === 'true') {
                                return;
                            }

                            field.disabled = !active;
                        });
                    });

                    if (title) title.textContent = copy[selected].title;
                    if (description) description.textContent = copy[selected].description;
                    if (submit) submit.textContent = copy[selected].submit;
                };

                radios.forEach((radio) => radio.addEventListener('change', sync));
                sync();
            });
        });
    </script>
@endsection
