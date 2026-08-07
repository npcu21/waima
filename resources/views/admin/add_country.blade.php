@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

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

      
    <h4 class="mb-4">Add Country</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('countries.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Country Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Country Code</label>
            <input type="text" name="code" class="form-control">
        </div>

        <!-- <div class="mb-3">
            <label class="form-label">Language ID</label>
            <input type="number" name="language_id" class="form-control">
        </div> -->
        <div class="text-center">
          <button type="submit" class="btn btn-primary w-50">Save Country</button>
        </div>
        
    </form>
</div>

</div>
    </div>
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
