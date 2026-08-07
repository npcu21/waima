@extends('admin.layouts.app')

@section('title', 'Upload Document')

@section('content')

@php
    use Illuminate\Support\Facades\Auth;
@endphp

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@include('countryadmin.layouts.nav')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 p-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-4">Upload Document for {{ $displayName }}</h5>

                    <form method="POST" 
                          action="{{ route('countryadmin.upload.file', ['table' => $table, 'id' => $record->id]) }}" 
                          enctype="multipart/form-data">
                        @csrf

                        {{-- Record Info --}}
                        <div class="mb-3">
                            <label class="form-label">Record ID</label>
                            <input type="text" class="form-control" value="{{ $record->id }}" readonly>
                        </div>

                        @if(isset($record->seed))
                        <div class="mb-3">
                            <label class="form-label">Seed</label>
                            <input type="text" class="form-control" value="{{ $record->seed }}" readonly>
                        </div>
                        @endif

                        {{-- File Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">File Title</label>
                            <input type="text" name="title" id="title" class="form-control" 
                                   placeholder="Enter file title" value="{{ old('title') }}" required>
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- File Input --}}
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload File</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                            @error('file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Hidden country field --}}
                        <input type="hidden" name="country" value="{{ Auth::user()->country_id ?? '' }}">

                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload"></i> Upload
                        </button>
                        <a href="{{ route('countryadmin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
