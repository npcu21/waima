@extends('admin.layouts.app')

@section('title', 'Add Region')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


@include('includes.navbar')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 col-lg-12 p-4">
      <div class="form-section">

      
    <h4>Add New Region</h4>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to Add Region -->
    <form action="{{ route('region.store') }}" method="POST">
        @csrf

        <!-- Country Dropdown -->
        <div class="mb-3">
            <label for="country_id" class="form-label">Country</label>
            <select name="country_id" id="country_id" class="form-control" required>
                <option value="">-- Select Country --</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Region Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Region Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter region name" required>
        </div>

        <!-- Commune -->
        <div class="mb-3">
            <label for="commune" class="form-label">Commune</label>
            <input type="text" name="commune" id="commune" class="form-control" placeholder="Enter commune" required>
        </div>

        <!-- District -->
        <div class="mb-3">
            <label for="district" class="form-label">District</label>
            <input type="text" name="district" id="district" class="form-control" placeholder="Enter district" required>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary w-50">Add Region</button>
        </div>
        
    </form>
</div>
</div>
    </div>
  </div>
@endsection
