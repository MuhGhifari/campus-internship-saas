@php
    $messages = collect();

    foreach (['success' => 'Berhasil', 'warning' => 'Perhatian', 'error' => 'Gagal'] as $key => $title) {
        if (session($key)) {
            $messages->push(['type' => $key, 'title' => $title, 'body' => session($key)]);
        }
    }

    if ($errors->any()) {
        $messages->push([
            'type' => 'error',
            'title' => 'Ada data yang perlu diperbaiki',
            'body' => $errors->all(),
        ]);
    }
@endphp

@foreach ($messages as $message)
    <div class="cb-modal-backdrop cb-flash-modal" data-modal-backdrop data-auto-close="4200">
        <section class="cb-modal-panel cb-status-modal max-w-sm" role="alertdialog" aria-modal="true">
            <button type="button" class="cb-status-close" data-modal-close aria-label="Tutup pesan">&times;</button>
            <div class="px-8 py-9 text-center">
                <div class="cb-status-mark cb-status-{{ $message['type'] }}">
                    <span class="cb-status-circle"></span>
                    @if ($message['type'] === 'success')
                        <span class="cb-status-check"></span>
                    @elseif ($message['type'] === 'warning')
                        <span class="cb-status-bang">!</span>
                    @else
                        <span class="cb-status-cross"></span>
                    @endif
                </div>

                <div class="mt-6">
                    <h2 class="text-2xl font-bold text-[#0D1B2A]">{{ $message['title'] }}</h2>
                    @if (is_array($message['body']))
                        <ul class="mt-4 list-inside list-disc text-left text-sm leading-6 text-[#6B7E94]">
                            @foreach ($message['body'] as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="mt-3 text-sm leading-6 text-[#6B7E94]">{{ $message['body'] }}</p>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endforeach
