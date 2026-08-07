@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Seed Forms List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Form Type</th>
                <th>Crop Name</th>
                <th>Variety Name</th>
                <th>Breeder Name</th>
                <th>Country Origin</th>
                <th>Registration Number</th>
                <th>Variety Type</th>
                <th>Seed Category</th>
                <th>Precocity</th>
                <th>Fruit Color</th>
                <th>Fruit Shape</th>
                <th>Leaf Length</th>
                <th>Leaf Color</th>
                <th>Plant Height</th>
                <th>Plant Habit</th>
                <th>Biotic Resistance</th>
                <th>Biotic Resistance 1</th>
                <th>Inherent Nutritional Value</th>
                <th>Other</th>
                <th>Yield</th>
                <th>Other Recommendations</th>
                <th>Other Recommendations Photo</th>
                <th>Wholesale Price</th>
                <th>Semi-wholesale Price</th>
                <th>Retail Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($seedForms as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->form_type }}</td>
                    <td>{{ $item->cropName }}</td>
                    <td>{{ $item->verityName }}</td>
                    <td>{{ $item->breederName }}</td>
                    <td>{{ $item->countryOrigin }}</td>
                    <td>{{ $item->registrationNumber }}</td>
                    <td>{{ $item->varietyType }}</td>
                    <td>{{ $item->seedCategory }}</td>
                    <td>{{ $item->precocity }}</td>
                    <td>{{ $item->fruitColor }}</td>
                    <td>{{ $item->fruitShape }}</td>
                    <td>{{ $item->leafLength }}</td>
                    <td>{{ $item->leafColor }}</td>
                    <td>{{ $item->plantHeight }}</td>
                    <td>{{ $item->plantHabit }}</td>
                    <td>{{ $item->bioticResistance }}</td>
                    <td>{{ $item->bioticResistance1 }}</td>
                    <td>{{ $item->InherentNutritionalValue }}</td>
                    <td>{{ $item->other }}</td>
                    <td>{{ $item->yield }}</td>
                    <td>{{ $item->otherRecommendations }}</td>
                    <td>
                        @if($item->otherRecommendationsPhoto)
                            <img src="{{ asset('uploads/seeds/'.$item->otherRecommendationsPhoto) }}" width="100">
                        @endif
                    </td>
                    <td>{{ $item->wholesalePrice }}</td>
                    <td>{{ $item->semiwholesalePrice }}</td>
                    <td>{{ $item->retailPrice }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
