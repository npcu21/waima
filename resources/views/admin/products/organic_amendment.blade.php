<form action="{{ route('organic.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="form3 form-section form-container">
    <h5>Organic Amendment</h5>

    <input type="hidden" name="form_type" value="organic_amendment">
    <input type="hidden" name="product_id" value="6">
    <input type="hidden" name="created_by" value="{{ session('user_id') }}">
    <input type="hidden" name="supplier_id" id="supplier_id" value="{{ old('supplier_id') }}">
    <input type="hidden" name="agent_id" id="agent_id" value="{{ old('agent_id') }}">

    <!-- ✅ NEW: product_master_id (important) -->
    <input type="hidden" name="product_master_id" id="organic_product_master_id">

    <div class="row gy-3">

        @foreach($fields as $field)

            {{-- ✅ TRADE NAME SPECIAL (Suggestion enabled) --}}
            @if($field->name == 'trade_name')
                <div class="col-md-6 position-relative">
                    <label class="form-label">
                        {{ $field->label }} 
                        @if($field->is_required == 1)*@endif
                    </label>

                    <input type="text"
                        id="organic_trade_name"
                        name="trade_name"
                        class="form-control"
                        autocomplete="off"
                        placeholder="{{ $field->placeholder }}">

                    <div id="organic_trade_name_suggestions"
                         class="list-group position-absolute w-100"></div>
                </div>

            @else

                <div class="col-md-6">

                    <label class="form-label">
                        {{ $field->label }} 
                        @if($field->is_required == 1)*@endif
                    </label>

                    {{-- Normal Fields --}}
                    @if($field->type == 'text')
                        <input type="text" 
                            name="{{ $field->name }}" 
                            class="form-control"
                            placeholder="{{ $field->placeholder }}">
                    
                    @elseif($field->type == 'number')
                        <input type="number" 
                            name="{{ $field->name }}" 
                            class="form-control"
                            placeholder="{{ $field->placeholder }}">

                    @elseif($field->type == 'textarea')
                        <textarea name="{{ $field->name }}" class="form-control" rows="2"
                            placeholder="{{ $field->placeholder }}"></textarea>

                    @elseif($field->type == 'radio')
                        @foreach(json_decode($field->options) as $opt)
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" 
                                    name="{{ $field->name }}" value="{{ $opt }}">
                                <label class="form-check-label">{{ $opt }}</label>
                            </div>
                        @endforeach

                    @elseif($field->type == 'checkbox')
                        @foreach(json_decode($field->options) as $opt)
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" 
                                    name="{{ $field->name }}[]" value="{{ $opt }}">
                                <label class="form-check-label">{{ $opt }}</label>
                            </div>
                        @endforeach

                    @elseif($field->type == 'select')
                        <select class="form-control" name="{{ $field->name }}">
                            <option value="">Select</option>
                            @foreach(json_decode($field->options) as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                    @endif

                </div>

            @endif

        @endforeach

        <!-- Image Upload -->
        <div class="col-md-6">
            <label class="form-label">Upload Image</label>
            <input type="file" name="otherRecommendationsPhoto" class="form-control" accept="image/*">
        </div>

    </div>

    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</div>
</form>