@extends('admin.layouts.app')

@section('title', __('dashboard.view_announcement'))

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<!-- Navbar -->
@include('includes.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 p-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('dashboard.view_announcement') }}</h5>
                    
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>{{ __('dashboard.id') }}</th>
                            <td>{{ $announcement->id }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('dashboard.title') }}</th>
                            <td>{{ $announcement->title }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('dashboard.description') }}</th>
                            <td>{{ $announcement->description }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('dashboard.user_type') }}</th>
                            <td>{{ $userTypeName }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('dashboard.created_at') }}</th>
                            <td>{{ $announcement->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('dashboard.image') }}</th>
                            <td>
                                @if($announcement->image)
                                    <img src="{{ asset('uploads/announcements/' . $announcement->image) }}" 
                                         alt="Announcement Image" 
                                         style="max-width: 300px; border-radius: 5px;">
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
