@extends('admin.layouts.app')

@section('title', __('labels.all_products'))

@section('content')

<!-- Bootstrap CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@include('includes.navbar')


@php
$categoryLabels = [

'seeds' => [
    'cropName' => __('labels.crop_name'),
    'verityName' => __('labels.variety_name'),
    'breederName' => __('labels.breeder_name'),
    'countryOrigin' => __('labels.country_origin'),
    'registrationNumber' => __('labels.registration_number'),
    'varietyType' => __('labels.variety_type'),
    'seedCategory' => __('labels.seed_category'),
    'precocity' => __('labels.precocity'),
    'fruitColor' => __('labels.fruit_color'),
    'fruitShape' => __('labels.fruit_shape'),
    'leafColor' => __('labels.leaf_color'),
    'plantHeight' => __('labels.plant_height'),
    'bioticResistance' => __('labels.biotic_resistance'),
    'abioticResistance' => __('labels.abiotic_resistance'),
    'InherentNutritionalValue' => __('labels.nutritional_value'),
    'yield' => __('labels.yield'),
    'retailPrice' => __('labels.average_wholesale_price'),
],

'mineral_fertilizers' => [
    'title' => __('labels.fertilizer_type'),
    'fertilizer_registration' => __('labels.registration_number'),
    'physical_form' => __('labels.physical_form'),
    'trade_name' => __('labels.trade_name'),
    'n' => __('labels.nitrogen'),
    'p2' => __('labels.phosphorus'),
    'k2' => __('labels.potassium'),
    'application_rate' => __('labels.application_rate'),
    'fertilizer_retail_price' => __('labels.average_retail_price'),
],

'organic_amendments' => [
    'organic_type' => __('labels.type'),
    'physical_form' => __('labels.physical_form'),
    'trade_name' => __('labels.trade_name'),
    'country_origin' => __('labels.country_origin'),
    'n' => __('labels.nitrogen'),
    'p2' => __('labels.phosphorus'),
    'k2' => __('labels.potassium'),
    'cn_ratio' => __('labels.cn_ratio'),
    'raw_material_other' => __('labels.raw_material'),
    'chromium_content' => __('labels.heavy_metals_compliance'),
    'retail_price' => __('labels.average_retail_price'),
],

'bio_stimulants' => [
    'trade_name' => __('labels.trade_name'),
    'physical_form' => __('labels.physical_form'),
    'biostimulant_product' => __('labels.biostimulant_type'),
    're_registration' => __('labels.registration_number'),
    'action_mode' => __('labels.mode_of_action'),
    'n' => __('labels.nitrogen'),
    'p2' => __('labels.phosphorus'),
    'k2' => __('labels.potassium'),
    'retail_price' => __('labels.average_retail_price'),
],

'inorganic_soil_conditioners' => [
    'conditioner_type' => __('labels.conditioner_type'),
    'physical_form' => __('labels.physical_form'),
    'trade_name' => __('labels.trade_name'),
    'raw_material' => __('labels.raw_material'),
    'function' => __('labels.function'),
    'retail_price' => __('labels.average_retail_price'),
],

'synthetic_pesticides' => [
    'trade_name' => __('labels.trade_name'),
    'active_ingredient' => __('labels.active_ingredient'),
    'formulation' => __('labels.formulation'),
    'registration_number' => __('labels.registration_number'),
    'function' => __('labels.function'),
    'toxicological_class_number' => __('labels.toxicological_class'),
    'approval_number' => __('labels.approval_number'),
    'retail_price' => __('labels.average_retail_price'),
],

'animal_feeds' => [
    'Typeoffeed'            => __('labels.feed_type'),
    'afrm'                  => __('labels.raw_material'),
    'afPhysicalform'        => __('labels.physical_form'),
    'afdm'                  => __('labels.dry_matter'),
    'afEnergy'              => __('labels.energy'),
    'afcp'                  => __('labels.crude_protein'),
    'afsp'                  => __('labels.storage_period'),
    'affs'                  => __('labels.feed_size'),
    'afWholesalePrice'      => __('labels.wholesale_price'),
    'afsemiwholesalePrice'  => __('labels.semi_wholesale_price'),
    'afretailPrice'         => __('labels.retail_price'),
],

'veterinary_products' => [
    'product_name' => __('labels.product_name'),
    'manufacturing_lab' => __('labels.manufacturing_laboratory'),
    'active_substance' => __('labels.active_substance'),
    'registration_number' => __('labels.registration_number'),
    'therapeutic_class' => __('labels.therapeutic_class'),
    'dosage' => __('labels.dosage'),
    'pharmaceutical_form' => __('labels.pharmaceutical_form'),
    'route_of_administration' => __('labels.route_of_administration'),
    'targeted_animals' => __('labels.target_animals'),
    'expiry_date' => __('labels.expiry_date'),
    'transport_storage_requirements' => __('labels.storage'),
    'retail_price' => __('labels.average_retail_price'),
],
];

$currentCategory = Str::slug($category,'_');
$labelsForCategory = $categoryLabels[$currentCategory] ?? [];
@endphp


