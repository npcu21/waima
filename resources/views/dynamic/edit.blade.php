@extends('admin.layouts.app')

@section('title', 'Edit Dynamic Field')

@section('content')
<div class="container mt-4">
    <h2>Edit Field</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('dynamic.update', $field->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="label" class="form-label">Label</label>
            <input type="text" class="form-control" id="label" name="label" value="{{ $field->label }}" required>
        </div>

        <!-- Hidden Name Field -->
        <input type="hidden" name="name" value="{{ $field->name }}">

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="{{ $field->type }}">
        </div>

        <div class="mb-3">
            <label for="options" class="form-label">Options</label>
            <textarea class="form-control" id="options" name="options">{{ $field->options }}</textarea>
        </div>

        <div class="mb-3">
            <label for="required" class="form-label">Required</label>
            <select class="form-select" id="required" name="required">
                <option value="0" {{ $field->required == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ $field->required == 1 ? 'selected' : '' }}>Yes</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Field</button>
        <a href="{{ route('dynamic.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
