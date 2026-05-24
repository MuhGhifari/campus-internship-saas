<x-layouts.app title="Masuk - CareerBridge">
    <div class="mx-auto grid max-w-5xl overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm lg:grid-cols-[1fr_420px]">
        <section class="bg-slate-950 p-8 text-white lg:p-10">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-300">CareerBridge Workspace</p>
            <h1 class="mt-4 text-3xl font-bold">Masuk ke ruang kerja sesuai peran Anda.</h1>
            <p class="mt-4 text-sm leading-6 text-slate-300">Universitas mengelola kemitraan, perusahaan menyeleksi kandidat, mahasiswa melamar posisi, dan dosen memantau progres magang.</p>

            <div class="mt-8 grid gap-3 text-sm">
                <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                    <p class="font-semibold text-cyan-200">Universitas</p>
                    <p class="mt-1 text-slate-300">Review proposal perusahaan dan lowongan.</p>
                </div>
                <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                    <p class="font-semibold text-amber-200">Perusahaan</p>
                    <p class="mt-1 text-slate-300">Ajukan kemitraan dan kelola kandidat.</p>
                </div>
                <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                    <p class="font-semibold text-emerald-200">Mahasiswa</p>
                    <p class="mt-1 text-slate-300">Cari lowongan resmi kampus dan submit CV.</p>
                </div>
            </div>
        </section>

        <section class="p-6 lg:p-8">
            <h2 class="text-2xl font-bold">Masuk</h2>
            <p class="mt-2 text-sm text-slate-600">Gunakan akun demo atau akun yang sudah terdaftar.</p>

            <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-4">
                @csrf
                <label class="block">
                    <span class="text-sm font-medium">Email</span>
                    <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                </label>
                <label class="block">
                    <span class="text-sm font-medium">Kata Sandi</span>
                    <input name="password" type="password" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                </label>
                <label class="flex items-center gap-2 text-sm">
                    <input name="remember" type="checkbox" class="rounded border-slate-300">
                    Ingat saya
                </label>
                <button class="w-full rounded-lg bg-emerald-600 px-4 py-2 font-semibold text-white hover:bg-emerald-700">Masuk</button>
            </form>

            <div class="mt-6 rounded-lg bg-slate-50 p-4 text-sm text-slate-600">
                <p class="font-semibold text-slate-900">Akun demo</p>
                <p>staf@careerbridge.test / password</p>
                <p>hr@careerbridge.test / password</p>
                <p>mahasiswa@careerbridge.test / password</p>
                <p>dosen@careerbridge.test / password</p>
            </div>
        </section>
    </div>
</x-layouts.app>
