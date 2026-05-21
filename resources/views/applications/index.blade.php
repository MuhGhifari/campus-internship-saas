<x-layouts.app title="Lamaran - CareerBridge">
    <h1 class="text-3xl font-bold">Lamaran Magang</h1>
    <p class="mt-2 text-slate-600">Pantau status lamaran, penanggung jawab perusahaan, dan pembimbing kampus.</p>

    <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold">Mahasiswa</th>
                    <th class="px-4 py-3 font-semibold">Lowongan</th>
                    <th class="px-4 py-3 font-semibold">Status</th>
                    <th class="px-4 py-3 font-semibold">Pembimbing</th>
                    <th class="px-4 py-3 font-semibold">Periode</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($applications as $application)
                    <tr>
                        <td class="px-4 py-4">
                            <p class="font-semibold">{{ $application->student->name }}</p>
                            <p class="text-slate-500">{{ $application->student->nomor_induk }}</p>
                        </td>
                        <td class="px-4 py-4">
                            <a href="{{ route('offers.show', $application->offer) }}" class="font-semibold text-emerald-700">{{ $application->offer->judul }}</a>
                            <p class="text-slate-500">{{ $application->offer->company->nama }}</p>
                        </td>
                        <td class="px-4 py-4"><span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium">{{ ucfirst($application->status) }}</span></td>
                        <td class="px-4 py-4">
                            <p>Kampus: {{ $application->campusSupervisor->name ?? '-' }}</p>
                            <p class="text-slate-500">Perusahaan: {{ $application->companySupervisor->name ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-4 text-slate-600">{{ $application->tanggal_mulai?->format('d/m/Y') ?? '-' }} - {{ $application->tanggal_selesai?->format('d/m/Y') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada lamaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $applications->links() }}</div>
</x-layouts.app>
