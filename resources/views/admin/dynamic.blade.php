@extends('admin.layouts.app')

@section('title', 'Dynamic Fields')

@section('content')
<div class="container mt-4">
    <h3>Seed Fields List</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product ID</th>
                <th>Language ID</th>
                <th>Label</th>
                <th>Name</th>
                <th>Type</th>
                <th>Required</th>
                <th>Form Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fields as $field)
            <tr>
                <td>{{ $field->id }}</td>
                <td>{{ $field->product_id }}</td>
                <td>{{ $field->language_id }}</td>
                <td>{{ $field->label }}</td>
                <td>{{ $field->name }}</td>
                <td>{{ $field->type }}</td>
                <td>{{ $field->required }}</td>
                <td>{{ $field->form_type }}</td>
                <td>
                    <a href="{{ route('admin.dynamic.edit', $field->id) }}" class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
