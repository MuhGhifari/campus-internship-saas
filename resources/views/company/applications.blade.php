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
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-[#6B7E94]">Belum ada lamaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $applications->links() }}</div>
@endsection
