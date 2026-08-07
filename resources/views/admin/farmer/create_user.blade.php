@extends('admin.layouts.app')

@section('title', __('farmer.create_farmer'))

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@include('includes.navbar')

<div class="container create-user-container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-10">
            <div class="card shadow-sm rounded-4 p-4 mb-5">
                <h4 class="text-center mb-4">{{ __('farmer.create_farmer') }}</h4>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.store_user') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('farmer.name') }}</label>
                        <input type="text" name="name" class="form-control" id="name"
                            placeholder="{{ __('farmer.enter_name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('farmer.email') }}</label>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="{{ __('farmer.enter_email') }}" required>
                    </div>

                    <input type="hidden" name="usertype_id" value="3">
                    <!-- <div class="mb-3">
                        <label for="usertype_id" class="form-label">{{ __('farmer.user_type') }}</label>
                        <select name="usertype_id" class="form-select" id="usertype_id" required>
                            <option value="">{{ __('farmer.select_user_type') }}</option>
                            @foreach($usertypes as $type)
                                @if($type->id == 3)
                                    <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div> -->

                    <div class="mb-3">
                        <label for="country_id" class="form-label">{{ __('farmer.country') }}</label>
                        <select name="country_id" class="form-select" id="country_id" required>
                            <option value="">{{ __('farmer.select_country') }}</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('farmer.phone') }}</label>
                        <input type="text" name="phone" class="form-control" id="phone"
                            placeholder="{{ __('farmer.enter_phone') }}" required>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary w-50 py-2">{{ __('farmer.create_user_btn') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.create-user-container { padding-top: 60px; padding-bottom: 60px; }
@media (max-width: 768px) { .create-user-container { padding-top: 110px; } }
body { background-color: #f8f9fa; }
.navbar-brand { font-size: 1.3rem; }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
