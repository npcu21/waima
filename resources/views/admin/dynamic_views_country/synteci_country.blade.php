
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
.form-label { font-weight: 600; }
.form-control-plaintext { padding-top: 0; padding-bottom: 10px; }
.record-image {
    display:block;
    max-width:100%;
    max-height:150px;
    margin-top:5px;
    border-radius:5px;
    border:1px solid #ddd;
    padding:2px;
}
</style>

@php
$hiddenKeys = [
    'id','created_by','language_id','created_at','updated_at',
    'supplier_id','form_type','agent_id','product_id','title',
    'status_id','reject_reason'
];
@endphp

<div class="container-fluid px-4">
<div class="row">
<div class="col-12">

<div class="preview-box mb-4">

<div class="mb-3">
    <label class="form-label">{{ __('labels.product_category') }}</label>
    <input type="text" class="form-control" value="Synthetic Pesticides" disabled>
</div>

@if(isset($record) && $record)

<div class="row gy-3">
@foreach($record as $key => $value)
@if(!in_array($key, $hiddenKeys))

<div class="col-md-4">
<label class="form-label">{{ __('labels.'.$key) }}:</label>

@php
    $isImage = false;

    if (!empty($value)) {

        // QR field
        if (str_contains(strtolower($key), 'qr')) {
            $isImage = true;
        }

        // Image extension
        $ext = pathinfo($value, PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), ['jpg','jpeg','png','webp'])) {
            $isImage = true;
        }
    }
@endphp

@if($isImage)
    <img src="{{ asset($value) }}" class="record-image" alt="{{ $key }}">
@else
    <p class="form-control-plaintext">{{ $value ?? '—' }}</p>
@endif

</div>
@endif
@endforeach
</div>

{{-- STATUS --}}
@if(isset($currentStatus))
<p class="mt-3">
    {{ __('labels.status_id') }} :
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

{{-- DOCUMENTS --}}
<h5 class="mt-4">{{ __('labels.related_documents') }}</h5>
@if($documents && $documents->count())
<ul>
@foreach($documents as $doc)
    <li>
        <a href="{{ $doc->file_url }}" target="_blank">{{ $doc->file_path }}</a>
    </li>
@endforeach
</ul>
@else
<p>{{ __('labels.no_documents') }}</p>
@endif

{{-- ACTION BUTTONS --}}
@if(isset($record['id']) && $record['status_id'] == 1)

<div class="mt-4 d-flex gap-3">

<form action="{{ url('admin/update-status/synthetic_pesticides/'.$record['id']) }}" method="POST"
      onsubmit="return confirmApprove();">
    @csrf
    <input type="hidden" name="status" value="approved">
    <button class="btn btn-success btn-w">{{ __('labels.approve') }}</button>
</form>


<a href="{{ route('record.edit', ['table' => $table, 'id' => $record['id']]) }}"
   class="btn btn-primary btn-w">{{ __('labels.edit') }}</a>

<button type="button" class="btn btn-warning btn-w" data-bs-toggle="modal" data-bs-target="#rejectModal">
    {{ __('labels.deny') }}
</button>

<form action="{{ route('admin.delete', ['table' => 'synthetic_pesticides', 'id' => $record['id']]) }}"
      method="POST" onsubmit="return confirmDelete();">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-w">{{ __('labels.delete') }}</button>
</form>

</div>
@endif

{{-- REJECT MODAL --}}
<div class="modal fade" id="rejectModal">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
    <h5 class="modal-title">{{ __('labels.enter_rejection_reason') }}</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form action="{{ url('admin/update-status/synthetic_pesticides/'.$record['id']) }}" method="POST">
    @csrf
    <input type="hidden" name="status" value="rejected">

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
<a href="{{ url()->previous() }}" class="btn btn-secondary btn-w">
    {{ __('labels.back') }}
</a>
</div>

@else
<p class="text-muted">No record found.</p>
@endif

</div>
</div>
</div>
</div>

<script>
function confirmApprove() {
    return confirm('Approving this record will make it live. Continue?');
}
function confirmDelete() {
    return confirm('Once deleted, this data cannot be recovered. Continue?');
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
