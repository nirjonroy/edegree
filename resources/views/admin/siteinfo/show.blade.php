@extends('admin.layout')

@section('title', 'View Site Info | Admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Site Info Details</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="/admin/siteinfo">Site Info</a></li>
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
                    <h3 class="card-title">Record #{{ $siteinfo->id }}</h3>
                    <div class="card-tools">
                        <a href="/admin/siteinfo/{{ $siteinfo->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                        <a href="/admin/siteinfo" class="btn btn-secondary btn-sm">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        @foreach ($siteinfo->getAttributes() as $key => $value)
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-secondary small">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                                    <div class="fw-semibold text-break">
                                        @if (in_array($key, ['logo', 'favicon']) && $value)
                                            <img src="/{{ $value }}" alt="{{ $key }}" style="max-height: 60px">
                                        @elseif (is_bool($siteinfo->{$key}))
                                            {{ $siteinfo->{$key} ? 'Yes' : 'No' }}
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
