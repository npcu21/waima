@extends('admin.layouts.app')

@section('title', __('documents.admin_dashboard'))

@section('content')

<!-- Bootstrap & Custom CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@include('includes.navbar')

<div class="container-fluid">

    <!-- Filter + Add Button -->
    <div class="row px-4 pt-4 align-items-end">
        <div class="col-md-8 px-4 pt-4">

            <label for="country_id" class="mb-0">{{ __('documents.filter_by_country') }}:</label>
            <form method="GET" class="d-flex gap-2 align-items-center">
                <div class="w-100">                    
                    <select name="country_id" id="country_id" class="form-select w-100">
                        <option value="">{{ __('documents.all_countries') }}</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" 
                                {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-secondary w-100">{{ __('documents.filter') }}</button>
            </form>
        </div>

        <div class="col-md-4 text-end px-4 pt-4">
            <a href="{{ route('documents.create') }}" class="btn btn-primary">{{ __('documents.add_document') }}</a>
        </div>
    </div>


    <!-- DYNAMIC DOCUMENT CARDS -->
    <div class="p-4 mt-3">
        <h4 class="mb-4 px-3">{{ __('documents.uploaded_documents') }}</h4>

        <div class="row g-4 px-3">

            @forelse($documents as $doc)
                <div class="col-md-6 col-lg-4">
                    <div class="doc-card h-100">

                        <div class="d-flex align-items-center mb-3">

                            @php
                                $ext = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                                $icon = 'bi-file-earmark';
                                if($ext == 'pdf') $icon = 'bi-file-earmark-pdf';
                                if($ext == 'doc' || $ext == 'docx') $icon = 'bi-file-earmark-word';
                                if($ext == 'xls' || $ext == 'xlsx') $icon = 'bi-file-earmark-excel';
                            @endphp

                            <i class="bi {{ $icon }} doc-icon me-3"></i>

                            <div>
                                <div class="doc-title">{{ $doc->name }}</div>
                                <div class="doc-meta">
                                    {{ __('documents.category') }}: {{ $doc->usertype->type_name ?? 'N/A' }} 
                                    | {{ __('documents.type') }}: {{ strtoupper($ext) }}
                                </div>
                            </div>
                        </div>

                        <a href="{{ asset($doc->file_path) }}" target="_blank" 
                            class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-box-arrow-up-right me-1"></i> {{ __('documents.view_document') }}
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-muted px-4">{{ __('documents.no_documents_found') }}</p>
            @endforelse

        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


@endsection
