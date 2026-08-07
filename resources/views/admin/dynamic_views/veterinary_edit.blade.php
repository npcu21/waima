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
            <div class="form-section">

                <div class="mb-3">
                    <label class="form-label">{{ __('labels.product_category', [], app()->getLocale()) }}</label>
                    <input type="text" class="form-control" value="Veterinary Product" disabled>
                </div>

                {{-- SUCCESS / ERROR MESSAGE --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('record.update', ['table' => $table, 'id' => $id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        @foreach($record as $field => $value)

                            {{-- Skip hidden fields --}}
                            @if(!in_array($field,  ['created_by', 'agent_id', 'supplier_id', 'qr_code_path', 'id', 'created_at', 'updated_at','product_id','language_id','reject_reason','title','form_type']))

                                <div class="col-md-6 mb-3">
                                    <label>{{ __('labels.' . $field, [], app()->getLocale()) ?? ucfirst(str_replace('_',' ',$field)) }}</label>

                                    {{-- TEXTAREA --}}
                                    @if(in_array($field, ['other_therapeutic_class']))
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
