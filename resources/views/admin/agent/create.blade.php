@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')

@php
$columnLabels = [
    'seed' => __('dashboard.seed'),
    'typeoffeed' => __('dashboard.typeoffeed'),
    'afrm' => __('dashboard.afrm'),
    'afenergy' => __('dashboard.afenergy'),
    'title' => __('dashboard.title'),
    'afwholesaleprice' => __('dashboard.afwholesaleprice'),
    'afsemiwholesaleprice' => __('dashboard.afsemiwholesaleprice'),
    'afretailprice' => __('dashboard.afretailprice'),
];

// Status map
$statusMap = [
    1 => __('dashboard.pending'),
    2 => __('dashboard.approved'),
    3 => __('dashboard.rejected'),
];
@endphp

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('admin/dashboard') }}" style="font-size: 1.3rem;">
            ADMIN WAIMA
        </a>
    </div>
</nav> -->
@include('countryadmin.layouts.nav')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 p-4">
            <div class="card shadow-sm p-4">
                <h4 class="mb-4">{{ __('agent.add_agent') }}</h4>

                {{-- Success / Error Messages --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('country.agent.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">{{ __('agent.name') }}*</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">{{ __('agent.email') }}*</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" required>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">{{ __('agent.password') }}*</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
                        </div>

                        <div class="col-md-6">
                            <label for="country" class="form-label">{{ __('agent.country') }}*</label>
                            <select name="country" id="country" class="form-select" required>
                                <option value="{{ session('country_id') }}" selected>
                                    {{ \App\Models\Country::where('id', session('country_id'))->value('name') }}
                                </option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="region" class="form-label">{{ __('agent.region') }}*</label>
                            <select name="region[]" id="region" class="form-select select2" multiple required>
                                @foreach(\App\Models\Region::where('country_id', session('country_id'))->get() as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary w-50">{{ __('agent.create_agent') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 for multi-select regions
    $('#region').select2({
        placeholder: "Select Regions",
        allowClear: true,
        width: '100%'
    });
});
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
