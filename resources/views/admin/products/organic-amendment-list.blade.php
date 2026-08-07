@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Organic Amendments List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Form Type</th>
                <th>Organic Type</th>
                <th>Physical Form</th>
                <th>Trade Name</th>
                <th>Country Origin</th>
                <th>Bio Label</th>
                <th>N</th>
                <th>P2</th>
                <th>K2</th>
                <th>CaO</th>
                <th>MgO</th>
                <th>C/N Ratio</th>
                <th>Raw Material</th>
                <th>Raw Material Other</th>
                <th>Arsenic Content</th>
                <th>Wholesale Price</th>
                <th>Semi-wholesale Price</th>
                <th>Retail Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($organicAmendments as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->form_type }}</td>
                    <td>{{ $item->organic_type }}</td>
                    <td>{{ $item->physical_form }}</td>
                    <td>{{ $item->trade_name }}</td>
                    <td>{{ $item->country_origin }}</td>
                    <td>{{ $item->bio_label }}</td>
                    <td>{{ $item->n }}</td>
                    <td>{{ $item->p2 }}</td>
                    <td>{{ $item->k2 }}</td>
                    <td>{{ $item->cao }}</td>
                    <td>{{ $item->mgo }}</td>
                    <td>{{ $item->cn_ratio }}</td>
                    <td>{{ json_decode($item->raw_material) ? implode(', ', json_decode($item->raw_material)) : '' }}</td>
                    <td>{{ $item->raw_material_other }}</td>
                    <td>{{ $item->arsenic_content }}</td>
                    <td>{{ $item->wholesale_price }}</td>
                    <td>{{ $item->semiwholesale_price }}</td>
                    <td>{{ $item->retail_price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
