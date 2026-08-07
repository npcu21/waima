<div class="form8 form-section form-container">
    <h5>Veterinary Products</h5>

    <form action="{{ route('veterinary_products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="form_type" value="veterinary_products">
        <input type="hidden" name="product_id" id="hidden_product_id" value="1">
        <input type="hidden" name="product_master_id" id="veterinary_product_master_id">
        <input type="hidden" name="created_by" value="{{ session('user_id') }}">
        <input type="hidden" name="supplier_id" id="supplier_id">
        <input type="hidden" name="agent_id" id="agent_id">

        <div class="row gy-3">

            <!-- ✅ PRODUCT NAME WITH SUGGESTION -->
            <div class="col-md-6 position-relative">
                <label class="form-label">Veterinary product name*</label>

                <input type="text"
                       class="form-control"
                       name="product_name"
                       id="veterinary_product_name"
                       autocomplete="off"
                       required>

                <!-- suggestion box -->
                <div id="veterinary_product_name_suggestions"
                     class="list-group position-absolute w-100"
                     style="z-index:999;"></div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Manufacturing laboratory</label>
                <input type="text" class="form-control" name="manufacturing_lab">
            </div>

            <div class="col-md-6">
                <label class="form-label">Active substance</label>
                <input type="text" class="form-control" name="active_substance">
            </div>

            <div class="col-md-6">
                <label class="form-label">Registration Number*</label>
                <input type="text" class="form-control" name="registration_number" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Therapeutic Class</label>
                <select class="form-select" name="therapeutic_class" required>
                    <option value="">Select</option>
                    <option>Pest Control</option>
                    <option>Antibiotics</option>
                    <option>Vaccines</option>
                    <option>Others</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Other</label>
                <input type="text" class="form-control" name="other_therapeutic_class">
            </div>

            <div class="col-md-6">
                <label class="form-label">Dosage</label>
                <input type="text" class="form-control" name="dosage">
            </div>

            <div class="col-md-6">
                <label class="form-label">Pharmaceutical form</label>
                <input type="text" class="form-control" name="pharmaceutical_form">
            </div>

            <div class="col-md-6">
                <label class="form-label">Route of administration</label>
                <input type="text" class="form-control" name="route_of_administration">
            </div>

            <div class="col-md-6">
                <label class="form-label">Targeted animals</label>
                <input type="text" class="form-control" name="targeted_animals">
            </div>

            <div class="col-md-6">
                <label class="form-label">Waiting period</label>
                <input type="text" class="form-control" name="waiting_period">
            </div>

            <div class="col-md-6">
                <label class="form-label">Expiry date</label>
                <input type="date" class="form-control" name="expiry_date">
            </div>

            <div class="col-md-6">
                <label class="form-label">Storage requirements</label>
                <input type="text" class="form-control" name="transport_storage_requirements">
            </div>

            <div class="col-md-6">
                <label class="form-label">Wholesale price*</label>
                <input type="number" step="0.01" class="form-control" name="wholesale_price" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Semi wholesale price*</label>
                <input type="number" step="0.01" class="form-control" name="semiwholesale_price" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Retail price*</label>
                <input type="number" step="0.01" class="form-control" name="retail_price" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Upload Image</label>
                <input type="file" name="otherRecommendationsPhoto" class="form-control">
            </div>

            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary">Save Veterinary Product</button>
            </div>

        </div>
    </form>
</div>