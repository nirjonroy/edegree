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
                    <h3 class="card-title">Sitemap Entries</h3>
                    <div class="card-tools d-flex gap-2">
                        <form action="{{ url('/admin/sitemap-entries/sync') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-arrow-repeat"></i> Sync Dynamic Pages
                            </button>
                        </form>
                        <a href="{{ $routeUrl }}/create" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> Add Entry
                        </a>
                        <a href="{{ url('/sitemap.xml') }}" target="_blank" class="btn btn-secondary btn-sm">
                            <i class="bi bi-box-arrow-up-right"></i> View XML
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>URL</th>
                                <th>Source</th>
                                <th>Frequency</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Last Modified</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($records as $record)
                                <tr>
                                    <td class="fw-semibold">{{ $record->title }}</td>
                                    <td class="text-break">
                                        <a href="{{ $record->absolute_url }}" target="_blank">{{ $record->url }}</a>
                                    </td>
                                    <td>{{ $record->source_type ? ucwords(str_replace('_', ' ', $record->source_type)) : 'Manual' }}</td>
                                    <td>{{ ucfirst($record->changefreq) }}</td>
                                    <td>{{ number_format((float) $record->priority, 1) }}</td>
                                    <td>
                                        <span class="badge text-bg-{{ $record->is_active ? 'success' : 'secondary' }}">
                                            {{ $record->is_active ? 'Included' : 'Hidden' }}
                                        </span>
                                    </td>
                                    <td>{{ $record->lastmod?->format('Y-m-d H:i') ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ $routeUrl }}/{{ $record->id }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                        <a href="{{ $routeUrl }}/{{ $record->id }}/edit" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                        <form action="{{ $routeUrl }}/{{ $record->id }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this sitemap entry?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-secondary py-4">No sitemap entries found.</td>
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
