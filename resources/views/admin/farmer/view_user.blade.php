@extends('admin.layouts.app')

@section('title', __('farmer.view_farmer'))

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

@include('includes.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 p-4">

            <h4 class="mb-4">{{ __('farmer.farmer_details') }}</h4>
            
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ __('farmer.id') }}</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('farmer.name') }}</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('farmer.email') }}</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('farmer.user_type') }}</th>
                        <td>{{ $user->usertype->type_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('farmer.country') }}</th>
                        <td>{{ $user->country->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('farmer.status') }}</th>
                        <td>
                            @php
                                $statusName = \App\Models\Status::where('id', $user->status_id)->value('name') ?? 'Pending';
                            @endphp

                            <span class="badge 
                                @if($statusName == 'Pending') bg-warning
                                @elseif($statusName == 'Approved') bg-success
                                @elseif($statusName == 'Denied') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ __('farmer.' . strtolower($statusName)) }}
                            </span>
                        </td>
                    </tr>

                    @if($user->status_id == 3 && !empty($user->reject_message))
                    <tr>
                        <th>{{ __('farmer.rejection_reason') }}</th>
                        <td>{{ $user->reject_message }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <a href="{{ url('admin/users') }}" class="btn btn-secondary mt-3">{{ __('farmer.back_to_list') }}</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
