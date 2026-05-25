<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CareerBridge')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen cb-page antialiased">
    @guest
        @include('partials.guest-nav')

        <main class="pt-[68px]">
            <div class="mx-auto max-w-none">
                @include('partials.workspace-flash')
                @yield('content')
            </div>
        </main>
    @else
        @include(match (auth()->user()->role) {
            'mahasiswa' => 'student.app',
            'staf' => 'university.app',
            'perusahaan' => 'company.app',
            'dosen' => 'professor.app',
            default => 'student.app',
        })
    @endguest

    @yield('scripts')
</body>
</html>
