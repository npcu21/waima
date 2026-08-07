@extends('admin.layouts.app')

@section('title', 'Edit Region')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm w-100">
  <div class="d-flex justify-content-between align-items-center px-4 w-100">
    <a class="navbar-brand fw-bold text-primary" href="{{ url('admin/dashboard') }}" style="font-size: 1.3rem;">
      ADMIN WAIMA
    </a>

    <div class="d-flex align-items-center">
      <span class="me-3 fw-medium">{{ __('dashboard.admin') }}</span>

      <!-- ✅ Language Switcher -->
      <div class="ms-3">
        <form method="GET" action="{{ route('masteradmin.dashboard') }}">
            <select name="lang" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="en" {{ request('lang') == 'en' ? 'selected' : '' }}>English</option>
                <option value="fr" {{ request('lang') == 'fr' ? 'selected' : '' }}>Français</option>
            </select>
        </form>
      </div>

      <!-- ✅ Profile Dropdown -->
      <div class="dropdown ms-3">
        <button class="btn border-0 bg-transparent dropdown-toggle p-0" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle fs-4"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end mt-2 shadow" aria-labelledby="profileDropdown">
  <li><a class="dropdown-item" href="{{ url('admin/dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>{{ __('dashboard.dashboard') }}</a></li>
  <li><a class="dropdown-item" href="{{ url('admin/users') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.farmer_list') }}</a></li>
  <li><a class="dropdown-item" href="{{ url('admin/suppliers') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.supplier_list') }}</a></li>
  <li><a class="dropdown-item" href="{{ url('admin/product-overview') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.overview') }}</a></li>
  <li><a class="dropdown-item" href="{{ url('admin/create-user') }}"><i class="bi bi-plus-circle me-2"></i>{{ __('dashboard.create_user') }}</a></li>
  <li><a class="dropdown-item" href="{{ url('admin/agents') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.agent_list') }}</a></li>
  <li><a class="dropdown-item" href="{{ url('admin/products/form-selector') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.add_product') }}</a></li>
  <li><a class="dropdown-item" href="{{ route('admin.products.all') }}"><i class="bi bi-table me-2"></i>{{ __('dashboard.all_products') }}</a></li>

  <li><a class="dropdown-item" href="{{ url('admin/privacy-policies') }}"><i class="bi bi-file-text me-2"></i>{{ __('dashboard.privacy_policy') }}</a></li>
  <li><a class="dropdown-item" href="{{ url('admin/terms-conditions') }}"><i class="bi bi-file-text me-2"></i>{{ __('dashboard.terms_conditions') }}</a></li>
  
  <li><a class="dropdown-item" href="{{ url('admin/documents/create') }}"><i class="bi bi-plus-circle me-2"></i>{{ __('dashboard.add_document') }}</a></li>
  <li><a class="dropdown-item" href="{{ url('admin/documents') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.documents_list') }}</a></li>
  <li><a class="dropdown-item" href="{{ route('dynamic.index') }}"><i class="bi bi-ui-checks-grid me-2"></i>{{ __('dashboard.dynamic_form') }}</a></li>

  <li><a class="dropdown-item" href="{{ route('countries.create') }}"><i class="bi bi-plus-circle me-2"></i>{{ __('dashboard.add_country') }}</a></li>
  <li><a class="dropdown-item" href="{{ route('country.list') }}"><i class="bi bi-flag me-2"></i>Country List</a></li>
  <li><a class="dropdown-item" href="{{ route('region.create') }}"><i class="bi bi-plus-circle me-2"></i>Create Region</a></li>
  <li><a class="dropdown-item" href="{{ route('region.list') }}"><i class="bi bi-card-list me-2"></i>Region List</a></li>
  <li><a class="dropdown-item text-danger" href="{{ route('masteradmin.logout') }}"><i class="bi bi-box-arrow-right me-2"></i>{{ __('dashboard.logout') }}</a></li>
</ul>
      </div>
    </div>
  </div>
</nav>
<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-lg-12 p-4">
      <div class="form-section">
    <h4>Edit Region</h4>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('region.update', $region->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Country Dropdown -->
        <div class="mb-3">
            <label for="country_id" class="form-label">Country</label>
            <select name="country_id" id="country_id" class="form-control" required>
                <option value="">-- Select Country --</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ $region->country_id == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Region Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Region Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $region->name }}" required>
        </div>

        <!-- Commune -->
        <div class="mb-3">
            <label for="commune" class="form-label">Commune</label>
            <input type="text" name="commune" id="commune" class="form-control" value="{{ $region->commune }}" required>
        </div>

        <!-- District -->
        <div class="mb-3">
            <label for="district" class="form-label">District</label>
            <input type="text" name="district" id="district" class="form-control" value="{{ $region->district }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Region</button>
        <a href="{{ route('region.list') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
</div>
    </div>
  </div>
@endsection
