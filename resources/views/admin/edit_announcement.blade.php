@extends('admin.layouts.app')

@section('title', __('dashboard.dashboard'))

@section('content')
<!-- ✅ Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">


 <!-- Navbar -->
    @include('includes.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 p-4">        
            <h4 class="mb-4">{{ __('dashboard.edit_announcement') }}</h4>

            <div class="form-section">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.update-announcement', $announcement->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="col-md-6">
                        <label for="title" class="form-label">{{ __('dashboard.title') }}*</label>
                        <input type="text" name="title" id="title" class="form-control" 
                               placeholder="{{ __('dashboard.enter_title') }}"
                               value="{{ old('title', $announcement->title) }}" required>
                        @error('title') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- User Type -->
                    <div class="col-md-6">
                        <label for="user_type_id" class="form-label">{{ __('dashboard.user_type') }}*</label>
                        <select name="user_type_id" id="user_type_id" class="form-select" required>
                            <option value="" disabled>{{ __('dashboard.select_user_type') }}</option>
                            @foreach($usertypes as $type)
                                <option value="{{ $type->id }}" 
                                    {{ old('user_type_id', $announcement->user_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $userTypeNames[$selectedLang][$type->id] ?? 'Type '.$type->id }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_type_id') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label for="description" class="form-label">{{ __('dashboard.description') }}*</label>
                        <textarea name="description" id="description" rows="5" class="form-control" 
                                  placeholder="{{ __('dashboard.enter_description') }}" required>{{ old('description', $announcement->description) }}</textarea>
                        @error('description') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label for="status" class="form-label">{{ __('dashboard.status') }}*</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="Active" {{ old('status', $announcement->status) == 'Active' ? 'selected' : '' }}>{{ __('dashboard.active') }}</option>
                            <option value="Inactive" {{ old('status', $announcement->status) == 'Inactive' ? 'selected' : '' }}>{{ __('dashboard.inactive') }}</option>
                        </select>
                        @error('status') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 mt-3">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-50">{{ __('dashboard.update_announcement') }}</button>
                        </div>            
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
