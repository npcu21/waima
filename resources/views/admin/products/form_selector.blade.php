@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@include('includes.navbar')

<div class="container-fluid">

       <div class="mb-3" style="display:none;">
        <label class="form-label">Select Country:</label>
        <select id="country_select" class="form-control">
            <option value="">-- Select Country --</option>
            <option value="rigonal">Rigonal</option>
            <option value="country">Country</option>
        </select>
    </div>

    <!-- COUNTRY LIST HIDDEN -->
    <div class="mb-3" id="country_list_box" style="display:none;">
        <label class="form-label">Select From Countries Table:</label>
        <select id="country_list" class="form-control">
            <option value="">-- Select Country --</option>
        </select>
    </div>


    <div class="row">
        <div class="col-md-12 col-lg-12 p-4">
            <div class="card shadow-sm p-4">

                <!-- TITLE ADDED -->
                <h3 class="mb-3">Product Management</h3>

                <h4 class="mb-4">Select Form Type</h4>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- HIDDEN Supplier -->
                <div class="mb-3" >
                    <label class="form-label">Select Supplier:</label>
                    <select id="supplier_select" class="form-control">
                        <option value="">-- Select Supplier --</option>
                    </select>
                </div>

                <!-- HIDDEN Agent -->
                <div class="mb-3" style="display:none;">
                    <label class="form-label">Select Agent:</label>
                    <select id="agent_select" class="form-control">
                        <option value="">-- Select Agent --</option>
                    </select>
                </div>

                <!-- Form Type -->
                <div class="mb-3">
                    <label class="form-label">Choose Form:</label>
                    <select id="form_select" class="form-control">
                        <option value="">-- Select Form --</option>
                        <option value="seed">Seeds</option>
                        <option value="veterinary_products">Veterinary Products</option>
                        <option value="animal_feed">Animal Feed</option>
                        <option value="mineral_fertilizers">Mineral Fertilizers</option>
                        <option value="organic_amendment">Organic Amendment</option>
                        <option value="bio_stimulants">Bio-Stimulants</option>
                        <option value="inorganic_soil_conditioners">Inorganic Soil Conditioners</option>
                        <option value="synthetic_pesticides">Synthetic Pesticides</option>
                    </select>
                </div>

                <!-- <input type="hidden" id="hidden_product_id" name="product_id">


                <input type="text" name="cropName" id="cropName" class="form-control" autocomplete="off"> -->

