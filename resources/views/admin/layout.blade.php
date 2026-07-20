<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('admin.partials.head')
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        @include('admin.partials.header')
        @include('admin.partials.sidebar')

        <main class="app-main">
            @yield('content')
        </main>

        @include('admin.partials.footer')
    </div>

    <script src="{{ asset('admin/js/adminlte.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
