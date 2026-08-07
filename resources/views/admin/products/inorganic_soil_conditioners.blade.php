<div class="form5 form-section form-container" style="display: block;">
    <h5>Inorganic Soil Conditioners</h5>

    <form action="{{ route('inorganic_soil_conditioners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="form_type" value="inorganic_soil_conditioners">
        <input type="hidden" name="product_id" id="hidden_product_id" value="4">
        <input type="hidden" name="created_by" value="{{ session('admin_id') }}">
        <input type="hidden" name="supplier_id" id="supplier_id" value="">
        <input type="hidden" name="agent_id" id="agent_id" value="">

        <div class="row gy-3">

            <!-- ✅ TRADE NAME WITH SUGGESTION -->
            <div class="col-md-6 position-relative">
                <label class="form-label">Trade Name *</label>
                <input type="text" id="inorganic_trade_name" name="trade_name"
                       class="form-control" autocomplete="off" required>

                <!-- hidden for ID -->
                <input type="hidden" name="product_master_id" id="inorganic_product_master_id">

                <!-- suggestion box -->
                <div id="inorganic_trade_name_suggestions"
                     class="list-group position-absolute w-100"></div>
            </div>

            <!-- ✅ DYNAMIC FIELDS -->
            @foreach(\App\Models\InorganicSoilConditionerField::all() as $f)

                {{-- ❌ SKIP TRADE NAME (already added above) --}}
                @if($f->name == 'trade_name')
                    @continue
                @endif

                @if($f->type == 'text')
                    <div class="col-md-6">
                        <label class="form-label">
                            {{ $f->label }} @if($f->required)*@endif
                        </label>
                        <input type="text" name="{{ $f->name }}" class="form-control"
                               @if($f->required) required @endif>
                    </div>

                @elseif($f->type == 'number')
                    <div class="col-md-6">
                        <label class="form-label">
                            {{ $f->label }} @if($f->required)*@endif
                        </label>
                        <input type="number" step="0.01" name="{{ $f->name }}" class="form-control"
                               @if($f->required) required @endif>
                    </div>

                @elseif($f->type == 'select')
                    <div class="col-md-6">
                        <label class="form-label d-block">
                            {{ $f->label }} @if($f->required)*@endif
                        </label>

                        @foreach(json_decode($f->options) as $opt)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                       name="{{ $f->name }}" value="{{ $opt }}"
                                       @if($f->required) required @endif>
                                <label class="form-check-label">{{ $opt }}</label>
                            </div>
                        @endforeach
                    </div>
                @endif

            @endforeach

            <!-- ✅ IMAGE -->
            <div class="col-md-6">
                <label class="form-label">Upload Image</label>
                <input type="file" name="otherRecommendationsPhoto"
                       class="form-control" accept="image/*">
            </div>

            <!-- ✅ SUBMIT -->
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary">
                    Save Inorganic Soil Conditioner
                </button>
            </div>

        </div>
    </form>
</div>