<div id="suggestions" class="list-group"></div>

                <div id="formsContainer">

                    <div id="seedForm" class="form-container" style="display:none;">
                        @include('admin.products.seed', [
                            'fields' => \App\Models\SeedField::all(),
                            'supplier_id' => '',
                            'agent_id' => ''
                        ])
                    </div>

                    <div id="animalFeedForm" class="form-container" style="display:none;">
                        @include('admin.products.animalfeed', [
                            'fields' => \App\Models\AnimalFeedField::all(),
                            'supplier_id' => '',
                            'agent_id' => ''
                        ])
                    </div>

                    <div id="mineralForm" class="form-container" style="display:none;">
                        @include('admin.products.mineral_fertilizers', [
                            'fields' => \App\Models\MineralFertilizerField::all(),
                            'supplier_id' => '',
                            'agent_id' => ''
                        ])
                    </div>

                    <div id="organicForm" class="form-container" style="display:none;">
                        @include('admin.products.organic_amendment', [
                            'fields' => \App\Models\OrganicAmendmentField::all(),
                            'supplier_id' => '',
                            'agent_id' => ''
                        ])
                    </div>

                    <div id="bioStimulantsForm" class="form-container" style="display:none;">
                        @include('admin.products.bio_stimulants', [
                            'fields' => \App\Models\BioStimulantsField::all(),
                            'supplier_id' => '',
                            'agent_id' => ''
                        ])
                    </div>

                    <div id="inorganicForm" class="form-container" style="display:none;">
                        @include('admin.products.inorganic_soil_conditioners', [
                            'fields' => \App\Models\InorganicSoilConditionerField::all()
                        ])
                    </div>

                    <div id="syntheticPesticidesForm" class="form-container" style="display:none;">
                        @include('admin.products.synthetic_pesticides', [
                            'fields' => \App\Models\SyntheticPesticidesField::all(),
                            'supplier_id' => '',
                            'agent_id' => ''
                        ])
                    </div>

                    <div id="veterinaryProductsForm" class="form-container" style="display:none;">
                        @include('admin.products.veterinary_products')
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', () => {

    const supplierSelect = document.getElementById('supplier_select');
    const agentSelect = document.getElementById('agent_select');

    const mainCountrySelect = document.getElementById('country_select');
    const dbCountryBox = document.getElementById('country_list_box');
    const dbCountrySelect = document.getElementById('country_list');

    loadSuppliers();
    loadAgents();

    mainCountrySelect.addEventListener('change', function () {

        if (this.value === "country") {

            dbCountryBox.style.display = "block";

            fetch('{{ url("get-countries") }}')
                .then(res => res.json())
                .then(data => {

                    dbCountrySelect.innerHTML = `<option value="">-- Select Country --</option>`;

                    data.forEach(c => {
                        dbCountrySelect.innerHTML += `<option value="${c.id}">${c.name}</option>`;
                    });

                });

        } else {

            dbCountryBox.style.display = "none";
            dbCountrySelect.innerHTML = "";

            loadSuppliers();
            loadAgents();

        }

    });

    dbCountrySelect.addEventListener('change', function () {

        if (this.value) {

            loadSuppliers(this.value);
            loadAgents(this.value);

        } else {

            loadSuppliers();
            loadAgents();

        }

    });

    function loadSuppliers(countryId = '') {

        let url = '{{ url("products/get-suppliers") }}';

        if (countryId) url += '?country_id=' + countryId;

        fetch(url)
            .then(res => res.json())
            .then(data => {

                supplierSelect.innerHTML = '<option value="">-- Select Supplier --</option>';

                data.forEach(s => {
                    supplierSelect.innerHTML += `<option value="${s.id}">${s.company_name}</option>`;
                });

            });

    }

    function loadAgents(countryId = '') {

        let url = '{{ url("products/get-agents") }}';

        if (countryId) url += '?country_id=' + countryId;

        fetch(url)
            .then(res => res.json())
            .then(data => {

                agentSelect.innerHTML = '<option value="">-- Select Agent --</option>';

                data.forEach(a => {
                    agentSelect.innerHTML += `<option value="${a.id}">${a.name}</option>`;
                });

            });

    }

    const formsMap = {
        seed: 'seedForm',
        animal_feed: 'animalFeedForm',
        mineral_fertilizers: 'mineralForm',
        organic_amendment: 'organicForm',
        bio_stimulants: 'bioStimulantsForm',
        inorganic_soil_conditioners: 'inorganicForm',
        synthetic_pesticides: 'syntheticPesticidesForm',
        veterinary_products: 'veterinaryProductsForm'
    };

    const formProductMap = {
        seed: 8,
        veterinary_products: 1,
        animal_feed: 2,
        mineral_fertilizers: 7,
        organic_amendment: 6,
        bio_stimulants: 5,
        inorganic_soil_conditioners: 4,
        synthetic_pesticides: 3
    };

    const formSelect = document.getElementById('form_select');

    formSelect.addEventListener('change', function () {

        Object.values(formsMap).forEach(id => document.getElementById(id).style.display = 'none');

        if (this.value) {

            const formId = formsMap[this.value];

            document.getElementById(formId).style.display = 'block';

            const productId = formProductMap[this.value];

            document.getElementById('hidden_product_id').value = productId;

            document.querySelectorAll('input[name="product_id"]').forEach(el => el.value = productId);

        }

    });

    function updateInputs() {

        document.querySelectorAll('input[name="supplier_id"]').forEach(el => el.value = supplierSelect.value);

        document.querySelectorAll('input[name="agent_id"]').forEach(el => el.value = agentSelect.value);

    }

    supplierSelect.addEventListener('change', updateInputs);
    agentSelect.addEventListener('change', updateInputs);

});

