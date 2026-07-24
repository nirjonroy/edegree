@extends('admin.layout')

@section('title', $title.' | Admin')

@section('content')
    @php($routeUrl = url($routeBase))
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">{{ $title }}</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
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
                    <h3 class="card-title">Page List</h3>
                    <div class="card-tools">
                        <a href="{{ $routeUrl }}/create" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> Add Custom Page
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Page Name</th>
                                <th>URL</th>
                                <th>Status</th>
                                <th>Published At</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($records as $record)
                                <tr>
                                    <td>
                                        <strong>{{ $record->page_name }}</strong>
                                        <div class="text-muted small">{{ $record->slug }}</div>
                                    </td>
                                    <td>
                                        <a href="{{ $record->public_url }}" target="_blank">{{ $record->public_url }}</a>
                                    </td>
                                    <td>
                                        <span class="badge text-bg-{{ $record->status ? 'success' : 'secondary' }}">
                                            {{ $record->status ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td>{{ optional($record->published_at)->format('d M Y h:i A') ?: '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ $routeUrl }}/{{ $record->id }}/edit" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ $routeUrl }}/{{ $record->id }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this page?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-secondary py-4">No custom pages found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">{{ $records->links() }}</div>
            </div>
        </div>
    </div>
@endsection
