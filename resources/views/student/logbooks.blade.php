@extends('layouts.app')

@section('title', 'Tugas Magang - CareerBridge')

@section('content')
    @php
        $statusMeta = [
            'todo' => ['Belum Dikerjakan', 'bg-slate-100 text-slate-700', 'border-slate-200'],
            'in_progress' => ['Sedang Dikerjakan', 'bg-amber-100 text-amber-800', 'border-amber-200'],
            'done' => ['Selesai', 'bg-emerald-100 text-emerald-800', 'border-emerald-200'],
        ];
        $groupedTasks = $logbooks->getCollection()->groupBy('status');
    @endphp

    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="cb-section-label">Tugas Magang</p>
            <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">Papan tugas dari pembimbing perusahaan</h1>
            <p class="mt-3 max-w-2xl text-[#6B7E94]">Ubah status tugas dari belum dikerjakan, sedang dikerjakan, sampai selesai. Nilai akan muncul setelah PJ perusahaan meninjau hasilnya.</p>
        </div>
    </div>

    <div class="grid gap-5 xl:grid-cols-3">
        @foreach ($statusMeta as $status => [$label, $badgeClass, $borderClass])
            <section class="rounded-lg border {{ $borderClass }} bg-white p-4">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="font-bold text-[#0D1B2A]">{{ $label }}</h2>
                    <span class="rounded-full {{ $badgeClass }} px-3 py-1 text-xs font-bold">{{ ($groupedTasks[$status] ?? collect())->count() }}</span>
                </div>

                <div class="space-y-4">
                    @forelse ($groupedTasks[$status] ?? collect() as $task)
                        <article class="rounded-lg border border-[#0D1B2A]/10 bg-[#F7F3ED] p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-[#E8A020]">{{ $task->application->offer->company->nama }}</p>
                                    <h3 class="mt-2 font-bold text-[#0D1B2A]">{{ $task->judul_kegiatan }}</h3>
                                </div>
                                @if ($task->score !== null)
                                    <span class="rounded-full bg-[#0D1B2A] px-3 py-1 text-xs font-bold text-white">{{ $task->score }}/100</span>
                                @endif
                            </div>
                            <p class="mt-3 text-sm leading-6 text-[#3D526B]">{{ $task->deskripsi }}</p>
                            <div class="mt-4 grid gap-2 text-sm text-[#6B7E94]">
                                <p>PJ: {{ $task->assignedBy->name ?? $task->application->companySupervisor->name ?? 'Belum ditentukan' }}</p>
                                <p>Deadline: {{ $task->due_date?->translatedFormat('d F Y') ?? 'Tidak ditentukan' }}</p>
                            </div>
                            @if ($task->kendala)
                                <p class="mt-3 rounded-lg bg-white p-3 text-sm text-[#3D526B]">Catatan saya: {{ $task->kendala }}</p>
                            @endif
                            @if ($task->score_notes || $task->catatan_pembimbing)
                                <p class="mt-3 rounded-lg bg-[#FDF3DC] p-3 text-sm text-[#0D1B2A]">Feedback: {{ $task->score_notes ?: $task->catatan_pembimbing }}</p>
                            @endif

                            <button type="button" data-modal-target="#task-status-{{ $task->id }}" class="cb-dark-button mt-4 w-full px-4 py-2 text-sm">Perbarui Status</button>

                            @component('partials.modal-shell', [
                                'id' => 'task-status-'.$task->id,
                                'title' => 'Perbarui status tugas',
                                'eyebrow' => $task->application->offer->judul,
                                'description' => $task->judul_kegiatan,
                            ])
                                <form method="POST" action="{{ route('logbooks.update', $task) }}" class="grid gap-4">
                                    @csrf
                                    @method('PATCH')
                                    <label class="block">
                                        <span class="text-sm font-medium">Status</span>
                                        <select name="status" class="cb-input mt-2 text-sm">
                                            @foreach ($statusMeta as $value => [$optionLabel])
                                                <option value="{{ $value }}" @selected($task->status === $value)>{{ $optionLabel }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="block">
                                        <span class="text-sm font-medium">Catatan progres / kendala</span>
                                        <textarea name="kendala" rows="4" class="cb-input mt-2 text-sm">{{ $task->kendala }}</textarea>
                                    </label>
                                    <button class="cb-dark-button px-4 py-3 text-sm">Simpan Status</button>
                                </form>
                            @endcomponent
                        </article>
                    @empty
                        <div class="rounded-lg border border-dashed border-[#0D1B2A]/15 p-6 text-center text-sm text-[#6B7E94]">Belum ada tugas.</div>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>

    <div class="mt-6">{{ $logbooks->links() }}</div>
@endsection
