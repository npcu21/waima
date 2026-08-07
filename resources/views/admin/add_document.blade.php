@extends('admin.layouts.app')

@section('title', __('documents.admin_dashboard'))

@section('content')

<!-- ✅ Bootstrap & Custom CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- Navbar -->
@include('includes.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 p-4">
            <div class="card shadow-sm p-4"> 
                
                <h4 class="mb-4">{{ __('documents.add_document') }}</h4>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Document Name -->
                    <div class="mb-3">
                        <label class="form-label">{{ __('documents.document_name') }}</label>
                        <input type="text" name="document_name" class="form-control" required>
                    </div>

                    <!-- User Type Dropdown -->
                    <div class="mb-3">
                        <label class="form-label">{{ __('documents.user_type') }}</label>
                        <select name="usertype_id" class="form-control" required>
                            <option value="">-- {{ __('documents.select_user_type') }} --</option>
                            @foreach($usertypes as $type)
                                <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Country Dropdown -->
                    <div class="mb-3">
                        <label class="form-label">{{ __('documents.country') }}</label>
                        <select name="country_id" class="form-control">
                            <option value="">-- {{ __('documents.select_country') }} --</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-3">
                        <label class="form-label">{{ __('documents.upload_file') }}</label>
                        <input type="file" name="document_file" class="form-control" accept=".pdf,.xlsx,.csv" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-50">
                            {{ __('documents.upload') }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>        
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
