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
    'product_name' => __('dashboard.product_name'),
    'manufacturing_lab' => __('dashboard.manufacturing_lab'),
    'registration_number' => __('dashboard.registration_number'),
    'trade_name' => __('dashboard.trade_name'),
    'active_ingredient' => __('dashboard.active_ingredient'),
    'composition' => __('dashboard.composition'),
    'physical_form' => __('dashboard.physical_form'),
    'fertilizer_registration' => __('dashboard.fertilizer_registration'),
    'application_rate' => __('dashboard.application_rate'),
    'wholesale_price' => __('dashboard.wholesale_price'),
    'semiwholesale_price' => __('dashboard.semiwholesale_price'),
    'retail_price' => __('dashboard.retail_price'),
      'seed' => __('dashboard.seed'),

    // ❗ ADD THESE
    'cropname' => __('dashboard.crop_name'),
    'created_at' => __('dashboard.created_at'),
    'updated_at' => __('dashboard.updated_at'),
    'retailprice' => __('dashboard.retail_price'),
    'supplier_name' => __('dashboard.supplier_name'),
    'country_name' => __('dashboard.country_name'),
    'id' => __('dashboard.id'),

    // existing
    'product_name' => __('dashboard.product_name'),
];

$statusMap = [
    1 => __('dashboard.pending'),
    2 => __('dashboard.approved'),
    3 => __('dashboard.deny'),
];

$badgeClass = [
    1 => 'bg-warning text-dark',
    2 => 'bg-success text-white',
    3 => 'bg-danger text-white',
];
@endphp

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

@include('includes.navbar')

<div class="container-fluid">   
<div class="row">
<div class="col-md-12 p-4">
  <ul class="list-unstyled mb-3">
    <li class="nav-item dropdown text-end">

        <!-- BELL ICON -->
        <a class="nav-link position-relative" href="#" id="notificationDropdown"
           role="button" data-bs-toggle="dropdown" aria-expanded="false">

            <i class="bi bi-bell noti-icon"></i>

            <!-- COUNT BADGE -->
            <span id="notifyCount"
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                style="display:none;">
            </span>

        </a>

        <!-- DROPDOWN -->
        <ul id="notifyList"
            class="dropdown-menu dropdown-menu-end shadow noti-dropdown"
            aria-labelledby="notificationDropdown"
            style="width:300px; max-height:350px; overflow-y:auto; display:none;">

            <li class="dropdown-header fw-bold">Notifications</li>
            <li><hr class="dropdown-divider"></li>

            <!-- NOTIFICATIONS WILL LOAD HERE -->
            <div id="notifyItems">
                <li class="text-center text-muted">Loading...</li>
            </div>

        </ul>

    </li>
</ul>

{{-- FILTER CARD --}}
<div class="card shadow-sm mb-4">
<div class="card-body">
<form method="GET" action="{{ route('masteradmin.dashboard') }}">
<div class="row">

{{-- CATEGORY FILTER --}}
<div class="col-md-4">
<label class="form-label">{{ __('dashboard.filter_by_category') }}</label>
<select class="form-select" name="category" onchange="this.form.submit()">
<option value="">{{ __('dashboard.select_category') }}</option>

@foreach($counts as $item)
<option value="{{ $item['slug'] }}"
    {{ ($selectedCategory === $item['slug']) ? 'selected' : '' }}>
    {{ __('labels.' . $item['slug']) }}
</option>
@endforeach

</select>
</div>

{{-- COUNTRY --}}
<div class="col-md-4">
<label class="form-label">{{ __('dashboard.filter_by_country') }}</label>
<select class="form-select" name="country" onchange="this.form.submit()">
<option value="">{{ __('dashboard.select_country') }}</option>
@foreach($countries as $id => $c)
<option value="{{ $id }}" {{ ($selectedCountry == $id) ? 'selected' : '' }}>
{{ $c }}
</option>
@endforeach
</select>
</div>

{{-- APPLY --}}
<div class="col-md-4">
<label class="form-label" style="visibility:hidden;">Apply</label>
<button class="btn btn-outline-primary w-100">
{{ __('dashboard.apply_filter') }}
</button>
</div>

