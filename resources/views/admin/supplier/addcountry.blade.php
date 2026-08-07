@extends('admin.layouts.app')

@section('title', 'Add Supplier')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
@include('countryadmin.layouts.nav')


<div class="container mt-4">

    <div class="card p-4 shadow">
        <h4 class="mb-3">{{ __('dashboard.add_supplier') }}</h4>

        {{-- Success & Error Messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('supplier.countryStore') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Hidden fields not needed: country & language will be set automatically in backend --}}
            
            <div class="row">

                <div class="col-md-6">
                    <label class="form-label">{{ __('dashboard.company_name') }}*</label>
                    <input type="text" name="company_name" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('dashboard.manager_name') }}*</label>
                    <input type="text" name="manager_name" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">{{ __('dashboard.position') }}*</label>
                    <input type="text" name="position" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">{{ __('dashboard.image') }}*</label>
                    <input type="file" name="image" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">{{ __('dashboard.city') }}*</label>
                    <input type="text" name="city" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">{{ __('dashboard.region') }}*</label>
                    <select name="region[]" class="form-select" multiple required>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">{{ __('dashboard.address') }}*</label>
                    <input type="text" name="address" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">{{ __('dashboard.phone') }}*</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">{{ __('dashboard.mobile') }}*</label>
                    <input type="text" name="mobile" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">{{ __('dashboard.email') }}*</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">{{ __('dashboard.state_entity_registration') }}</label>
                    <input type="text" name="state_entity_registration" class="form-control">
                </div>

                <div class="col-md-6 mt-3">
                    <label class="form-label">{{ __('dashboard.employer_identification_number') }}</label>
                    <input type="text" name="employer_identification_number" class="form-control">
                </div>

            </div>

            <button type="submit" class="btn btn-primary mt-4">{{ __('dashboard.submit') }}</button>

        </form>

    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
