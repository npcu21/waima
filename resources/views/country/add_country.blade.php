@extends('admin.layouts.app')

@section('title', __('country.add_country'))

@section('content')

<!-- ✅ Bootstrap & Custom CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- Navbar -->
@include('includes.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 p-4">

            <div class="form-section">

                <h4>{{ __('country.add_country') }}</h4>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form action="{{ route('country.store') }}" method="POST">
                    @csrf

                    <!-- Country Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('country.country_name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <!-- Country Code -->
                    <div class="mb-3">
                        <label for="code" class="form-label">{{ __('country.country_code') }}</label>
                        <input type="text" name="code" id="code" class="form-control">
                    </div>

                    <!-- Language ID -->
                    <div class="mb-3">
                        <label for="language_id" class="form-label">{{ __('country.language_id') }}</label>
                        <input type="number" name="language_id" id="language_id" class="form-control">
                    </div>

                    <!-- Submit -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-50">
                            {{ __('country.submit') }}
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
