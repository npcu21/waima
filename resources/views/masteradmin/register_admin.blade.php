@extends('admin.layouts.app')

@section('title', __('masteradmin.page_title'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="container-fluid p-0">


    <div class="container my-5">
        <h2 class="text-center mb-4">{{ __('masteradmin.heading') }}</h2>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Registration Form -->
<form action="{{ route('masteradmin.register.admin.store') }}" method="POST" class="card p-4 col-md-6 mx-auto shadow">
    @csrf

    <div class="mb-3">
        <label>{{ __('masteradmin.name') }}</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    <div class="mb-3">
        <label>{{ __('masteradmin.email') }}</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>

    <div class="mb-3">
        <label>{{ __('masteradmin.phone') }}</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
    </div>

    <div class="mb-3">
        <label>{{ __('masteradmin.password') }}</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>{{ __('masteradmin.confirm_password') }}</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <!-- Select Type -->
    <div class="mb-3">
        <label>{{ __('masteradmin.type') }}</label>
        <select name="type_select" id="type_select" class="form-control" required>
            <option value="">{{ __('masteradmin.select_type') }}</option>
            <option value="country" {{ old('type_select') == 'country' ? 'selected' : '' }}>
                {{ __('masteradmin.country') }}
            </option>
            <option value="region" {{ old('type_select') == 'region' ? 'selected' : '' }}>
                {{ __('masteradmin.region') }}
            </option>
        </select>
    </div>

    <!-- Country dropdown -->
    <div class="mb-3" id="country_dropdown" style="display: none;">
        <label>{{ __('masteradmin.country') }}</label>
        <select name="country_id" class="form-control">
            <option value="">{{ __('masteradmin.select_country') }}</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="d-grid mt-3">
        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">
            {{ __('masteradmin.register') }}
        </button>
    </div>
</form>
</div>

</div>

<style>
    body { background-color: #f8f9fa; }
    h2 { font-weight: 600; }
    .card { border-radius: 12px; }
    @media (max-width: 767px) { .card { padding: 20px; } }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type_select');
        const countryDropdown = document.getElementById('country_dropdown');

        function toggleCountryDropdown() {
            countryDropdown.style.display = (typeSelect.value === 'country') ? 'block' : 'none';
        }

        toggleCountryDropdown();
        typeSelect.addEventListener('change', toggleCountryDropdown);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
