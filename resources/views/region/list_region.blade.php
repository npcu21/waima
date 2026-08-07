@extends('admin.layouts.app')

@section('title', 'Regions List')

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

      <div class="ms-3">
        <form method="GET" action="{{ route('masteradmin.dashboard') }}">
            <select name="lang" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="en" {{ request('lang') == 'en' ? 'selected' : '' }}>English</option>
                <option value="fr" {{ request('lang') == 'fr' ? 'selected' : '' }}>Français</option>
            </select>
        </form>
      </div>

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

          <!-- <li><a class="dropdown-item" href="{{ url('admin/privacy-policies') }}"><i class="bi bi-file-text me-2"></i>{{ __('dashboard.privacy_policy') }}</a></li> -->
          <!-- <li><a class="dropdown-item" href="{{ url('admin/terms-conditions') }}"><i class="bi bi-file-text me-2"></i>{{ __('dashboard.terms_conditions') }}</a></li> -->

          <!-- <li><a class="dropdown-item" href="{{ url('admin/documents/create') }}"><i class="bi bi-plus-circle me-2"></i>{{ __('dashboard.add_document') }}</a></li> -->
          <li><a class="dropdown-item" href="{{ url('admin/documents') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.documents_list') }}</a></li>
          <li><a class="dropdown-item" href="{{ route('dynamic.index') }}"><i class="bi bi-ui-checks-grid me-2"></i>{{ __('dashboard.dynamic_form') }}</a></li>

          <!-- <li><a class="dropdown-item" href="{{ route('countries.create') }}"><i class="bi bi-plus-circle me-2"></i>{{ __('dashboard.add_country') }}</a></li> -->
             <li>
    <a class="dropdown-item" href="{{ route('country.list') }}">
        <i class="bi bi-flag me-2"></i>{{ __('dashboard.country_list') }}
    </a>
</li>

<li>
    <a class="dropdown-item" href="{{ route('region.create') }}">
        <!-- <i class="bi bi-plus-circle me-2"></i>{{ __('dashboard.create_region') }} -->
    </a>
</li>

<li>
    <a class="dropdown-item" href="{{ route('region.list') }}">
        <i class="bi bi-card-list me-2"></i>{{ __('dashboard.region_list') }}
    </a>
</li>

          <li><a class="dropdown-item text-danger" href="{{ route('masteradmin.logout') }}"><i class="bi bi-box-arrow-right me-2"></i>{{ __('dashboard.logout') }}</a></li>
        </ul>
      </div>

    </div>
  </div>
</nav>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 col-lg-12 p-4">
      <div class="preview-box mt-0">
    
          <div class="d-flex justify-content-between align-items-center mb-4">
          <h3 class="preview-title theme-color mb-0">Regions List</h3>
          <!-- ✅ Add Region Button -->
          <a href="{{ route('region.create') }}" class="btn btn-primary">Add Region</a>
        </div>
    

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Country</th>
                <th>Region Name</th>
                <th>Commune</th>
                <th>District</th>
           
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($regions as $region)
            <tr>
                <td>{{ $region->id }}</td>
                <td>{{ $region->country_name }}</td>
                <td>{{ $region->name }}</td>
                <td>{{ $region->commune }}</td>
                <td>{{ $region->district }}</td>
    
                <td>
                    <a href="{{ route('region.edit', $region->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('region.delete', $region->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
    </div>
  </div>
@endsection
