@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')

<!-- ✅ Bootstrap & Custom CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">


<!-- ✅ Navbar -->
@include('includes.navbar')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 col-lg-12 p-4">
      <div class="preview-box mt-0">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="preview-title theme-color mb-0">{{ __('country.countries_list') }}</h3>

            <!-- 🌍 Language Switcher -->
            <form method="GET" action="{{ route('country.list') }}" class="me-3">
                <select name="lang" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="en" {{ $defaultLangId == 1 ? 'selected' : '' }}>English</option>
                    <option value="fr" {{ $defaultLangId == 2 ? 'selected' : '' }}>Français</option>
                </select>
            </form>

            <a href="{{ route('countries.create') }}" class="btn btn-primary">
                {{ __('country.add_country') }}
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('country.id') }}</th>
                    <th>{{ __('country.name') }}</th>
                    <th>{{ __('country.code') }}</th>
                    <th>{{ __('country.created_at') }}</th>
                    <th>{{ __('country.updated_at') }}</th>
                    <th>{{ __('country.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($countries as $country)
                <tr>
                    <td>{{ $country->id }}</td>
                    <td>{{ $country->name }}</td>
                    <td>{{ $country->code }}</td>
                    <td>{{ $country->created_at }}</td>
                    <td>{{ $country->updated_at }}</td>

                    <td>
                        <a href="{{ route('country.edit', $country->id) }}" class="btn btn-sm btn-warning">
                            {{ __('country.edit') }}
                        </a>

                        <form action="{{ route('country.delete', $country->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('country.confirm_delete') }}')">
                                {{ __('country.delete') }}
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
