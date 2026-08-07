@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Mineral Fertilizers List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fertilizer Type</th>
                <th>Form Type</th>
                <th>Fertilizer Registration</th>
                <th>Physical Form</th>
                <th>Trade Name</th>
                <th>N</th>
                <th>P2</th>
                <th>K2</th>
                <th>Zn</th>
                <th>Ca</th>
                <th>Mg</th>
                <th>S</th>
                <th>B</th>
                <th>Mo</th>
                <th>Application Rate</th>
                <th>Wholesale Price</th>
                <th>Semi-wholesale Price</th>
                <th>Retail Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fertilizers as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->fertilizer_type }}</td>
                    <td>{{ $item->form_type }}</td>
                    <td>{{ $item->fertilizer_registration }}</td>
                    <td>{{ $item->physical_form }}</td>
                    <td>{{ $item->trade_name }}</td>
                    <td>{{ $item->n }}</td>
                    <td>{{ $item->p2 }}</td>
                    <td>{{ $item->k2 }}</td>
                    <td>{{ $item->zn }}</td>
                    <td>{{ $item->ca }}</td>
                    <td>{{ $item->mg }}</td>
                    <td>{{ $item->s }}</td>
                    <td>{{ $item->b }}</td>
                    <td>{{ $item->mo }}</td>
                    <td>{{ $item->application_rate }}</td>
                    <td>{{ $item->fertilizer_wholesale_price }}</td>
                    <td>{{ $item->fertilizer_semiwholesale_price }}</td>
                    <td>{{ $item->fertilizer_retail_price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
