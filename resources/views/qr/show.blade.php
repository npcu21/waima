<!DOCTYPE html>
<html>
<head>
    <title>QR Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="card p-4 shadow">

        <h3 class="mb-4 text-capitalize">
            {{ str_replace('_',' ', $typeSlug ?? $dbTable) }} — ID: {{ $record['id'] }}
        </h3>

        {{-- QR Code --}}
        @if(!empty($record['qr_code_path']))
            <div class="mb-4 text-center">
                <img src="{{ asset($record['qr_code_path']) }}" style="max-height:150px">
            </div>
        @endif

        <div class="row gy-3">
            @foreach($record as $key => $value)
                @continue(in_array($key, ['id', 'created_at', 'updated_at', 'qr_code_path'])) {{-- skip these --}}
                @if(!empty($value))
                    <div class="col-md-4">
                        <strong>{{ ucwords(str_replace('_',' ',$key)) }}:</strong><br>
                        {{ $value }}
                    </div>
                @endif
            @endforeach
        </div>

    </div>
</div>

</body>
</html>
