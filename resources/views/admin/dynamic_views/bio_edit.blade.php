{{-- resources/views/admin/dynamic_views/inorganic_soil_conditioner.blade.php --}}

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
                    <label class="form-label">{{ __('labels.product_category') }}</label>
                    <input type="text" class="form-control" value="{{ __('labels.inorganic_soil_conditioner') }}" disabled>
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
                        'conditioner_type' => __('labels.conditioner_type'),
                        'physical_form' => __('labels.physical_form'),
                        'trade_name' => __('labels.trade_name'),
                        'raw_material' => __('labels.raw_material'),
                        'other' => __('labels.other_info'),
                        'function' => __('labels.function'),
                        'wholesale_price' => __('labels.wholesale_price'),
                        'semiwholesale_price' => __('labels.semiwholesale_price'),
                        'retail_price' => __('labels.retail_price'),
                        'qr_code_path' => __('labels.qr_code_path'),
                        'status_id' => __('labels.status_id'),
                        'form_type' => __('labels.form_type'),
                        'title' => __('labels.title')
                    ];

                    $hiddenFields = ['form_type','product_id','created_by','reject_reason','language_id','title','qr_code_path'];
                    $skipFields = array_merge(['id','created_at','updated_at','supplier_id','agent_id'], $hiddenFields);
                @endphp

                <form action="{{ route('record.update', ['table' => $table, 'id' => $id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        @foreach($record as $field => $value)
                            @if(!in_array($field, $skipFields))
                                <div class="col-md-6 mb-3">
                                    <label>{{ $labels[$field] ?? ucfirst(str_replace('_',' ',$field)) }}</label>

                                    {{-- IMAGE FIELDS --}}
                                    @if(in_array($field, ['image', 'otherRecommendationsPhoto']))
                                        <input type="file" name="{{ $field }}" class="form-control">
                                        @if($value)
                                            <p>{{ __('labels.current_image') }}:</p>
                                            <img src="{{ asset($value) }}" class="current-image" alt="{{ $labels[$field] ?? $field }}">
                                        @endif

                                    {{-- STATUS --}}
                                    @elseif($field == 'status_id')
                                        <select name="status_id" class="form-control">
                                            <option value="1" {{ $value == 1 ? 'selected' : '' }}>{{ __('labels.pending') }}</option>
                                            <option value="2" {{ $value == 2 ? 'selected' : '' }}>{{ __('labels.approved') }}</option>
                                            <option value="3" {{ $value == 3 ? 'selected' : '' }}>{{ __('labels.rejected') }}</option>
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
                        <button type="submit" class="btn btn-success">{{ __('labels.update') }}</button>
                        <a href="{{ url()->previous() }}" class="btn btn-danger">{{ __('labels.cancel') }}</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
