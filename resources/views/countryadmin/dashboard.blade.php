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
    3 => __('dashboard.deny'),
];

// TABLE NAME FIX MAP
$map = [
    'seed_country' => 'seed',
    'typeoffeed_country' => 'typeoffeed',
    'veterinary_products_country' => 'veterinary_products',
    'animal_feeds_country' => 'animal_feeds',
    'mineral_fertilizers_country' => 'mineral_fertilizers',
    'organic_amendments_country' => 'organic_amendments',
    'bio_stimulants_country' => 'bio_stimulants',
    'inorganic_soil_conditioners_country' => 'inorganic_soil_conditioners',
    'synthetic_pesticides_country' => 'synthetic_pesticides',
];

@endphp

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

@include('countryadmin.layouts.nav')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 p-4">

            {{-- Filter Section --}}
    <div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="">
            <div class="row">

                {{-- CATEGORY --}}
                <div class="col-md-4">
                    <label for="category" class="form-label">{{ __('dashboard.filter_by_category') }}</label>
                    <select class="form-select" id="category" name="category" onchange="this.form.submit()">
                        <option value="">{{ __('dashboard.select_category') }}</option>
                        @foreach($dropdownCounts as $item)
                            @php 
                                $name = is_object($item) ? $item->name : $item['name'];
                                $slug = Str::slug($name, '_');
                            @endphp
                            <option value="{{ $slug }}" {{ ($selectedCategory === $slug) ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="country" value="{{ $selectedCountry ?? '' }}">

                {{-- STATUS FILTER --}}
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Pending</option>
                        <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Approved</option>
                        <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>Denied</option>
                    </select>
                </div>

                {{-- APPLY BUTTON --}}
                <div class="col-md-4">
                    <label class="form-label" style="visibility:hidden;">{{ __('dashboard.apply_filter') }}</label>
                    <button class="btn btn-outline-primary w-100">{{ __('dashboard.apply_filter') }}</button>
                </div>

                {{-- SEARCH --}}
                <div class="col-12 mt-3">
                    <input 
                        type="text" 
                        class="form-control" 
                        id="search" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="{{ __('dashboard.search') }}" 
                        style="border-radius:20px;background-color:#f9f9f9;">
                </div>

                {{-- YIELD RANGE --}}
                <div class="col-md-6 mt-3">
                    <label class="form-label">Yield Range</label>
                    <div class="d-flex gap-2">
                        <input type="number" class="form-control" name="yield_min" placeholder="Min" value="{{ request('yield_min') }}">
                        <input type="number" class="form-control" name="yield_max" placeholder="Max" value="{{ request('yield_max') }}">
                    </div>
                </div>

                {{-- PRICE RANGE --}}
                <div class="col-md-6 mt-3">
                    <label class="form-label">Price Range</label>
                    <div class="d-flex gap-2">
                        <input type="number" class="form-control" name="price_min" placeholder="Min" value="{{ request('price_min') }}">
                        <input type="number" class="form-control" name="price_max" placeholder="Max" value="{{ request('price_max') }}">
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>


            {{-- Add Buttons --}}
            <div class="row mb-4 gy-3">
                <div class="col-md-3">
                    <a href="https://fivoflow.com/wclm/public/supplier/addcountry" class="btn theme-outline w-100 py-2"><i class="bi bi-plus-lg me-2"></i>{{ __('dashboard.add_new_supplier') }}</a>
                </div>
                <div class="col-md-3">
                    <a href="https://fivoflow.com/wclm/public/country/agent/create" class="btn theme-outline w-100 py-2"><i class="bi bi-plus-lg me-2"></i>{{ __('dashboard.add_new_agent') }}</a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.announcement.createcountry') }}" class="btn theme-outline w-100 py-2"><i class="bi bi-plus-lg me-2"></i>{{ __('dashboard.create_announcement') }}</a>
                </div>
                <div class="col-md-3">
                    <a href="https://fivoflow.com/wclm/public/admin/announcements/country" class="btn theme-outline w-100 py-2"><i class="bi bi-plus-lg me-2"></i>{{ __('dashboard.view_announcement_list') }}</a>
                </div>
            </div>

 <h5 class="mb-3">{{ __('dashboard.all_category_counts') }}</h5>
<div class="row mb-4 gy-3">
    @foreach($counts as $item)

        @php
            // ✅ Name (object + array safe)
            $name = is_object($item)
                ? ($item->name ?? '')
                : ($item['name'] ?? '');

            // ✅ Slug (prefer controller slug)
            $slug = is_object($item)
                ? ($item->slug ?? \Str::slug($name, '_'))
                : ($item['slug'] ?? \Str::slug($name, '_'));

            // ✅ Count safe
            $count = is_object($item)
                ? ($item->count ?? 0)
                : ($item['count'] ?? 0);
        @endphp

        @if($name)
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('products.all.country', ['category' => $slug]) }}"
               class="text-decoration-none">
                <div class="card shadow-sm card-stats h-100">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-0 text-capitalize">
                            {{ $name }} ({{ $count }})
                        </h6>
                    </div>
                </div>
            </a>
        </div>
        @endif

    @endforeach
