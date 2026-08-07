@extends('admin.layouts.app')

@section('title', 'Products Map')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

 <!-- Navbar -->
 @include('includes.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 p-4">        
            <h4 class="mb-4">Products Map</h4>
            <div class="card shadow-sm"> 
                <div class="card-body">                      
                    <!-- Filters: Category + Region -->
                    <form method="GET" action="{{ route('products.map') }}" class="mb-3 row g-2">
                        <!-- Category Filter -->
                        <div class="col-md-6">
                            <select name="category" class="form-select" onchange="this.form.submit()">
                                <option value="">{{ __('dashboard.all_categories') }}</option>
                                @foreach([
                                    'Seeds','Animal Feed','Biostimulants','Inorganic Soil Conditioners',
                                    'Mineral Fertilizers','Organic Amendments','Synthetic Pesticides','Veterinary Products'
                                ] as $cat)
                                    <option value="{{ $cat }}" {{ ($category == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Region Filter -->
                        <div class="col-md-6">
                            <select name="region" class="form-select" onchange="this.form.submit()">
                                <option value="">{{ __('dashboard.all_regions') }}</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->region }}" {{ (request('region') == $region->region) ? 'selected' : '' }}>
                                        {{ $region->region }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <div id="map" style="height: 600px;"></div>
                </div>     
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
var map = L.map('map').setView([20.5937, 78.9629], 5); // Center on India

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

var products = @json($allData);

products.forEach(function(product) {
    if(product.latitude && product.longitude) {
        L.marker([product.latitude, product.longitude])
         .addTo(map)
         .bindPopup(`<b>${product.supplier_name}</b><br>Category: ${product.table_name}<br>Product ID: ${product.product_id}<br>Region: ${product.region}`);
    }
});
</script>
@endsection
