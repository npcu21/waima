@extends('admin.layouts.app')

@section('title', 'Edit Language')

@section('content')

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<!-- Navbar -->
@include('includes.navbar')

<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12 col-md-12 p-4">

    <h4 class="mb-4 text-center">Edit Language</h4>

    <div class="card p-4 shadow col-md-6 mx-auto">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('languages.update', $language->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Lang Code</label>
                <input type="text" name="lang_code" class="form-control" value="{{ old('lang_code', $language->lang_code) }}" required>
            </div>

            <div class="mb-3">
                <label>Lang Name</label>
                <input type="text" name="lang_name" class="form-control" value="{{ old('lang_name', $language->lang_name) }}" required>
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary w-50 py-2">Update Language</button>
            </div>
        </form>

            </div>
        </div>
    </div>
</div>

@endsection
