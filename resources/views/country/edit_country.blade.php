@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@include('includes.navbar')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 col-lg-12 p-4">

      <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="theme-color">{{ __('country.edit_country') }}</h4>

          <!-- 🌍 Language Switch -->
          <form method="GET" action="{{ route('country.edit', $country->id) }}">
              <select name="lang" class="form-select form-select-sm" onchange="this.form.submit()">
                  <option value="en" {{ $lang == 'en' ? 'selected' : '' }}>English</option>
                  <option value="fr" {{ $lang == 'fr' ? 'selected' : '' }}>Français</option>
              </select>
          </form>
      </div>

      @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
          </div>
      @endif

      <form action="{{ route('country.update', $country->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
              <label class="form-label">{{ __('country.name') }}</label>
              <input type="text" name="name" class="form-control" value="{{ $country->name }}" required>
          </div>

          <div class="mb-3">
              <label class="form-label">{{ __('country.code') }}</label>
              <input type="text" name="code" class="form-control" value="{{ $country->code }}">
          </div>

          <!-- <div class="mb-3">
              <label class="form-label">{{ __('country.language_id') }}</label>
              <input type="number" name="language_id" class="form-control" value="{{ $country->language_id }}">
          </div> -->

          <button type="submit" class="btn btn-primary">{{ __('country.update') }}</button>
          <a href="{{ route('country.list') }}" class="btn btn-secondary">{{ __('country.back') }}</a>
      </form>

    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
