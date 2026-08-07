@extends('admin.layouts.app')

@section('title', __('masteradmin.edit_title'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="container-fluid p-0">

    <!-- Navbar -->
    @include('includes.navbar')

    <div class="container p-4">
        <h4 class="mb-4 text-center">{{ __('masteradmin.edit_heading') }}</h4>

        <div class="card p-4 shadow col-md-6 mx-auto">

            <form action="{{ route('masteradmin.update', $admin->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>{{ __('masteradmin.name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>{{ __('masteradmin.email') }}</label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>{{ __('masteradmin.phone') }}</label>
                    <input type="text" name="phone" value="{{ old('phone', $admin->phone) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>{{ __('masteradmin.password') }}</label>
                    <input type="password" name="password" class="form-control" placeholder="{{ __('masteradmin.password_placeholder') }}">
                </div>

                <div class="mb-3">
                    <label>{{ __('masteradmin.country') }}</label>
                    <select name="country_id" class="form-control">
                        <option value="">{{ __('masteradmin.select_country') }}</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" 
                                {{ $admin->country_id == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary d-block w-100 py-2">
                        {{ __('masteradmin.update') }}
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


@endsection
