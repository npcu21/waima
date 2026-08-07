@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')

<!-- ✅ Bootstrap & Custom CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- ✅ Navbar -->
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
.btn-w { width: 160px!important; }
.preview-title { border-bottom: 2px solid #dee2e6; padding-bottom: 10px; margin-bottom: 20px; }
.form-label { font-weight: 600; }
.form-control-plaintext { padding-top: 0; padding-bottom: 10px; }
.record-image {
    display:block; max-width: 100%; max-height: 150px; margin-top: 5px;
    border-radius: 5px; border: 1px solid #ddd; padding: 2px; margin-right:5px;
}
</style>

@php
$labels = [
    'title' => __('labels.title'),
    'Typeoffeed' => __('labels.type_of_feed'),
    'afrm' => __('labels.raw_material_feed'),
    'afPhysicalform' => __('labels.physical_form'),
    'afdm' => __('labels.dry_matter'),
    'afEnergy' => __('labels.energy'),
    'afcp' => __('labels.crude_protein'),
    'afsp' => __('labels.shelf_life'),
    'affs' => __('labels.feed_supplements'),
    'afWholesalePrice' => __('labels.wholesale_price'),
    'afsemiwholesalePrice' => __('labels.semiwholesale_price'),
    'afretailPrice' => __('labels.retail_price'),
    'qr_code_path' => __('labels.qr_code_path'),
    'status_id' => __('labels.status_id'),
    'supplier_id' => __('labels.supplier_id'),
];

$statusText = [
    1 => __('labels.pending'), 
    2 => __('labels.approved'), 
    3 => __('labels.denied')
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
      <div class="preview-box mb-4">

        {{-- Product Category --}}
        <div class="mb-3">
            <label class="form-label">{{ __('labels.product_category') }}</label>
            <input type="text" class="form-control" value="{{ __('labels.animal_feed') }}" disabled>
        </div>

        @if(isset($record) && $record)
            <div class="row gy-3">
                @foreach($record as $key => $value)
                    @if(!in_array($key, $hiddenKeys))
                        <div class="col-md-4">
                            <label class="form-label">{{ $labels[$key] ?? ucwords(str_replace('_',' ',$key)) }}:</label>

                            @php
                                $images = [];
                                if(str_contains(strtolower($key),'qr') && !empty($value)) {
                                    $images[] = $value;
                                } elseif(is_string($value) && !empty($value) && 
                                        (str_contains(strtolower($key),'image') || str_contains(strtolower($key),'photo'))) {
                                    $decoded = json_decode($value, true);
                                    $images = is_array($decoded) ? $decoded : [$value];
                                }
                            @endphp

                            @if(count($images) > 0)
                                @foreach($images as $img)
                                    <img src="{{ asset($img) }}" class="record-image" alt="{{ $labels[$key] ?? $key }}">
                                @endforeach
                            @else
                                <p class="form-control-plaintext">{{ $value ?? '—' }}</p>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- CURRENT STATUS --}}
            @if(isset($currentStatus))
                <p>
                    {{ __('labels.status') }}:
                    <span class="badge 
                        @if(strtolower($currentStatus) === 'approved') bg-success
                        @elseif(strtolower($currentStatus) === 'pending') bg-warning text-dark
                        @elseif(strtolower($currentStatus) === 'deny') bg-danger
                        @else bg-secondary @endif">
                        {{ $currentStatus }}
                    </span>
                </p>
            @endif

            {{-- DOCUMENTS --}}
            <h5>{{ __('labels.related_documents') }}</h5>
            @if($documents && $documents->count())
                <ul>
                    @foreach($documents as $doc)
                        <li>
                            <a href="{{ $doc->file_url }}" target="_blank">{{ $doc->file_path }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>{{ __('labels.no_documents_found') }}</p>
            @endif

            {{-- ACTION BUTTONS --}}
            @if(isset($record['id']) && $record['status_id'] == 1)
                <div class="mt-4 d-flex align-items-center gap-3">
                   <form action="{{ url('admin/update-status/animal_feeds/'.$record['id']) }}"
      method="POST" class="d-inline approve-form" onsubmit="return confirmApprove();">
    @csrf
    <input type="hidden" name="status" value="approved">
    <button type="submit" class="btn btn-success btn-w">
        {{ __('labels.approve') }}
    </button>
</form>


                    <a href="{{ route('record.edit', ['table' => $table, 'id' => $record['id']]) }}" class="btn btn-primary btn-w">✏️ {{ __('labels.edit') }}</a>

                    <button type="button" class="btn btn-warning btn-w" data-bs-toggle="modal" data-bs-target="#rejectModalAnimal">{{ __('labels.reject') }}</button>

                    <form action="{{ route('admin.delete', ['table' => 'animal_feeds', 'id' => $record['id']]) }}" method="POST" class="d-inline delete-form" onsubmit="return confirmDelete();">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-w">{{ __('labels.delete') }}</button>
                    </form>
                </div>
            @endif

            {{-- REJECT MODAL --}}
            <div class="modal fade" id="rejectModalAnimal" tabindex="-1" aria-labelledby="rejectModalAnimalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('labels.enter_rejection_reason') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ url('admin/update-status/animal_feeds/'.$record['id']) }}" method="POST" class="reject-form">
                            @csrf
                            <input type="hidden" name="status" value="rejected">

                            <div class="modal-body">
                                <textarea name="reason" class="form-control" rows="4" placeholder="{{ __('labels.enter_reason') }}" required></textarea>
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
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-w">{{ __('labels.back') }}</a>
            </div>

        @else
            <p class="text-muted mb-0">{{ __('labels.no_record_found') }}</p>
        @endif
      </div>
    </div>
  </div>
</div>

<script>
function confirmApprove() { return confirm("{{ __('labels.confirm_approve') }}"); }
function confirmDelete() { return confirm("{{ __('labels.confirm_delete') }}"); }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
