<!DOCTYPE html>
<html>
<head>
    <title>Upload Image</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { margin-bottom: 20px; }
        input[type="text"], input[type="file"] { padding: 5px; width: 300px; }
        button { padding: 8px 16px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #45a049; }
        .message { margin-bottom: 20px; padding: 10px; border-radius: 5px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Upload Image</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="message success">
            {{ session('success') }}
            @if(session('image_url'))
                <br>
                <a href="{{ session('image_url') }}" target="_blank">View Uploaded Image</a>
            @endif
        </div>
    @endif

    <!-- Error Message -->
    @if($errors->any())
        <div class="message error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Upload Form -->
    <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label>Name:</label>
        <input type="text" name="name" required>
    </div>

    <div>
        <label>Description:</label>
        <input type="text" name="description">
    </div>

    <div>
        <label>Images:</label>
        <input type="file" name="images[]" multiple required>
    </div>

    <button type="submit">Upload</button>
</form>


    <hr>
    <a href="{{ route('images.index') }}">View All Images</a>
</body>
</html>
