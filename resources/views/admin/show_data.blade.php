<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<div class="container mt-4">
    <h3 class="mb-4 text-capitalize">{{ str_replace('_', ' ', $table) }} Data</h3>

    <a href="{{ route('masteradmin.dashboard') }}" class="btn btn-secondary mb-3">← Back to Dashboard</a>

    @if($data->isEmpty())
        <div class="alert alert-info">No data found in {{ $table }} table.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    @foreach(array_keys((array)$data->first()) as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr>
                        @foreach((array)$row as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</body>
</html>
