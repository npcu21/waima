{{-- resources/views/admin/dynamic_views/bio_stimulant.blade.php --}}

@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')

<!-- Bootstrap & Custom CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@include('includes.navbar')

<style>
body { background-color: #f8f9fa; }
.preview-box { background: #fff; padding:30px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.1); margin-top:40px; }
.btn-w { width:160px!important; }
.preview-title { border-bottom:2px solid #dee2e6; padding-bottom:10px; margin-bottom:20px; }
.form-label { font-weight:600; }
.form-control-plaintext { padding-top:0; padding-bottom:10px; }
.record-image { display:block; max-width:100%; max-height:150px; margin-top:5px; border-radius:5px; border:1px solid #ddd; padding:2px; margin-right:5px; }
</style>

@php
$labels = [
    'trade_name' => __('labels.trade_name'),
    'physical_form' => __('labels.physical_form'),
    'biostimulant_product' => __('labels.biostimulant_product'),
    're_registration' => __('labels.re_registration'),
    'n' => __('labels.n'),
    'p2' => __('labels.p2'),
    'k2' => __('labels.k2'),
    'zn' => __('labels.zn'),
    'ca' => __('labels.ca'),
    'mg' => __('labels.mg'),
    's' => __('labels.s'),
    'b' => __('labels.b'),
    'mo' => __('labels.mo'),
    'action_mode' => __('labels.action_mode'),
    'wholesale_price' => __('labels.wholesale_price'),
    'semiwholesale_price' => __('labels.semiwholesale_price'),
    'retail_price' => __('labels.retail_price'),
    'qr_code_path' => __('labels.qr_code_path'),
    'status_id' => __('labels.status_id'),
    'title' => __('labels.title'),
    'form_type' => __('labels.form_type'),
];

$hiddenKeys = [
    'id','created_by','language_id','created_at','updated_at',
    'supplier_id','form_type','agent_id','product_id','title',
   'status_id','reject_reason'
];
@endphp

<div class="container-fluid px-4">
  <div class="row">
    <div class="col-12">

      <!-- Product Category -->
      <div class="mb-3">
        <label class="form-label">{{ __('labels.product_category') }}</label>
        <input type="text" class="form-control" value="{{ __('labels.biostimulant') }}" disabled>
      </div>

      <div class="preview-box mb-4">

        @if(isset($record) && $record)
          <div class="row gy-3">
            @foreach($record as $key => $value)
              @if(!in_array($key, $hiddenKeys))
                <div class="col-md-4">
                  <label class="form-label">{{ $labels[$key] ?? ucwords(str_replace('_',' ',$key)) }}:</label>

                  @if($key == 'qr_code_path' && $value)
                    <img src="{{ asset($value) }}" class="record-image" alt="QR Code">
                  @else
                    <p class="form-control-plaintext">{{ $value ?? '—' }}</p>
                  @endif
                </div>
              @endif
            @endforeach
          </div>

          <!-- Status Section -->
          @if(isset($currentStatus))
            <p class="mt-3">
              <strong>{{ __('labels.status') }}:</strong>
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

          <h5>{{ __('labels.related_documents') }}</h5>
          @if($documents && $documents->count())
            <ul>
              @foreach($documents as $doc)
                <li><a href="{{ $doc->file_url }}" target="_blank">{{ $doc->file_path }}</a></li>
              @endforeach
            </ul>
          @else
            <p>{{ __('labels.no_documents') }}</p>
          @endif

          <!-- Approve / Edit / Denied Buttons -->
          @if(isset($record['id']) && $record['status_id'] == 1)
            <div class="mt-4 d-flex align-items-center gap-3">
            <form action="{{ url('admin/update-status/bio_stimulants/'.$record['id']) }}"
      method="POST" onsubmit="return confirmApprove();">
    @csrf
    <input type="hidden" name="status" value="approved">
    <button type="submit" class="btn btn-success btn-w">
        {{ __('labels.approve') }}
    </button>
</form>


              <a href="{{ route('record.edit', ['table'=>$table,'id'=>$record['id']]) }}" class="btn btn-primary btn-w">✏️ {{ __('labels.edit') }}</a>

              <button type="button" class="btn btn-danger btn-w" data-bs-toggle="modal" data-bs-target="#rejectModalBio">
                {{ __('labels.deny') }}
              </button>
            </div>
          @endif

          <!-- Reject Modal -->
          <div class="modal fade" id="rejectModalBio" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">{{ __('labels.rejection_reason') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ url('admin/update-status/bio_stimulants/'.$record['id']) }}"
                  method="POST" onsubmit="return confirmReject();">
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


          <!-- Back + Delete -->
          <div class="d-flex justify-content-start mt-3 gap-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-w">{{ __('labels.back') }}</a>

            <form action="{{ route('admin.delete',['table'=>'bio_stimulants','id'=>$record['id']]) }}" method="POST" onsubmit="return confirmDelete();">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-warning btn-w">{{ __('labels.delete') }}</button>
            </form>
          </div>

        @else
          <p class="text-muted">{{ __('labels.no_record') }}</p>
        @endif

      </div>
    </div>
  </div>
</div>

<script>
function confirmApprove() { return confirm("{{ __('labels.confirm_approve') }}"); }
function confirmReject() { return confirm("{{ __('labels.confirm_reject') }}"); }
function confirmDelete() { return confirm("{{ __('labels.confirm_delete') }}"); }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
