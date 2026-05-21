<x-layouts.app title="Buat Lowongan - CareerBridge">
    <div class="mx-auto max-w-4xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold">Buat Lowongan Magang</h1>
        <p class="mt-2 text-sm text-slate-600">Lowongan dari perusahaan akan masuk ke proses review sebelum tampil untuk mahasiswa.</p>
        <form method="POST" action="{{ route('offers.store') }}" class="mt-6">
            @include('offers._form')
        </form>
    </div>
</x-layouts.app>
