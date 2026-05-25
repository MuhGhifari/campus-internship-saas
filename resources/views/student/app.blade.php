<div class="grid min-h-screen bg-[#F2F7F2] lg:grid-cols-[280px_1fr]">
    @include('student.partials.sidebar')
    <div>
        @include('student.partials.header')
        <main class="px-5 py-8 sm:px-8">
            @include('partials.workspace-flash')
            @yield('content')
        </main>
    </div>
</div>
