{{-- resources/views/admin/dynamic_views/inorganic_soil_conditioner.blade.php --}}

@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')

<!-- ✅ Bootstrap & Custom CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- ✅ Navbar -->
@include('countryadmin.layouts.nav')

<style>
    label {
        font-weight: 600;
        margin-bottom: 5px;
    }
    img.current-image {
        border: 1px solid #ccc;
        padding: 2px;
        margin-top: 5px;
        max-height: 120px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 p-4">
            <div class="form-section">
            
                <div class="mb-3">
                    <label class="form-label">Product Category</label>
                    <input type="text" class="form-control" value="Bio Stimulant" disabled>
                </div>

                {{-- SUCCESS / ERROR MESSAGE --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @php
                    $labels = [
                        'trade_name' => 'Trade Name',
                        'physical_form' => 'Physical Form',
                        'biostimulant_product' => 'Biostimulants Product Name',
                        're_registration' => 'Registration Number',
                        'n' => '%N',
                        'p2' => '%P205',
                        'k2' => '%K20',
                        'zn' => '%Zn',
                        'ca' => '%Ca',
                        'mg' => '%Mg',
                        's' => '%S',
                        'b' => '%B',
                        'mo' => '%Mo',
                        'action_mode' => 'Mode of Action',
                        'wholesale_price' => 'Average Wholesale Prices by Packaging Type',
                        'semiwholesale_price' => 'Average Semi-Wholesale Prices by Packaging Type',
                        'retail_price' => 'Average Retail Prices by Packaging Type',
                        'qr_code_path' => 'QR Code',
                        'status_id' => 'Status',
                        'title' => 'Title',
                        'form_type' => 'Form Type'
                    ];

                    $hiddenFields = ['form_type','product_id','created_by','reject_reason','language_id','title','qr_code_path'];

                    $skipFields = array_merge(
                        ['id','created_at','updated_at','supplier_id','agent_id'],
                        $hiddenFields
                    );
                @endphp

<form action="{{ route('country.update.record', ['table' => $table, 'id' => $id]) }}" 
      method="POST" 
      enctype="multipart/form-data">                    @csrf

                    <div class="row">

                        @foreach($record as $field => $value)
                            @if(!in_array($field, $skipFields))
                                <div class="col-md-6 mb-3">
                                    <label>{{ $labels[$field] ?? ucfirst(str_replace('_',' ',$field)) }}</label>

                                    {{-- IMAGE FIELDS --}}
                                    @if(in_array($field, ['image', 'otherRecommendationsPhoto']))
                                        <input type="file" name="{{ $field }}" class="form-control">
                                        @if($value)
                                            <p>Current Image:</p>
                                            <img src="{{ asset($value) }}" class="current-image" alt="{{ $labels[$field] ?? $field }}">
                                        @endif

                                    {{-- STATUS --}}
                                    @elseif($field == 'status_id')
                                        <select name="status_id" class="form-control">
                                            <option value="1" {{ $value == 1 ? 'selected' : '' }}>Pending</option>
                                            <option value="2" {{ $value == 2 ? 'selected' : '' }}>Approved</option>
                                            <option value="3" {{ $value == 3 ? 'selected' : '' }}>Deny</option>
                                        </select>

                                    {{-- DEFAULT INPUT --}}
                                    @else
                                        <input type="text" name="{{ $field }}" class="form-control" value="{{ $value }}">
                                    @endif

                                </div>
                            @endif
                        @endforeach

                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
