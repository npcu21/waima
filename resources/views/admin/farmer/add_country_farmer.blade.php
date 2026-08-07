@extends('admin.layouts.app')

@section('title', 'Create Farmer')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

@include('countryadmin.layouts.nav')

<!-- ✅ Create Farmer Form -->
<div class="container create-user-container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-sm rounded-4 p-4 mb-5">
                <h2 class="text-center mb-4">{{ __('farmer.create_farmer') }}</h2>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('admin.country.farmer.store') }}" method="POST">
                    @csrf

                    <!-- Logged-in User Country -->
                    <div class="mb-3">
                        <!-- <label class="form-label">Country</label>
                        <input type="text" class="form-control" value="{{ $country_name }}" readonly> -->
                        <input type="hidden" name="country_id" value="{{ $country_id }}">
                    </div>

                    <!-- <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div> -->

                    <div class="mb-3">
                        <label class="form-label">{{ __('farmer.name') }}</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('farmer.email') }}</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('farmer.phone') }}</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <!-- User Type Farmer (hidden) -->
                    <input type="hidden" name="usertype_id" value="2">

                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary rounded-pill py-2">{{ __('farmer.create_user_btn') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.create-user-container {
    padding-top: 60px;
    padding-bottom: 60px;
}

body {
    background-color: #f8f9fa;
}
</style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
