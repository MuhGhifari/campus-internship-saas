<x-layouts.app title="Edit Lowongan - CareerBridge">
    <div class="mx-auto max-w-4xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold">Edit Lowongan Magang</h1>
        <form method="POST" action="{{ route('offers.update', $offer) }}" class="mt-6">
            @include('offers._form', ['method' => 'PATCH'])
        </form>
    </div>
</x-layouts.app>
