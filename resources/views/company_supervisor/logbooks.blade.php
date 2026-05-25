@extends('layouts.app')

@section('title', 'Tugas Mahasiswa - CareerBridge')

@section('content')
    @php
        $statusLabels = [
            'todo' => 'Belum Dikerjakan',
            'in_progress' => 'Sedang Dikerjakan',
            'done' => 'Selesai',
        ];
    @endphp

    <div class="grid gap-6 lg:grid-cols-[360px_1fr]">
        <aside class="space-y-5">
            <div class="cb-card p-6">
                <div class="grid h-12 w-12 place-items-center rounded-xl bg-[#FDF3DC] text-[#0D1B2A]">
                    @include('partials.icon', ['name' => 'clipboard', 'class' => 'h-6 w-6'])
                </div>
                <h1 class="mt-5 text-xl font-bold text-[#0D1B2A]">Berikan Tugas</h1>
                <p class="mt-2 text-sm leading-6 text-[#6B7E94]">Pilih mahasiswa yang sudah diterima atau sedang berjalan, lalu berikan tugas yang bisa dipantau sampai selesai.</p>
                @if ($assignableApplications->isNotEmpty())
                    <button type="button" data-modal-target="#task-create-modal" class="cb-primary mt-5 w-full px-4 py-3 text-sm">Buat Tugas</button>
                @else
                    <p class="mt-4 text-sm text-[#6B7E94]">Belum ada mahasiswa aktif untuk diberi tugas.</p>
                @endif
            </div>

            <div class="cb-card p-6">
                <p class="cb-section-label">Ringkasan</p>
                <div class="mt-5 grid gap-3 text-sm">
                    <div class="flex items-center justify-between rounded-lg bg-[#F7F3ED] p-3">
                        <span>Total tugas</span>
                        <strong>{{ $logbooks->total() }}</strong>
                    </div>
                    <div class="flex items-center justify-between rounded-lg bg-[#F7F3ED] p-3">
                        <span>Siap dinilai</span>
                        <strong>{{ $logbooks->getCollection()->where('status', 'done')->whereNull('score')->count() }}</strong>
                    </div>
                </div>
            </div>
        </aside>

        <section class="space-y-4">
            @forelse ($logbooks as $task)
                <article class="cb-card p-5">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <p class="text-sm text-[#6B7E94]">{{ $task->student->name }} · {{ $task->application->offer->judul }}</p>
                            <h2 class="mt-1 text-lg font-bold text-[#0D1B2A]">{{ $task->judul_kegiatan }}</h2>
                            <p class="mt-2 text-sm text-[#6B7E94]">Deadline: {{ $task->due_date?->translatedFormat('d F Y') ?? 'Tidak ditentukan' }}</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full bg-[#FDF3DC] px-3 py-1 text-xs font-semibold text-[#0D1B2A]">{{ $statusLabels[$task->status] ?? ucfirst($task->status) }}</span>
                            @if ($task->score !== null)
                                <span class="rounded-full bg-[#0D1B2A] px-3 py-1 text-xs font-bold text-white">{{ $task->score }}/100</span>
                            @endif
                        </div>
                    </div>
                    <p class="mt-4 leading-7 text-[#3D526B]">{{ $task->deskripsi }}</p>
                    @if ($task->kendala)
                        <p class="mt-3 rounded-lg bg-[#F7F3ED] p-3 text-sm text-[#3D526B]">Catatan mahasiswa: {{ $task->kendala }}</p>
                    @endif
                    @if ($task->score_notes || $task->catatan_pembimbing)
                        <p class="mt-3 rounded-lg bg-[#FDF3DC] p-3 text-sm text-[#0D1B2A]">Feedback: {{ $task->score_notes ?: $task->catatan_pembimbing }}</p>
                    @endif

                    <button type="button" data-modal-target="#task-score-{{ $task->id }}" class="cb-dark-button mt-4 px-4 py-2 text-sm">
                        {{ $task->score === null ? 'Beri Nilai' : 'Ubah Nilai' }}
                    </button>

                    @component('partials.modal-shell', [
                        'id' => 'task-score-'.$task->id,
                        'title' => 'Nilai tugas mahasiswa',
                        'eyebrow' => $task->student->name,
                        'description' => $task->judul_kegiatan,
                    ])
                        <form method="POST" action="{{ route('logbooks.update', $task) }}" class="grid gap-4">
                            @csrf
                            @method('PATCH')
                            @if ($task->status !== 'done')
                                <p class="rounded-lg bg-[#FDF3DC] p-3 text-sm text-[#0D1B2A]">Mahasiswa belum menandai tugas ini sebagai selesai. Nilai baru bisa disimpan setelah status tugas selesai.</p>
                            @endif
                            <label class="block">
                                <span class="text-sm font-medium">Nilai</span>
                                <input name="score" type="number" min="0" max="100" value="{{ old('score', $task->score ?? 80) }}" class="cb-input mt-2">
                            </label>
                            <label class="block">
                                <span class="text-sm font-medium">Feedback nilai</span>
                                <textarea name="score_notes" rows="3" class="cb-input mt-2">{{ old('score_notes', $task->score_notes) }}</textarea>
                            </label>
                            <label class="block">
                                <span class="text-sm font-medium">Catatan pembimbing perusahaan</span>
                                <textarea name="catatan_pembimbing" rows="3" class="cb-input mt-2">{{ old('catatan_pembimbing', $task->catatan_pembimbing) }}</textarea>
                            </label>
                            <button class="cb-dark-button px-4 py-3 text-sm">Simpan Nilai</button>
                        </form>
                    @endcomponent
                </article>
            @empty
                <div class="cb-card border-dashed p-10 text-center text-[#6B7E94]">Belum ada tugas mahasiswa.</div>
            @endforelse
            {{ $logbooks->links() }}
        </section>
    </div>

    @if ($assignableApplications->isNotEmpty())
        @component('partials.modal-shell', [
            'id' => 'task-create-modal',
            'title' => 'Buat tugas magang',
            'eyebrow' => 'Tugas Mahasiswa',
            'description' => 'Tugas akan dikirim ke mahasiswa dan pembimbing kampus lewat email.',
        ])
            <form method="POST" action="{{ route('logbooks.store') }}" class="grid gap-4">
                @csrf
                <label class="block">
                    <span class="text-sm font-medium">Mahasiswa</span>
                    <select name="internship_application_id" required class="cb-input mt-2 text-sm">
                        @foreach ($assignableApplications as $application)
                            <option value="{{ $application->id }}">{{ $application->student->name }} · {{ $application->offer->judul }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="block">
                    <span class="text-sm font-medium">Judul tugas</span>
                    <input name="judul_kegiatan" required class="cb-input mt-2">
                </label>
                <label class="block">
                    <span class="text-sm font-medium">Instruksi tugas</span>
                    <textarea name="deskripsi" rows="5" required class="cb-input mt-2"></textarea>
                </label>
                <label class="block">
                    <span class="text-sm font-medium">Deadline</span>
                    <input name="due_date" type="date" class="cb-input mt-2">
                </label>
                <button class="cb-dark-button px-4 py-3 text-sm">Kirim Tugas</button>
            </form>
        @endcomponent
    @endif
@endsection
