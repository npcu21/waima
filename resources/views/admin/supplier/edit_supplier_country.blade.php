<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Supplier - Admin WAIMA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-light">

 <!-- Navbar -->
@include('countryadmin.layouts.nav')
    
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 p-4">
    <div class="card shadow-sm p-4">

    
        
    <h3 class="mb-4">{{ __('supplier.edit_supplier') }}</h3>

<form action="{{ route('supplier.update.country', $supplier->id) }}" 
      method="POST" enctype="multipart/form-data">

    @csrf




        <!-- ✅ Supplier Information -->
        <div class="form-section mb-4">
            <h5>{{ __('supplier.supplier_information') }}</h5>
            <div class="row gy-3">

                <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.company_name') }}*</label>
                    <input type="text" name="company_name" class="form-control"
                           value="{{ $supplier->company_name }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.manager') }}*</label>
                    <input type="text" name="manager_name" class="form-control"
                           value="{{ $supplier->manager_name }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.position') }}</label>
                    <input type="text" name="position" class="form-control" value="{{ $supplier->position }}">
                </div>

                <!-- <div class="col-md-6">
                    <label class="form-label">Profile Image</label>
                    <input type="file" name="image" class="form-control">

                    @if($supplier->image)
                        <img src="{{ asset('uploads/supplier/'.$supplier->image) }}"
                             class="mt-2 rounded" width="80">
                    @endif
                </div> -->
                <div class="col-md-6">
    <label class="form-label">{{ __('supplier.profile_image') }}</label>
    <input type="file" name="image" class="form-control">

    @if($supplier->image)
        @php
            $img = $supplier->image;
            $supplierImagePath = public_path('uploads/supplier/'.$img);
            $userImagePath = public_path('uploads/user_images/'.$img);
        @endphp

        @if(file_exists($supplierImagePath))
            <img src="{{ asset('uploads/supplier/'.$img) }}" class="mt-2 rounded" width="80">
        @elseif(file_exists($userImagePath))
            <img src="{{ asset('uploads/user_images/'.$img) }}" class="mt-2 rounded" width="80">
        @else
            <span class="text-muted mt-2 d-block">{{ __('supplier.no_image') }}</span>
        @endif
    @endif
</div>

               
               <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.status') }}</label>
                    <select name="status_id" class="form-select" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ $supplier->status_id == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


            </div>
        </div>

        <!-- ✅ Location Section -->
        <div class="form-section mb-4">
            <h5>{{ __('supplier.location') }}</h5>
            <div class="row gy-3">

                <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.city') }}*</label>
                    <input type="text" class="form-control" name="city" value="{{ $supplier->city }}" required>
                </div>

              <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.region') }}*</label>
                    @php
                        $selectedRegions = json_decode($supplier->region) ?? [];
                    @endphp
                    <select name="region[]" class="form-select" multiple required>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ in_array($region->id, $selectedRegions) ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.country') }}*</label>
                    <select name="country_id" class="form-select" required>
                        <option value="">-- Select Country --</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ $supplier->country_id == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.address') }}*</label>
                    <input type="text" class="form-control" name="address" value="{{ $supplier->address }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.phone') }}*</label>
                    <input type="text" class="form-control" name="phone" value="{{ $supplier->phone }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.mobile') }}*</label>
                    <input type="text" class="form-control" name="mobile" value="{{ $supplier->mobile }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.email') }}*</label>
                    <input type="email" class="form-control" name="email" value="{{ $supplier->email }}" required>
                </div>

                <!-- ✅ Added Missing Backend Fields -->
                <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.employer_identification_number') }}</label>
                    <input type="text" class="form-control" name="employer_identification_number"
                           value="{{ $supplier->employer_identification_number }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.state_entity_registration') }}</label>
                    <input type="text" class="form-control" name="state_entity_registration"
                           value="{{ $supplier->state_entity_registration }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.latitude') }}</label>
                    <input type="text" class="form-control" name="latitude" value="{{ $supplier->latitude }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('supplier.longitude') }}</label>
                    <input type="text" class="form-control" name="longitude" value="{{ $supplier->longitude }}">
                </div>
            </div>
        </div>

        <!-- ✅ Submit -->
        <button type="submit" class="btn btn-success">{{ __('supplier.update_supplier') }}</button>
       <a href="{{ url('admin/suppliers') }}" class="btn btn-secondary">{{ __('supplier.back') }}</a>

    </form>
</div>
</div>

</div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>
