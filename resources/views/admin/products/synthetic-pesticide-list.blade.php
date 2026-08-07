@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Synthetic Pesticides List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Form Type</th>
                <th>Trade Name</th>
                <th>Active Ingredient</th>
                <th>Other Active Ingredient</th>
                <th>Formulation</th>
                <th>Registration Number</th>
                <th>Function</th>
                <th>Other Function</th>
                <th>Toxicological Class Number</th>
                <th>Approval Number</th>
                <th>Wholesale Price</th>
                <th>Semi-wholesale Price</th>
                <th>Retail Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesticides as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->form_type }}</td>
                    <td>{{ $item->trade_name }}</td>
                    <td>{{ $item->active_ingredient }}</td>
                    <td>{{ $item->other_active_ingredient }}</td>
                    <td>{{ $item->formulation }}</td>
                    <td>{{ $item->registration_number }}</td>
                    <td>{{ $item->function }}</td>
                    <td>{{ $item->other_function }}</td>
                    <td>{{ $item->toxicological_class_number }}</td>
                    <td>{{ $item->approval_number }}</td>
                    <td>{{ $item->wholesale_price }}</td>
                    <td>{{ $item->semiwholesale_price }}</td>
                    <td>{{ $item->retail_price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
