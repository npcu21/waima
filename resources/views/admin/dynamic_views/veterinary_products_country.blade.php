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
.btn-w {
  width:160px!important;
}
.preview-title {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 10px;
    margin-bottom: 20px;
}
.form-label { font-weight: 600; }
.form-control-plaintext { padding-top: 0; padding-bottom: 10px; }
.record-image {display:block; max-width: 100%; max-height: 150px; margin-top: 5px; border-radius: 5px; border: 1px solid #ddd; padding: 2px; margin-right:5px; }
</style>

@php
$labels = [
    'product_name' => 'Veterinary Product Name',
    'manufacturing_lab' => 'Name of Manufacturing Laboratory',
    'active_substance' => 'Active Ingredient',
    'registration_number' => 'Registration Number',
    'therapeutic_class' => 'Therapeutic class',
    'other_therapeutic_class' => 'Other Therapeutic class',
    'dosage' => 'Dosage',
    'pharmaceutical_form' => 'Pharmaceutical form',
    'route_of_administration' => 'Route of administration',
    'targeted_animals' => 'Target animals',
    'waiting_period' => 'Withdrawal period',
    'expiry_date' => 'Expiration date',
    'transport_storage_requirements' => 'Transport and storage conditions',
    'wholesale_price' => 'Average wholesale prices by type of packaging',
    'semiwholesale_price' => 'Average semi-wholesaler selling prices by type of packaging',
    'retail_price' => 'Average retail selling prices by type of packaging',
    'qr_code_path' => 'QR Code',
    'status_id' => 'Status',
];

$statusText = [1 => 'Pending', 2 => 'Approved', 3 => 'Rejected'];
$hiddenKeys = ['id','created_by','language_id','created_at','updated_at',
'supplier_id','form_type','agent_id','product_id','title'];
@endphp

<div class="container-fluid px-4">
  <div class="row">
    <div class="col-12">
      <div class="preview-box mb-4">
        <h3 class="preview-title">Veterinary Product Details</h3>

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
                      @php
                        $imgPath = asset($img);
                      @endphp
                      <img src="{{ $imgPath }}" class="record-image" alt="{{ $key }}">
                    @endforeach
                  @else
                    <p class="form-control-plaintext">{{ $value ?? '—' }}</p>
                  @endif
                </div>
              @endif
            @endforeach
          </div>

          <!-- ✅ Status Buttons -->
          <!-- @if(isset($record['id']))
            <div class="mt-4">
              <form action="{{ url('admin/veterinary_products/'.$record['id'].'/status') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="2">
                <button type="submit" class="btn btn-success">Approve</button>
              </form>

              <form action="{{ url('admin/veterinary_products/'.$record['id'].'/status') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="3">
                <button type="submit" class="btn btn-danger">Reject</button>
              </form>
            </div>
          @endif -->
          <!-- @if(isset($record['id']))
    <div class="mt-4">

        {{-- ✅ APPROVE --}}
        <form action="{{ url('admin/update-status/veterinary_products/'.$record['id']) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="status" value="approved">
            <button type="submit" class="btn btn-success">Approve</button>
        </form>

        {{-- ❌ REJECT — MODAL OPEN BUTTON --}}
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModalVet">
            Reject
        </button>

    </div>
@endif

<div class="modal fade" id="rejectModalVet" tabindex="-1" aria-labelledby="rejectModalVetLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalVetLabel">Enter Rejection Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ url('admin/update-status/veterinary_products/'.$record['id']) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="rejected">

                <div class="modal-body">
                    <textarea name="reason" class="form-control" rows="4" placeholder="Enter reason..." required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Now</button>
                </div>
            </form>

        </div>
    </div>
</div> -->
@if(isset($record['id']) && isset($record['status_id']) && $record['status_id'] == 1)
    <div class="mt-4 d-flex align-items-center gap-3">

        {{-- ✅ APPROVE --}}
        <form action="{{ url('admin/update-status/veterinary_products/'.$record['id']) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="status" value="2"> {{-- 2 = approved --}}
            <button type="submit" class="btn btn-success btn-w">Approve</button>
        </form>

        {{-- ❌ REJECT — MODAL OPEN BUTTON --}}
        <button type="button" class="btn btn-warning btn-w" data-bs-toggle="modal" data-bs-target="#rejectModalVet">
            Reject
        </button>       

    </div>
@endif

<!-- ✅ REJECT REASON MODAL -->
<div class="modal fade" id="rejectModalVet" tabindex="-1" aria-labelledby="rejectModalVetLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalVetLabel">Enter Rejection Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ url('admin/update-status/veterinary_products/'.$record['id']) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="3"> {{-- 3 = rejected --}}

                <div class="modal-body">
                    <textarea name="reason" class="form-control" rows="4" placeholder="Enter reason..." required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Now</button>
                </div>
            </form>

        </div>
    </div>
</div>



          <!-- ✅ Display Status -->
          <!-- @if(isset($record['status_id']))
            <div class="mt-2">
              <strong>Status:</strong> {{ $statusText[$record['status_id']] ?? 'Pending' }}
            </div>
          @endif -->

          <div class="mt-3 d-flex align-items-center gap-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-w">Back</a>
            <a href="{{ route('record.edit', ['table' => $table, 'id' => $record['id']]) }}" class="btn btn-primary btn-w">✏️ Edit
</a>

             {{-- 🗑️ DELETE BUTTON --}}
            <form action="{{ route('admin.delete', ['table' => 'veterinary_products', 'id' => $record['id']]) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-w" onclick="return confirm('Are you sure you want to delete this record?')">
                    Delete
                </button>
            </form>
          </div>
         

        @else
          <p class="text-muted mb-0">No record found for this entry.</p>
        @endif
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
