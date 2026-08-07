@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Veterinary Products List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Form Type</th>
                <th>Product Name</th>
                <th>Manufacturing Lab</th>
                <th>Active Substance</th>
                <th>Registration Number</th>
                <th>Therapeutic Class</th>
                <th>Other Therapeutic Class</th>
                <th>Dosage</th>
                <th>Pharmaceutical Form</th>
                <th>Route of Administration</th>
                <th>Targeted Animals</th>
                <th>Waiting Period</th>
                <th>Expiry Date</th>
                <th>Transport/Storage Requirements</th>
                <th>Wholesale Price</th>
                <th>Semi-wholesale Price</th>
                <th>Retail Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($veterinaryProducts as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->form_type }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->manufacturing_lab }}</td>
                    <td>{{ $item->active_substance }}</td>
                    <td>{{ $item->registration_number }}</td>
                    <td>{{ $item->therapeutic_class }}</td>
                    <td>{{ $item->other_therapeutic_class }}</td>
                    <td>{{ $item->dosage }}</td>
                    <td>{{ $item->pharmaceutical_form }}</td>
                    <td>{{ $item->route_of_administration }}</td>
                    <td>{{ $item->targeted_animals }}</td>
                    <td>{{ $item->waiting_period }}</td>
                    <td>{{ $item->expiry_date }}</td>
                    <td>{{ $item->transport_storage_requirements }}</td>
                    <td>{{ $item->wholesale_price }}</td>
                    <td>{{ $item->semiwholesale_price }}</td>
                    <td>{{ $item->retail_price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
