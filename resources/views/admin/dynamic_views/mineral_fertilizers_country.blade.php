{{-- resources/views/admin/dynamic_views/mineral_fertilizers.blade.php --}}

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
.record-image {
    display:block; max-width: 100%; max-height: 150px; margin-top: 5px;
    border-radius: 5px; border: 1px solid #ddd; padding: 2px; margin-right:5px;
}
</style>

@php
$labels = [
    'fertilizer_type' => 'Fertilizer Type (example: 15-15-15)',
    'fertilizer_registration' => 'Registration Number',
    'physical_form' => 'Physical Form',
    'trade_name' => 'Trade Name (urea, NPK, TSP, KCl, etc.)',
    'n' => '%N',
    'p2' => '%P205',
    'k2' => '%K20',
    'zn' => '%Zn',
    'ca' => 'Ca',
    'mg' => '%Mg',
    's' => '%S',
    'b' => '%B',
    'mo' => '%Mo',
    'application_rate' => 'Application Rate per Hectare',
    'fertilizer_wholesale_price' => 'Average Wholesale Price by Packaging Type',
    'fertilizer_semiwholesale_price' => 'Average Semi-Wholesale Price by Packaging Type',
    'fertilizer_retail_price' => 'Average Retail Price by Packaging Type',
    'qr_code_path' => 'QR Code',
    'status_id' => 'Status',
    'title' => 'Title',
    'form_type' => 'Form Type'
];

$statusText = [1 => 'Pending', 2 => 'Approved', 3 => 'Rejected'];
$hiddenKeys = ['id','created_by','language_id','created_at','updated_at',
'supplier_id','form_type','agent_id','product_id','title'];
@endphp

<div class="container-fluid px-4">
  <div class="row">
    <div class="col-12">
      <div class="preview-box mb-4">
        <h3 class="preview-title">Mineral Fertilizer Details</h3>

        @if(isset($record) && $record)
          <div class="row gy-3">
            @foreach($record as $key => $value)
              @if(!in_array($key, $hiddenKeys))

                <div class="col-md-4">
                  <label class="form-label">{{ $labels[$key] ?? ucwords(str_replace('_',' ',$key)) }}:</label>

                  @php
                    $images = [];
                    // Handle QR code images
                    if(str_contains(strtolower($key),'qr') && !empty($value)) {
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

          <!-- ✅ Status Buttons -->
          <!-- @if(isset($record['id']))
            <div class="mt-4">
              <form action="{{ url('admin/mineral_fertilizers/'.$record['id'].'/status') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="2">
                <button type="submit" class="btn btn-success">Approve</button>
              </form>

              <form action="{{ url('admin/mineral_fertilizers/'.$record['id'].'/status') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="3">
                <button type="submit" class="btn btn-danger">Reject</button>
              </form>
            </div>
          @endif -->
   @if(isset($record['id']) && isset($record['status_id']) && (int)$record['status_id'] === 1)
    <div class="mt-4 d-flex align-items-center gap-3">

        {{-- ✅ APPROVE --}}
        <form action="{{ url('admin/update-status/mineral_fertilizers/'.$record['id']) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="status" value="approved">
            <button type="submit" class="btn btn-success btn-w">Approve</button>
        </form>

        <a href="{{ route('record.edit', ['table' => $table, 'id' => $record['id']]) }}" class="btn btn-primary btn-w">✏️ Edit</a>

        {{-- ❌ REJECT — MODAL OPEN BUTTON --}}
        <button type="button" class="btn btn-warning btn-w" data-bs-toggle="modal" data-bs-target="#rejectModalMineral">
            Reject
        </button>        

    </div>
@endif

<!-- ✅ REJECT REASON MODAL -->
<div class="modal fade" id="rejectModalMineral" tabindex="-1" aria-labelledby="rejectModalMineralLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalMineralLabel">Enter Rejection Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ url('admin/update-status/mineral_fertilizers/'.$record['id']) }}" method="POST">
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
</div>


          <!-- ✅ Display Status -->
          <!-- @if(isset($record['status_id']))
            <div class="mt-2">
              <strong>Status:</strong> {{ $statusText[$record['status_id']] ?? 'Pending' }}
            </div>
          @endif -->

      <div class="mt-3 d-flex aling-items-center gap-3">
    {{-- Back Button --}}
    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-w">Back</a> 
             

     {{-- Delete Button --}}
        <form action="{{ route('admin.delete', ['table' => 'mineral_fertilizers', 'id' => $record['id']]) }}" method="POST" class="d-inline">
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
