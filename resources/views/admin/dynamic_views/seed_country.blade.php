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
    'cropName' => 'Crop Name',
    'verityName' => 'Variety Name',
    'breederName' => 'Breeder Name',
    'countryOrigin' => 'Country of Origin',
    'registrationNumber' => 'Registration Number',
    'varietyType' => 'Variety Type',
    'seedCategory' => 'Seed Category (Breeder, Foundation, Certified, Commercial, etc.)',
    'precocity' => 'Earliness (Days from sowing to ripening)',
    'fruitColor' => 'Fruit Color',
    'fruitShape' => 'Fruit Shape (Oval, Globular, Round, Semi-flattened)',
    'leafLength' => 'Leaf Length',
    'leafColor' => 'Leaf Color (Dark Green, Light Green)',
    'plantHeight' => 'Plant Height (cm)',
    'plantHabit' => 'Plant Habit',
    'bioticResistance' => 'Biotic Resistance',
    'abioticResistance' => 'Abiotic Resistance',
    'InherentNutritionalValue' => 'Inherent Nutritional Value',
    'yield' => 'Yield (t/ha)',
    'otherRecommendations' => 'Other Recommendations (Text)',
    'otherRecommendationsPhoto' => 'Other Recommendations (Photo)',
    'wholesalePrice' => 'Average Wholesale Prices by Packaging Type',
    'semiwholesalePrice' => 'Average Semi-Wholesale Prices by Packaging Type',
    'retailPrice' => 'Average Retail Prices by Packaging Type',
    'qr_code_path' => 'QR Code',
    'image' => 'Seed Image',
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
        <h3 class="preview-title">Seed Details</h3>

        @if(isset($record) && $record)
          <div class="row gy-3">
            @foreach($record as $key => $value)
              @if(!in_array($key, $hiddenKeys))

                <div class="col-md-4">
                  <label class="form-label">{{ $labels[$key] ?? ucwords(str_replace('_',' ',$key)) }}:</label>

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
              <form action="{{ url('admin/seed_forms/'.$record['id'].'/status') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="2">
                <button type="submit" class="btn btn-success">Approve</button>
              </form>

              <form action="{{ url('admin/seed_forms/'.$record['id'].'/status') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="3">
                <button type="submit" class="btn btn-danger">Reject</button>
              </form>
            </div>
          @endif -->
          <!-- @if(isset($record['id']))
    <div class="mt-4">

        {{-- ✅ APPROVE --}}
        <form action="{{ url('admin/update-status/seed_forms/'.$record['id']) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="status" value="approved">
            <button type="submit" class="btn btn-success">Approve</button>
        </form>

        {{-- ❌ REJECT — MODAL OPEN BUTTON --}}
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModalSeed">
            Reject
        </button>

    </div>
@endif


<div class="modal fade" id="rejectModalSeed" tabindex="-1" aria-labelledby="rejectModalSeedLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalSeedLabel">Enter Rejection Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ url('admin/update-status/seed_forms/'.$record['id']) }}" method="POST">
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

          <!-- @if(isset($record['id']))
    <div class="d-flex aling-items-center gap-3 mt-4">

        {{-- ✅ APPROVE --}}
        <form action="{{ url('admin/update-status/seed_forms/'.$record['id']) }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="status" value="approved">
            <button type="submit" class="btn btn-success btn-w">Approve</button>
        </form>

        <a href="{{ route('record.edit', ['table' => $table, 'id' => $record['id']]) }}" class="btn btn-primary btn-w">✏️ Edit</a>

        {{-- ❌ REJECT — MODAL OPEN BUTTON --}}
        <button type="button" class="btn btn-warning btn-w" data-bs-toggle="modal" data-bs-target="#rejectModalSeed">
            Reject
        </button>

        <form action="{{ route('admin.delete', ['table' => 'seed_forms', 'id' => $record['id']]) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-w" onclick="return confirm('Are you sure you want to delete this record?')">
                Delete
            </button>
        </form>

    </div>
@endif -->

<!-- ✅ REJECT REASON MODAL -->
<!-- <div class="modal fade" id="rejectModalSeed" tabindex="-1" aria-labelledby="rejectModalSeedLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalSeedLabel">Enter Rejection Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ url('admin/update-status/seed_forms/'.$record['id']) }}" method="POST">
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

          <!-- ✅ Display Status -->
          <!-- @if(isset($record['status_id']))
            <div class="mt-2">
              <strong>Status:</strong> {{ $statusText[$record['status_id']] ?? 'Pending' }}
            </div>
          @endif -->

          <div class="mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-w">Back</a>
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
