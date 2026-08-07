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

          

        <h4 class="mb-4">Terms & Conditions</h4>

        @if($terms->isEmpty())
            <p>No terms & conditions found.</p>
        @else
            <div class="accordion" id="termsAccordion">
                @foreach($terms as $term)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $term->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $term->id }}" aria-expanded="false" aria-controls="collapse{{ $term->id }}">
                            {{ $term->title }}
                        </button>
                    </h2>
                    <div id="collapse{{ $term->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $term->id }}" data-bs-parent="#termsAccordion">
                        <div class="accordion-body">
                            {!! nl2br(e($term->description)) !!}
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
@endsection