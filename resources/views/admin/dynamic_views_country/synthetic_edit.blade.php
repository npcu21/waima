

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
            <div class="form-section">
  <div class="mb-3">
        <label class="form-label">Product Category</label>
        <input type="text" class="form-control" value="Synthetic Pesticides" disabled>
      </div>
    <!-- <h4 class="mb-4">Edit Synthetic Pesticide Record</h4> -->

    {{-- SUCCESS / ERROR MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        // ✅ Editable field labels
        $labels = [
            'title' => 'Title',
            'product_name' => 'Trade Name',
            'active_substance' => 'Active ingredient(s)',
            'pharmaceutical_form' => 'Formulation',
            'registration_number' => 'Registration number',
            'therapeutic_class' => 'Function',
            'other_therapeutic_class' => 'Other Therapeutic Class',
            'dosage' => 'Dosage',
            'route_of_administration' => 'Route of Administration',
            'targeted_animals' => 'Targeted Animals',
            'waiting_period' => 'Waiting Period',
            'expiry_date' => 'Expiry Date',
            'transport_storage_requirements' => 'Transport & Storage Requirements',
            'wholesale_price' => 'Average Wholesale Price by Packaging Type',
            'semiwholesale_price' => 'Average Semi-Wholesale Price by Packaging Type',
            'retail_price' => 'Average Retail Price by Packaging Type',
            'status_id' => 'Status',
        ];

        // Fields to hide
        $hiddenFields = ['created_by', 'agent_id', 'supplier_id', 'qr_code_path', 'id', 'created_at', 'updated_at','product_id','language_id','reject_reason','title','form_type'];
    @endphp

    <form action="{{ route('record.update', ['table' => $table, 'id' => $id]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

            @foreach($record as $field => $value)

                @if(!in_array($field, $hiddenFields))

                    <div class="col-md-6 mb-3">
                        <label>{{ $labels[$field] ?? ucfirst(str_replace('_',' ',$field)) }}</label>

                        {{-- TEXTAREA for long text fields --}}
                        @if(in_array($field, ['therapeutic_class', 'other_therapeutic_class', 'transport_storage_requirements']))
                            <textarea class="form-control" name="{{ $field }}" rows="3">{{ $value }}</textarea>

                        {{-- STATUS dropdown --}}
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
