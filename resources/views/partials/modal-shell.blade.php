<div id="{{ $id }}" class="cb-modal-backdrop" data-modal-backdrop @if (! ($open ?? false)) hidden @endif>
    <section class="cb-modal-panel {{ $width ?? 'max-w-2xl' }}">
        <div class="flex items-start justify-between gap-4 border-b border-[#0D1B2A]/10 p-5">
            <div>
                @isset($eyebrow)
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#E8A020]">{{ $eyebrow }}</p>
                @endisset
                <h2 class="mt-1 text-2xl font-bold text-[#0D1B2A]">{{ $title }}</h2>
                @isset($description)
                    <p class="mt-2 text-sm leading-6 text-[#6B7E94]">{{ $description }}</p>
                @endisset
            </div>
            <button type="button" class="rounded-lg p-2 text-[#6B7E94] hover:bg-[#F7F3ED] hover:text-[#0D1B2A]" data-modal-close aria-label="Tutup modal">
                @include('partials.icon', ['name' => 'close', 'class' => 'h-5 w-5'])
            </button>
        </div>
        <div class="p-5">
            {{ $slot }}
        </div>
    </section>
</div>
