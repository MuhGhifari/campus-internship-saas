<div class="min-h-screen bg-[#F7F3ED]">
    @include('partials.auth-nav')
    <main class="px-5 py-8 lg:px-16">
        @include('partials.workspace-flash')
        @yield('content')
    </main>
</div>
