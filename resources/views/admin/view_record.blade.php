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
.preview-title {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 10px;
    margin-bottom: 20px;
}
.form-label { font-weight: 600; }
.form-control-plaintext { padding-top: 0; padding-bottom: 10px; }
.record-image {display:block; max-width: 100%; max-height: 150px; margin-top: 5px; border-radius: 5px; border: 1px solid #ddd; padding: 2px; margin-right:5px; }
</style>

<div class="container-fluid px-4">
  <div class="row">
    <div class="col-12">
      <div class="preview-box">
        <h3 class="preview-title">{{ isset($tableName) ? ucwords(str_replace('_', ' ', $tableName)) : 'Record Details' }}</h3>

        @if(isset($record) && $record)
          <div class="row gy-3">
            @php
              $hiddenKeys = [
                  'id','supplier_id','product_id','agent_id','created_by','language_id','created_at','updated_at','status_id'
              ]; // hide status_id
            @endphp

            @foreach($record as $key => $value)
              @if(!in_array($key, $hiddenKeys))
                <div class="col-md-4">
                  <label class="form-label">{{ str_replace('_',' ', ucwords($key)) }}:</label>

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
                        $imgPath = $img;
                        if(!str_contains(strtolower($key),'qr')) {
                            $imgPath = str_replace('/seed_forms/uploads/seed_images/', '/uploads/seed_images/', $imgPath);
                            if(!str_starts_with($imgPath,'http://') && !str_starts_with($imgPath,'https://')) {
                                $imgPath = asset('uploads/seed_images/' . basename($imgPath));
                            }
                        }
                        if(str_starts_with($imgPath,'ftp://')) {
                            $imgPath = str_replace(
                                'ftp://lokesh%40fivoflow.com@173.201.186.254/wclm/public/uploads/seed_images/',
                                asset('uploads/seed_images/') . '/',
                                $imgPath
                            );
                        }
                        if(!str_contains(strtolower($key),'qr') && !file_exists(public_path('uploads/seed_images/' . basename($imgPath)))) {
                            $imgPath = asset('images/no-image.png');
                        }
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

          <!-- Status Update Buttons -->
          @if(isset($record['id']) && isset($tableName))
            <div class="mt-4">
              <form action="{{ url('admin/'.$tableName.'/'.$record['id'].'/status') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="approved">
                <button type="submit" class="btn btn-success">Approve</button>
              </form>

              <form action="{{ url('admin/'.$tableName.'/'.$record['id'].'/status') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="status" value="rejected">
                <button type="submit" class="btn btn-danger">Reject</button>
              </form>
            </div>
          @endif

          <!-- Display Status Name Only -->
          @php
              $statusText = [1 => 'Pending', 2 => 'Approved', 3 => 'Rejected'];
          @endphp
          @if(isset($record['status_id']))
            <div class="mt-2">
                <strong>Status:</strong> {{ $statusText[$record['status_id']] ?? 'Pending' }}
            </div>
          @endif

          <div class="d-flex justify-content-start mt-4 gap-2">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
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
