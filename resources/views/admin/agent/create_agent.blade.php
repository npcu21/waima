@extends('admin.layouts.app')

@section('title', __('agent.add_agent'))

@section('content')

{{-- CSS --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<style>
.select2 {
    --bs-form-select-bg-img: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e);
    display: block;
    width: 100%;
    padding: .375rem 2.25rem .375rem .75rem;
    font-size: 1rem;
    color: var(--bs-body-color);
    background-repeat: no-repeat;
    background-position: right .75rem center;
    background-size: 16px 12px;
    border: 1px solid var(--bs-border-color);
    border-radius: .375rem;
}
</style>

@include('includes.navbar')
<form method="GET" action="" class="d-flex ms-auto">
    <select name="lang" onchange="this.form.submit()" class="form-select form-select-sm">
        <option value="en" {{ session('lang') == 'en' ? 'selected' : '' }}>English</option>
        <option value="fr" {{ session('lang') == 'fr' ? 'selected' : '' }}>Français</option>
    </select>
</form>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 p-4">

            <div class="card shadow-sm p-4">
                <h4 class="mb-4">{{ __('agent.add_agent') }}</h4>

                {{-- Messages --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.store-agent') }}" method="POST">
                    @csrf
                    <div class="row g-3">

                        <input type="hidden" name="status_id" value="1">

                        <div class="col-md-6">
                            <label class="form-label">{{ __('agent.name') }} *</label>
                            <input type="text" name="name" class="form-control"
                                   placeholder="{{ __('agent.enter_name') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">{{ __('agent.email') }} *</label>
                            <input type="email" name="email" class="form-control"
                                   placeholder="{{ __('agent.enter_email') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">{{ __('agent.password') }} *</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="{{ __('agent.enter_password') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">{{ __('agent.country') }} *</label>
                            <select name="country" id="country" class="form-select" required>
                                <option value="">{{ __('agent.select_country') }}</option>
                                @foreach(\App\Models\Country::all() as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">{{ __('agent.region') }} *</label>
                            <select name="region[]" id="region" class="form-select select2" multiple required>
                                <option value="">{{ __('agent.select_regions') }}</option>
                            </select>
                        </div>

                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary w-50">
                            {{ __('agent.create_agent') }}
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

{{-- JS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {

    // Init Select2
    $('#region').select2({
        placeholder: "{{ __('agent.select_regions') }}",
        width: '100%',
        allowClear: true
    });

    // Country → Region AJAX
    $('#country').on('change', function() {
        let countryId = $(this).val();

        $('#region').empty();

        if (!countryId) {
            $('#region').append('<option>{{ __("agent.select_regions") }}</option>');
            return;
        }

        $.ajax({
            url: '{{ url("admin/get-regions") }}/' + countryId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#region').empty();
                if(data.length > 0){
                    $.each(data, function(key, value) {
                        $('#region').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                    });
                } else {
                    $('#region').append('<option>{{ __("agent.no_regions") }}</option>');
                }
            },
            error: function() {
                alert('Failed to fetch regions');
            }
        });
    });

});
</script>

@endsection
