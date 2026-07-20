<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="/admin/dashboard" class="brand-link">
            <img src="/admin/assets/img/AdminLTELogo.png" alt="Admin Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">AdminLTE 4</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
                @foreach ($sidebarMenu ?? [] as $item)
                    @include('admin.partials.sidebar-menu-item', ['item' => $item])
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
