

{{-- resources/views/admin/dynamic_views/inorganic_soil_conditioner.blade.php --}}

@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')

<!-- ✅ Bootstrap & Custom CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- Navbar -->
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
        <div class="col-md-12 col-lg-12 p-4">
            <div class="form-section">

           <div class="mb-3">
        <label class="form-label">Product Category</label>
        <input type="text" class="form-control" value="Seed" disabled>
      </div>
    <!-- <h4 class="mb-4">Edit Seed Record</h4> -->

    {{-- SUCCESS / ERROR MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

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
            'image' => 'Seed Image',
            'status_id' => 'Status',
            'title' => 'Title',
            'form_type' => 'Form Type'
        ];

        // Fields to hide
        $hiddenFields = ['created_by', 'agent_id', 'supplier_id', 'qr_code_path','product_id','language_id','title','reject_reason','form_type'];
    @endphp

    <form action="{{ route('record.update', ['table' => $table, 'id' => $id]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

            @foreach($record as $field => $value)

                @if(!in_array($field, $hiddenFields) && $field != 'id' && $field != 'created_at' && $field != 'updated_at')

                    <div class="col-md-6 mb-3">
                        <label>{{ $labels[$field] ?? ucfirst(str_replace('_',' ',$field)) }}</label>

                        {{-- IMAGE FIELDS --}}
                        @if(in_array($field, ['image', 'otherRecommendationsPhoto']))
                            <input type="file" name="{{ $field }}" class="form-control">

                            @if($value)
                                <p>Current Image:</p>
                                <img src="{{ asset($value) }}" class="current-image" alt="{{ $labels[$field] ?? $field }}">
                            @endif

                        {{-- TEXTAREA --}}
                        @elseif($field == 'otherRecommendations')
                            <textarea class="form-control" name="{{ $field }}" rows="3">{{ $value }}</textarea>

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
