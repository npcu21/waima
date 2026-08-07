@extends('admin.layouts.app')

@section('title', __('dashboard.create_announcement'))

@section('content')

<!-- Navbar -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-primary" href="https://fivoflow.com/wclm/public/country-admin/dashboard" style="font-size: 1.3rem;">
            ADMIN WAIMA
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav align-items-center">

                {{-- Language Switch --}}
                <li class="nav-item me-3">
                    <form method="GET" action="{{ route('countryadmin.dashboard') }}">
                        <select name="lang" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="en" {{ request('lang') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="fr" {{ request('lang') == 'fr' ? 'selected' : '' }}>Français</option>
                        </select>
                    </form>
                </li>

                {{-- Admin --}}
                <li class="nav-item me-3">
                    <span class="fw-medium">{{ __('dashboard.admin') }}</span>
                </li>

                {{-- Profile --}}
                <li class="nav-item dropdown">
                    <button class="btn border-0 bg-transparent dropdown-toggle p-0" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-4"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end mt-2 shadow" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{ url('admin/dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>{{ __('dashboard.dashboard') }}</a></li>
                        <li><a class="dropdown-item" href="https://fivoflow.com/wclm/public/admin/country/users"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.farmer_list') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('supplier.countryList') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.supplier_list') }}</a></li>
                                            <li>
    <a class="dropdown-item" href="{{ route('admin.product.overview.country') }}">
        <i class="bi bi-card-list me-2"></i>{{ __('dashboard.overview') }}
    </a>
</li>
                        <!-- <li><a class="dropdown-item" href="{{ url('admin/product-overview') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.overview') }}</a></li> -->
                        <li><a class="dropdown-item" href="{{ route('agents.country.list') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.agent_list') }}</a></li>
                        <!-- <li><a class="dropdown-item" href="{{ url('admin/products/form-selector') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.add_product') }}</a></li> -->
                        <li><a class="dropdown-item" href="https://fivoflow.com/wclm/public/products-all-country"><i class="bi bi-table me-2"></i>{{ __('dashboard.all_products') }}</a></li>
                        <li><a class="dropdown-item text-danger" href="{{ route('masteradmin.logout') }}"><i class="bi bi-box-arrow-right me-2"></i>{{ __('dashboard.logout') }}</a></li>
    

                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 p-4">
            <div class="card shadow-sm p-4">

            
    <h4 class="mb-4">{{ __('dashboard.create_announcement') }}</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

                <form action="{{ route('admin.announcement.countrystore') }}" method="POST" enctype="multipart/form-data">
       <!-- 💥 IMPORTANT -->

    @csrf
    <input type="hidden" name="language_id" value="{{ session('lang', 'en') }}">

    <div class="row gy-3">

        <!-- Title -->
        <div class="col-md-6">
            <label for="title" class="form-label">{{ __('dashboard.title') }}*</label>
            <input type="text" name="title" id="title" class="form-control" 
                   value="{{ old('title') }}" required>
            @error('title') 
                <div class="text-danger mt-1">{{ $message }}</div> 
            @enderror
        </div>

        <!-- User Type -->
        <div class="col-md-6">
            <label for="user_type_id" class="form-label">{{ __('dashboard.user_type') }}*</label>
            <select name="user_type_id" id="user_type_id" class="form-select" required>
                <option value="" disabled selected>{{ __('dashboard.select_user_type') }}</option>
                @foreach($usertypes as $type)
                    <option value="{{ $type->id }}"
                        {{ old('user_type_id') == $type->id ? 'selected' : '' }}>
                        {{ $userTypeNames[session('lang', 'en')][$type->id] ?? $type->name_type }}
                    </option>
                @endforeach
            </select>
            @error('user_type_id') 
                <div class="text-danger mt-1">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Description -->
        <div class="col-12">
            <label for="description" class="form-label">{{ __('dashboard.description') }}*</label>
            <textarea name="description" id="description" rows="5" 
                      class="form-control" required>{{ old('description') }}</textarea>
            @error('description') 
                <div class="text-danger mt-1">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Status -->
        <div class="col-md-6">
            <label for="status" class="form-label">{{ __('dashboard.status') }}*</label>
            <select name="status" id="status" class="form-select" required>
                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>
                    {{ __('dashboard.active') }}
                </option>
                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                    {{ __('dashboard.inactive') }}
                </option>
            </select>
            @error('status') 
                <div class="text-danger mt-1">{{ $message }}</div> 
            @enderror
        </div>
<div class="col-md-6">
    @if($selectedCountry)
        <input type="hidden" name="country_id" value="{{ $selectedCountry->id }}">
    @else
        <input type="hidden" name="country_id" value="">
    @endif
</div>




        <!-- Image Upload -->
        <div class="col-md-6">
            <label for="image" class="form-label">{{ __('dashboard.image') }}</label>
            <input type="file" name="image" id="image" class="form-control">
            @error('image') 
                <div class="text-danger mt-1">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Submit -->
        <div class="col-12 mt-3">
            <div class="text-center">
                <button type="submit" class="btn btn-primary w-50">
                    {{ __('dashboard.submit') }}
                </button>
            </div>
        </div>

    </div>
</form>

</div>
</div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection