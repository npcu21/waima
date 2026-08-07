@extends('admin.layouts.app')

@section('title', 'Country Announcements')

@section('content')

@include('countryadmin.layouts.nav')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 p-4">

            <div class="card shadow-sm p-4">

                <h4 class="mb-4">Announcements (Your Country Only)</h4>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($announcements->count())
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>User Type</th>
                            <th>Country</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($announcements as $a)
                            <tr>
                                <td>{{ $a->id }}</td>
                                <td>{{ $a->title }}</td>

                                <!-- User Type Name -->
                                <td>
                                    {{ $a->userType->{'type_name'} ?? 'N/A' }}
                                </td>

                                <!-- Country Name -->
                                <td>
                                    {{ $a->country->{'name_en'} ?? $a->country->name ?? 'N/A' }}
                                </td>

                                <!-- Image Thumbnail -->
                             <td>
                                @if($a->image)
                                    <img src="{{ url($a->image) }}" alt="Image" width="80">
                                @else
                                    N/A
                                @endif
                            </td>


                                <td>{{ $a->status }}</td>
                                <td>{{ $a->created_at->format('d M Y') }}</td>

                                <!-- Actions -->
                                <td>
                                    <a href="{{ route('admin.announcement.countryedit', $a->id) }}" 
                                       class="btn btn-sm btn-primary mb-1">Edit</a>

                                    <form action="{{ route('admin.announcement.deletcountry', $a->id) }}" 
                                          method="POST" style="display:inline-block;" 
                                          onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mb-1">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @else
                    <div class="alert alert-info">
                        No announcements found for your country.
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection
