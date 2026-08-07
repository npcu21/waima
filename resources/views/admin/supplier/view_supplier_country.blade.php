@extends('admin.layouts.app')

@section('title', 'Supplier Details')

@section('content')
<!-- ✅ Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- ✅ Custom CSS -->
<link rel="stylesheet" href="https://fivoflow.com/wclm/public/css/style.css">

<!-- ✅ Top Navbar -->
@include('includes.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 p-4">
            <div>

           
    <h4 class="mb-4">Supplier Details</h4>
    
    <table class="table table-bordered table-striped">
        <tbody>
            <tr><th>ID</th><td>{{ $supplier->id }}</td></tr>
            <!-- <tr><th>User Type ID</th><td>{{ $supplier->usertype_id }}</td></tr> -->
            <tr><th>Country</th><td>{{ $supplier->country?->name ?? $supplier->country_id }}</td></tr>
            <tr><th>Company Name</th><td>{{ $supplier->company_name }}</td></tr>
            <tr><th>Manager Name</th><td>{{ $supplier->manager_name }}</td></tr>
            <tr><th>Name</th><td>{{ $supplier->name }}</td></tr>
            <tr><th>Position</th><td>{{ $supplier->position }}</td></tr>
            <tr><th>Image</th>
              
                  <td>
                    @if(!empty($supplier->image))
                        @php
                            $img = $supplier->image;
                            $userImagePath = public_path('uploads/user_images/'.$img);
                            $supplierImagePath = public_path('uploads/supplier/'.$img);
                        @endphp

                        @if(Str::startsWith($img, 'ftp://'))
                            <img src="{{ $img }}" width="50" height="50" style="object-fit: cover; border-radius:8px;">
                        @elseif(file_exists($userImagePath))
                            <img src="{{ asset('uploads/user_images/'.$img) }}" width="50" height="50" style="object-fit: cover; border-radius:8px;">
                        @elseif(file_exists($supplierImagePath))
                            <img src="{{ asset('uploads/supplier/'.$img) }}" width="50" height="50" style="object-fit: cover; border-radius:8px;">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                  </td>
            </tr>
            <tr><th>City</th><td>{{ $supplier->city }}</td></tr>
            <tr><th>Region</th><td>{{ $supplier->region }}</td></tr>
            <tr><th>Address</th><td>{{ $supplier->address }}</td></tr>
            <tr><th>Phone</th><td>{{ $supplier->phone }}</td></tr>
            <tr><th>Mobile</th><td>{{ $supplier->mobile }}</td></tr>
            <tr><th>Email</th><td>{{ $supplier->email }}</td></tr>
           
            <tr><th>State Entity Registration</th><td>{{ $supplier->state_entity_registration }}</td></tr>
            <tr><th>Employer Identification Number</th><td>{{ $supplier->employer_identification_number }}</td></tr>
           
            <tr><th>Status</th>
                <td>
                    @if($supplier->status_id == 1)
                        Pending
                    @elseif($supplier->status_id == 2)
                        Approved
                    @else
                        Denied
                    @endif
                </td>
            </tr>
         
            <tr><th>Created At</th><td>{{ $supplier->created_at }}</td></tr>
            
            <tr><th>Enumerator Last Name</th><td>{{ $supplier->enumerator_last_name }}</td></tr>
            <tr><th>Enumerator First Name</th><td>{{ $supplier->enumerator_first_name }}</td></tr>
            <tr><th>Enumerator WhatsApp</th><td>{{ $supplier->enumerator_whatsapp }}</td></tr>
            <tr><th>Latitude</th><td>{{ $supplier->latitude }}</td></tr>
            <tr><th>Longitude</th><td>{{ $supplier->longitude }}</td></tr>
            <tr><th>Altitude</th><td>{{ $supplier->altitude }}</td></tr>
            <tr><th>Accuracy</th><td>{{ $supplier->accuracy }}</td></tr>
        </tbody>
    </table>
</div>

<a href="{{ route('admin.supplier.list-suppliers') }}" class="btn btn-secondary mb-3">Back to List</a>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