<div class="container-fluid">
    <div class="row">
        <div class="col-12 p-4">

            <h4 class="mb-4">{{ __('labels.all_products') }}</h4>

            {{-- CATEGORY CARDS --}}
            <div class="row mb-4 gy-3">
                @foreach($counts as $item)
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('admin.products.all', ['category' => $item['slug']]) }}"
                           class="text-decoration-none">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center">
                                    <h6 class="mb-0 text-capitalize">
                                        {{ __('labels.' . $item['slug']) }} ({{ $item['count'] }})
                                    </h6>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>



            {{-- FILTERS --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.products.all') }}">

                        @if($category)
                            <input type="hidden" name="category" value="{{ $category }}">
                        @endif

                        <div class="row">

                            <div class="col-md-3 mb-3">
                                <label class="form-label">{{ __('labels.country') }}</label>
                                <select class="form-select" name="country" onchange="this.form.submit()">
                                    <option value="">{{ __('labels.select_country') }}</option>
                                    @foreach($countries as $c)
                                        @php
                                            $countryName = DB::table('countries')->where('id',$c)->value('name');
                                        @endphp
                                        <option value="{{ $c }}" {{ request('country')==$c?'selected':'' }}>
                                            {{ $countryName ?? $c }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">{{ __('labels.status') }}</label>
                                <select class="form-select" name="status" onchange="this.form.submit()">
                                    <option value="">{{ __('labels.all_status') }}</option>
                                    <option value="1" {{ request('status')==1?'selected':'' }}>{{ __('labels.pending') }}</option>
                                    <option value="2" {{ request('status')==2?'selected':'' }}>{{ __('labels.approved') }}</option>
                                    <option value="3" {{ request('status')==3?'selected':'' }}>{{ __('labels.deny') }}</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">{{ __('labels.search') }}</label>
                                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="{{ __('labels.search') }}">
                            </div>

                            <div class="col-md-3 mb-3 d-flex align-items-end">
                                <button class="btn btn-outline-primary w-100">{{ __('labels.apply_filters') }}</button>
                            </div>

                            {{-- Price & Yield filters --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">{{ __('labels.min_price') }}</label>
                                <input type="number" class="form-control" name="min_price" value="{{ request('min_price') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">{{ __('labels.max_price') }}</label>
                                <input type="number" class="form-control" name="max_price" value="{{ request('max_price') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">{{ __('labels.min_yield') }}</label>
                                <input type="number" class="form-control" name="min_yield" value="{{ request('min_yield') }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">{{ __('labels.max_yield') }}</label>
                                <input type="number" class="form-control" name="max_yield" value="{{ request('max_yield') }}">
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="card shadow-sm">
                <div class="card-body">
                   @if($tableData->count())
<div class="table-responsive">

<table id="productTable" class="table table-bordered table-striped">
<thead>
<tr>
@foreach($labelsForCategory as $label)
<th>{{ $label }}</th>
@endforeach
<th>Supplier</th>
<th>{{ __('labels.status') }}</th>
<th class="text-center">Action</th>
</tr>
</thead>

<tbody>
@foreach($tableData as $row)
<tr>

{{-- CATEGORY DATA --}}
@foreach($labelsForCategory as $field => $label)
<td>{{ $row->$field ?? '—' }}</td>
@endforeach

{{-- SUPPLIER NAME --}}
@php
$supplier = DB::table('suppliers')->where('id',$row->supplier_id)->first();
@endphp
<td>{{ $supplier->company_name ?? $supplier->name ?? 'N/A' }}</td>

{{-- STATUS --}}
<td>
@if($row->status_id == 1)
<span class="badge bg-warning">Pending</span>
@elseif($row->status_id == 2)
<span class="badge bg-success">Approved</span>
@else
<span class="badge bg-danger">Deny</span>
@endif
</td>

{{-- ACTION --}}
<td class="d-flex gap-2 flex-wrap">

    {{-- View --}}
    <a href="{{ route('masteradmin.view.record', [
            'table' => $row->table_name,
            'id'    => $row->id
        ]) }}"
        class="btn btn-sm btn-primary w-max">
        <i class="bi bi-eye"></i> {{ __('labels.view') }}
    </a>

    {{-- Upload Document --}}
    <a href="{{ route('masteradmin.upload.record', [
            'table' => $row->table_name,
            'id'    => $row->id
        ]) }}"
        class="btn btn-sm btn-success w-max">
        <i class="bi bi-upload"></i> {{ __('labels.document_upload') }}
    </a>

    {{-- Download Excel --}}
    <a href="{{ route('admin.products.export', [
            'table' => $row->table_name,
            'id'    => $row->id
        ]) }}"
        class="btn btn-sm btn-info w-max">
        <i class="bi bi-file-earmark-excel"></i> {{ __('labels.download_excel') }}
    </a>
     <form action="{{ route('admin.products.import') }}"
      method="POST"
      enctype="multipart/form-data"
      class="d-flex gap-2 align-items-center">
    @csrf

    <input type="file" name="excel_file" class="form-control w-max" required>

    <button class="btn btn-secondary w-max">
           {{ __('labels.import_excel') }}

    </button>
</form>

</td>


</tr>
@endforeach
</tbody>
</table>

</div>
@else
<div class="alert alert-info">No data found</div>
@endif

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    $('#productTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true,

        // ✅ Default sorting (first column ASC)
        order: [[0, 'asc']],

        // ❌ Disable sorting on Status & Action columns
        columnDefs: [
            { orderable: false, targets: [-1] }, // Action
            { orderable: false, targets: [-2] }  // Status
        ]
    });
});
</script>



@endsection
