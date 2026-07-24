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
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Frontend Page Summary</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Page</th>
                                <th class="text-end">Visits</th>
                                <th class="text-end">Unique Users</th>
                                <th class="text-end">Last Visit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pageSummaries as $page)
                                <tr>
                                    <td class="text-break">{{ $page->path }}</td>
                                    <td class="text-end fw-semibold">{{ $page->total_visits }}</td>
                                    <td class="text-end fw-semibold">{{ $page->unique_users }}</td>
                                    <td class="text-end">{{ \Illuminate\Support\Carbon::parse($page->last_visited_at)->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-secondary py-4">No frontend visits tracked yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">{{ $pageSummaries->withQueryString()->links() }}</div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Frontend Visits</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Page</th>
                                <th>IP Address</th>
                                <th>MAC Address</th>
                                <th>User</th>
                                <th>Visited At</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($records as $record)
                                <tr>
                                    <td>{{ $record->id }}</td>
                                    <td class="text-break">{{ $record->path }}</td>
                                    <td>{{ $record->ip_address ?? '-' }}</td>
                                    <td>{{ $record->mac_address ?? '-' }}</td>
                                    <td>{{ $record->user?->email ?? 'Guest' }}</td>
                                    <td>{{ $record->visited_at?->format('Y-m-d H:i') }}</td>
                                    <td class="text-end">
                                        <a href="{{ $routeUrl }}/{{ $record->id }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-secondary py-4">No frontend visits tracked yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">{{ $records->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
@endsection
