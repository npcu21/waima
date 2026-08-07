@extends('admin.layouts.app')

@section('title', 'View Agent')

@section('content')

<link rel="stylesheet" href="{{ asset('css/style.css') }}">



<!-- Navbar -->
@include('includes.navbar')

<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12 col-md-12 p-4">        

            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Agent Details</h5>
                    
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $agent->id }}</td>
                            </tr>
                            <tr>
                                <th>Name:</th>
                                <td>{{ $agent->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $agent->email }}</td>
                            </tr>
                            <tr>
                                <th>Username:</th>
                                <td>{{ $agent->username }}</td>
                            </tr>
                            <tr>
                                <th>Country:</th>
                                <td>{{ $agent->country_id ? \App\Models\Country::find($agent->country_id)->name : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>{{ $agent->status_id ? \App\Models\Status::find($agent->status_id)->name : 'Pending' }}</td>
                            </tr>
                            <tr>
                                <th>Created At:</th>
                                <td>{{ $agent->created_at ? $agent->created_at->format('Y-m-d H:i') : '' }}</td>
                            </tr>
                            @if(!empty($agent->image))
                            <tr>
                                <th>Profile Image:</th>
                                <td>
                                    <img src="{{ asset('uploads/user_images/' . $agent->image) }}" alt="Profile Image" style="max-width: 200px; border-radius: 5px;">
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <a href="{{ route('admin.agent.status') }}" class="btn btn-secondary mt-3">
                Back to Agent List
            </a>

        </div>
    </div>
</div>

@endsection
