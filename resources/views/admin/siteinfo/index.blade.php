@extends('admin.layout')

@section('title', 'Site Info | Admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Site Info</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Site Info</li>
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
                    <h3 class="card-title">Site Info Records</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Logo</th>
                                <th>Header</th>
                                <th>Contact Email</th>
                                <th>Theme</th>
                                <th>Maintenance</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siteinfos as $siteinfo)
                                <tr>
                                    <td>{{ $siteinfo->id }}</td>
                                    <td>
                                        @if ($siteinfo->logo)
                                            <img src="{{ asset($siteinfo->logo) }}" alt="Logo" style="height: 36px">
                                        @else
                                            <span class="text-secondary">No logo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $siteinfo->sidebar_lg_header ?: 'Not set' }}</strong>
                                        <div class="text-secondary small">{{ $siteinfo->sidebar_sm_header }}</div>
                                    </td>
                                    <td>{{ $siteinfo->contact_email ?: '-' }}</td>
                                    <td>{{ ucfirst($siteinfo->default_theme) }}</td>
                                    <td>
                                        <span class="badge text-bg-{{ $siteinfo->maintenance_mode ? 'danger' : 'success' }}">
                                            {{ $siteinfo->maintenance_mode ? 'On' : 'Off' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ url('/admin/siteinfo/'.$siteinfo->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ url('/admin/siteinfo/'.$siteinfo->id.'/edit') }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-secondary py-4">No site info records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $siteinfos->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
