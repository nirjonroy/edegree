<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ url('/admin/dashboard') }}" class="brand-link">
            @if (! empty($adminBrand['logo']))
                <img src="{{ asset($adminBrand['logo']) }}" alt="{{ $adminBrand['large'] ?? 'eDegree+' }}" class="brand-image bg-white rounded opacity-100 shadow-sm">
            @else
                <span class="brand-image d-inline-flex align-items-center justify-content-center bg-white rounded-circle text-danger fw-bold shadow-sm">e</span>
            @endif
            <span class="brand-text fw-semibold">{{ $adminBrand['large'] ?? 'eDegree+' }}</span>
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
