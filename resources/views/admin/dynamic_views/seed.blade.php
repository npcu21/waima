@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')

<!-- ✅ Bootstrap & Custom CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- Navbar -->
@include('includes.navbar')

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
.preview-title { border-bottom: 2px solid #dee2e6; padding-bottom: 10px; margin-bottom: 20px; }
.form-label { font-weight: 600; }
.form-control-plaintext { padding-top: 0; padding-bottom: 10px; }
.record-image { display:block; max-width: 100%; max-height: 150px; margin-top: 5px; border-radius: 5px; border: 1px solid #ddd; padding: 2px; margin-right:5px; }
</style>

@php
$statusText = [
    1 => __('labels.pending', [], app()->getLocale()), 
    2 => __('labels.approved', [], app()->getLocale()), 
    3 => __('labels.deny', [], app()->getLocale())
];

$hiddenKeys = [
    'id','created_by','language_id','created_at','updated_at',
    'supplier_id','form_type','agent_id','product_id','title','status_id','reject_reason'
];
@endphp

<div class="container-fluid px-4">
  <div class="row">
    <div class="col-12">
      <div class="preview-box mb-4">

         <div class="mb-3">
            <label class="form-label">{{ __('labels.product_category', [], app()->getLocale()) }}</label>
            <input type="text" class="form-control" value="{{ __('labels.seed', [], app()->getLocale()) }}" disabled>
        </div>

        @if(isset($record) && $record)
          <div class="row gy-3">
            @foreach($record as $key => $value)
              @if(!in_array($key, $hiddenKeys))
                <div class="col-md-4">
                  <label class="form-label">{{ __('labels.' . $key, [], app()->getLocale()) }}:</label>

                  @php
                    $images = [];
                    // Handle images & photos
                    if(in_array($key,['image','otherRecommendationsPhoto']) && !empty($value)){
                        $decoded = is_string($value) ? json_decode($value, true) : $value;
                        $images = is_array($decoded) ? $decoded : [$value];
                    }
                    // QR code
                    elseif(str_contains(strtolower($key),'qr') && !empty($value)) {
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

          {{-- ✅ Current Status --}}
          @if(isset($currentStatus))
            <p>
                {{ __('labels.status_id', [], app()->getLocale()) }}:
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

          <h5>{{ __('labels.related_documents', [], app()->getLocale()) }}</h5>
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
              <p>{{ __('labels.no_documents', [], app()->getLocale()) }}</p>
          @endif

          @if(isset($record['id']))
            <div class="d-flex align-items-center gap-3 mt-4">

                {{-- ✅ APPROVE --}}
                <form action="{{ url('admin/update-status/seed_forms/'.$record['id']) }}" 
                      method="POST" class="d-inline" onsubmit="return confirmApprove();">
                    @csrf
                    <input type="hidden" name="status" value="approved">
                    <button type="submit" class="btn btn-success btn-w">{{ __('labels.approve', [], app()->getLocale()) }}</button>
                </form>

                {{-- ✏️ EDIT --}}
                <a href="{{ route('record.edit', ['table' => $table, 'id' => $record['id']]) }}" class="btn btn-primary btn-w">{{ __('labels.edit', [], app()->getLocale()) }}</a>

                {{-- ❌ REJECT — MODAL OPEN BUTTON --}}
                <button type="button" class="btn btn-warning btn-w" data-bs-toggle="modal" data-bs-target="#rejectModalSeed">
                    {{ __('labels.deny', [], app()->getLocale()) }}
                </button>

                {{-- 🗑️ DELETE --}}
                <form action="{{ route('admin.delete', ['table' => 'seed_forms', 'id' => $record['id']]) }}" 
                      method="POST" class="d-inline" onsubmit="return confirmDelete();">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-w">
                        {{ __('labels.delete', [], app()->getLocale()) }}
                    </button>
                </form>

            </div>
          @endif

          <!-- ✅ REJECT REASON MODAL -->
          <div class="modal fade" id="rejectModalSeed" tabindex="-1" aria-labelledby="rejectModalSeedLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">

                      <div class="modal-header">
                          <h5 class="modal-title" id="rejectModalSeedLabel">{{ __('labels.enter_rejection_reason', [], app()->getLocale()) }}</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>

                      <form action="{{ url('admin/update-status/seed_forms/'.$record['id']) }}" method="POST">
                          @csrf
                          <input type="hidden" name="status" value="rejected">

                          <div class="modal-body">
                              <textarea name="reason" class="form-control" rows="4" placeholder="{{ __('labels.enter_rejection_reason', [], app()->getLocale()) }}" required></textarea>
                          </div>

                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('labels.cancel', [], app()->getLocale()) }}</button>
                              <button type="submit" class="btn btn-danger">{{ __('labels.deny_now', [], app()->getLocale()) }}</button>
                          </div>
                      </form>

                  </div>
              </div>
          </div>

          <div class="mt-3">
              <a href="{{ url()->previous() }}" class="btn btn-secondary btn-w">{{ __('labels.back', [], app()->getLocale()) }}</a>
          </div>

        @else
          <p class="text-muted mb-0">{{ __('labels.no_record_found', [], app()->getLocale()) }}</p>
        @endif

      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmApprove() {
    return confirm("{{ __('labels.confirm_approve_message', [], app()->getLocale()) }}");
}

function confirmDelete() {
    return confirm("{{ __('labels.confirm_delete_message', [], app()->getLocale()) }}");
}
</script>

@endsection
