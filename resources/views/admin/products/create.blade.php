<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<div class="container mt-4">
    <h2 class="mb-4">Add New Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There are some issues with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Crop Name</label>
                <input type="text" name="crop_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Variety Name</label>
                <input type="text" name="variety_name" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Breeder Name</label>
                <input type="text" name="breeder_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Country of Origin</label>
                <input type="text" name="country_origin" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Registration Number</label>
                <input type="text" name="registration_number" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Variety Type</label>
                <input type="text" name="variety_type" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Seed Category</label>
            <select name="seed_category" class="form-select">
                <option value="">-- Select Category --</option>
                <option value="Veterinary Products">Veterinary Products</option>
                <option value="Animal Feed">Animal Feed</option>
                <option value="Chemical Pesticides">Chemical Pesticides</option>
                <option value="Inorganic Soil Conditioners">Inorganic Soil Conditioners</option>
                <option value="Biostimulants">Biostimulants</option>
                <option value="Organic Amendments">Organic Amendments</option>
                <option value="Mineral Fertilizers">Mineral Fertilizers</option>
                <option value="Seeds">Seeds</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Other Recommendations</label>
            <textarea name="other_recommendations" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Photo</label>
            <input type="file" name="other_recommendations_photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
