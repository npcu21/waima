@extends('admin.layouts.app')

@section('title', __('masteradmin.list_title'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="container-fluid p-0">

    @include('includes.navbar')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 p-4">

                <!-- Language Switch -->
                <div class="mb-3">
                    <form action="" method="GET">
                        <select name="lang" onchange="this.form.submit()" class="form-select w-auto">
                            <option value="en" {{ $lang == 'en' ? 'selected' : '' }}>English</option>
                            <option value="fr" {{ $lang == 'fr' ? 'selected' : '' }}>Français</option>
                        </select>
                    </form>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-4">{{ __('masteradmin.list_title') }}</h4>

                    <a href="{{ route('masteradmin.register') }}" class="btn btn-primary mb-4">
                        <i class="bi bi-plus-circle me-1"></i> 
                        {{ __('masteradmin.add_admin') }}
                    </a>
                </div>

                <div class="form-section">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('masteradmin.id') }}</th>
                                <th>{{ __('masteradmin.name') }}</th>
                                <th>{{ __('masteradmin.email') }}</th>
                                <th>{{ __('masteradmin.country') }}</th>
                                <th>{{ __('masteradmin.created_at') }}</th>
                                <th>{{ __('masteradmin.action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <td>{{ $admin->id }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        {{ $admin->country_id ? ($admin->country ? $admin->country->name : '-') : 'Regional' }}
                                    </td>
                                    <td>{{ $admin->created_at ? $admin->created_at->format('d/m/Y') : '-' }}</td>

                                    <td class="d-flex align-items-center gap-2">
                                        <a href="{{ route('masteradmin.edit', $admin->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i> 
                                            {{ __('masteradmin.edit') }}
                                        </a>

                                        <form action="{{ route('masteradmin.delete', $admin->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('{{ __('masteradmin.delete_confirm') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                {{ __('masteradmin.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>

            </div>
        </div>
    </div>

</div>

<style>
    body {
        background-color: #f8f9fa;
    }
    .table {
        background-color: #fff;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


@endsection
