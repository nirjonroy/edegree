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
                        @if ($canEdit ?? true)
                            <a href="{{ $routeBase }}/{{ $record->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                        @endif
                        <a href="{{ $routeBase }}" class="btn btn-secondary btn-sm">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ($record->getAttributes() as $key => $value)
                            @continue(\Illuminate\Support\Str::endsWith($key, '_source'))
                            @php
                                $label = ucwords(str_replace('_', ' ', $key));
                                $label = str_replace([' Path', ' path'], '', $label);
                                $isUpload = is_string($value) && (
                                    \Illuminate\Support\Str::startsWith($value, 'uploads/')
                                    || \Illuminate\Support\Str::contains($key, ['image', 'background', 'logo', 'favicon'])
                                );
                            @endphp
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-secondary small">{{ $label }}</div>
                                    <div class="fw-semibold text-break">
                                        @if ($value instanceof \Illuminate\Support\Carbon)
                                            {{ $value->format('Y-m-d H:i') }}
                                        @elseif (is_bool($record->{$key}))
                                            {{ $record->{$key} ? 'Yes' : 'No' }}
                                        @elseif ($isUpload && $value)
                                            @if (\Illuminate\Support\Str::endsWith(strtolower($value), ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.svg']))
                                                <img src="/{{ $value }}" alt="{{ $label }}" class="img-thumbnail" style="max-height: 90px">
                                            @else
                                                <a href="/{{ $value }}" target="_blank" class="btn btn-outline-secondary btn-sm">View File</a>
                                            @endif
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
