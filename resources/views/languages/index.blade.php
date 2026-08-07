@extends('admin.layouts.app')

@section('title', 'Languages List')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<!-- Navbar -->
@include('includes.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 p-4">

        

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Languages List</h4>
                <a href="{{ route('languages.create') }}" class="btn theme-outline py-2">
                    <i class="bi bi-plus-circle me-1"></i> Add Language
                </a>
            </div>

            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <div>
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Lang Code</th>
                            <th>Lang Name</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($languages as $lang)
                            <tr>
                                <td>{{ $lang->id }}</td>
                                <td>{{ $lang->lang_code }}</td>
                                <td>{{ $lang->lang_name }}</td>
                                <td>{{ $lang->created_at }}</td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('languages.edit', $lang->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('languages.destroy', $lang->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Delete
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

@endsection
