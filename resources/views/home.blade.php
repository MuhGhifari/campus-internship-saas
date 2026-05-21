<x-layouts.app title="CareerBridge">
    <section class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">SaaS pengelolaan magang kampus</p>
            <h1 class="mt-4 max-w-3xl text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl">
                Satu sistem untuk lowongan, lamaran, pembimbing, logbook, dan evaluasi magang.
            </h1>
            <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">
                CareerBridge membantu staf kampus mengelola permintaan magang dari perusahaan, mahasiswa melamar secara mandiri, dosen memantau progres, dan perwakilan perusahaan memberi evaluasi.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('login') }}" class="rounded-lg bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700">Masuk ke Demo</a>
                <a href="{{ route('register') }}" class="rounded-lg border border-slate-300 px-5 py-3 text-sm font-semibold hover:bg-white">Daftar Mahasiswa</a>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <div class="grid gap-4">
                @foreach ([
                    ['Perusahaan', 'Mengirim permintaan lowongan magang dan penanggung jawab perusahaan.'],
                    ['Staf Kampus', 'Meninjau lowongan, menerbitkan peluang, dan mengawasi penempatan.'],
                    ['Mahasiswa', 'Melihat lowongan, mengirim lamaran, dan mengisi logbook harian.'],
                    ['Dosen Pembimbing', 'Memantau logbook dan memberi evaluasi akademik.'],
                ] as [$role, $desc])
                    <div class="rounded-lg border border-slate-200 p-4">
                        <p class="font-semibold text-slate-950">{{ $role }}</p>
                        <p class="mt-1 text-sm leading-6 text-slate-600">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
