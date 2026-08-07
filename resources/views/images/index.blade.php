<!DOCTYPE html>
<html>
<head>
    <title>All Images</title>
</head>
<body>
    <h1>All Images</h1>

    @foreach($images as $image)
        <div style="margin-bottom:20px;">
            <strong>{{ $image->name }}</strong><br>
            <img src="data:image/png;base64,{{ base64_encode($image->image_data) }}" width="200">
        </div>
    @endforeach

    <a href="{{ route('images.create') }}">Upload New Image</a>
</body>
</html>
