@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- ✅ Bootstrap & Icons -->
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<!-- ✅ Custom CSS -->
<link rel="stylesheet" href="https://fivoflow.com/wclm/public/css/style.css">

<body>

 <!-- Navbar -->
    @include('countryadmin.layouts.nav')

<div class="container-fluid">
   <div class="row">
        <div class="col-md-12 col-lg-12 p-4">       

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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


<form action="{{ route('admin.country.farmer.update', ['id' => $user->id]) }}" 
      method="POST" enctype="multipart/form-data">
    @csrf
    <!-- form fields -->
 


{{-- ✅ USER SECTION --}}
<div id="user-info-section" class="form-section mb-4" 
     style="{{ $user->usertype_id == 1 ? '' : 'display:none;' }}">
    <h4>User Info</h4>
    <div class="row gy-3">

        <div class="col-md-6">
            <label class="form-label">Username:</label>
            <input type="text" name="username" class="form-control"
                   value="{{ old('username', $user->username) }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Full Name:</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $user->name) }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $user->email) }}">
        </div>

        <div class="col-md-6 user-field">
            <label class="form-label">Password:</label>
            <input type="password" name="password" class="form-control"
                   placeholder="Leave blank to keep same">
        </div>

        <div class="col-md-6">
            <label class="form-label">User Type:</label>
            <select id="usertype" name="usertype_id" class="form-select">
                @foreach($usertypes as $type)
                    <option value="{{ $type->id }}" {{ $user->usertype_id == $type->id ? 'selected' : '' }}>
                        {{ $type->type_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 user-field">
            <label class="form-label">Country:</label>
            <select name="country_id" class="form-select">
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ $user->country_id == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>
</div>

{{-- ✅ SUPPLIER SECTION --}}
<div id="supplier-section" class="form-section"
     style="{{ $user->usertype_id == 2 ? '' : 'display:none;' }}">
<h4>Supplier Information</h4>

<div class="row gy-3">
     <div class="col-md-6">
            <label class="form-label">Username:</label>
            <input type="text" name="username" class="form-control"
                   value="{{ old('username', $user->username) }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Full Name:</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $user->name) }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $user->email) }}">
        </div>

    <div class="col-md-6 supplier-field">
        <label class="form-label">Company Name</label>
        <input type="text" name="company_name" class="form-control" value="{{ $user->company_name }}">
    </div>

    <div class="col-md-6 supplier-field">
        <label class="form-label">Manager Name</label>
        <input type="text" name="manager_name" class="form-control" value="{{ $user->manager_name }}">
    </div>

    <div class="col-md-6 supplier-field">
        <label class="form-label">Position</label>
        <input type="text" name="position" class="form-control" value="{{ $user->position }}">
    </div>

    <div class="col-md-6 supplier-field">
        <label class="form-label">City</label>
        <input type="text" name="city" class="form-control" value="{{ $user->city }}">
    </div>

    <div class="col-md-6 supplier-field">
        <label class="form-label">Region</label>
        <input type="text" name="region" class="form-control" value="{{ $user->region }}">
    </div>

    <div class="col-md-6 supplier-field">
        <label class="form-label">Address</label>
        <input type="text" name="address" class="form-control" value="{{ $user->address }}">
    </div>

    <div class="col-md-6 supplier-field">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
    </div>

    <div class="col-md-6 supplier-field">
        <label class="form-label">Mobile</label>
        <input type="text" name="mobile" class="form-control" value="{{ $user->mobile }}">
    </div>

    <div class="col-md-6 supplier-field">
        <label class="form-label">Latitude</label>
        <input type="text" name="latitude" class="form-control" value="{{ $user->latitude }}">
    </div>

    <div class="col-md-6 supplier-field">
        <label class="form-label">Longitude</label>
        <input type="text" name="longitude" class="form-control" value="{{ $user->longitude }}">
    </div>

    <div class="col-md-6 supplier-field">
        <label class="form-label">Employer Identification Number</label>
        <input type="text" name="employer_identification_number" class="form-control" value="{{ $user->employer_identification_number }}">
    </div>

    <div class="col-md-6 supplier-field">
        <label class="form-label">State Entity Registration</label>
        <input type="text" name="state_entity_registration" class="form-control" value="{{ $user->state_entity_registration }}">
    </div>

    <div class="col-md-6 supplier-field">
        <label class="form-label">Upload Image</label>
        <input type="file" name="image" class="form-control">
        @if($user->image)
            <img src="{{ asset('uploads/user_images/'.$user->image) }}" width="120" class="mt-2">
        @endif
    </div>

</div>
</div>

<button type="submit" class="btn btn-primary px-4">Update User</button>
<a href="{{ route('admin.list_users') }}" class="btn btn-secondary">Back</a>

</form>
</div>
 </div>
   </div>

<script>
function toggleFields() {
    let type = document.getElementById("usertype").value;

    if (type == "2") {
        document.getElementById("supplier-section").style.display = "block";
        document.getElementById("user-info-section").style.display = "none";
    } else {
        document.getElementById("supplier-section").style.display = "none";
        document.getElementById("user-info-section").style.display = "block";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("usertype").addEventListener("change", toggleFields);
    toggleFields();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
