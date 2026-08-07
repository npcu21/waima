@extends('admin.layouts.app')

@section('title', 'View Farmer')

@section('content')
<!-- ✅ Bootstrap & Icons -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- ✅ Custom CSS -->
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- Navbar -->
@include('countryadmin.layouts.nav')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 p-4">

            <div>           
                <h4 class="mb-4">Farmer Details</h4>
                
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr><th>ID</th><td>{{ $user->id }}</td></tr>
                        <tr><th>Username:</th><td>{{ $user->username }}</td></tr>
                        <tr><th>Name:</th><td>{{ $user->name }}</td></tr>
                        <tr><th>Email:</th><td>{{ $user->email }}</td></tr>
                        <tr><th>User Type:</th><td>{{ $user->usertype->type_name ?? '-' }}</td></tr>
                        <tr><th>Country:</th><td>{{ $user->country->name ?? '-' }}</td></tr>
                        <tr><th>Status:</th><td>
                                @php
                                    $statusName = \App\Models\Status::where('id', $user->status_id)->value('name') ?? 'Pending';
                                @endphp

                                <span class="badge 
                                    @if($statusName == 'Pending') bg-warning
                                    @elseif($statusName == 'Approved') bg-success
                                    @elseif($statusName == 'Denied') bg-danger
                                    @else bg-secondary
                                    @endif">
                                    {{ $statusName }}
                                </span>
                            </td>
                        </tr>  

                        @if($user->status_id == 3 && !empty($user->reject_message))
                        <tr><th>Rejection Reason:</th><td>{{ $user->reject_message }}</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>

<a href="{{ url('admin/country/users') }}" class="btn btn-secondary mt-3">
    Back to List
</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
