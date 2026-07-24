@extends('admin.layout')

@section('title', 'Create Site Info | Admin')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Create Site Info</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/admin/siteinfo') }}">Site Info</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <form action="{{ url('/admin/siteinfo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.siteinfo.form', ['submitLabel' => 'Create Site Info'])
            </form>
        </div>
    </div>
@endsection
