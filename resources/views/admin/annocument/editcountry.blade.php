@extends('admin.layouts.app')

@section('title', 'Edit Announcement')

@section('content')

@include('includes.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2 p-4">
            <div class="card shadow-sm p-4">
                <h4 class="mb-4">Edit Announcement</h4>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.announcement.updatecountry', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Title*</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $announcement->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $announcement->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">User Type*</label>
                        <select name="user_type_id" class="form-select" required>
                            <option value="">Select User Type</option>
                            @foreach($usertypes as $type)
                                <option value="{{ $type->id }}" 
                                    {{ old('user_type_id', $announcement->user_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->type_name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status*</label>
                        <select name="status" class="form-select" required>
                            <option value="Active" {{ $announcement->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $announcement->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                   <div class="mb-3">
    <label class="form-label">Image</label><br>
    @if($announcement->image)
        {{-- Image ka correct path --}}
        <img src="{{ url($announcement->image) }}" alt="Image" width="100" class="mb-2">
    @endif
    <input type="file" name="image" class="form-control">
    <small class="text-muted">Leave empty if you do not want to change the image.</small>
</div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Announcement</button>
                        <a href="{{ route('admin.announcement.countrylist') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
