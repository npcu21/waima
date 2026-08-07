{{-- resources/views/admin/dynamic_views/inorganic_soil_conditioner.blade.php --}}

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
                    <label class="form-label">{{ __('labels.product_category', [], app()->getLocale()) }}</label>
                    <input type="text" class="form-control" value="{{ __('labels.seed', [], app()->getLocale()) }}" disabled>
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
                        'cropName' => __('labels.crop_name', [], app()->getLocale()),
                        'verityName' => __('labels.variety_name', [], app()->getLocale()),
                        'breederName' => __('labels.breeder_name', [], app()->getLocale()),
                        'countryOrigin' => __('labels.country_origin', [], app()->getLocale()),
                        'registrationNumber' => __('labels.registration_number', [], app()->getLocale()),
                        'varietyType' => __('labels.variety_type', [], app()->getLocale()),
                        'seedCategory' => __('labels.seed_category', [], app()->getLocale()),
                        'precocity' => __('labels.precocity', [], app()->getLocale()),
                        'fruitColor' => __('labels.fruit_color', [], app()->getLocale()),
                        'fruitShape' => __('labels.fruit_shape', [], app()->getLocale()),
                        'leafLength' => __('labels.leaf_length', [], app()->getLocale()),
                        'leafColor' => __('labels.leaf_color', [], app()->getLocale()),
                        'plantHeight' => __('labels.plant_height', [], app()->getLocale()),
                        'plantHabit' => __('labels.plant_habit', [], app()->getLocale()),
                        'bioticResistance' => __('labels.biotic_resistance', [], app()->getLocale()),
                        'abioticResistance' => __('labels.abiotic_resistance', [], app()->getLocale()),
                        'InherentNutritionalValue' => __('labels.inherent_nutritional_value', [], app()->getLocale()),
                        'yield' => __('labels.yield', [], app()->getLocale()),
                        'otherRecommendations' => __('labels.other_recommendations_text', [], app()->getLocale()),
                        'otherRecommendationsPhoto' => __('labels.other_recommendations_photo', [], app()->getLocale()),
                        'wholesalePrice' => __('labels.wholesale_price', [], app()->getLocale()),
                        'semiwholesalePrice' => __('labels.semiwholesale_price', [], app()->getLocale()),
                        'retailPrice' => __('labels.retail_price', [], app()->getLocale()),
                        'image' => __('labels.seed_image', [], app()->getLocale()),
                        'status_id' => __('labels.status_id', [], app()->getLocale()),
                        'title' => __('labels.title', [], app()->getLocale()),
                        'form_type' => __('labels.form_type', [], app()->getLocale())
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
                                            <p>{{ __('labels.current_image', [], app()->getLocale()) }}:</p>
                                            <img src="{{ asset($value) }}" class="current-image" alt="{{ $labels[$field] ?? $field }}">
                                        @endif

                                    {{-- TEXTAREA --}}
                                    @elseif($field == 'otherRecommendations')
                                        <textarea class="form-control" name="{{ $field }}" rows="3">{{ $value }}</textarea>

                                    {{-- STATUS --}}
                                    @elseif($field == 'status_id')
                                        <select name="status_id" class="form-control">
                                            <option value="1" {{ $value == 1 ? 'selected' : '' }}>{{ __('labels.pending', [], app()->getLocale()) }}</option>
                                            <option value="2" {{ $value == 2 ? 'selected' : '' }}>{{ __('labels.approved', [], app()->getLocale()) }}</option>
                                            <option value="3" {{ $value == 3 ? 'selected' : '' }}>{{ __('labels.deny', [], app()->getLocale()) }}</option>
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
                        <button type="submit" class="btn btn-success">{{ __('labels.update', [], app()->getLocale()) }}</button>
                        <a href="{{ url()->previous() }}" class="btn btn-danger">{{ __('labels.cancel', [], app()->getLocale()) }}</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
