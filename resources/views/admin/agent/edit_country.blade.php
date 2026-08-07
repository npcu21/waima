@extends('admin.layouts.app')

@section('title', 'Edit Agent')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">


<!-- Navbar -->
@include('countryadmin.layouts.nav')

    
<div class="container-fluid">

  <div class="row">
    <div class="col-md-12 col-lg-12 p-4">

    <div class="card shadow-sm p-4">

   
    

  <h4 class="mb-4">Edit Agent</h4>

  {{-- Success Message --}}
  @if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
  @endif

  {{-- Validation Errors --}}
  @if($errors->any())
    <div class="alert alert-danger mt-3">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

<form action="{{ route('admin.agent.update_country', $agent->id) }}" method="POST">
        @csrf
    @method('POST')
    <div class="row g-3">

      {{-- Name --}}
      <div class="col-md-6">
        <label for="name" class="form-label">{{ __('agent.name') }}*</label>
        <input type="text" name="name" class="form-control" value="{{ $agent->name }}" required>
      </div>

      {{-- Email --}}
      <div class="col-md-6">
        <label for="email" class="form-label">{{ __('agent.email') }}*</label>
        <input type="email" name="email" class="form-control" value="{{ $agent->email }}" required>
      </div>

      {{-- Username --}}
      <!-- <div class="col-md-6">
        <label for="username" class="form-label">Username*</label>
        <input type="text" name="username" class="form-control" value="{{ $agent->username }}" required>
      </div> -->

      {{-- Password --}}
      <div class="col-md-6">
        <label for="password" class="form-label">{{ __('agent.password_optional') }}</label>
        <input type="password" name="password" class="form-control">
      </div>

      {{-- Country --}}
      <div class="col-md-6">
        <label for="country" class="form-label">{{ __('agent.country') }}*</label>
        <select name="country" id="country" class="form-select" required>
          <option value="">-- Select Country --</option>
          @foreach(\App\Models\Country::all() as $country)
            <option value="{{ $country->name }}" {{ $agent->country == $country->name ? 'selected' : '' }}>
              {{ $country->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Region (Multi-Select) --}}
      <div class="col-md-6">
        <label for="region" class="form-label">{{ __('agent.region') }}*</label>
        <select name="region[]" id="region" class="form-select select2" multiple required>
          @php
            $selectedRegions = explode(',', $agent->region);
          @endphp
          @foreach(\App\Models\Region::all() as $region)
            <option value="{{ $region->id }}" {{ in_array($region->id, $selectedRegions) ? 'selected' : '' }}>
              {{ $region->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Status --}}
      <div class="col-md-6">
        <label for="status_id" class="form-label">{{ __('agent.status') }}*</label>
        <select name="status_id" id="status_id" class="form-select" required>
          @foreach(\App\Models\Status::all() as $status)
            <option value="{{ $status->id }}" {{ $agent->status_id == $status->id ? 'selected' : '' }}>
              {{ $status->name }}
            </option>
          @endforeach
        </select>
      </div>

    </div>

    <div class="text-center mt-4">
      <button type="submit" class="btn btn-primary w-50">{{ __('agent.update_agent') }}</button>
    </div>
  </form>
</div>

</div>
  </div>

   </div>

{{-- Select2 JS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#region').select2({
        placeholder: "Select Regions",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection
