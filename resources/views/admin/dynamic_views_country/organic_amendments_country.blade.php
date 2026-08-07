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
$statusText = [1 => 'Pending', 2 => 'Approved', 3 => 'Deny'];
$hiddenKeys = [
    'id','created_by','language_id','created_at','updated_at',
    'supplier_id','form_type','agent_id','product_id',
    'title','status_id','reject_reason'
];
@endphp

<div class="container-fluid px-4">
<div class="row">
<div class="col-12">

<div class="preview-box mb-4">
<div class="mb-3">
    <label class="form-label">{{ __('labels.form_type') }}</label>
    <input type="text" class="form-control" value="Organic Amendment" disabled>
</div>

@if(isset($record) && $record)

<div class="row gy-3">
@foreach($record as $key => $value)
@if(!in_array($key, $hiddenKeys))

<div class="col-md-4">
<label class="form-label">
    {{ __('labels.' . $key, [], app()->getLocale()) }}:
</label>

{{-- ✅ IMAGE + QR FIX --}}
@php
    $showImage = false;

    if (!empty($value)) {
        // QR field
        if (str_contains(strtolower($key), 'qr')) {
            $showImage = true;
        }

        // Image extension
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

{{-- ✅ Current Status --}}
@if(isset($currentStatus))
<p class="mt-3">
    Status:
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

<h5>Related Documents</h5>
@if($documents && $documents->count())
<ul>
@foreach($documents as $doc)
<li>
    <a href="{{ $doc->file_url }}" target="_blank">{{ $doc->file_path }}</a>
</li>
@endforeach
</ul>
@else
<p>No related documents found.</p>
@endif

@if(isset($record['id']) && isset($record['status_id']) && $record['status_id'] == 1)
<div class="mt-4 d-flex align-items-center gap-3 flex-wrap">
<form action="{{ url('admin/update-status/organic_amendments/'.$record['id']) }}"
      method="POST" onsubmit="return confirmApprove();">
    @csrf
    <input type="hidden" name="status" value="approved">
    <button type="submit" class="btn btn-success btn-w">{{ __('labels.approve') }}</button>
</form>


<a href="{{ route('record.edit', ['table' => $table, 'id' => $record['id']]) }}"
   class="btn btn-primary btn-w">{{ __('labels.edit') }}</a>

<button type="button" class="btn btn-warning btn-w"
        data-bs-toggle="modal" data-bs-target="#rejectModalOrganic">
{{ __('labels.deny') }}
</button>

<form action="{{ route('admin.delete', ['table' => 'organic_amendments', 'id' => $record['id']]) }}"
      method="POST" onsubmit="return confirmDelete();">
@csrf
@method('DELETE')
<button type="submit" class="btn btn-danger btn-w">{{ __('labels.delete') }}</button>
</form>

</div>
@endif

{{-- ❌ Reject Modal --}}
<div class="modal fade" id="rejectModalOrganic" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<form action="{{ url('admin/update-status/organic_amendments/'.$record['id']) }}" method="POST">
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('labels.cancel') }}</button>
        <button type="submit" class="btn btn-danger">{{ __('labels.deny_now') }}</button>
    </div>
</form>

</div>
</div>
</div>

<div class="mt-3">
<a href="{{ url()->previous() }}" class="btn btn-secondary btn-w">Back</a>
</div>

@else
<p class="text-muted mb-0">No record found for this entry.</p>
@endif

</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function confirmApprove() {
    return confirm("Approving this record will make it live. Continue?");
}
function confirmDelete() {
    return confirm("Once deleted, this data cannot be recovered. Continue?");
}
</script>

@endsection
