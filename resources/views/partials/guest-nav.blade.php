<header id="site-navbar" class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-[#0D1B2A]/95 transition-colors duration-300">
    <div class="mx-auto flex h-[68px] max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <span class="cb-display text-2xl font-semibold text-white">Career<span class="text-[#E8A020]">Bridge</span>.</span>
        </a>

        <nav class="hidden items-center gap-8 text-sm md:flex">
            <a class="text-white/70 hover:text-[#F5B84A]" href="{{ route('home') }}#cara-kerja">Cara Kerja</a>
            <a class="text-white/70 hover:text-[#F5B84A]" href="{{ route('home') }}#layanan">Layanan</a>
            <a class="text-white/70 hover:text-[#F5B84A]" href="{{ route('home') }}#tentang">Tentang</a>
            <a class="text-white/70 hover:text-[#F5B84A]" href="{{ route('home') }}#kontak">Kontak</a>
        </nav>

        <nav class="flex items-center gap-3 text-sm">
            <a class="rounded-lg border border-white/15 px-4 py-2 text-white/85 hover:bg-white/10 hover:text-white" href="{{ route('login') }}">Masuk</a>
            <a class="rounded-lg border border-[#E8A020] bg-[#E8A020] px-4 py-2 font-semibold text-[#0D1B2A] hover:bg-[#F5B84A]" href="{{ route('register') }}">Daftar</a>
        </nav>
    </div>
</header>
