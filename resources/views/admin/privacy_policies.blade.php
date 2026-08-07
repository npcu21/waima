@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<!-- ✅ Bootstrap & Custom CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<!-- ✅ Navbar -->
@include('includes.navbar')

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 col-lg-12 p-4">

        <div class="card shadow-sm p-4">

        
        
        <h4 class="mb-4">Privacy Policies</h4>
        @if($policies->isEmpty())
            <p>No privacy policies found.</p>
        @else
            <div class="accordion" id="privacyPoliciesAccordion">
                @foreach($policies as $policy)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $policy->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $policy->id }}" aria-expanded="false" aria-controls="collapse{{ $policy->id }}">
                            {{ $policy->title }}
                        </button>
                    </h2>
                    <div id="collapse{{ $policy->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $policy->id }}" data-bs-parent="#privacyPoliciesAccordion">
                        <div class="accordion-body">
                            {!! nl2br(e($policy->description)) !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    </div>
      </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection
