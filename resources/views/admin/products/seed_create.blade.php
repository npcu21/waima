<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    


@section('content')
<div class="container mt-4">
    <h2>Add New Seed</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('seed.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Seed Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="language_id" class="form-label">Language</label>
            <select name="language_id" id="language_id" class="form-control">
                <option value="1" selected>English</option>
                @foreach($languages as $lang)
                    <option value="{{ $lang->id }}">{{ $lang->lang_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="related_table_id" class="form-label">Related Table ID (optional)</label>
            <input type="number" name="related_table_id" class="form-control" id="related_table_id" value="{{ old('related_table_id') }}">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Seed Image (optional)</label>
            <input type="file" name="image" class="form-control" id="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Save Seed</button>
    </form>
</div>
</body>
</html>