@extends('admin.layout')

@section('title', $title.' | Admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">{{ $title }}</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ $routeBase }}">Back</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Record #{{ $record->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ $routeBase }}/{{ $record->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ $routeBase }}" class="btn btn-secondary btn-sm">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ($record->getAttributes() as $key => $value)
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-secondary small">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                                    <div class="fw-semibold text-break">
                                        @if ($value instanceof \Illuminate\Support\Carbon)
                                            {{ $value->format('Y-m-d H:i') }}
                                        @elseif (is_bool($record->{$key}))
                                            {{ $record->{$key} ? 'Yes' : 'No' }}
                                        @else
                                            {{ $value ?? '-' }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
