<form action="{{ route('animalfeed.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <h5>Animal Feed</h5>

    <input type="hidden" name="form_type" value="animal_feed">
    <input type="hidden" name="product_id" id="product_id" value="">
    <input type="hidden" name="created_by" value="{{ session('user_id') }}">
    <input type="hidden" name="supplier_id" id="supplier_id" value="">
    <input type="hidden" name="agent_id" id="agent_id" value="">

    <div class="row gy-3">
        @foreach($fields as $field)

        <div class="col-md-6">
            <label class="form-label">{{ $field->label }}</label>
<input type="hidden" name="product_master_id" id="product_master_id">
            {{-- SELECT FIELD --}}
            @if($field->type == 'select')
                @php $opts = json_decode($field->options); @endphp
                <select class="form-select" name="{{ $field->name }}" @if($field->required) required @endif>
                    <option value="">Select {{ $field->label }}</option>
                    @foreach($opts as $opt)
                        <option value="{{ $opt }}">{{ $opt }}</option>
                    @endforeach
                </select>

            @else

                {{-- ✅ RAW MATERIAL (AFRM) WITH SUGGESTION --}}
                @if($field->name == 'afrm')

                    <input 
                        type="text" 
                        id="afrm"
                        name="afrm"
                        class="form-control"
                        autocomplete="off"
                        @if($field->required) required @endif
                    >

                    <div id="afrm_suggestions" class="list-group"></div>

                @else

                    {{-- NORMAL INPUT --}}
                    <input 
                        type="{{ $field->type }}" 
                        class="form-control" 
                        name="{{ $field->name }}"
                        @if($field->required) required @endif
                    >

                @endif

            @endif
        </div>

        @endforeach

    </div>

    <button type="submit" class="btn btn-primary mt-3">Save Animal Feed</button>
</form>


{{-- ================= JS ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ✅ PRODUCT ID SET
    const mainProduct = document.getElementById('hidden_product_id'); 
    const productInput = document.getElementById('product_id');
    
    if(mainProduct && productInput){
        productInput.value = mainProduct.value;
        mainProduct.addEventListener('change', function(){
            productInput.value = this.value;
        });
    }

    // ✅ SUPPLIER & AGENT SET
    const mainSupplier = document.getElementById('supplier_select');
    const mainAgent = document.getElementById('agent_select');

    const supplierInput = document.getElementById('supplier_id');
    const agentInput = document.getElementById('agent_id');

    function updateHiddenFields(){
        if(mainSupplier) supplierInput.value = mainSupplier.value;
        if(mainAgent) agentInput.value = mainAgent.value;
    }

    updateHiddenFields();

    if(mainSupplier){
        mainSupplier.addEventListener('change', updateHiddenFields);
    }

    if(mainAgent){
        mainAgent.addEventListener('change', updateHiddenFields);
    }

    // ===============================
    // ✅ SUGGESTION (AFRM)
    // ===============================
    const input = document.getElementById('afrm');
    const box = document.getElementById('afrm_suggestions');

    if(input && box){

        input.addEventListener('input', function () {

            let query = this.value.trim();

            if (query.length < 2) {
                box.innerHTML = '';
                return;
            }

            let url = window.location.origin + "/wclm/public/products/suggestions?search=" + query;

            fetch(url)
                .then(res => res.json())
                .then(data => {

                    let html = '';

                    if (!data || data.length === 0) {
                        html = '<div class="list-group-item">No results</div>';
                    } else {
                        data.forEach(item => {
                            html += `<a href="#" class="list-group-item list-group-item-action">${item}</a>`;
                        });
                    }

                    box.innerHTML = html;

                    box.querySelectorAll('a').forEach(el => {
                        el.addEventListener('click', function(e) {
                            e.preventDefault();
                            input.value = this.innerText;
                            box.innerHTML = '';
                        });
                    });

                })
                .catch(() => {
                    box.innerHTML = '<div class="list-group-item text-danger">Error</div>';
                });

        });

        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !box.contains(e.target)) {
                box.innerHTML = '';
            }
        });
    }

});
</script>