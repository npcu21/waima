<div class="form6 form-section form-container">
    <h5>Synthetic Pesticides</h5>

    <form action="{{ route('synthetic_pesticides.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="form_type" value="synthetic_pesticides">
        <input type="hidden" name="product_id" value="3">
        <input type="hidden" name="created_by" value="{{ session('user_id') }}">
        <input type="hidden" name="supplier_id" id="supplier_id" value="">
        <input type="hidden" name="agent_id" id="agent_id" value="">

        <div class="row gy-3">

            <!-- ✅ TRADE NAME WITH SUGGESTION -->
            <div class="col-md-6 position-relative">
                <label class="form-label">Trade Name *</label>

                <input type="text"
                       id="synthetic_trade_name"
                       name="trade_name"
                       class="form-control"
                       autocomplete="off"
                       required>

                <!-- hidden product master id -->
                <input type="hidden"
                       name="product_master_id"
                       id="synthetic_product_master_id">

                <!-- suggestion box -->
                <div id="synthetic_trade_name_suggestions"
                     class="list-group position-absolute w-100"></div>
            </div>

            @foreach($fields as $field)

                {{-- ❌ TRADE NAME duplicate remove --}}
                @if($field->name == 'trade_name')
                    @continue
                @endif

                <div class="col-md-6">
                    <label class="form-label">
                        {{ $field->label }}
                        @if($field->required == 1)*@endif
                    </label>

                    @if($field->type == 'text')
                        <input type="text"
                               name="{{ $field->name }}"
                               class="form-control"
                               @if($field->required) required @endif>

                    @elseif($field->type == 'number')
                        <input type="number"
                               step="0.01"
                               name="{{ $field->name }}"
                               class="form-control"
                               @if($field->required) required @endif>

                    @elseif($field->type == 'textarea')
                        <textarea name="{{ $field->name }}"
                                  class="form-control"
                                  @if($field->required) required @endif></textarea>

                    @elseif($field->type == 'select')
                        @php $opts = json_decode($field->options, true) ?? []; @endphp

                        <select name="{{ $field->name }}"
                                class="form-select"
                                @if($field->required) required @endif>
                            <option value="">Select</option>

                            @foreach($opts as $op)
                                <option value="{{ $op }}">{{ $op }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

            @endforeach

            <!-- IMAGE -->
            <div class="col-md-6">
                <label class="form-label">Upload Image</label>
                <input type="file"
                       name="otherRecommendationsPhoto"
                       class="form-control"
                       accept="image/*">
            </div>

            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary w-100">
                    Save Synthetic Pesticide
                </button>
            </div>

        </div>
    </form>
</div>