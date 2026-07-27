@extends('admin.layout')

@section('title', 'Maintenance | Admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Maintenance</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Maintenance</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laravel Maintenance Commands</h3>
                </div>
                <div class="card-body">
                    @php
                        $groups = [
                            'clear' => ['title' => 'Clear Commands', 'button' => 'btn-primary'],
                            'build' => ['title' => 'Build Cache Commands', 'button' => 'btn-success'],
                            'utility' => ['title' => 'Utility Commands', 'button' => 'btn-secondary'],
                        ];
                    @endphp

                    @foreach ($groups as $groupKey => $group)
                        <div class="{{ $loop->first ? '' : 'mt-4' }}">
                            <h5 class="mb-3">{{ $group['title'] }}</h5>
                            <div class="row g-3">
                                @foreach (array_filter($commands, fn ($command) => $command['group'] === $groupKey) as $action => $command)
                                    <div class="col-md-4">
                                        <div class="border rounded p-3 h-100">
                                            <h5>{{ $command['label'] }}</h5>
                                            <p class="text-secondary mb-2">{{ $command['description'] }}</p>
                                            <p class="mb-3">Runs <code>php artisan {{ $command['command'] }}</code>.</p>
                                            <form method="POST" action="{{ route('admin.maintenance.run') }}">
                                                @csrf
                                                <input type="hidden" name="action" value="{{ $action }}">
                                                <button type="submit" class="btn {{ $group['button'] }}">
                                                    <i class="bi {{ $command['icon'] }}"></i> Run {{ $command['label'] }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer text-end">
                    <form method="POST" action="{{ route('admin.maintenance.run') }}" class="d-inline">
                        @csrf
                        <input type="hidden" name="action" value="all_clear">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-arrow-repeat"></i> Run All Clear Commands
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
