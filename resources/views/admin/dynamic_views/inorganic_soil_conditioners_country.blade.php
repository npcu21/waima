{{-- resources/views/admin/dynamic_views/inorganic_soil_conditioner.blade.php --}}

@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')

<!-- ✅ Bootstrap & Custom CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- ✅ Navbar -->
 <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('admin/dashboard') }}" style="font-size: 1.3rem;">
                ADMIN WAIMA
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav align-items-center">

                    <!-- Language Switch -->
                    <li class="nav-item me-3">
                        <form method="GET" action="{{ route('masteradmin.dashboard') }}">
                            <select name="lang" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="en" {{ request('lang') == 'en' ? 'selected' : '' }}>English</option>
                                <option value="fr" {{ request('lang') == 'fr' ? 'selected' : '' }}>Français</option>
                            </select>
                        </form>
                    </li>

                    <!-- Admin Label -->
                    <li class="nav-item me-3">
                        <span class="fw-medium">{{ __('dashboard.admin') }}</span>
                    </li>

                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <button class="btn border-0 bg-transparent dropdown-toggle p-0" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-4"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end mt-2 shadow" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="{{ url('admin/dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>{{ __('dashboard.dashboard') }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/users') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.farmer_list') }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/suppliers') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.supplier_list') }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/product-overview') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.overview') }}</a></li>
                            <!-- <li><a class="dropdown-item" href="{{ url('admin/create-user') }}"><i class="bi bi-plus-circle me-2"></i>{{ __('dashboard.create_user') }}</a></li> -->
                            <li><a class="dropdown-item" href="{{ url('admin/agents') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.agent_list') }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/products/form-selector') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.add_product') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.products.all') }}"><i class="bi bi-table me-2"></i>{{ __('dashboard.all_products') }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/documents') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.documents_list') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('dynamic.index') }}"><i class="bi bi-ui-checks-grid me-2"></i>{{ __('dashboard.dynamic_form') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('country.list') }}"><i class="bi bi-flag me-2"></i>{{ __('dashboard.country_list') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('region.list') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.region_list') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('masteradmin.list') }}"><i class="bi bi-card-list me-2"></i>{{ __('dashboard.country_user') }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('/admin/products-map?category=') }}"><i class="bi bi-geo-alt me-2"></i>{{ __('dashboard.products_map') }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('/price-chart') }}"><i class="bi bi-bar-chart-line me-2"></i>{{ __('dashboard.price_chart') }}</a></li>
                            <li><a class="dropdown-item text-danger" href="{{ route('masteradmin.logout') }}"><i class="bi bi-box-arrow-right me-2"></i>{{ __('dashboard.logout') }}</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
<style>
body { background-color: #f8f9fa; }
.preview-box {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-top: 40px;
}
.btn-w {
  width:160px!important;
}
.preview-title {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 10px;
    margin-bottom: 20px;
}
.form-label { font-weight: 600; }
.form-control-plaintext { padding-top: 0; padding-bottom: 10px; }
.record-image {
    display:block; max-width: 100%; max-height: 150px; margin-top: 5px;
    border-radius: 5px; border: 1px solid #ddd; padding: 2px; margin-right:5px;
}
</style>

@php
$labels = [
    'conditioner_type' => 'Conditioner Type (example: lime, gypsum)',
    'physical_form' => 'Physical Form',
    'trade_name' => 'Trade Name',
    'raw_material' => 'Raw Material',
    'other' => 'Other Info',
    'function' => 'Function',
    'wholesale_price' => 'Average Wholesale Price by Packaging Type',
    'semiwholesale_price' => 'Average Semi-Wholesale Price by Packaging Type',
    'retail_price' => 'Average Retail Price by Packaging Type',
    'qr_code_path' => 'QR Code',
    'status_id' => 'Status',
    'form_type' => 'Form Type',
    'title' => 'Title'
];

$statusText = [1 => 'Pending', 2 => 'Approved', 3 => 'Rejected'];
$hiddenKeys = ['id','created_by','language_id','created_at','updated_at',
'supplier_id','form_type','agent_id','product_id','title'];
@endphp

<div class="container-fluid px-4">
  <div class="row">
    <div class="col-12">
      <div class="preview-box mb-4">
        <h3 class="preview-title">Inorganic Soil Conditioner Details</h3>

        @if(isset($record) && $record)
          <div class="row gy-3">
            @foreach($record as $key => $value)
              @if(!in_array($key, $hiddenKeys))
                <div class="col-md-4">
                  <label class="form-label">{{ $labels[$key] ?? ucwords(str_replace('_',' ',$key)) }}:</label>

                  @php
                    $images = [];
                    if(str_contains(strtolower($key),'qr') && !empty($value)) {
                        $images[] = $value;
                    }
                  @endphp

                  @if(count($images) > 0)
                    @foreach($images as $img)
                      <img src="{{ asset($img) }}" class="record-image" alt="{{ $key }}">
                    @endforeach
                  @else
                    <p class="form-control-plaintext">{{ $value ?? '—' }}</p>
                  @endif
                </div>
              @endif
            @endforeach
          </div>

          <!-- ✅ Status Buttons -->
          <!-- @if(isset($record['id']))
            <div class="mt-4">
              <form action="{{ url('admin/inorganic_soil_conditioners/'.$record['id'].'/status') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="2">
                <button type="submit" class="btn btn-success">Approve</button>
              </form>

              <form action="{{ url('admin/inorganic_soil_conditioners/'.$record['id'].'/status') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="3">
                <button type="submit" class="btn btn-danger">Reject</button>
              </form>
            </div>
          @endif -->
@if(isset($record['id']) && isset($record['status_id']) && $record['status_id'] == 1)
    <div class="mt-4 d-flex align-items-center gap-3">

        {{-- ✅ APPROVE --}}
        <form action="{{ url('admin/update-status/inorganic_soil_conditioners/'.$record['id']) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="status" value="2"> {{-- assuming 2 means approved --}}
            <button type="submit" class="btn btn-success btn-w">Approve</button>
        </form>

        <a href="{{ route('record.edit', ['table' => $table, 'id' => $record['id']]) }}" class="btn btn-primary btn-w">✏️ Edit</a>

        {{-- ❌ REJECT — MODAL OPEN BUTTON --}}
        <button type="button" class="btn btn-warning btn-w" data-bs-toggle="modal" data-bs-target="#rejectModalInorganic">
            Reject
        </button>

        {{-- 🗑️ DELETE BUTTON --}}
          <form action="{{ route('admin.delete', ['table' => 'inorganic_soil_conditioners', 'id' => $record['id']]) }}" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-w" onclick="return confirm('Are you sure you want to delete this record?')">
                  Delete
              </button>
          </form>

    </div>
@endif

<!-- ✅ REJECT REASON MODAL -->
<div class="modal fade" id="rejectModalInorganic" tabindex="-1" aria-labelledby="rejectModalInorganicLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalInorganicLabel">Enter Rejection Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ url('admin/update-status/inorganic_soil_conditioners/'.$record['id']) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="3"> {{-- assuming 3 means rejected --}}

                <div class="modal-body">
                    <textarea name="reason" class="form-control" rows="4" placeholder="Enter reason..." required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Now</button>
                </div>
            </form>

        </div>
    </div>
</div>


          <!-- ✅ Display Status -->
          <!-- @if(isset($record['status_id']))
            <div class="mt-2">
              <strong>Status:</strong> {{ $statusText[$record['status_id']] ?? 'Pending' }}
            </div>
          @endif -->

          <div class="mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-w">Back</a>                     
          </div>          

        @else
          <p class="text-muted mb-0">No record found for this entry.</p>
        @endif

      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
