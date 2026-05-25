@extends('layouts.app')

@section('title', 'Tugas Bimbingan - CareerBridge')

@section('content')
    @php
        $statusLabels = [
            'todo' => 'Belum Dikerjakan',
            'in_progress' => 'Sedang Dikerjakan',
            'done' => 'Selesai',
        ];
    @endphp

    <div class="mb-8">
        <p class="cb-section-label">Monitoring Tugas</p>
        <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">Pantau progres mahasiswa bimbingan</h1>
        <p class="mt-3 max-w-2xl text-[#6B7E94]">Lihat tugas yang diberikan PJ perusahaan, status pengerjaan mahasiswa, dan nilai yang masuk dari perusahaan.</p>
    </div>

    <section class="space-y-4">
        @forelse ($logbooks as $task)
            <article class="cb-card p-5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-[#6B7E94]">{{ $task->student->name }} · {{ $task->application->offer->company->nama }}</p>
                        <h2 class="mt-1 text-lg font-bold text-[#0D1B2A]">{{ $task->judul_kegiatan }}</h2>
                        <p class="mt-2 text-sm text-[#6B7E94]">{{ $task->application->offer->judul }} · Deadline {{ $task->due_date?->translatedFormat('d F Y') ?? 'tidak ditentukan' }}</p>
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
                    <p class="mt-3 rounded-lg bg-[#FDF3DC] p-3 text-sm text-[#0D1B2A]">Feedback perusahaan: {{ $task->score_notes ?: $task->catatan_pembimbing }}</p>
                @endif
            </article>
        @empty
            <div class="cb-card border-dashed p-10 text-center text-[#6B7E94]">Belum ada tugas dari perusahaan untuk mahasiswa bimbingan Anda.</div>
        @endforelse
        {{ $logbooks->links() }}
    </section>
@endsection
