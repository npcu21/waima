@extends('admin.layouts.app')

@section('title', __('agent.agent_details'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- Navbar -->
@include('includes.navbar')
<form method="GET" action="" class="d-flex ms-auto">
    <select name="lang" onchange="this.form.submit()" class="form-select form-select-sm">
        <option value="en" {{ session('lang') == 'en' ? 'selected' : '' }}>English</option>
        <option value="fr" {{ session('lang') == 'fr' ? 'selected' : '' }}>Français</option>
    </select>
</form>

<div class="container-fluid">

    <div class="row">
        <div class="col-lg-12 col-md-12 p-4">        

            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('agent.agent_details') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>{{ __('agent.agent_id') }}</th>
                                <td>{{ $agent->id }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('agent.full_name') }}</th>
                                <td>{{ $agent->name }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('agent.email') }}</th>
                                <td>{{ $agent->email }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('agent.username') }}</th>
                                <td>{{ $agent->username }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('agent.country') }}</th>
                                <td>{{ $agent->country_id ? \App\Models\Country::find($agent->country_id)->name : __('agent.n_a') }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('agent.status') }}</th>
                                <td>{{ $agent->status_id ? \App\Models\Status::find($agent->status_id)->name : __('agent.pending') }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('agent.created_at') }}</th>
                                <td>{{ $agent->created_at ? $agent->created_at->format('Y-m-d H:i') : __('agent.n_a') }}</td>
                            </tr>
                            @if(!empty($agent->image))
                            <tr>
                                <th>{{ __('agent.profile_image') }}</th>
                                <td>
                                    <img src="{{ asset('uploads/user_images/' . $agent->image) }}" alt="Profile Image" style="max-width: 200px; border-radius: 5px;">
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('admin.agent.status') }}" class="btn btn-secondary">
                    {{ __('agent.back_list') }}
                </a>

            </div>

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
