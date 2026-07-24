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
                    <h3 class="card-title">{{ $title }}</h3>
                    @if ($canCreate ?? true)
                        <div class="card-tools">
                            <a href="{{ $routeUrl }}/create" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-lg"></i> Add New
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                @foreach ($columns as $label)
                                    <th>{{ $label }}</th>
                                @endforeach
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($records as $record)
                                <tr>
                                    @foreach (array_keys($columns) as $column)
                                        @php($value = data_get($record, $column))
                                        <td>
                                            @if (is_bool($value))
                                                <span class="badge text-bg-{{ $value ? 'success' : 'secondary' }}">{{ $value ? 'Yes' : 'No' }}</span>
                                            @elseif ($value instanceof \Illuminate\Support\Carbon)
                                                {{ $value->format('Y-m-d H:i') }}
                                            @else
                                                {{ \Illuminate\Support\Str::limit((string) ($value ?? '-'), 80) }}
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="text-end">
                                        <a href="{{ $routeUrl }}/{{ $record->id }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                        @if ($canEdit ?? true)
                                            <a href="{{ $routeUrl }}/{{ $record->id }}/edit" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                        @endif
                                        @if ($canDelete ?? true)
                                            <form action="{{ $routeUrl }}/{{ $record->id }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($columns) + 1 }}" class="text-center text-secondary py-4">No records found.</td>
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
