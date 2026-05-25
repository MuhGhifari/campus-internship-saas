@extends('layouts.app')

@section('title', 'CareerBridge — Magang Kampus Terstruktur')

@section('content')
    <section id="beranda" class="relative flex min-h-[calc(100vh-68px)] flex-col items-center justify-center overflow-hidden bg-[#0D1B2A] px-5 py-24 text-center text-white lg:px-16">
        <div class="cb-grid-bg absolute inset-0 opacity-[0.04]"></div>
        <div class="absolute left-1/2 top-1/2 h-175 w-[700px] -translate-x-1/2 -translate-y-1/2 rounded-full border border-[#E8A020]/15"></div>
        <div class="absolute left-1/2 top-1/2 h-[1000px] w-[1000px] -translate-x-1/2 -translate-y-1/2 rounded-full border border-[#E8A020]/10"></div>

        <div class="relative z-10 w-full max-w-6xl">
            <div class="cb-reveal inline-flex items-center gap-2 rounded-full border border-[#E8A020]/30 bg-[#E8A020]/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-[#F5B84A]">
                <span class="h-1.5 w-1.5 rounded-full bg-[#E8A020]"></span>
                Infrastruktur Magang Kampus
            </div>

            <h1 class="cb-display cb-reveal cb-delay-1 mx-auto mt-8 max-w-5xl text-5xl font-light leading-none text-white sm:text-7xl lg:text-8xl">
                Satu tempat untuk kampus, perusahaan, dan <em class="text-[#F5B84A]">mahasiswa siap magang</em>
            </h1>

            <p class="cb-reveal cb-delay-2 mx-auto mt-6 max-w-2xl text-base font-light leading-8 text-white/65">
                CareerBridge mengatur kemitraan, persetujuan lowongan, lamaran CV, penanggung jawab magang, tugas terpantau, dan evaluasi akhir dalam satu layanan SaaS.
            </p>

            <div class="cb-reveal cb-delay-3 mt-12 grid gap-4 md:grid-cols-3">
                @foreach ([
                    ['university', 'Untuk Universitas', 'Tinjau partner, kurasi lowongan, dan pantau hasil magang mahasiswa.'],
                    ['company', 'Untuk Perusahaan', 'Ajukan kemitraan, kirim posisi, dan seleksi kandidat dari kampus partner.'],
                    ['student', 'Untuk Mahasiswa', 'Temukan lowongan resmi kampus dan lamar dengan CV langsung dari sistem.'],
                ] as [$icon, $label, $desc])
                    <a href="{{ route('register') }}" class="group relative min-h-44 overflow-hidden rounded-lg border border-white/15 bg-white/[0.06] p-6 text-left text-white transition hover:-translate-y-1 hover:border-[#E8A020]/50">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#E8A020]/20 to-transparent opacity-0 transition group-hover:opacity-100"></div>
                        <div class="relative">
                            <div class="mb-5 grid h-11 w-11 place-items-center rounded-lg bg-[#E8A020] text-[#0D1B2A]">
                                @include('partials.icon', ['name' => $icon, 'class' => 'h-5 w-5'])
                            </div>
                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#F5B84A]">{{ $label }}</p>
                            <p class="mt-3 text-sm leading-6 text-white/60">{{ $desc }}</p>
                            <span class="absolute right-0 top-0 text-xl text-white/30 transition group-hover:-translate-y-1 group-hover:translate-x-1 group-hover:text-[#E8A020]">↗</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <div class="flex flex-wrap justify-center gap-10 bg-[#E8A020] px-5 py-5 text-center lg:px-16">
        @foreach ([['2', 'Universitas Demo'], ['2', 'Perusahaan Partner'], ['7', 'Akun Pengguna'], ['10', 'Tahap Workflow']] as [$num, $label])
            <div class="cb-scroll-reveal">
                <p class="cb-display text-4xl font-bold leading-none text-[#0D1B2A]">{{ $num }}</p>
                <p class="mt-1 text-xs font-semibold uppercase tracking-[0.16em] text-[#0D1B2A]/70">{{ $label }}</p>
            </div>
        @endforeach
    </div>

    <section id="cara-kerja" class="bg-white px-5 py-28 lg:px-16">
        <div class="w-full" data-tab-group>
            <div class="mb-8 max-w-3xl cb-scroll-reveal">
                <p class="cb-section-label">Cara Kerja</p>
                <h2 class="cb-display mt-6 text-5xl font-light leading-tight text-[#0D1B2A] sm:text-6xl">Cara kerja CareerBridge untuk Anda</h2>
                <p class="mt-7 max-w-2xl text-lg leading-9 text-[#6B7E94]">Perjalanan yang dibuat khusus untuk setiap peran di platform. Pilih jalur Anda di bawah.</p>
            </div>

            <div class="mb-16 overflow-x-auto border-b border-[#0D1B2A]/10 cb-scroll-reveal cb-scroll-delay-1">
                <div class="relative flex min-w-max gap-0">
                    <div data-tab-indicator class="absolute bottom-0 left-0 h-0.5 rounded-full bg-[#E8A020] transition-all duration-300 ease-out"></div>
                    <button type="button" data-tab-target="perusahaan" aria-selected="true" class="cb-tab-active relative z-10 cursor-pointer px-10 pb-5 pt-2 text-left text-base font-semibold transition hover:text-[#0D1B2A]">Untuk Perusahaan</button>
                    <button type="button" data-tab-target="universitas" aria-selected="false" class="relative z-10 cursor-pointer px-10 pb-5 pt-2 text-left text-base font-semibold text-[#6B7E94] transition hover:text-[#0D1B2A]">Untuk Universitas</button>
                    <button type="button" data-tab-target="mahasiswa" aria-selected="false" class="relative z-10 cursor-pointer px-10 pb-5 pt-2 text-left text-base font-semibold text-[#6B7E94] transition hover:text-[#0D1B2A]">Untuk Mahasiswa</button>
                </div>
            </div>

            @foreach ([
                'perusahaan' => [
                    ['01', 'Daftar Perusahaan', 'Buat profil perusahaan dan akun HR.'],
                    ['02', 'Ajukan Kemitraan', 'Kirim proposal ke universitas pilihan.'],
                    ['03', 'Kirim Posisi', 'Pilih satu atau banyak kampus partner.'],
                    ['04', 'Tinjau Pelamar', 'Terima atau tolak CV mahasiswa.'],
                ],
                'universitas' => [
                    ['01', 'Daftarkan Kampus', 'Buat tenant universitas dan akun staf.'],
                    ['02', 'Tinjau Partner', 'Terima atau tolak proposal perusahaan.'],
                    ['03', 'Setujui Lowongan', 'Lowongan resmi tampil ke mahasiswa.'],
                    ['04', 'Pantau Evaluasi', 'Lihat nilai akhir dan progres magang.'],
                ],
                'mahasiswa' => [
                    ['01', 'Pilih Kampus', 'Daftar memakai identitas akademik.'],
                    ['02', 'Cari Lowongan', 'Lihat posisi yang disetujui kampus.'],
                    ['03', 'Kirim CV', 'Ajukan lamaran langsung dari sistem.'],
                    ['04', 'Kerjakan Tugas', 'Ubah status tugas dan terima nilai dari PJ perusahaan.'],
                ],
            ] as $key => $steps)
                <div data-tab-panel="{{ $key }}" @if ($key !== 'perusahaan') hidden @endif class="grid gap-6 md:grid-cols-2 xl:grid-cols-4 xl:gap-8">
                    @foreach ($steps as [$number, $title, $desc])
                        <article class="cb-scroll-reveal cb-scroll-delay-{{ $loop->iteration }} min-h-72 rounded-lg border border-[#0D1B2A]/10 bg-[#F7F3ED] p-8">
                            <p class="cb-display text-6xl font-light leading-none text-[#E8A020]/55">{{ $number }}</p>
                            <h3 class="mt-7 text-xl font-bold leading-7 text-[#0D1B2A]">{{ $title }}</h3>
                            <p class="mt-4 text-base leading-8 text-[#6B7E94]">{{ $desc }}</p>
                        </article>
                    @endforeach
                </div>
            @endforeach
        </div>
    </section>

    <section id="layanan" class="bg-[#F7F3ED] px-5 py-24 lg:px-16">
        <div class="w-full">
            <div class="mb-14 cb-scroll-reveal">
                <p class="cb-section-label">Layanan</p>
                <h2 class="cb-display mt-4 max-w-3xl text-4xl font-light text-[#0D1B2A] sm:text-5xl">Semua kebutuhan magang, dari kerja sama sampai evaluasi akhir</h2>
                <p class="mt-4 max-w-2xl leading-7 text-[#6B7E94]">Bukan hanya daftar lowongan. CareerBridge mengelola hubungan kampus-perusahaan secara lengkap.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ([
                    ['handshake', 'Manajemen Kemitraan', 'Perusahaan mengirim proposal resmi, universitas meninjau dan memberi keputusan.', 'Kampus & Perusahaan'],
                    ['clipboard', 'Lowongan Terkurasi', 'Posisi hanya tampil untuk mahasiswa setelah disetujui universitas.', 'Mahasiswa'],
                    ['users', 'Seleksi Kandidat', 'HR melihat lamaran, CV, dan status kandidat dalam satu panel.', 'Perusahaan'],
                    ['mentor', 'Penanggung Jawab Magang', 'Setiap mahasiswa punya pembimbing kampus dan perwakilan perusahaan.', 'Pembimbing'],
                    ['note', 'Tugas Terpantau', 'PJ perusahaan memberi tugas, mahasiswa memperbarui status, dan nilai tersimpan untuk evaluasi.', 'Mahasiswa & Perusahaan'],
                    ['chart', 'Evaluasi Terpusat', 'Nilai dan catatan akhir tersimpan untuk kebutuhan akademik kampus.', 'Universitas'],
                ] as [$icon, $title, $desc, $tag])
                    <article class="cb-scroll-reveal cb-scroll-delay-{{ ($loop->iteration - 1) % 3 + 1 }} rounded-lg border border-[#0D1B2A]/10 bg-white p-8 transition hover:-translate-y-1 hover:border-[#E8A020] hover:shadow-xl">
                        <div class="mb-5 grid h-14 w-14 place-items-center rounded-lg bg-[#0D1B2A] text-[#E8A020]">
                            @include('partials.icon', ['name' => $icon, 'class' => 'h-6 w-6'])
                        </div>
                        <h3 class="font-semibold text-[#0D1B2A]">{{ $title }}</h3>
                        <p class="mt-3 text-sm leading-7 text-[#6B7E94]">{{ $desc }}</p>
                        <span class="mt-5 inline-flex rounded-full border border-[#0D1B2A]/10 bg-[#F7F3ED] px-3 py-1 text-xs font-semibold text-[#3D526B]">{{ $tag }}</span>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="tentang" class="grid gap-12 bg-[#0D1B2A] px-5 py-24 text-white lg:grid-cols-2 lg:px-16">
        <div>
            <p class="cb-section-label cb-scroll-reveal">Tentang CareerBridge</p>
            <h2 class="cb-display cb-scroll-reveal cb-scroll-delay-1 mt-4 text-4xl font-light sm:text-5xl">Dibuat untuk menutup jarak antara kampus dan dunia kerja</h2>
            <p class="cb-scroll-reveal cb-scroll-delay-2 mt-5 max-w-xl leading-8 text-white/60">Banyak proses magang masih tersebar di chat, email, spreadsheet, dan hubungan personal. CareerBridge membuat alur itu menjadi sistem yang jelas, adil, dan bisa dipantau oleh semua pihak.</p>

            <div class="mt-9 grid gap-4">
                @foreach ([
                    ['scale', 'Lebih adil', 'Mahasiswa melihat peluang yang benar-benar sudah disetujui kampus.'],
                    ['link', 'Lebih terstruktur', 'Proposal, lowongan, lamaran, pembimbing, dan evaluasi tidak tercecer.'],
                    ['growth', 'Lebih berdampak', 'Kampus bisa melihat hasil magang sebagai bahan evaluasi akademik.'],
                ] as [$icon, $title, $desc])
                    <div class="cb-scroll-reveal cb-scroll-delay-{{ $loop->iteration }} flex gap-4 rounded-lg border border-white/10 bg-white/[0.04] p-5">
                        <div class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-[#E8A020]/15 text-[#E8A020]">
                            @include('partials.icon', ['name' => $icon, 'class' => 'h-5 w-5'])
                        </div>
                        <div>
                            <h3 class="font-semibold">{{ $title }}</h3>
                            <p class="mt-1 text-sm leading-6 text-white/55">{{ $desc }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="cb-scroll-reveal cb-scroll-delay-2 overflow-hidden rounded-lg border border-white/10 bg-white/[0.05]">
            <img src="{{ asset('images/internship-collaboration.webp') }}" alt="Mahasiswa berdiskusi dalam program magang" class="h-72 w-full object-cover lg:h-96">
            <div class="grid grid-cols-2 gap-px bg-white/10">
                @foreach ([['24 jam', 'Status proposal terlihat real-time'], ['3 peran', 'Kampus, perusahaan, mahasiswa'], ['2 PJ', 'Pembimbing kampus dan perusahaan'], ['1 data', 'Evaluasi akhir terpusat']] as [$num, $label])
                    <div class="bg-[#0D1B2A] p-5">
                        <p class="cb-display text-3xl font-bold text-[#E8A020]">{{ $num }}</p>
                        <p class="mt-1 text-sm leading-5 text-white/55">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="bukti" class="bg-[#F7F3ED] px-5 py-24 lg:px-16">
        <div class="w-full">
            <div class="mx-auto mb-14 max-w-2xl text-center cb-scroll-reveal">
                <p class="cb-section-label inline-block">Dipercaya Oleh Pengguna</p>
                <h2 class="cb-display mt-4 text-4xl font-light text-[#0D1B2A] sm:text-5xl">Setiap pihak mendapat ruang kerja yang sesuai</h2>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                @foreach ([
                    ['“Kami bisa memilah proposal perusahaan tanpa kehilangan konteks dan catatan keputusan.”', 'Staf Kemitraan Kampus', 'Universitas'],
                    ['“Lowongan hanya dikirim ke kampus partner, jadi kandidat yang masuk jauh lebih relevan.”', 'HR Internship Program', 'Perusahaan'],
                    ['“Saya tahu lowongan mana yang resmi dari kampus dan progres lamaran bisa dipantau.”', 'Mahasiswa Informatika', 'Mahasiswa'],
                ] as [$quote, $name, $role])
                    <article class="cb-scroll-reveal cb-scroll-delay-{{ $loop->iteration }} rounded-lg border border-[#0D1B2A]/10 bg-white p-7">
                        <p class="cb-display text-2xl italic leading-9 text-[#0D1B2A]">{{ $quote }}</p>
                        <div class="mt-6 flex items-center justify-between gap-4">
                            <div>
                                <p class="font-semibold text-[#0D1B2A]">{{ $name }}</p>
                                <p class="text-sm text-[#6B7E94]">{{ $role }}</p>
                            </div>
                            <span class="rounded-full bg-[#FDF3DC] px-3 py-1 text-xs font-bold text-[#0D1B2A]">{{ $role }}</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="mulai" class="relative overflow-hidden bg-[#0D1B2A] px-5 py-24 text-center text-white lg:px-16">
        <div class="cb-grid-bg absolute inset-0 opacity-[0.03]"></div>
        <div class="relative mx-auto max-w-4xl cb-scroll-reveal">
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#E8A020]">Mulai Sekarang</p>
            <h2 class="cb-display mt-4 text-4xl font-light sm:text-6xl">Bangun jaringan magang resmi pertama Anda.</h2>
            <p class="mx-auto mt-5 max-w-2xl leading-8 text-white/55">Daftarkan universitas atau perusahaan, lalu mulai kelola kemitraan dengan cara kerja yang transparan.</p>
            <div class="mt-9 grid gap-4 md:grid-cols-2">
                <a href="{{ route('register') }}" class="rounded-lg bg-[#E8A020] p-7 text-left text-[#0D1B2A] transition hover:-translate-y-1 hover:bg-[#F5B84A]">
                    <p class="text-xs font-bold uppercase tracking-[0.16em] opacity-70">Untuk Perusahaan</p>
                    <h3 class="mt-3 text-2xl font-bold">Ajukan kemitraan</h3>
                    <p class="mt-2 text-sm leading-6 opacity-75">Buat profil perusahaan dan kirim proposal ke kampus pilihan.</p>
                    <span class="mt-5 inline-flex font-bold">Daftar Perusahaan →</span>
                </a>
                <a href="{{ route('register') }}" class="rounded-lg border border-white/15 bg-white/[0.06] p-7 text-left text-white transition hover:-translate-y-1 hover:border-[#E8A020]/50">
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#E8A020]">Untuk Universitas</p>
                    <h3 class="mt-3 text-2xl font-bold">Kelola partner magang</h3>
                    <p class="mt-2 text-sm leading-6 text-white/60">Terima proposal, setujui lowongan, dan pantau evaluasi mahasiswa.</p>
                    <span class="mt-5 inline-flex font-bold text-[#F5B84A]">Daftarkan Kampus →</span>
                </a>
            </div>
        </div>
    </section>

    <section id="kontak" class="bg-white px-5 py-24 lg:px-16">
        <div class="grid w-full gap-12 lg:grid-cols-[0.85fr_1.15fr]">
            <div class="cb-scroll-reveal">
                <p class="cb-section-label">Kontak</p>
                <h2 class="cb-display mt-4 text-4xl font-light text-[#0D1B2A] sm:text-5xl">Butuh penjelasan sebelum mendaftar?</h2>
                <p class="mt-5 max-w-xl leading-8 text-[#6B7E94]">Tim CareerBridge siap membantu menjelaskan cara kerja onboarding, peran pengguna, dan simulasi demo untuk kebutuhan tugas cloud computing Anda.</p>

                <div class="mt-9 grid gap-5">
                    @foreach ([
                        ['mail', 'Email', 'halo@careerbridge.test'],
                        ['phone', 'Telepon', '+62 812 0000 2026'],
                        ['map-pin', 'Lokasi', 'Jakarta, Indonesia'],
                    ] as [$icon, $label, $value])
                        <div class="flex gap-4">
                            <div class="grid h-11 w-11 shrink-0 place-items-center rounded-lg border border-[#0D1B2A]/10 bg-[#F7F3ED] text-[#E8A020]">
                                @include('partials.icon', ['name' => $icon, 'class' => 'h-5 w-5'])
                            </div>
                            <div>
                                <p class="font-semibold text-[#0D1B2A]">{{ $label }}</p>
                                <p class="text-sm text-[#6B7E94]">{{ $value }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <form data-contact-form class="cb-scroll-reveal cb-scroll-delay-2 grid gap-4 rounded-lg border border-[#0D1B2A]/10 bg-[#F7F3ED] p-6">
                <div class="grid gap-4 md:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-semibold text-[#3D526B]">Nama</span>
                        <input class="cb-input mt-2" placeholder="Nama lengkap">
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-[#3D526B]">Email kerja</span>
                        <input type="email" class="cb-input mt-2" placeholder="nama@organisasi.ac.id">
                    </label>
                </div>
                <label class="block">
                    <span class="text-sm font-semibold text-[#3D526B]">Tipe organisasi</span>
                    <select class="cb-input mt-2">
                        <option>Universitas</option>
                        <option>Perusahaan</option>
                        <option>Mahasiswa</option>
                    </select>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-[#3D526B]">Pesan</span>
                    <textarea rows="5" class="cb-input mt-2" placeholder="Ceritakan kebutuhan Anda..."></textarea>
                </label>
                <button class="cb-dark-button justify-self-start px-5 py-3 text-sm">Kirim Pesan</button>
            </form>
        </div>
    </section>

    <footer class="bg-[#0D1B2A] px-5 py-12 text-white lg:px-16">
        <div class="grid w-full gap-8 md:grid-cols-[1.5fr_1fr_1fr_1fr]">
            <div>
                <p class="cb-display text-3xl font-semibold">Career<span class="text-[#E8A020]">Bridge</span>.</p>
                <p class="mt-3 max-w-sm text-sm leading-7 text-white/55">SaaS untuk menghubungkan universitas, perusahaan, dan mahasiswa dalam workflow magang yang resmi.</p>
            </div>
            @foreach ([
                ['Platform', ['Cara Kerja', 'Layanan', 'Evaluasi']],
                ['Pengguna', ['Universitas', 'Perusahaan', 'Mahasiswa']],
                ['Kontak', ['halo@careerbridge.test', 'Jakarta', 'Demo SaaS']],
            ] as [$heading, $items])
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-[0.16em] text-white/80">{{ $heading }}</h3>
                    <ul class="mt-4 space-y-2 text-sm text-white/50">
                        @foreach ($items as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
        <div class="mt-10 flex w-full flex-wrap items-center justify-between gap-3 border-t border-white/10 pt-6 text-xs text-white/45">
            <p>© 2026 CareerBridge. Semua hak dilindungi.</p>
            <p>Cloud Computing SaaS Implementation</p>
        </div>
    </footer>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('cb-scroll-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            document.querySelectorAll('.cb-scroll-reveal').forEach((element) => revealObserver.observe(element));

            document.querySelectorAll('[data-tab-group]').forEach((group) => {
                const buttons = group.querySelectorAll('[data-tab-target]');
                const panels = group.querySelectorAll('[data-tab-panel]');
                const indicator = group.querySelector('[data-tab-indicator]');

                const setActive = (target) => {
                    buttons.forEach((button, index) => {
                        const active = button.dataset.tabTarget === target;
                        button.setAttribute('aria-selected', active ? 'true' : 'false');
                        button.classList.toggle('cb-tab-active', active);
                        button.classList.toggle('text-[#0D1B2A]', active);
                        button.classList.toggle('text-[#6B7E94]', !active);
                        button.classList.toggle('font-bold', active);
                        button.classList.toggle('font-semibold', !active);

                        if (active && indicator) {
                            indicator.style.width = `${button.offsetWidth}px`;
                            indicator.style.transform = `translateX(${button.offsetLeft}px)`;
                        }
                    });

                    panels.forEach((panel) => {
                        const active = panel.dataset.tabPanel === target;
                        panel.toggleAttribute('hidden', !active);

                        if (active) {
                            panel.classList.remove('cb-reveal');
                            void panel.offsetWidth;
                            panel.classList.add('cb-reveal');
                        } else {
                            panel.classList.remove('cb-reveal');
                        }
                    });
                };

                buttons.forEach((button) => {
                    button.addEventListener('click', () => setActive(button.dataset.tabTarget));
                });

                setActive(group.querySelector('[aria-selected="true"]')?.dataset.tabTarget || buttons[0]?.dataset.tabTarget);
                window.addEventListener('resize', () => {
                    setActive(group.querySelector('[aria-selected="true"]')?.dataset.tabTarget || buttons[0]?.dataset.tabTarget);
                });
            });

            document.querySelector('[data-contact-form]')?.addEventListener('submit', (event) => {
                event.preventDefault();
                const button = event.currentTarget.querySelector('button');
                button.textContent = 'Pesan terkirim';
                button.classList.add('bg-emerald-700');

                setTimeout(() => {
                    button.textContent = 'Kirim Pesan';
                    button.classList.remove('bg-emerald-700');
                    event.currentTarget.reset();
                }, 2500);
            });
        });
    </script>
@endsection
