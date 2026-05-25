<div class="grid min-h-screen bg-[#F5F3FA] lg:grid-cols-[280px_1fr]">
    @include('professor.partials.sidebar')
    <div>
        @include('professor.partials.header')
        <main class="px-5 py-8 sm:px-8">
            @include('partials.workspace-flash')
            @yield('content')
        </main>
    </div>
</div>
