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
                        <li class="breadcrumb-item"><a href="{{ $routeUrl }}">Back</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $record->exists ? 'Edit' : 'Create' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ $record->exists ? $routeUrl.'/'.$record->id : $routeUrl }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($record->exists)
                    @method('PUT')
                @endif

                @include('admin.crud.form')
            </form>
        </div>
    </div>
@endsection