</div>




 {{-- Latest Products --}}
<h5 class="mb-4 mt-4">{{ __('dashboard.latest_product') }}</h5>

<div class="card shadow-sm mb-4">
    <div class="card-body table-responsive">

        @if($combinedData->count())

            @php
                // ❌ Columns jo hide karne hain
                $hiddenColumns = [
                    'seed',
                    'table_name',
                    'status_id',
                    'table_id',
                    'supplier_id',
                    'country_id',
                    'category_slug',
                    'parent_id'   // ✅ HIDE parent_id
                ];
            @endphp

            <table id="productTable" class="table table-bordered table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        {{-- Category --}}
                        <th>{{ $columnLabels['seed'] ?? 'Category' }}</th>

                        {{-- Dynamic Headers --}}
                        @foreach(array_keys((array)$combinedData->first()) as $column)
                            @if(!in_array($column, $hiddenColumns))
                                <th>
                                    {{ $columnLabels[strtolower($column)]
                                        ?? ucwords(str_replace('_', ' ', $column)) }}
                                </th>
                            @endif
                        @endforeach

                        <th>{{ __('dashboard.status') }}</th>
                        <th>{{ __('dashboard.action') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($combinedData as $row)

                        {{-- 🚫 Hide status 0 --}}
                        @if(($row->status_id ?? 0) == 0)
                            @continue
                        @endif

                        <tr>
                            {{-- Category --}}
                            <td><strong>{{ $row->seed }}</strong></td>

                            {{-- Dynamic Values --}}
                            @foreach($row as $key => $val)
                                @if(!in_array($key, $hiddenColumns))
                                    <td>{{ $val ?? '-' }}</td>
                                @endif
                            @endforeach

                            {{-- Status --}}
                            <td>
                                @php
                                    $status = $row->status_id ?? 1;

                                    $badgeClass = [
                                        1 => 'bg-warning text-dark',
                                        2 => 'bg-success text-white',
                                        3 => 'bg-danger text-white',
                                    ];

                                    $statusMap = [
                                        1 => 'Pending',
                                        2 => 'Approved',
                                        3 => 'Deny'
                                    ];
                                @endphp

                                <span class="badge {{ $badgeClass[$status] }}">
                                    {{ $statusMap[$status] }}
                                </span>
                            </td>

                            {{-- Action --}}
                            <td class="d-flex gap-2">
                                <a href="{{ route('masteradmincountry.view.record', [
                                    'table' => $row->table_name,
                                    'id'    => $row->table_id
                                ]) }}"
                                   class="btn btn-sm btn-primary shadow-sm">
                                    <i class="bi bi-eye"></i> {{ __('dashboard.view') }}
                                </a>

                                <a href="{{ route('countryadmin.upload.record', [
                                    'table' => $row->table_name,
                                    'id'    => $row->table_id
                                ]) }}"
                                   class="btn btn-sm btn-success shadow-sm">
                                    <i class="bi bi-upload"></i> {{ __('dashboard.document_upload') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <p class="text-muted mb-0">{{ __('dashboard.no_records_found') }}</p>
        @endif

    </div>
</div>





        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#productTable').DataTable({
        "order": [],
        "paging": true,
        "searching": true,
        "language": {
            "search": "{{ __('dashboard.search') }}",
            "zeroRecords": "{{ __('dashboard.no_records_found') }}",
            "paginate": {
                "next": "{{ __('dashboard.next') }}",
                "previous": "{{ __('dashboard.previous') }}"
            }
        }
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
