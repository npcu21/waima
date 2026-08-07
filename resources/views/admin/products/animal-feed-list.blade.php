@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h2>Animal Feeds List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type of Feed</th>
                <th>Physical Form</th>
                <th>DM</th>
                <th>Energy</th>
                <th>CP</th>
                <th>SP</th>
                <th>FS</th>
                <th>Wholesale Price</th>
                <th>Semi Wholesale Price</th>
                <th>Retail Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feeds as $feed)
                <tr>
                    <td>{{ $feed->id }}</td>
                    <td>{{ $feed->Typeoffeed }}</td>
                    <td>{{ $feed->afPhysicalform }}</td>
                    <td>{{ $feed->afdm }}</td>
                    <td>{{ $feed->afEnergy }}</td>
                    <td>{{ $feed->afcp }}</td>
                    <td>{{ $feed->afsp }}</td>
                    <td>{{ $feed->affs }}</td>
                    <td>{{ $feed->afWholesalePrice }}</td>
                    <td>{{ $feed->afsemiwholesalePrice }}</td>
                    <td>{{ $feed->afretailPrice }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
