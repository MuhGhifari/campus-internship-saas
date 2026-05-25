<div class="grid min-h-screen bg-[#FAF7F1] lg:grid-cols-[280px_1fr]">
    @include('company.partials.sidebar')
    <div>
        @include('company.partials.header')
        <main class="px-5 py-8 sm:px-8">
            @include('partials.workspace-flash')
            @yield('content')
        </main>
    </div>
</div>
