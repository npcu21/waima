@extends('admin.layouts.app')

@section('title', __('dashboard.admin_dashboard'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- Navbar -->
@include('includes.navbar')

<form method="GET" action="{{ route('admin.list-announcements') }}" class="mb-3">
    <div class="row g-2 align-items-center">
        <div class="col-auto">
            <select name="country_id" class="form-select">
                <option value="">{{ __('dashboard.select_country') }}</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ ($selectedCountry == $country->id) ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">{{ __('dashboard.filter') }}</button>
        </div>
    </div>
</form>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 p-4">

            <div class="preview-box mt-0">
                <h3 class="preview-title theme-color mb-4">{{ __('dashboard.announcement_list') }}</h3>

                <div class="table-responsive mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">{{ __('dashboard.recent_announcements') }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('dashboard.id') }}</th>
                                            <th>{{ __('dashboard.title') }}</th>
                                            <th>{{ __('dashboard.description') }}</th>
                                            <th>{{ __('dashboard.image') }}</th>
                                            <th>{{ __('dashboard.user_type') }}</th>
                                            <th>Currency</th>
                                            <th>{{ __('dashboard.created_at') }}</th>
                                            <th>{{ __('dashboard.actions') }}</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($announcements as $announcement)
                                            <tr>
                                                <td>{{ $announcement->id }}</td>
                                                <td>{{ $announcement->title }}</td>
                                                <td>{{ $announcement->description }}</td>
                                              <td>
    @if($announcement->image)
        <img src="{{ asset($announcement->image) }}" 
             alt="Announcement Image" 
             style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
    @else
        -
    @endif
</td>
<td>

@php
$userTypes = json_decode($announcement->user_type_id, true);

// agar single value ho to usko array bana do
if (!is_array($userTypes)) {
    $userTypes = [$announcement->user_type_id];
}
@endphp

@if(!empty($userTypes))

    @foreach($userTypes as $typeId)

        <span class="badge bg-primary">
            {{ $userTypeNames[$typeId] ?? '-' }}
        </span>

    @endforeach

@else

    -

@endif

</td>
<td>

@php
$currencies = json_decode($announcement->currency, true);

if (!is_array($currencies)) {
    $currencies = [$announcement->currency];
}
@endphp

@if(!empty($currencies))

    @foreach($currencies as $currency)

        <span class="badge bg-success">
            {{ $currency }}
        </span>

    @endforeach

@else

    -

@endif

</td>

                                                <!-- <td>{{ $userTypeNames[$announcement->user_type_id] ?? '-' }}</td> -->
                                                <td>{{ $announcement->created_at->format('Y-m-d') }}</td>
                                                <td class="d-flex gap-1">
                                                    <a href="{{ route('admin.view-announcement', $announcement->id) }}" class="btn btn-sm btn-info">
        {{ __('dashboard.view') }}
    </a>
                                                    <a href="{{ route('admin.edit-announcement', $announcement->id) }}" class="btn btn-sm btn-warning">{{ __('dashboard.edit') }}</a>

                                                    <form action="{{ route('admin.delete-announcement', $announcement->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('dashboard.confirm_delete') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">{{ __('dashboard.delete') }}</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">{{ __('dashboard.no_announcements_found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
