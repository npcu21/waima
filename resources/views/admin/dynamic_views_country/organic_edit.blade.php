

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
        <div class="col-lg-12 col-md-12 p-4">
             <div class="mb-3">
        <label class="form-label">Product Category</label>
        <input type="text" class="form-control" value="Organic Amendment" disabled>
      </div>
            <div class="form-section">

           

    <!-- <h4 class="mb-4">Edit Organic Amendment Record</h4> -->

    {{-- SUCCESS / ERROR MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        $labels = [
            'organic_type' => 'Type of Organic Amendment (compost, vermicompost, bokashi, etc.)',
            'physical_form' => 'Physical Form',
            'trade_name' => 'Trade Name',
            'country_origin' => 'Country of Origin',
            'bio_label' => 'Organic Label Name, if applicable',
            'n' => '%N',
            'p2' => '%P205',
            'k2' => '%K20',
            'cao' => '%Cao',
            'mgo' => '%Mg0',
            'cn_ratio' => 'C/N',
            'raw_material' => 'Raw Material',
            'raw_material_other' => 'Other Raw Material',
            'arsenic_content' => 'Arsenic content less than 10 mg/kg',
            'cadmium_content' => 'Cadmium content less than 5 mg/kg',
            'chromium_content' => 'Chromium content less than 50 mg/kg',
            'copper_content' => 'Copper content less than 300 mg/kg',
            'lead_content' => 'Lead content less than 100 mg/kg',
            'wholesale_price' => 'Average wholesale prices by packaging type',
            'semiwholesale_price' => 'Average semi-wholesale price by packaging type',
            'retail_price' => 'Average retail prices by packaging type',
            'qr_code_path' => 'QR Code',
            'status_id' => 'Status',
            'title' => 'Title',
            'form_type' => 'Form Type',
        ];
          
    @endphp

<form action="{{ route('country.update.record', ['table' => $table, 'id' => $id]) }}" 
      method="POST" 
      enctype="multipart/form-data">       
       @csrf

        <div class="row">

            @foreach($record as $field => $value)
                {{-- Skip hidden fields --}}
                @if(!in_array($field,  ['created_by', 'agent_id','form_type','supplier_id', 'qr_code_path', 'id', 'created_at', 'updated_at','product_id','language_id','reject_reason','title']))

                    <div class="col-md-6 mb-3">
                        <label>{{ $labels[$field] ?? ucfirst(str_replace('_',' ',$field)) }}</label>

                        {{-- IMAGE / QR FIELDS --}}
                        @if(in_array($field, ['qr_code_path']))
                            {{-- Skip showing QR field --}}
                        @elseif(in_array($field, ['image', 'otherRecommendationsPhoto']))
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