</script>
<!-- <script>
document.addEventListener('DOMContentLoaded', function () {

    function setupSuggestion(inputId, boxId) {

        const input = document.getElementById(inputId);
        const box = document.getElementById(boxId);

        if (!input || !box) return;

        input.addEventListener('input', function () {

            let query = this.value.trim();

            if (query.length < 2) {
                box.innerHTML = '';
                return;
            }

            // ✅ FORCE सही URL (public fix)
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

    // 🔥 APPLY BOTH
    setupSuggestion('cropName_main', 'suggestions_main');
    setupSuggestion('cropName_form', 'suggestions_form');

});
</script> -->
<!-- <script> dot 

    document.addEventListener('DOMContentLoaded', function () {

    function setupSuggestion(inputId, boxId) {

        const input = document.getElementById(inputId);
        const box = document.getElementById(boxId);

        if (!input || !box) return;

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

    // EXISTING
    setupSuggestion('cropName_main', 'suggestions_main');
    setupSuggestion('cropName_form', 'suggestions_form');

    // ✅ NEW (Animal Feed)
    setupSuggestion('afrm', 'afrm_suggestions');

});
</script> -->
<!-- <script>
document.addEventListener('DOMContentLoaded', function () {

    function setupSuggestion(inputId, boxId, hiddenId = null) {

        const input = document.getElementById(inputId);
        const box = document.getElementById(boxId);
        const hidden = hiddenId ? document.getElementById(hiddenId) : null;

        if (!input || !box) return;

        input.addEventListener('input', function () {

            let query = this.value.trim();

            if (query.length < 2) {
                box.innerHTML = '';
                if(hidden) hidden.value = '';
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

                            // ✅ HANDLE BOTH CASES
                            let name = '';
                            let id = '';

                            if (typeof item === 'string') {
                                name = item; // seed old data
                                id = '';
                            } else {
                                name = item.name ?? item.cropName ?? '';
                                id = item.id ?? '';
                            }

                            html += `<a href="#" data-id="${id}" class="list-group-item list-group-item-action">${name}</a>`;
                        });
                    }

                    box.innerHTML = html;

                    box.querySelectorAll('a').forEach(el => {
                        el.addEventListener('click', function(e) {
                            e.preventDefault();

                            input.value = this.innerText;

                            // ✅ SAVE ID IF EXISTS
                            if(hidden){
                                hidden.value = this.dataset.id || '';
                            }

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

    // ✅ SEED (old working)
    setupSuggestion('cropName_main', 'suggestions_main');
    setupSuggestion('cropName_form', 'suggestions_form');

    // ✅ ANIMAL FEED
    setupSuggestion('afrm', 'afrm_suggestions', 'product_id');

    // ✅ BIO STIMULANT
    setupSuggestion('trade_name', 'trade_name_suggestions', 'trade_product_id');

});  bios 
</script> -->
<!-- <script> mineral 
document.addEventListener('DOMContentLoaded', function () {

    function setupSuggestion(inputId, boxId, hiddenId = null) {

        const input = document.getElementById(inputId);
        const box = document.getElementById(boxId);
        const hidden = hiddenId ? document.getElementById(hiddenId) : null;

        if (!input || !box) return;

        input.addEventListener('input', function () {

            let query = this.value.trim();

            if (query.length < 2) {
                box.innerHTML = '';
                if(hidden) hidden.value = '';
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

                            let name = '';
                            let id = '';

                            // ✅ STRING (OLD SEED DATA)
                            if (typeof item === 'string') {
                                name = item;
                                id = '';
                            } 
                            // ✅ OBJECT (PRODUCT API)
                            else {
                                name = item.name ?? item.cropName ?? '';
                                id = item.id ?? '';
                            }

                            if(name){
                                html += `<a href="#" data-id="${id}" class="list-group-item list-group-item-action">${name}</a>`;
                            }
                        });
                    }

                    box.innerHTML = html;

                    box.querySelectorAll('a').forEach(el => {
                        el.addEventListener('click', function(e) {
                            e.preventDefault();

                            input.value = this.innerText;

                            if(hidden){
                                hidden.value = this.dataset.id || '';
                            }

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

    // ✅ SEED (old)
    setupSuggestion('cropName_main', 'suggestions_main');
    setupSuggestion('cropName_form', 'suggestions_form');

    // ✅ ANIMAL
    setupSuggestion('afrm', 'afrm_suggestions', 'product_master_id');

    // ✅ BIO
    setupSuggestion('trade_name', 'trade_name_suggestions', 'trade_product_id');

    // ✅ MINERAL
    setupSuggestion('min_trade_name', 'min_trade_name_suggestions', 'min_product_master_id');

});
</script> -->
<!-- <script>  inorgaic
document.addEventListener('DOMContentLoaded', function () {

    function setupSuggestion(inputId, boxId, hiddenId = null) {

        const input = document.getElementById(inputId);
        const box = document.getElementById(boxId);
        const hidden = hiddenId ? document.getElementById(hiddenId) : null;

        if (!input || !box) return;

        input.addEventListener('input', function () {

            let query = this.value.trim();

            if (query.length < 2) {
                box.innerHTML = '';
                if(hidden) hidden.value = '';
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

                            let name = item.name ?? '';
                            let id = item.id ?? '';

                            if(name){
                                html += `
                                    <a href="#" data-id="${id}" 
                                       class="list-group-item list-group-item-action">
                                       ${name}
                                    </a>`;
                            }
                        });
                    }

                    box.innerHTML = html;

                    box.querySelectorAll('a').forEach(el => {
                        el.addEventListener('click', function(e) {
                            e.preventDefault();

                            input.value = this.innerText;

                            if(hidden){
                                hidden.value = this.dataset.id || '';
                            }

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

    // ALL FORMS
    setupSuggestion('cropName_main', 'suggestions_main');
    setupSuggestion('cropName_form', 'suggestions_form');

    setupSuggestion('afrm', 'afrm_suggestions', 'product_master_id'); // animal

    setupSuggestion('trade_name', 'trade_name_suggestions', 'trade_product_id'); // bio

    setupSuggestion('min_trade_name', 'min_trade_name_suggestions', 'min_product_master_id'); // mineral

    setupSuggestion('inorganic_trade_name', 'inorganic_trade_name_suggestions', 'inorganic_product_master_id'); // inorganic

});
</script> -->
<!-- <script>
document.addEventListener('DOMContentLoaded', function () {

    function setupSuggestion(inputId, boxId, hiddenId = null) {

        const input = document.getElementById(inputId);
        const box = document.getElementById(boxId);
        const hidden = hiddenId ? document.getElementById(hiddenId) : null;

        if (!input || !box) return;

        input.addEventListener('input', function () {

            let query = this.value.trim();

            if (query.length < 2) {
                box.innerHTML = '';
                if (hidden) hidden.value = '';
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

                            let name = '';
                            let id = '';

                            // ✅ HANDLE BOTH TYPES (IMPORTANT FIX)
                            if (typeof item === 'string') {
                                name = item;
                                id = '';
                            } else {
                                name = item.name ?? item.cropName ?? '';
                                id = item.id ?? '';
                            }

                            if (name) {
                                html += `
                                    <a href="#" data-id="${id}" 
                                       class="list-group-item list-group-item-action">
                                       ${name}
                                    </a>`;
                            }
                        });
                    }

                    box.innerHTML = html;

                    box.querySelectorAll('a').forEach(el => {
                        el.addEventListener('click', function(e) {
                            e.preventDefault();

                            input.value = this.innerText;

                            if (hidden) {
                                hidden.value = this.dataset.id || '';
                            }

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

    // ✅ SEED
    setupSuggestion('cropName_main', 'suggestions_main');
    setupSuggestion('cropName_form', 'suggestions_form');

    // ✅ ANIMAL
    setupSuggestion('afrm', 'afrm_suggestions', 'product_master_id');

    // ✅ BIO
    setupSuggestion('trade_name', 'trade_name_suggestions', 'trade_product_id');

    // ✅ MINERAL
    setupSuggestion('min_trade_name', 'min_trade_name_suggestions', 'min_product_master_id');

    // ✅ INORGANIC
    setupSuggestion('inorganic_trade_name', 'inorganic_trade_name_suggestions', 'inorganic_product_master_id');

    // ✅ ORGANIC (🔥 NEW ADD)
    setupSuggestion('organic_trade_name', 'organic_trade_name_suggestions', 'organic_product_master_id');

});
</script> -->
<!-- <script>
document.addEventListener('DOMContentLoaded', function () {

    function setupSuggestion(inputId, boxId, hiddenId = null) {

        const input = document.getElementById(inputId);
        const box = document.getElementById(boxId);
        const hidden = hiddenId ? document.getElementById(hiddenId) : null;

        if (!input || !box) return;

        let debounceTimer;

        input.addEventListener('input', function () {

            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(() => {

                let query = input.value.trim();

                // ❌ minimum length check
                if (query.length < 2) {
                    box.innerHTML = '';
                    if (hidden) hidden.value = '';
                    return;
                }

                // ✅ API URL (dynamic safe)
                let url = window.location.origin + "/wclm/public/products/suggestions?search=" + encodeURIComponent(query);

                fetch(url)
                    .then(res => res.json())
                    .then(data => {

                        let html = '';

                        if (!data || data.length === 0) {
                            html = '<div class="list-group-item">No results</div>';
                        } else {

                            data.forEach(item => {

                                let name = '';
                                let id = '';

                                // ✅ STRING support (old data)
                                if (typeof item === 'string') {
                                    name = item;
                                } 
                                // ✅ OBJECT support (new data)
                                else {
                                    name = item.name ?? item.cropName ?? item.trade_name ?? '';
                                    id = item.id ?? '';
                                }

                                if (name) {
                                    html += `
                                        <a href="#" data-id="${id}" 
                                           class="list-group-item list-group-item-action">
                                           ${name}
                                        </a>`;
                                }
                            });
                        }

                        box.innerHTML = html;

                        // ✅ click select
                        box.querySelectorAll('a').forEach(el => {
                            el.addEventListener('click', function(e) {
                                e.preventDefault();

                                input.value = this.innerText;

                                if (hidden) {
                                    hidden.value = this.dataset.id || '';
                                }

                                box.innerHTML = '';
                            });
                        });

                    })
                    .catch(() => {
                        box.innerHTML = '<div class="list-group-item text-danger">Error loading data</div>';
                    });

            }, 300); // ✅ debounce (performance fix)

        });

        // ✅ outside click close
        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !box.contains(e.target)) {
                box.innerHTML = '';
            }
        });
    }

    // ✅ SEED
    setupSuggestion('cropName_main', 'suggestions_main');
    setupSuggestion('cropName_form', 'suggestions_form');

    // ✅ ANIMAL
    setupSuggestion('afrm', 'afrm_suggestions', 'product_master_id');

    // ✅ BIO
    setupSuggestion('trade_name', 'trade_name_suggestions', 'trade_product_id');

    // ✅ MINERAL
    setupSuggestion('min_trade_name', 'min_trade_name_suggestions', 'min_product_master_id');

    // ✅ INORGANIC
    setupSuggestion('inorganic_trade_name', 'inorganic_trade_name_suggestions', 'inorganic_product_master_id');

    // ✅ ORGANIC
    setupSuggestion('organic_trade_name', 'organic_trade_name_suggestions', 'organic_product_master_id');

    // ✅ SYNTHETIC (🔥 NEW ADD)
    setupSuggestion('synthetic_trade_name', 'synthetic_trade_name_suggestions', 'synthetic_product_master_id');

});
</script> -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    function setupSuggestion(inputId, boxId, hiddenId = null) {

        const input = document.getElementById(inputId);
        const box = document.getElementById(boxId);
        const hidden = hiddenId ? document.getElementById(hiddenId) : null;

        if (!input || !box) return;

        let debounceTimer;

        input.addEventListener('input', function () {

            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(() => {

                let query = input.value.trim();

                if (query.length < 2) {
                    box.innerHTML = '';
                    if (hidden) hidden.value = '';
                    return;
                }

                let url = window.location.origin + "/wclm/public/products/suggestions?search=" + encodeURIComponent(query);

                fetch(url)
                    .then(res => res.json())
                    .then(data => {

                        let html = '';

                        if (!data || data.length === 0) {
                            html = '<div class="list-group-item">No results</div>';
                        } else {

                            data.forEach(item => {

                                let name = '';
                                let id = '';

                                if (typeof item === 'string') {
                                    name = item;
                                } else {
                                    name = item.name ?? item.cropName ?? item.trade_name ?? '';
                                    id = item.id ?? '';
                                }

                                if (name) {
                                    html += `
                                        <a href="#" data-id="${id}" 
                                           class="list-group-item list-group-item-action">
                                           ${name}
                                        </a>`;
                                }
                            });
                        }

                        box.innerHTML = html;

                        box.querySelectorAll('a').forEach(el => {
                            el.addEventListener('click', function(e) {
                                e.preventDefault();

                                input.value = this.innerText;

                                if (hidden) {
                                    hidden.value = this.dataset.id || '';
                                }

                                box.innerHTML = '';
                            });
                        });

                    })
                    .catch(() => {
                        box.innerHTML = '<div class="list-group-item text-danger">Error loading data</div>';
                    });

            }, 300);

        });

        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !box.contains(e.target)) {
                box.innerHTML = '';
            }
        });
    }

    // ✅ SEED
    setupSuggestion('cropName_main', 'suggestions_main');
    setupSuggestion('cropName_form', 'suggestions_form');

    // ✅ ANIMAL
    setupSuggestion('afrm', 'afrm_suggestions', 'product_master_id');

    // ✅ BIO
    setupSuggestion('trade_name', 'trade_name_suggestions', 'trade_product_id');

    // ✅ MINERAL
    setupSuggestion('min_trade_name', 'min_trade_name_suggestions', 'min_product_master_id');

    // ✅ INORGANIC
    setupSuggestion('inorganic_trade_name', 'inorganic_trade_name_suggestions', 'inorganic_product_master_id');

    // ✅ ORGANIC
    setupSuggestion('organic_trade_name', 'organic_trade_name_suggestions', 'organic_product_master_id');

    // ✅ SYNTHETIC
    setupSuggestion('synthetic_trade_name', 'synthetic_trade_name_suggestions', 'synthetic_product_master_id');

    // ✅ VETERINARY (🔥 FINAL ADD)
    setupSuggestion(
        'veterinary_product_name',
        'veterinary_product_name_suggestions',
        'veterinary_product_master_id'
    );

});
</script>
@endsection