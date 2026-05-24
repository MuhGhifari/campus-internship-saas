<x-layouts.app title="CareerBridge - Platform Magang Kampus">
    <section class="relative overflow-hidden rounded-lg bg-slate-950 px-6 py-16 text-white sm:px-10 lg:px-14">
        <div class="absolute inset-y-0 right-0 hidden w-1/2 bg-[linear-gradient(135deg,#10b981_0%,#38bdf8_52%,#f59e0b_100%)] opacity-70 lg:block"></div>
        <div class="relative max-w-3xl">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-300">CareerBridge for Campus Internship Operations</p>
            <h1 class="mt-5 text-4xl font-bold tracking-tight sm:text-6xl">
                Hub SaaS untuk menghubungkan kampus, perusahaan, dan mahasiswa magang.
            </h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                Kami membantu universitas menerima proposal perusahaan, meninjau posisi magang, mempublikasikan lowongan ke mahasiswa, dan memantau hasil evaluasi dalam satu sistem cloud.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('register') }}" class="rounded-lg bg-emerald-500 px-5 py-3 text-sm font-semibold text-slate-950 hover:bg-emerald-400">Mulai Registrasi</a>
                <a href="#kontak" class="rounded-lg border border-white/20 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10">Hubungi Kami</a>
            </div>
        </div>
    </section>

    <section id="layanan" class="mt-12">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Layanan</p>
                <h2 class="mt-2 text-3xl font-bold">Satu platform, tiga pengalaman berbeda.</h2>
            </div>
            <p class="max-w-xl text-sm leading-6 text-slate-600">CareerBridge dirancang sebagai layanan SaaS multi-pihak, bukan sekadar daftar lowongan.</p>
        </div>

        <div class="mt-6 grid gap-5 lg:grid-cols-3">
            <article class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <span class="rounded-full bg-cyan-50 px-3 py-1 text-xs font-semibold text-cyan-700">Untuk Universitas</span>
                <h3 class="mt-5 text-xl font-bold">Kontrol kemitraan dan publikasi lowongan</h3>
                <p class="mt-3 text-sm leading-6 text-slate-600">Staf kampus menerima proposal kerja sama, menyetujui posisi magang, dan melihat evaluasi mahasiswa setelah program berjalan.</p>
            </article>
            <article class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Untuk Perusahaan</span>
                <h3 class="mt-5 text-xl font-bold">Satu pintu ke banyak kampus partner</h3>
                <p class="mt-3 text-sm leading-6 text-slate-600">HR mengajukan kemitraan, mengirim posisi ke satu atau banyak universitas, lalu meninjau CV mahasiswa yang masuk.</p>
            </article>
            <article class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Untuk Mahasiswa</span>
                <h3 class="mt-5 text-xl font-bold">Lowongan resmi dari kampus</h3>
                <p class="mt-3 text-sm leading-6 text-slate-600">Mahasiswa memilih kampus, melihat lowongan yang sudah disetujui, mengirim CV, dan memantau status lamaran.</p>
            </article>
        </div>
    </section>

    <section class="mt-12 grid gap-8 rounded-lg border border-slate-200 bg-white p-6 shadow-sm lg:grid-cols-[0.9fr_1.1fr] lg:p-8">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Alur platform</p>
            <h2 class="mt-2 text-3xl font-bold">Dibuat untuk proses magang yang resmi.</h2>
            <p class="mt-4 text-sm leading-6 text-slate-600">Setiap lowongan melewati kemitraan dan review kampus sebelum terlihat oleh mahasiswa.</p>
        </div>
        <div class="grid gap-3 sm:grid-cols-2">
            @foreach ([
                'Universitas mendaftar sebagai tenant kampus.',
                'Perusahaan mengajukan proposal kemitraan.',
                'Kampus menerima atau menolak proposal.',
                'Perusahaan mengirim posisi ke kampus partner.',
                'Kampus menyetujui posisi sebelum dipublikasikan.',
                'Mahasiswa melamar dan perusahaan menilai kandidat.',
            ] as $step)
                <div class="rounded-lg bg-slate-50 p-4 text-sm font-medium text-slate-700">{{ $step }}</div>
            @endforeach
        </div>
    </section>

    <section id="kontak" class="mt-12 rounded-lg bg-slate-900 p-6 text-white sm:p-8">
        <div class="grid gap-8 lg:grid-cols-[1fr_0.8fr]">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-300">Kontak bisnis</p>
                <h2 class="mt-2 text-3xl font-bold">Ingin kampus atau perusahaan Anda masuk ke CareerBridge?</h2>
                <p class="mt-4 text-sm leading-6 text-slate-300">Tim kami membantu onboarding, konfigurasi akun kampus, dan simulasi workflow magang untuk kebutuhan presentasi atau implementasi.</p>
            </div>
            <div class="rounded-lg border border-white/10 bg-white/5 p-5 text-sm">
                <p class="font-semibold">CareerBridge Indonesia</p>
                <p class="mt-3 text-slate-300">Email: halo@careerbridge.test</p>
                <p class="mt-2 text-slate-300">Telepon: 021-555-8899</p>
                <p class="mt-2 text-slate-300">Alamat: Jakarta Digital Hub, Indonesia</p>
            </div>
        </div>
    </section>
</x-layouts.app>
