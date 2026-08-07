<form action="{{ route('mineral.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form2 form-section form-container">

        <input type="hidden" name="form_type" value="mineral_fertilizers">
        <input type="hidden" name="product_id" id="hidden_product_id" value="7">
        <input type="hidden" name="product_master_id" id="min_product_master_id">
        <input type="hidden" name="supplier_id" value="{{ $supplier_id ?? '' }}">
        <input type="hidden" name="agent_id" value="{{ $agent_id ?? '' }}">
        <input type="hidden" name="created_by" value="{{ session('admin_id') }}">

        <h5>Mineral Fertilizers</h5>

        <div class="row gy-3">

            <!-- ✅ Trade Name Suggestion Field -->
            <div class="col-md-6 position-relative">
                <label class="form-label">Trade Name *</label>
                <input type="text" id="min_trade_name" name="trade_name" class="form-control" autocomplete="off" required>

                <div id="min_trade_name_suggestions" class="list-group position-absolute w-100"></div>
            </div>

            @foreach($fields as $f)

                {{-- ❌ Duplicate Trade Name Remove --}}
                @if($f->name == 'trade_name')
                    @continue
                @endif

                @if($f->type == 'text')
                    <div class="col-md-6">
                        <label class="form-label">{{ $f->label }} @if($f->required)*@endif</label>
                        <input type="text" name="{{ $f->name }}" class="form-control"
                               @if($f->required) required @endif>
                    </div>

                @elseif($f->type == 'number')
                    <div class="col-md-6">
                        <label class="form-label">{{ $f->label }} @if($f->required)*@endif</label>
                        <input type="number" step="0.01" name="{{ $f->name }}" class="form-control"
                               @if($f->required) required @endif>
                    </div>

                @elseif($f->type == 'select')
                    <div class="col-md-6">
                        <label class="form-label d-block">{{ $f->label }} @if($f->required)*@endif</label>
                        @foreach(json_decode($f->options) as $option)
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" 
                                       name="{{ $f->name }}" value="{{ $option }}"
                                       @if($f->required) required @endif>
                                <label class="form-check-label">{{ $option }}</label>
                            </div>
                        @endforeach
                    </div>
                @endif

            @endforeach

            <!-- ✅ Image Upload -->
            <div class="col-md-6">
                <label class="form-label">Upload Image</label>
                <input type="file" name="otherRecommendationsPhoto" class="form-control" accept="image/*">
            </div>

        </div>

        <button type="submit" class="btn btn-primary mt-3">Save Mineral Fertilizer</button>
    </div>
</form>