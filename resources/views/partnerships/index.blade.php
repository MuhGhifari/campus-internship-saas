<x-layouts.app title="Kemitraan - CareerBridge">
    <div class="grid gap-6 lg:grid-cols-[360px_1fr]">
        <aside>
            @if (auth()->user()->hasRole('perusahaan'))
                <form method="POST" action="{{ route('partnerships.store') }}" class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    @csrf
                    <h1 class="text-xl font-bold">Ajukan Kemitraan</h1>
                    <p class="mt-2 text-sm text-slate-600">Pilih universitas yang ingin diajak bekerja sama sebelum mengirim posisi magang.</p>
                    <label class="mt-4 block">
                        <span class="text-sm font-medium">Universitas</span>
                        <select name="university_id" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
                            @foreach ($universities as $university)
                                <option value="{{ $university->id }}">{{ $university->nama }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="mt-4 block">
                        <span class="text-sm font-medium">Pesan Proposal</span>
                        <textarea name="pesan" rows="5" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">Kami ingin membuka program magang untuk mahasiswa dan berkolaborasi dengan kampus.</textarea>
                    </label>
                    <button class="mt-4 w-full rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Kirim Proposal</button>
                </form>
            @else
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <h1 class="text-xl font-bold">Review Kemitraan</h1>
                    <p class="mt-2 text-sm text-slate-600">Universitas menerima atau menolak proposal kerja sama dari perusahaan.</p>
                </div>
            @endif
        </aside>

        <section class="space-y-4">
            @forelse ($partnerships as $partnership)
                <article class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-semibold">{{ $partnership->company->nama }}</p>
                            <p class="text-sm text-slate-600">{{ $partnership->university->nama }}</p>
                            @if ($partnership->pesan)
                                <p class="mt-3 text-sm text-slate-700">{{ $partnership->pesan }}</p>
                            @endif
                        </div>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium">{{ ucfirst($partnership->status) }}</span>
                    </div>

                    @if ($partnership->catatan_review)
                        <p class="mt-3 rounded-lg bg-slate-50 p-3 text-sm text-slate-600">Catatan: {{ $partnership->catatan_review }}</p>
                    @endif

                    @if (auth()->user()->hasRole('staf') && $partnership->status === 'menunggu')
                        <form method="POST" action="{{ route('partnerships.update', $partnership) }}" class="mt-4 grid gap-3 sm:grid-cols-[160px_1fr_auto]">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                <option value="diterima">Terima</option>
                                <option value="ditolak">Tolak</option>
                            </select>
                            <input name="catatan_review" placeholder="Catatan untuk perusahaan" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Simpan</button>
                        </form>
                    @endif
                </article>
            @empty
                <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500">Belum ada proposal kemitraan.</div>
            @endforelse

            {{ $partnerships->links() }}
        </section>
    </div>
</x-layouts.app>
