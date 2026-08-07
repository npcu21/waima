@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <h3>🌾 Seed Translations</h3>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Original Name</th>
                @foreach($languages as $lang)
                    <th>{{ $lang->lang_name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($translatedSeeds as $seed)
                <tr>
                    <td>{{ $seed['id'] }}</td>
                    <td>{{ $seed['original_name'] }}</td>
                    @foreach($languages as $lang)
                        <td>{{ $seed['translations'][$lang->lang_name] ?? $seed['original_name'] }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
