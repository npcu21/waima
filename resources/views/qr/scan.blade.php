@extends('admin.layouts.app')

@section('title', 'QR Scan Data')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-5">
    <div class="card shadow-sm p-4">
        <h3 class="mb-4">Record Data (Table: {{ $table }})</h3>

        @if($record)
            <div class="row gy-3">
                @foreach($record as $key => $value)
                    @php
                        $isImage = str_contains(strtolower($key), 'image') || str_contains(strtolower($key), 'photo') || str_contains(strtolower($key), 'qr');
                        $decodedImages = json_decode($value, true);
                        $images = is_array($decodedImages) ? $decodedImages : ($isImage && $value ? [$value] : []);
                    @endphp

                    <div class="col-md-4">
                        <label class="form-label fw-bold">{{ ucwords(str_replace('_',' ',$key)) }}:</label>
                        
                        @if(count($images) > 0)
                            @foreach($images as $img)
                                <img src="{{ asset($img) }}" class="img-fluid rounded border my-1" alt="{{ $key }}">
                            @endforeach
                        @else
                            <p class="form-control-plaintext">{{ $value ?? '—' }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Status --}}
            @if(isset($record['status_id']))
                <p class="mt-3">
                    Status:
                    <span class="badge 
                        @if(isset($statusText[$record['status_id']]))
                            @if($statusText[$record['status_id']] == 'Approved') bg-success
                            @elseif($statusText[$record['status_id']] == 'Pending') bg-warning text-dark
                            @elseif($statusText[$record['status_id']] == 'Denied') bg-danger
                            @else bg-secondary @endif
                        @else bg-secondary @endif">
                        {{ $statusText[$record['status_id']] ?? $record['status_id'] }}
                    </span>
                </p>
            @endif

        @else
            <p class="text-muted">No record found.</p>
        @endif

        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</div>

@endsection
