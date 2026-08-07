@extends('admin.layouts.app')  {{-- ✅ Use your admin layout --}}

@section('content')
<div class="container py-5">
  <h3 class="mb-4">Agriculture Form</h3>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

 <form action="{{ route('admin.products.form.store') }}" method="POST">
    @csrf

    <!-- Enumerator Section -->
    <div class="form-section mb-4">
      <h5>Name of the enumerator</h5>
      <div class="row">
        <div class="col-md-6">
          <label for="enumerator_name" class="form-label">First name(s) of the enumerator</label>
          <input type="text" name="enumerator_name" id="enumerator_name" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label for="enumerator_phone" class="form-label">WhatsApp phone number of the enumerator</label>
          <input type="text" name="enumerator_phone" id="enumerator_phone" class="form-control" required>
        </div>
      </div>
    </div>

    <!-- Identification Section -->
    <div class="form-section mb-4">
      <h5>Identification</h5>
      <div class="row gy-3">
        <div class="col-md-6">
          <label for="company_name" class="form-label">Company Name</label>
          <input type="text" name="company_name" id="company_name" class="form-control">
        </div>
        <div class="col-md-6">
          <label for="manager_name" class="form-label">Name of manager</label>
          <input type="text" name="manager_name" id="manager_name" class="form-control">
        </div>
        <div class="col-md-6">
          <label for="position" class="form-label">Position</label>
          <input type="text" name="position" id="position" class="form-control">
        </div>
      </div>
    </div>

    <!-- Location Section -->
    <div class="form-section mb-4">
      <h5>Location</h5>
      <div class="row gy-3">
        <div class="col-md-6">
          <label for="city" class="form-label">City</label>
          <input type="text" name="city" id="city" class="form-control">
        </div>
        <div class="col-md-6">
          <label for="region" class="form-label">Region</label>
          <input type="text" name="region" id="region" class="form-control">
        </div>
        <div class="col-md-6">
          <label for="address" class="form-label">Address</label>
          <input type="text" name="address" id="address" class="form-control">
        </div>
        <div class="col-md-6">
          <label for="phone" class="form-label">Phone</label>
          <input type="number" name="phone" id="phone" class="form-control">
        </div>
        <div class="col-md-6">
          <label for="mobile" class="form-label">Mobile</label>
          <input type="number" name="mobile" id="mobile" class="form-control">
        </div>
        <div class="col-md-6">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" id="email" class="form-control">
        </div>
      </div>
    </div>

    <!-- GPS Section -->
    <div class="form-section mb-4">
      <h5>Please record your current location</h5>
      <div class="row gy-3">
        <div class="col-md-6">
          <label for="latitude" class="form-label">Latitude (x.y °)</label>
          <input type="text" name="latitude" id="latitude" class="form-control">
        </div>
        <div class="col-md-6">
          <label for="longitude" class="form-label">Longitude (x.y °)</label>
          <input type="text" name="longitude" id="longitude" class="form-control">
        </div>
        <div class="col-md-6">
          <label for="altitude" class="form-label">Altitude (m)</label>
          <input type="text" name="altitude" id="altitude" class="form-control">
        </div>
        <div class="col-md-6">
          <label for="accuracy" class="form-label">Accuracy (m)</label>
          <input type="text" name="accuracy" id="accuracy" class="form-control">
        </div>
      </div>
    </div>
   <div class="form-section mb-4">
  <h5>Seed Information</h5>
  <div class="row gy-3">
    <div class="col-md-6">
      <label for="seed_id" class="form-label">Select Seed Type</label>
      <select name="seed_id" id="seed_id" class="form-control" required>
        <option value="">-- Select Seed --</option>
        @foreach($seeds as $seed)
          <option value="{{ $seed->id }}">{{ $seed->name }}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>


    <button type="submit" class="btn btn-primary mt-3">Submit</button>
  </form>
</div>
@endsection
