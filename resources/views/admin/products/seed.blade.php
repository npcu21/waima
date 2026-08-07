<form action="{{ route('seedform.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<input type="hidden" name="form_type" value="seed">
<input type="hidden" name="product_id" id="hidden_product_id" value="{{ old('seed_id', 8) }}">
<input type="hidden" name="created_by" value="{{ session('user_id') }}">
<input type="hidden" name="supplier_id" id="supplier_id" value="{{ old('supplier_id') }}">
<input type="hidden" name="agent_id" id="agent_id" value="{{ old('agent_id') }}">

<div class="row gy-3">

    <!-- 🔥 CROP NAME WITH SUGGESTION -->
    <div class="col-md-6 position-relative">
        <label class="form-label">Crop Name *</label>

        <!-- ✅ ID CHANGE -->
        <input type="text" 
               name="cropName"
               id="cropName_form" 
               class="form-control"
               autocomplete="off"
               required>

        <!-- ✅ ID CHANGE -->
        <div id="suggestions_form" class="list-group position-absolute w-100" style="z-index:999;"></div>
    </div>

    @foreach($fields as $field)
        <div class="col-md-6">
            <label class="form-label">
                {{ $field->label }}
                {!! $field->required ? '<span class="text-danger">*</span>' : '' !!}
            </label>

            @if($field->type == 'text')
                <input type="text" 
                       name="{{ $field->name }}"
                       class="form-control"
                       value="{{ old($field->name) }}"
                       {{ $field->required ? 'required' : '' }}>

            @elseif($field->type == 'number')
                <input type="number"
                       name="{{ $field->name }}"
                       class="form-control"
                       value="{{ old($field->name) }}"
                       {{ $field->required ? 'required' : '' }}>

            @elseif($field->type == 'file')
                <input type="file" 
                       name="{{ $field->name }}"
                       class="form-control"
                       {{ $field->required ? 'required' : '' }}>

            @elseif($field->type == 'select')
                @php
                    $options = [];

                    if (!empty($field->options)) {
                        if (is_array($field->options)) {
                            $options = $field->options;
                        } elseif (is_string($field->options) && str_starts_with(trim($field->options), '[')) {
                            $decoded = json_decode($field->options, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                $options = $decoded;
                            }
                        } else {
                            $options = explode(',', $field->options);
                        }
                    }
                @endphp

                <select name="{{ $field->name }}"
                        class="form-select"
                        {{ $field->required ? 'required' : '' }}>

                    <option value="">Select {{ $field->label }}</option>

                    @foreach($options as $opt)
                        <option value="{{ trim($opt) }}">{{ trim($opt) }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    @endforeach

</div>

<button type="submit" class="btn btn-primary mt-3">Save Seed Form</button>
</form>