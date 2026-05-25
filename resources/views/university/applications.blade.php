@extends('layouts.app')

@section('title', 'Lamaran - CareerBridge')

@section('content')
    <div class="mb-8">
        <p class="cb-section-label">Lamaran</p>
        <h1 class="cb-display mt-3 text-5xl font-light text-[#0D1B2A]">Status kandidat dan penempatan magang.</h1>
    </div>

    <div class="cb-card overflow-hidden">
        <table class="min-w-full divide-y divide-[#0D1B2A]/10 text-sm">
            <thead class="bg-[#F7F3ED] text-left">
                <tr>
                    <th class="px-5 py-4 font-semibold">Mahasiswa</th>
                    <th class="px-5 py-4 font-semibold">Lowongan</th>
                    <th class="px-5 py-4 font-semibold">Status</th>
                    <th class="px-5 py-4 font-semibold">Pembimbing</th>
                    <th class="px-5 py-4 font-semibold">Periode</th>
                    <th class="px-5 py-4 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#0D1B2A]/10 bg-white">
                @forelse ($applications as $application)
                    <tr class="hover:bg-[#F7F3ED]/60">
                        <td class="px-5 py-4">
                            <p class="font-semibold text-[#0D1B2A]">{{ $application->student->name }}</p>
                            <p class="text-[#6B7E94]">{{ $application->student->nomor_induk }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <a href="{{ route('offers.show', $application->offer) }}" class="font-semibold text-[#0D1B2A] hover:text-[#E8A020]">{{ $application->offer->judul }}</a>
                            <p class="text-[#6B7E94]">{{ $application->offer->company->nama }}</p>
                        </td>
                        <td class="px-5 py-4"><span class="rounded-full bg-[#FDF3DC] px-3 py-1 text-xs font-semibold text-[#0D1B2A]">{{ ucfirst($application->status) }}</span></td>
                        <td class="px-5 py-4 text-[#3D526B]">
                            <p>Kampus: {{ $application->campusSupervisor->name ?? '-' }}</p>
                            <p>Perusahaan: {{ $application->companySupervisor->name ?? '-' }}</p>
                        </td>
                        <td class="px-5 py-4 text-[#6B7E94]">{{ $application->tanggal_mulai?->format('d/m/Y') ?? '-' }} - {{ $application->tanggal_selesai?->format('d/m/Y') ?? '-' }}</td>
                        <td class="px-5 py-4">
                            <button type="button" data-modal-target="#campus-supervisor-{{ $application->id }}" class="cb-dark-button px-3 py-2 text-xs">Atur PJ Kampus</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-[#6B7E94]">Belum ada lamaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @foreach ($applications as $application)
        @component('partials.modal-shell', [
            'id' => 'campus-supervisor-'.$application->id,
            'title' => 'Atur PJ kampus',
            'eyebrow' => $application->student->name,
            'description' => $application->offer->judul.' · '.$application->offer->company->nama,
        ])
            <form method="POST" action="{{ route('applications.update', $application) }}" class="grid gap-4">
                @csrf
                @method('PATCH')
                <label class="block">
                    <span class="text-sm font-medium">Pembimbing kampus</span>
                    <select name="campus_supervisor_id" required class="cb-input mt-2 text-sm">
                        <option value="">Pilih pembimbing kampus</option>
                        @foreach ($lecturers as $lecturer)
                            <option value="{{ $lecturer->id }}" @selected($application->campus_supervisor_id === $lecturer->id)>{{ $lecturer->name }}</option>
                        @endforeach
                    </select>
                </label>
                <button class="cb-dark-button px-4 py-3 text-sm">Simpan PJ Kampus</button>
            </form>
        @endcomponent
    @endforeach

    <div class="mt-6">{{ $applications->links() }}</div>
@endsection
