@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@include('countryadmin.layouts.nav')

<style>
body { background-color: #f8f9fa; }
.preview-box {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-top: 40px;
}
.btn-w { width:160px!important; }
.preview-title {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 10px;
    margin-bottom: 20px;
}
.form-label { font-weight: 600; }
.form-control-plaintext { padding-top: 0; padding-bottom: 10px; }
.record-image {
    display:block;
    max-width: 100%;
    max-height: 150px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ddd;
    padding: 2px;
}
</style>

@php
$labels = [
    'conditioner_type' => __('labels.conditioner_type'),
    'physical_form' => __('labels.physical_form'),
    'trade_name' => __('labels.trade_name'),
    'raw_material' => __('labels.raw_material'),
    'other' => __('labels.other_info'),
    'function' => __('labels.function'),
    'wholesale_price' => __('labels.wholesale_price'),
    'semiwholesale_price' => __('labels.semiwholesale_price'),
    'retail_price' => __('labels.retail_price'),
    'qr_code_path' => __('labels.qr_code_path'),
    'status_id' => __('labels.status'),
    'form_type' => __('labels.form_type'),
    'title' => __('labels.title'),
    'product_category' => __('labels.product_category')
];

$hiddenKeys = [
    'id','created_by','language_id','created_at','updated_at',
    'supplier_id','form_type','agent_id','product_id','title','status_id','reject_reason'
];
@endphp

<div class="container-fluid px-4">
<div class="row">
<div class="col-12">

<div class="mb-3">
    <label class="form-label">{{ $labels['product_category'] }}</label>
    <input type="text" class="form-control" value="{{ __('labels.inorganic_soil_conditioner') }}" disabled>
</div>

<div class="preview-box mb-4">

@if(isset($record) && $record)

<div class="row gy-3">
@foreach($record as $key => $value)
@if(!in_array($key, $hiddenKeys))

<div class="col-md-4">
<label class="form-label">
    {{ $labels[$key] ?? ucwords(str_replace('_',' ',$key)) }}:
</label>

@php
    $showImage = false;

    if (!empty($value)) {
        // QR key check
        if (str_contains(strtolower($key), 'qr')) {
            $showImage = true;
        }

        // Image extension check
        $ext = pathinfo($value, PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), ['jpg','jpeg','png','webp'])) {
            $showImage = true;
        }
    }
@endphp

@if($showImage)
    <img src="{{ asset($value) }}"
         class="record-image"
         alt="{{ $key }}">
@else
    <p class="form-control-plaintext">{{ $value ?? '—' }}</p>
@endif

</div>

@endif
@endforeach
</div>

{{-- ✅ STATUS --}}
@if(isset($currentStatus))
<p class="mt-3">
    {{ __('labels.status') }}:
    @if(strtolower($currentStatus) === 'approved')
        <span class="badge bg-success">{{ $currentStatus }}</span>
    @elseif(strtolower($currentStatus) === 'pending')
        <span class="badge bg-warning text-dark">{{ $currentStatus }}</span>
    @elseif(strtolower($currentStatus) === 'deny')
        <span class="badge bg-danger">{{ $currentStatus }}</span>
    @else
        <span class="badge bg-secondary">{{ $currentStatus }}</span>
    @endif
</p>
@endif

{{-- 📄 DOCUMENTS --}}
<h5 class="mt-4">{{ __('labels.related_documents') }}</h5>
@if($documents && $documents->count())
<ul>
@foreach($documents as $doc)
<li>
    <a href="{{ $doc->file_url }}" target="_blank">
        {{ $doc->file_path }}
    </a>
</li>
@endforeach
</ul>
@else
<p>{{ __('labels.no_documents') }}</p>
@endif

{{-- ✅ ACTION BUTTONS --}}
@if(isset($record['id']) && isset($record['status_id']) && $record['status_id'] == 1)
<div class="mt-4 d-flex gap-3 flex-wrap">

<form action="{{ url('admin/update-status/inorganic_soil_conditioners/'.$record['id']) }}" method="POST">
    @csrf
    <input type="hidden" name="status" value="approved">

    <button type="submit" class="btn btn-success btn-w">
        {{ __('labels.approve') }}
    </button>
</form>


<a href="{{ route('record.edit', ['table' => $table, 'id' => $record['id']]) }}" class="btn btn-primary btn-w">
{{ __('labels.edit') }}
</a>

<button type="button" class="btn btn-warning btn-w" data-bs-toggle="modal" data-bs-target="#rejectModalInorganic">
{{ __('labels.deny') }}
</button>

<form action="{{ route('admin.delete', ['table' => 'inorganic_soil_conditioners', 'id' => $record['id']]) }}" method="POST" onsubmit="return confirmDelete();">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-danger btn-w">{{ __('labels.delete') }}</button>
</form>

</div>
@endif

{{-- ❌ REJECT MODAL --}}
<div class="modal fade" id="rejectModalInorganic" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<form action="{{ url('admin/update-status/inorganic_soil_conditioners/'.$record['id']) }}" method="POST">
    @csrf
    <input type="hidden" name="status" value="rejected">

    <div class="modal-header">
        <h5 class="modal-title">{{ __('labels.enter_rejection_reason') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <textarea name="reason" class="form-control" rows="4" required></textarea>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            {{ __('labels.cancel') }}
        </button>
        <button type="submit" class="btn btn-danger">
            {{ __('labels.deny_now') }}
        </button>
    </div>
</form>

</div>
</div>
</div>

<div class="mt-3">
<a href="{{ url()->previous() }}" class="btn btn-secondary btn-w">{{ __('labels.back') }}</a>
</div>

@else
<p class="text-muted">{{ __('labels.no_record_found') }}</p>
@endif

</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function confirmApprove() {
    return confirm("{{ __('labels.confirm_approve') }}");
}
function confirmDelete() {
    return confirm("{{ __('labels.confirm_delete') }}");
}
</script>

@endsection
