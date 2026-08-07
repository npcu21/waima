{{-- resources/views/admin/dynamic_views/inorganic_soil_conditioner.blade.php --}}

@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

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
                    <label class="form-label">{{ __('products.product_category') }}</label>
                    <input type="text" class="form-control" value="Animal Feed" disabled>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @php
                    $hiddenFields = [
                        'form_type',
                        'product_id',
                        'created_by',
                        'reject_reason',
                        'language_id',
                        'title',
                        'qr_code_path'
                    ];

                    // Visible fields except status
                    $visibleFields = collect($record)->filter(function($value, $key) use ($hiddenFields) {
                        return !in_array($key, $hiddenFields)
                            && !in_array($key, [
                                'id',
                                'created_at',
                                'updated_at',
                                'supplier_id',
                                'agent_id',
                                'status_id'
                            ]);
                    });

                    // Status field separately
                    $statusField = $record['status_id'] ?? null;
                @endphp

                <form action="{{ route('record.update', ['table' => $table, 'id' => $id]) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        {{-- ALL FIELDS (DYNAMIC LABELS) --}}
                        @foreach($visibleFields as $field => $value)
                            <div class="col-md-6 mb-3">
                                <label>
                                    {{ __('products.' . $field) ?? ucfirst(str_replace('_',' ',$field)) }}
                                </label>

                                @if(in_array($field, ['image', 'otherRecommendationsPhoto']))
                                    <input type="file" name="{{ $field }}" class="form-control">

                                    @if($value)
                                        <p class="mt-1">{{ __('products.current_image') }}</p>
                                        <img src="{{ asset($value) }}" class="current-image" alt="">
                                    @endif
                                @else
                                    <input type="text"
                                           name="{{ $field }}"
                                           class="form-control"
                                           value="{{ $value }}">
                                @endif
                            </div>
                        @endforeach

                        {{-- STATUS FIELD --}}
                        @if($statusField !== null)
                            <div class="col-md-6 mb-3">
                                <label>{{ __('products.status_id') }}</label>
                                <select name="status_id" class="form-control">
                                    <option value="1" {{ $statusField == 1 ? 'selected' : '' }}>
                                        {{ __('products.pending') }}
                                    </option>
                                    <option value="2" {{ $statusField == 2 ? 'selected' : '' }}>
                                        {{ __('products.approved') }}
                                    </option>
                                    <option value="3" {{ $statusField == 3 ? 'selected' : '' }}>
                                        {{ __('products.deny') }}
                                    </option>
                                </select>
                            </div>
                        @endif

                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">
                            {{ __('products.update') }}
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-danger">
                            {{ __('products.cancel') }}
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
