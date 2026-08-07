@extends('admin.layouts.app')

@section('title', __('dashboard.dynamic_fields_list'))

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@section('content')
@include('includes.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 p-4">
            <div class="preview-box mt-0">
                <h3 class="preview-title theme-color mb-4">{{ __('dashboard.dynamic_fields') }}</h3>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- ✅ Seed Dropdown --}}
                <div class="mb-4">
                    <form method="GET" action="{{ route('dynamic.index') }}">
                        <label for="seed_id" class="form-label fw-bold">{{ __('dashboard.select_product') }}:</label>
                        <select class="form-select w-50" id="seed_id" name="seed_id" onchange="this.form.submit()">
                            <option value="">-- {{ __('dashboard.select_product') }} --</option>
                            @foreach($seeds as $seed)
                                <option value="{{ $seed->id }}" {{ ($selectedSeedId == $seed->id) ? 'selected' : '' }}>
                                    {{ $seed->name }}
                                </option>
                            @endforeach
                        </select>

                        {{-- ✅ Country Dropdown --}}
                        <label for="country_id" class="form-label fw-bold mt-3">{{ __('dashboard.select_country') }}:</label>
                        <select class="form-select w-50" id="country_id" name="country_id" onchange="this.form.submit()">
                            <option value="">-- {{ __('dashboard.select_country') }} --</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ (isset($selectedCountryId) && $selectedCountryId == $country->id) ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                @if($selectedSeedId)
                    @if(count($fields))
                        <form method="POST" action="{{ route('dynamic.updateAll', $selectedSeedId) }}">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover align-middle text-center">
                                    <thead class="table-dark">
                                        <tr>
                                            <th style="width: 25%;">{{ __('dashboard.label') }}</th>
                                            <th style="width: 15%;">{{ __('dashboard.name') }}</th>
                                            <th style="width: 15%;">{{ __('dashboard.type') }}</th>
                                            <th style="width: 30%;">{{ __('dashboard.options') }}</th>
                                            <th style="width: 15%;">{{ __('dashboard.required') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($fields as $field)
                                            @if(in_array($field->name, ['created_by', 'supplier_id', 'product_id', 'agent_id', 'created_at']))
                                                @continue
                                            @endif
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="label_{{ $field->id }}" value="{{ $field->label }}" required>
                                                </td>
                                                <td class="text-center">{{ $field->name }}</td>
                                                <td class="text-center">{{ $field->type }}</td>
                                                <td>
                                                    <textarea class="form-control" name="options_{{ $field->id }}" style="min-height: 40px;">{{ $field->options }}</textarea>
                                                </td>
                                                <td>
                                                    <select class="form-select" name="required_{{ $field->id }}">
                                                        <option value="0" {{ $field->required == 0 ? 'selected' : '' }}>{{ __('dashboard.no') }}</option>
                                                        <option value="1" {{ $field->required == 1 ? 'selected' : '' }}>{{ __('dashboard.yes') }}</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-success w-50">{{ __('dashboard.update_all_fields') }}</button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info">
                            {{ $lang == 'fr' ? 'Aucun champ trouvé pour la graine sélectionnée' : 'Selected product is not available in this language' }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
