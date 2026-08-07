{{-- resources/views/admin/dynamic_views/inorganic_soil_conditioner.blade.php --}}

@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

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
                    <input type="text" class="form-control" value="Animal Feed" disabled>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @php
                    $labels = [
                        'title' => 'Title',
                        'Typeoffeed' => 'Raw materials (inputs used in animal feed production)',
                        'afrm' => 'Raw materials (inputs used in the production of animal feed)',
                        'afPhysicalform' => 'Physical form (granules, flour, crumbs)',
                        'afdm' => '% Dry Matter (DM)',
                        'afEnergy' => '% Energy (UF, kcal)',
                        'afcp' => '% Crude Protein',
                        'afsp' => 'Shelf Life',
                        'affs' => 'Feed Supplements',
                        'afWholesalePrice' => 'Average Wholesale Prices by Packaging Type',
                        'afsemiwholesalePrice' => 'Average Semi-Wholesale Prices by Packaging Type',
                        'afretailPrice' => 'Average Retail Prices by Packaging Type',
                        'qr_code_path' => 'QR Code',
                        'status_id' => 'Status',
                    ];

                    $hiddenFields = ['form_type','product_id','created_by','reject_reason','language_id','title','qr_code_path'];

                    // Visible fields except status
                    $visibleFields = collect($record)->filter(function($value, $key) use ($hiddenFields) {
                        return !in_array($key, $hiddenFields)
                            && !in_array($key, ['id','created_at','updated_at','supplier_id','agent_id','status_id']);
                    });

                    // Status field separately
                    $statusField = $record['status_id'] ?? null;
                @endphp

<form action="{{ route('country.update.record', ['table' => $table, 'id' => $id]) }}" 
      method="POST" 
      enctype="multipart/form-data">                    @csrf

                    <div class="row">

                        {{-- FIRST: All visible fields except status --}}
                        @foreach($visibleFields as $field => $value)
                            <div class="col-md-6 mb-3">
                                <label>{{ $labels[$field] ?? ucfirst(str_replace('_',' ',$field)) }}</label>

                                @if(in_array($field, ['image', 'otherRecommendationsPhoto']))
                                    <input type="file" name="{{ $field }}" class="form-control">
                                    @if($value)
                                        <p>Current Image:</p>
                                        <img src="{{ asset($value) }}" class="current-image" alt="">
                                    @endif

                                @else
                                    <input type="text" name="{{ $field }}" class="form-control" value="{{ $value }}">
                                @endif
                            </div>
                        @endforeach

                        {{-- LAST: Status field --}}
                        @if($statusField !== null)
                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select name="status_id" class="form-control">
                                    <option value="1" {{ $statusField == 1 ? 'selected' : '' }}>Pending</option>
                                    <option value="2" {{ $statusField == 2 ? 'selected' : '' }}>Approved</option>
                                    <option value="3" {{ $statusField == 3 ? 'selected' : '' }}>Deny</option>
                                </select>
                            </div>
                        @endif

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
