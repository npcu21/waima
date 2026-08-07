@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@include('countryadmin.layouts.nav')

@php
    $loggedCountryId = Auth::user()->country_id ?? null;
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 p-4">
            <div class="card shadow-sm p-4">
                <h4 class="mb-4">Select Form Type</h4>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Supplier Dropdown -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Select Supplier:</label>
                    <select id="supplier_select" class="form-control">
                        <option value="">-- Select Supplier --</option>
                    </select>
                </div>

                <!-- Agent Dropdown -->
                <div class="mb-3" style="display:none;">
                    <label class="form-label fw-bold" >Select Agent:</label>
                    <select id="agent_select" class="form-control">
                        <option value="">-- Select Agent --</option>
                    </select>
                </div>

                <!-- Form Type -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Choose Form:</label>
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

                <input type="hidden" id="hidden_product_id" name="product_id">

                <div id="formsContainer">
                    <div id="seedForm" class="form-container" style="display:none;">
                        @include('admin.products.seed', ['fields' => \App\Models\SeedField::all()])
                    </div>

                    <div id="animalFeedForm" class="form-container" style="display:none;">
                        @include('admin.products.animalfeed', ['fields' => \App\Models\AnimalFeedField::all()])
                    </div>

                    <div id="mineralForm" class="form-container" style="display:none;">
                        @include('admin.products.mineral_fertilizers', ['fields' => \App\Models\MineralFertilizerField::all()])
                    </div>

                    <div id="organicForm" class="form-container" style="display:none;">
                        @include('admin.products.organic_amendment', ['fields' => \App\Models\OrganicAmendmentField::all()])
                    </div>

                    <div id="bioStimulantsForm" class="form-container" style="display:none;">
                        @include('admin.products.bio_stimulants', ['fields' => \App\Models\BioStimulantsField::all()])
                    </div>

                    <div id="inorganicForm" class="form-container" style="display:none;">
                        @include('admin.products.inorganic_soil_conditioners', ['fields' => \App\Models\InorganicSoilConditionerField::all()])
                    </div>

                    <div id="syntheticPesticidesForm" class="form-container" style="display:none;">
                        @include('admin.products.synthetic_pesticides', ['fields' => \App\Models\SyntheticPesticidesField::all()])
                    </div>

                    <div id="veterinaryProductsForm" class="form-container" style="display:none;">
                        @include('admin.products.veterinary_products')
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const supplierSelect = document.getElementById('supplier_select');
    const agentSelect    = document.getElementById('agent_select');

    const LOGGED_COUNTRY_ID = "{{ $loggedCountryId }}";

    // -------------------------
    // AUTO LOAD suppliers & agents of logged-in country
    // -------------------------
    if (LOGGED_COUNTRY_ID) {
        loadSuppliers(LOGGED_COUNTRY_ID);
        loadAgents(LOGGED_COUNTRY_ID);
    } else {
        loadSuppliers();
        loadAgents();
    }

    function loadSuppliers(countryId = '') {
        let url = '{{ url("products/get-country-suppliers") }}';
        if (countryId) url += '?country_id=' + countryId;

        fetch(url)
        .then(res => res.json())
        .then(data => {
            supplierSelect.innerHTML = '<option value="">-- Select Supplier --</option>';
            data.forEach(s => {
                supplierSelect.innerHTML += `<option value="${s.id}">${s.company_name}</option>`;
            });
        })
        .catch(err => console.error('Error loading suppliers:', err));
    }

    function loadAgents(countryId = '') {
        let url = '{{ url("products/get-country-agents") }}';
        if (countryId) url += '?country_id=' + countryId;

        fetch(url)
        .then(res => res.json())
        .then(data => {
            agentSelect.innerHTML = '<option value="">-- Select Agent --</option>';
            data.forEach(a => {
                agentSelect.innerHTML += `<option value="${a.id}">${a.name}</option>`;
            });
        })
        .catch(err => console.error('Error loading agents:', err));
    }

    // -------------------------
    // FORM SHOW/HIDE
    // -------------------------
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

    const productMap = {
        seed: 8,
        veterinary_products: 1,
        animal_feed: 2,
        mineral_fertilizers: 7,
        organic_amendment: 6,
        bio_stimulants: 5,
        inorganic_soil_conditioners: 4,
        synthetic_pesticides: 3
    };

    document.getElementById('form_select').addEventListener('change', function () {
        Object.values(formsMap).forEach(id => document.getElementById(id).style.display = 'none');

        if (this.value) {
            document.getElementById(formsMap[this.value]).style.display = 'block';
            const pid = productMap[this.value];
            document.getElementById('hidden_product_id').value = pid;

            document.querySelectorAll('input[name="product_id"]').forEach(i => i.value = pid);
        }
    });

});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
