@extends('admin.layouts.app')

@section('title', __('dashboard.create_announcement'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@include('includes.navbar')

<div class="container-fluid">
<div class="row">
<div class="col-md-12 col-lg-12 p-4">

<div class="card shadow-sm p-4">

<h4 class="mb-4">{{ __('dashboard.create_announcement') }}</h4>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif


<form action="{{ route('admin.store-announcement') }}" 
method="POST" 
enctype="multipart/form-data">

@csrf

<input type="hidden" name="language_id" value="{{ session('lang', 'en') }}">

<div class="row gy-3">

{{-- TITLE --}}
<div class="col-md-6">
<label class="form-label">{{ __('dashboard.title') }}*</label>

<input type="text"
name="title"
class="form-control"
value="{{ old('title') }}"
required>

@error('title')
<div class="text-danger mt-1">{{ $message }}</div>
@enderror
</div>


{{-- USER TYPE --}}
<!-- <div class="col-md-6">

<label class="form-label">{{ __('dashboard.user_type') }}*</label>

<select name="user_type_id"
class="form-select"
required>

<option value="" disabled selected>
{{ __('dashboard.select_user_type') }}
</option>

@foreach($usertypes as $type)

<option value="{{ $type->id }}"
{{ old('user_type_id') == $type->id ? 'selected' : '' }}>

{{ $userTypeNames[session('lang','en')][$type->id] ?? $type->name_type }}

</option>

@endforeach

</select>

@error('user_type_id')
<div class="text-danger mt-1">{{ $message }}</div>
@enderror

</div>
 -->
<div class="col-md-6">

<label class="form-label">{{ __('dashboard.user_type') }}*</label>

<select name="user_type_id[]" 
        class="form-select" 
        multiple 
        required>

<option value="" disabled>
{{ __('dashboard.select_user_type') }}
</option>

@foreach($usertypes as $type)

<option value="{{ $type->id }}"
{{ (collect(old('user_type_id'))->contains($type->id)) ? 'selected' : '' }}>

{{ $userTypeNames[session('lang','en')][$type->id] ?? $type->name_type }}

</option>

@endforeach

</select>

<small class="text-muted">Hold CTRL to select multiple user types</small>

@error('user_type_id')
<div class="text-danger mt-1">{{ $message }}</div>
@enderror

</div>

{{-- DESCRIPTION --}}
<div class="col-12">

<label class="form-label">
{{ __('dashboard.description') }}*
</label>

<textarea
name="description"
rows="5"
class="form-control"
required>{{ old('description') }}</textarea>

@error('description')
<div class="text-danger mt-1">{{ $message }}</div>
@enderror

</div>



{{-- STATUS --}}
<div class="col-md-6">

<label class="form-label">
{{ __('dashboard.status') }}*
</label>

<select name="status"
class="form-select"
required>

<option value="Active"
{{ old('status')=='Active' ? 'selected' : '' }}>
{{ __('dashboard.active') }}
</option>

<option value="Inactive"
{{ old('status')=='Inactive' ? 'selected' : '' }}>
{{ __('dashboard.inactive') }}
</option>

</select>

@error('status')
<div class="text-danger mt-1">{{ $message }}</div>
@enderror

</div>



{{-- COUNTRY --}}
<div class="col-md-6">

<label class="form-label">
{{ __('dashboard.country') }}
</label>

<select name="country_id"
class="form-select">

<option value="">
{{ __('dashboard.select_country') }}
</option>

@foreach($countries as $country)

<option value="{{ $country->id }}"
{{ old('country_id')==$country->id ? 'selected' : '' }}>

{{ $country->name }}

</option>

@endforeach

</select>

@error('country_id')
<div class="text-danger mt-1">{{ $message }}</div>
@enderror

</div>



{{-- MULTIPLE CURRENCY --}}
<div class="col-md-6">

<label class="form-label">
Multi Currency
</label>

<select name="currency[]"
class="form-select"
multiple>

<option value="USD">USD</option>
<option value="EUR">EUR</option>
<option value="INR">INR</option>

</select>

<small class="text-muted">
Hold CTRL to select multiple currencies
</small>

</div>



{{-- MULTIPLE ROLES --}}




{{-- IMAGE --}}
<div class="col-md-6">

<label class="form-label">
{{ __('dashboard.image') }}
</label>

<input type="file"
name="image"
class="form-control">

@error('image')
<div class="text-danger mt-1">{{ $message }}</div>
@enderror

</div>



{{-- SUBMIT --}}
<div class="col-12 mt-3">

<div class="text-center">

<button type="submit"
class="btn btn-primary w-50">

{{ __('dashboard.submit') }}

</button>

</div>

</div>


</div>
</form>

</div>
</div>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection