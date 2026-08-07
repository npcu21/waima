@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<style>

     #priceChart {
        width: 100% !important;
        height: 400px !important; /* change height as needed */
    } 
    

    .pc-reset-btn {
        background: #fff;
        color: #116bac;
        border: 1px solid #116bac;
    }

    .pc-reset-btn:hover {
        background: #fff;
        color: #116bac;
        border: 1px solid #116bac;
    }

  
</style>
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
                <li>
                    <a class="dropdown-item" href="{{ route('masteradmin.list') }}">
                        <i class="bi bi-card-list me-2"></i>{{ __('dashboard.country_user') }}
                    </a>
                </li>
                                            <li>
            <a class="dropdown-item" href="{{ url('/admin/products-map?category=') }}">
                <i class="bi bi-geo-alt me-2"></i>{{ __('dashboard.products_map') }}
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ url('/price-chart') }}">
                <i class="bi bi-bar-chart-line me-2"></i>{{ __('dashboard.price_chart') }}
            </a>
        </li>


    <li><a class="dropdown-item text-danger" href="{{ route('masteradmin.logout') }}"><i class="bi bi-box-arrow-right me-2"></i>{{ __('dashboard.logout') }}</a></li>
</ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>


<div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 p-4">
            
                <div class=".pc-box card shadow-sm mb-3">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Filter Price Movements</h5>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('chart.filter') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Category</label>
                                    <select class="form-select" name="product_id">
                                        <option value="0" {{ $productId == 0 ? 'selected' : '' }}>All Products</option>

                                        @foreach($products as $p)
                                            @if($p->id <= 8)
                                                <option value="{{ $p->id }}" {{ $productId == $p->id ? 'selected' : '' }}>
                                                    {{ $p->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Time Period</label>
                                    <select class="form-select" name="time_range">
                                        <option value="15"  {{ $timeRange == 15  ? 'selected' : '' }}>Last 15 Days</option>
                                        <option value="30"  {{ $timeRange == 30  ? 'selected' : '' }}>Last 30 Days</option>
                                        <option value="90"  {{ $timeRange == 90  ? 'selected' : '' }}>Last 3 Months</option>
                                        <option value="180" {{ $timeRange == 180 ? 'selected' : '' }}>Last 6 Months</option>
                                        <option value="365" {{ $timeRange == 365 ? 'selected' : '' }}>Last 12 Months</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label" style="visibility:hidden;">Apply</label>
                                    <button type="submit" class="btn btn-outline-primary w-100">Apply</button>
                                </div>

                                <div class="col-md-2"> 
                                    <label class="form-label d-block" style="visibility:hidden;">Reset</label>                                   
                                    <a href="{{ route('chart.index') }}">
                                        <button type="button" class=" btn pc-reset-btn w-100">Reset</button>
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>

                    
                </div>
           

                <div class=".pc-box card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Price Comparison Chart</h5>
                    </div>

                    <div class="card-body">
                        <canvas id="priceChart" ></canvas>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let chart = null;

    const rawLabels = @json($months);

    const labels = rawLabels.map(date => {
        let d = new Date(date);
        return d.toLocaleString('en-US', { month: 'short' });
    });

    const wholesale = @json($wholesale);
    const semi = @json($semi);
    const retail = @json($retail);

    function renderChart() {
        if (chart) chart.destroy();

        const ctx = document.getElementById("priceChart");

        chart = new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [
                    { label: "Wholesale", data: wholesale, borderColor: "#0056ff", tension: 0.4, borderWidth: 2 },
                    { label: "Semi Wholesale", data: semi, borderColor: "#ff9800", tension: 0.4, borderWidth: 2 },
                    { label: "Retail", data: retail, borderColor: "#008f39", tension: 0.4, borderWidth: 2 }
                ]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
            }
        });
    }

    renderChart();
</script>



@endsection
 