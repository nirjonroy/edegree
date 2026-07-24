<nav class="app-header navbar navbar-expand bg-body border-bottom">
    <div class="container-fluid">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="Toggle sidebar">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-block">
                <span class="navbar-text fw-semibold text-body">
                    @yield('page_title', 'Admin Panel')
                </span>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <img src="{{ asset('adminlte/assets/img/user2-160x160.jpg') }}" class="user-image rounded-circle shadow-sm" alt="User Image">
                    <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Admin' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="px-3 py-2">
                        <div class="fw-semibold">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="small text-secondary">{{ auth()->user()->email ?? '' }}</div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a href="{{ url('/profile') }}" class="dropdown-item">
                            <i class="bi bi-person me-2"></i> Profile
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Sign out
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
