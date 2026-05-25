<div class="grid min-h-screen bg-[#F3F7FA] lg:grid-cols-[280px_1fr]">
    @include('university.partials.sidebar')
    <div>
        @include('university.partials.header')
        <main class="px-5 py-8 sm:px-8">
            @include('partials.workspace-flash')
            @yield('content')
        </main>
    </div>
</div>
