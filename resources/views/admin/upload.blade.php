@extends('admin.layouts.app')

@section('title', 'Upload File')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@include('includes.navbar')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10 p-4">
            <!-- Card Wrapper -->
            <div class="card shadow-sm p-4">
                <div>
                    <h4 class="mb-1">Upload File for Record #{{ $record->id }}</h4>
                    <h5 class="mb-4">{{ $displayName }}</h5>
                </div>
                <div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Upload Form -->
                    <form action="{{ route('masteradmin.upload.file', ['table' => $table, 'id' => $record->id]) }}" 
                          method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Title Input -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter file title" required>
                        </div>

                        <!-- File Input -->
                        <div class="mb-3">
                            <label for="file" class="form-label">Select File</label>
                            <input type="file" class="form-control" name="file" id="file" required>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success w-50"><i class="bi bi-upload me-1"></i> Upload</button>
                            <a href="{{ route('masteradmin.dashboard') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
