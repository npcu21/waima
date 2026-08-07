@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Bio-Stimulant List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Trade Name</th>
                <th>Physical Form</th>
                <th>Bio-Stimulant Product</th>
                <th>Re-registration</th>
                <th>N</th>
                <th>P2</th>
                <th>K2</th>
                <th>Zn</th>
                <th>Ca</th>
                <th>Mg</th>
                <th>S</th>
                <th>B</th>
                <th>Mo</th>
                <th>Action Mode</th>
                <th>Wholesale Price</th>
                <th>Semi-wholesale Price</th>
                <th>Retail Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bioStimulants as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->trade_name }}</td>
                    <td>{{ $item->physical_form }}</td>
                    <td>{{ $item->biostimulant_product }}</td>
                    <td>{{ $item->re_registration }}</td>
                    <td>{{ $item->n }}</td>
                    <td>{{ $item->p2 }}</td>
                    <td>{{ $item->k2 }}</td>
                    <td>{{ $item->zn }}</td>
                    <td>{{ $item->ca }}</td>
                    <td>{{ $item->mg }}</td>
                    <td>{{ $item->s }}</td>
                    <td>{{ $item->b }}</td>
                    <td>{{ $item->mo }}</td>
                    <td>{{ $item->action_mode }}</td>
                    <td>{{ $item->wholesale_price }}</td>
                    <td>{{ $item->semiwholesale_price }}</td>
                    <td>{{ $item->retail_price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
