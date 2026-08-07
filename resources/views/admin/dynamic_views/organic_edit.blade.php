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
        <div class="col-lg-12 col-md-12 p-4">
             <div class="mb-3">
        <label class="form-label">{{ __('labels.product_category') }}</label>
        <input type="text" class="form-control" value="{{ __('labels.organic_amendment') }}" disabled>
      </div>
            <div class="form-section">

    {{-- SUCCESS / ERROR MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        $hiddenFields = ['created_by', 'agent_id','form_type','supplier_id', 'qr_code_path', 'id', 'created_at', 'updated_at','product_id','language_id','reject_reason','title'];
    @endphp

    <form action="{{ route('record.update', ['table' => $table, 'id' => $id]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

            @foreach($record as $field => $value)
                {{-- Skip hidden fields --}}
                @if(!in_array($field, $hiddenFields))

                    <div class="col-md-6 mb-3">
                        <label>{{ __('labels.'.$field) ?? ucfirst(str_replace('_',' ',$field)) }}</label>

                        {{-- IMAGE FIELDS --}}
                        @if(in_array($field, ['image', 'otherRecommendationsPhoto']))
                            <input type="file" name="{{ $field }}" class="form-control">
                            @if($value)
                                <p>{{ __('labels.current_image') }}:</p>
                                <img src="{{ asset($value) }}" class="current-image" alt="{{ __('labels.'.$field) ?? $field }}">
                            @endif

                        {{-- TEXTAREA --}}
                        @elseif($field == 'otherRecommendations')
                            <textarea class="form-control" name="{{ $field }}" rows="3">{{ $value }}</textarea>

                        {{-- STATUS --}}
                        @elseif($field == 'status_id')
                            <select name="status_id" class="form-control">
                                <option value="1" {{ $value == 1 ? 'selected' : '' }}>{{ __('labels.pending') }}</option>
                                <option value="2" {{ $value == 2 ? 'selected' : '' }}>{{ __('labels.approved') }}</option>
                                <option value="3" {{ $value == 3 ? 'selected' : '' }}>{{ __('labels.deny') }}</option>
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
