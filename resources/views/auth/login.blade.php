<x-layouts.app title="Masuk - CareerBridge">
    <div class="mx-auto max-w-md rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold">Masuk</h1>
        <p class="mt-2 text-sm text-slate-600">Gunakan akun demo atau akun mahasiswa yang sudah didaftarkan.</p>

        <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-4">
            @csrf
            <label class="block">
                <span class="text-sm font-medium">Email</span>
                <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
            </label>
            <label class="block">
                <span class="text-sm font-medium">Kata Sandi</span>
                <input name="password" type="password" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2">
            </label>
            <label class="flex items-center gap-2 text-sm">
                <input name="remember" type="checkbox" class="rounded border-slate-300">
                Ingat saya
            </label>
            <button class="w-full rounded-lg bg-emerald-600 px-4 py-2 font-semibold text-white hover:bg-emerald-700">Masuk</button>
        </form>

        <div class="mt-6 rounded-lg bg-slate-50 p-4 text-sm text-slate-600">
            <p class="font-semibold text-slate-900">Akun demo</p>
            <p>staf@careerbridge.test / password</p>
            <p>mahasiswa@careerbridge.test / password</p>
            <p>dosen@careerbridge.test / password</p>
            <p>hr@careerbridge.test / password</p>
        </div>
    </div>
</x-layouts.app>
