<!DOCTYPE html>
<html lang="{{ session('lang', 'en') }}">
<head>
<meta charset="UTF-8">
<title>{{ __('dashboard.add_supplier') }} - Admin WAIMA</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<style>
.form-section{
background:#fff;
padding:25px;
border-radius:10px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
margin-bottom:25px;
}

#preview{
width:120px;
height:120px;
object-fit:cover;
border-radius:10px;
margin-top:10px;
display:none;
}
</style>

</head>

<body>

@include('includes.navbar')

<div class="container-fluid content-wrapper">
<div class="row">
<div class="col-md-12 col-lg-12 p-4">

<h4 class="mb-4">{{ __('dashboard.add_supplier') }}</h4>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif


<form action="{{ route('admin.store-supplier') }}" method="POST" enctype="multipart/form-data">

@csrf
<input type="hidden" name="status_id" value="1">


<!-- IDENTIFICATION -->
<div class="form-section">

<h5>{{ __('dashboard.identification') }}</h5>

<div class="row gy-3">

<div class="col-md-6">
<label class="form-label">{{ __('dashboard.company_name') }}*</label>
<input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}" required>
</div>

<div class="col-md-6">
<label class="form-label">{{ __('dashboard.manager_name') }}*</label>
<input type="text" class="form-control" name="manager_name" value="{{ old('manager_name') }}" required>
</div>

<div class="col-md-6">
<label class="form-label">{{ __('dashboard.position') }}*</label>
<input type="text" class="form-control" name="position" value="{{ old('position') }}" required>
</div>

<div class="col-md-6">
<label class="form-label">{{ __('dashboard.image') }}*</label>
<input type="file" class="form-control" name="image" id="image" required>

<img id="preview">
</div>

</div>
</div>


<!-- LOCATION -->
<div class="form-section">

<h5>{{ __('dashboard.location') }}</h5>

<div class="row gy-3">

<div class="col-md-6">
<label class="form-label">{{ __('dashboard.city') }}*</label>
<input type="text" class="form-control" name="city" value="{{ old('city') }}" required>
</div>


<div class="col-md-6">
<label class="form-label">{{ __('dashboard.country') }}*</label>

<select name="country_id" class="form-select" required>

<option value="">{{ __('dashboard.select_country') }}</option>

@foreach($countries as $country)

<option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
{{ $country->name }}
</option>

@endforeach

</select>
</div>



<div class="col-md-6">
<label class="form-label">{{ __('dashboard.region') }}*</label>

<select name="region" class="form-select" required>

<option value="">{{ __('dashboard.select_region') }}</option>

@foreach($regions as $region)

<option value="{{ $region->id }}" {{ old('region') == $region->id ? 'selected' : '' }}>
{{ $region->name }}
</option>

@endforeach

</select>
</div>


<div class="col-md-6">
<label class="form-label">{{ __('dashboard.address') }}*</label>
<input type="text" class="form-control" name="address" value="{{ old('address') }}" required>
</div>

</div>



<div class="row gy-3 mt-3">

<div class="col-md-6">
<label class="form-label">{{ __('dashboard.state_entity_registration') }}</label>
<input type="text" class="form-control" name="state_entity_registration" value="{{ old('state_entity_registration') }}">
</div>


<div class="col-md-6">
<label class="form-label">{{ __('dashboard.employer_identification_number') }}</label>
<input type="text" class="form-control" name="employer_identification_number" value="{{ old('employer_identification_number') }}">
</div>


<div class="col-md-6">
<label class="form-label">{{ __('dashboard.latitude') }}</label>
<input type="number" step="any" class="form-control" name="latitude" value="{{ old('latitude') }}">
</div>


<div class="col-md-6">
<label class="form-label">{{ __('dashboard.longitude') }}</label>
<input type="number" step="any" class="form-control" name="longitude" value="{{ old('longitude') }}">
</div>


<div class="col-md-6">
<label class="form-label">{{ __('dashboard.phone') }}*</label>
<input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
</div>


<div class="col-md-6">
<label class="form-label">{{ __('dashboard.mobile') }}*</label>
<input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" required>
</div>


<div class="col-md-6">
<label class="form-label">{{ __('dashboard.email') }}*</label>
<input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
</div>

</div>

</div>



<div class="text-center mt-4">
<button type="submit" class="btn btn-primary px-5 w-50">
{{ __('dashboard.submit') }}
</button>
</div>

</form>

</div>
</div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>

document.getElementById("image").addEventListener("change",function(){

const file=this.files[0];

if(file){

const reader=new FileReader();

reader.onload=function(e){

document.getElementById("preview").src=e.target.result;
document.getElementById("preview").style.display="block";

}

reader.readAsDataURL(file);

}

});

</script>


</body>
</html>