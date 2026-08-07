@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Inorganic Soil Conditioners List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Form Type</th>
                <th>Conditioner Type</th>
                <th>Physical Form</th>
                <th>Trade Name</th>
                <th>Raw Material</th>
                <th>Other</th>
                <th>Function</th>
                <th>Wholesale Price</th>
                <th>Semi-wholesale Price</th>
                <th>Retail Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($conditioners as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->form_type }}</td>
                    <td>{{ $item->conditioner_type }}</td>
                    <td>{{ $item->physical_form }}</td>
                    <td>{{ $item->trade_name }}</td>
                    <td>{{ $item->raw_material }}</td>
                    <td>{{ $item->other }}</td>
                    <td>{{ $item->function }}</td>
                    <td>{{ $item->wholesale_price }}</td>
                    <td>{{ $item->semiwholesale_price }}</td>
                    <td>{{ $item->retail_price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
