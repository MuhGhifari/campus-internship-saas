<header class="border-b border-[#0D1B2A]/10 bg-white">
    <div class="flex items-center justify-between px-5 py-4 sm:px-8">
        <div>
            <p class="text-xs font-semibold uppercase tracking-wide {{ $roleConfig['text'] }}">{{ $roleConfig['label'] }}</p>
            <p class="text-sm text-slate-500">{{ $roleConfig['tagline'] }}</p>
        </div>
        <a href="{{ route('home') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold hover:bg-slate-50">Situs Publik</a>
    </div>
</header>