{{-- SEARCH --}}
<div class="col-md-12 mt-3">
<input type="text" class="form-control" name="search"
value="{{ request('search') }}"
placeholder="{{ __('dashboard.search') }}">
</div>
   <div class="col-md-6 mt-3">
                            <label class="form-label">{{ __('dashboard.min_price') }}</label>
                            <input type="number" class="form-control"
                                   name="min_price" value="{{ request('min_price') }}"
                                   placeholder="Enter minimum price">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label"> {{ __('dashboard.max_price') }}</label>
                            <input type="number" class="form-control"
                                   name="max_price" value="{{ request('max_price') }}"
                                   placeholder="Enter maximum price">
                        </div>

                        {{-- YIELD FILTER --}}
                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ __('dashboard.min_yield') }}</label>
                            <input type="number" class="form-control"
                                   name="min_yield" value="{{ request('min_yield') }}"
                                   placeholder="Enter minimum yield">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label">{{ __('dashboard.max_yield') }}</label>
                            <input type="number" class="form-control"
                                   name="max_yield" value="{{ request('max_yield') }}"
                                   placeholder="Enter maximum yield">
                        </div>

                        {{-- STATUS FILTER --}}
                        <div class="col-md-4 mt-3">
                            <label class="form-label">{{ __('dashboard.filter_by_status') }}</label>
                            <select class="form-select" name="status" onchange="this.form.submit()">
                                <option value="">Select Status</option>
                                @foreach($statusMap as $id => $label)
                                    <option value="{{ $id }}" {{ request('status') == $id ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
</div>
</form>
</div>
</div>
 <div class="row mb-4 gy-3">
          <div class="col-md-3 mt-0">
            <a href="{{ route('admin.create-announcement') }}" class="btn theme-outline w-100 py-2"><i class="bi bi-plus-lg me-2"></i>{{ __('dashboard.create_announcement') }}</a>
          </div>
          <div class="col-md-3 mt-0">
            <a href="{{ route('admin.list-announcements') }}" class="btn theme-outline w-100 py-2"><i class="bi bi-table me-2"></i>{{ __('dashboard.view_announcement_list') }}</a>
          </div>
          <div class="col-md-3 mt-0">
            <a href="{{ route('admin.create-supplier') }}" class="btn theme-outline w-100 py-2"><i class="bi bi-plus-lg me-2"></i>{{ __('dashboard.add_new_supplier') }}</a>
          </div>
          <div class="col-md-3 mt-0">
            <a href="{{ route('admin.create-agent') }}" class="btn theme-outline w-100 py-2"><i class="bi bi-plus-lg me-2"></i>{{ __('dashboard.add_new_agent') }}</a>
          </div>
        </div>

{{-- CATEGORY COUNTS --}}
<h5 class="mb-3">{{ __('dashboard.all_category_counts') }}</h5>
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

{{-- LATEST PRODUCTS --}}
<h5 class="mb-4 mt-4">{{ __('dashboard.latest_product') }}</h5>

<div class="card shadow-sm mb-4">
    <div class="card-body table-responsive">

        @if($combinedData->count())
            <table id="productTable" class="table table-bordered table-striped align-middle mb-0">
                
                {{-- TABLE HEAD --}}
                <thead class="table-light">
                <tr>
                    <th>{{ $columnLabels['seed'] ?? 'Category' }}</th>

                    @foreach(array_keys((array)$combinedData->first()) as $column)
                        @if(!in_array($column, [
                            'seed',
                            'table_name',
                            'status_id',
                            'table_id',
                            'supplier_id',
                            'country_id',
                            'category_slug',
                            'parent_id'   
                        ]))
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

                {{-- TABLE BODY --}}
                <tbody>
                @foreach($combinedData as $row)
                    <tr>

                        {{-- Category --}}
                        <td><strong>{{ $row->seed }}</strong></td>

                        {{-- Dynamic Columns --}}
                        @foreach($row as $key => $val)
                            @if(!in_array($key, [
                                'seed',
                                'table_name',
                                'status_id',
                                'table_id',
                                'supplier_id',
                                'country_id',
                                'category_slug',
                                'parent_id',   
                            ]))
                                <td>{{ $val ?? '-' }}</td>
                            @endif
                        @endforeach

                        {{-- Status --}}
                        <td>
                            @if(($row->status_id ?? 1) != 0)
                                @php
                                    $status = $row->status_id;
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
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="d-flex gap-2">
                            <a href="{{ route('masteradmin.view.record', ['table' => $row->table_name, 'id' => $row->id]) }}"
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> {{ __('dashboard.view') }}
                            </a>

                            <a href="{{ route('masteradmin.upload.record', ['table' => $row->table_name, 'id' => $row->id]) }}"
                               class="btn btn-sm btn-success">
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


// ============================
// LOAD NOTIFICATION COUNT
// ============================
function loadNotifyCount() {

    $.get("{{ url('notifications/count') }}", function (res) {

        let count = parseInt(res.count) || 0;

        if (count > 0) {

            $("#notifyCount").text(count).show();

        } else {

            $("#notifyCount").hide();
            $("#notifyList").hide(); // hide dropdown if no notifications

        }

    });

}


// ============================
// LOAD UNREAD NOTIFICATIONS
// ============================
function loadNotifyList() {

    $.get("{{ url('notifications/list') }}", function (res) {

        let unread = res.notifications.filter(n => n.is_read == 0);

        let html = "";

        // ❌ NO NOTIFICATION → HIDE BOX
        if (unread.length === 0) {

            $("#notifyList").hide();
            $("#notifyCount").hide();
            return;

        }

        // ✅ NOTIFICATION AVAILABLE
        unread.forEach(n => {

            html += `
                <li class="px-2 py-2 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">

                        <a href="javascript:void(0)"
                           onclick="openNotificationReload(${n.id})"
                           class="text-dark text-decoration-none w-100">

                            <strong>${n.title}</strong><br>
                            <small class="text-muted">${n.message ?? ''}</small>

                        </a>

                        <span class="badge bg-danger">New</span>

                    </div>
                </li>
            `;

        });

        $("#notifyList").html(html).show();

    });

}


// ============================
// CLICK NOTIFICATION
// ============================
function openNotificationReload(id) {

    let current = parseInt($("#notifyCount").text()) || 0;

    if (current > 0) {

        let newCount = current - 1;

        $("#notifyCount").text(newCount);

        if (newCount <= 0) {
            $("#notifyCount").hide();
            $("#notifyList").hide();
        }

    }

    $.post("{{ url('notifications/mark-read') }}/" + id,
        { _token: "{{ csrf_token() }}" }
    );

    setTimeout(() => location.reload(), 200);

}


// ============================
// INITIAL LOAD
// ============================
loadNotifyCount();
loadNotifyList();


// ============================
// AUTO REFRESH
// ============================
setInterval(function(){

    loadNotifyCount();
    loadNotifyList();

},10000);


</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


@endsection
