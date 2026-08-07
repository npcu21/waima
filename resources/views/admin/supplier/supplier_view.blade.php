@extends('admin.layouts.app')

@section('title', __('supplier.details'))

@section('content')
<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom CSS -->
<link rel="stylesheet" href="https://fivoflow.com/wclm/public/css/style.css">

<!-- Top Navbar -->
@include('includes.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 p-4">
            <div>

                <h4 class="mb-4">{{ __('supplier.details') }}</h4>

                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr><th>{{ __('supplier.id') }}</th><td>{{ $supplier->id }}</td></tr>

                        <tr><th>{{ __('supplier.country') }}</th><td>{{ $supplier->country?->name ?? $supplier->country_id }}</td></tr>

                        <tr><th>{{ __('supplier.company_name') }}</th><td>{{ $supplier->company_name }}</td></tr>

                        <tr><th>{{ __('supplier.manager_name') }}</th><td>{{ $supplier->manager_name }}</td></tr>

                        <tr><th>{{ __('supplier.name') }}</th><td>{{ $supplier->name }}</td></tr>

                        <tr><th>{{ __('supplier.position') }}</th><td>{{ $supplier->position }}</td></tr>

                        <tr>
                            <th>{{ __('supplier.image') }}</th>
                            <td>
                                @if(!empty($supplier->image))
                                    @php
                                        $img = $supplier->image;
                                        $userImagePath = public_path('uploads/user_images/'.$img);
                                        $supplierImagePath = public_path('uploads/supplier/'.$img);
                                    @endphp

                                    @if(Str::startsWith($img, 'ftp://'))
                                        <img src="{{ $img }}" width="50" height="50" style="object-fit: cover; border-radius:8px;">
                                    @elseif(file_exists($userImagePath))
                                        <img src="{{ asset('uploads/user_images/'.$img) }}" width="50" height="50" style="object-fit: cover; border-radius:8px;">
                                    @elseif(file_exists($supplierImagePath))
                                        <img src="{{ asset('uploads/supplier/'.$img) }}" width="50" height="50" style="object-fit: cover; border-radius:8px;">
                                    @else
                                        <span class="text-muted">{{ __('supplier.no_image') }}</span>
                                    @endif
                                @else
                                    <span class="text-muted">{{ __('supplier.no_image') }}</span>
                                @endif
                            </td>
                        </tr>

                        <tr><th>{{ __('supplier.city') }}</th><td>{{ $supplier->city }}</td></tr>

                        <tr><th>{{ __('supplier.region') }}</th><td>{{ $supplier->region }}</td></tr>

                        <tr><th>{{ __('supplier.address') }}</th><td>{{ $supplier->address }}</td></tr>

                        <tr><th>{{ __('supplier.phone') }}</th><td>{{ $supplier->phone }}</td></tr>

                        <tr><th>{{ __('supplier.mobile') }}</th><td>{{ $supplier->mobile }}</td></tr>

                        <tr><th>{{ __('supplier.email') }}</th><td>{{ $supplier->email }}</td></tr>

                        <tr>
                            <th>{{ __('supplier.state_entity_registration') }}</th>
                            <td>{{ $supplier->state_entity_registration }}</td>
                        </tr>

                        <tr>
                            <th>{{ __('supplier.employer_identification_number') }}</th>
                            <td>{{ $supplier->employer_identification_number }}</td>
                        </tr>

                        <tr>
                            <th>{{ __('supplier.status') }}</th>
                            <td>
                                @if($supplier->status_id == 1)
                                    {{ __('supplier.status_pending') }}
                                @elseif($supplier->status_id == 2)
                                    {{ __('supplier.status_approved') }}
                                @else
                                    {{ __('supplier.status_denied') }}
                                @endif
                            </td>
                        </tr>

                        <tr><th>{{ __('supplier.created_at') }}</th><td>{{ $supplier->created_at }}</td></tr>

                        <tr><th>{{ __('supplier.enumerator_last_name') }}</th><td>{{ $supplier->enumerator_last_name }}</td></tr>

                        <tr><th>{{ __('supplier.enumerator_first_name') }}</th><td>{{ $supplier->enumerator_first_name }}</td></tr>

                        <tr><th>{{ __('supplier.enumerator_whatsapp') }}</th><td>{{ $supplier->enumerator_whatsapp }}</td></tr>

                        <tr><th>{{ __('supplier.latitude') }}</th><td>{{ $supplier->latitude }}</td></tr>

                        <tr><th>{{ __('supplier.longitude') }}</th><td>{{ $supplier->longitude }}</td></tr>

                        <tr><th>{{ __('supplier.altitude') }}</th><td>{{ $supplier->altitude }}</td></tr>

                        <tr><th>{{ __('supplier.accuracy') }}</th><td>{{ $supplier->accuracy }}</td></tr>

                    </tbody>
                </table>

            </div>

            <a href="{{ route('admin.supplier.list-suppliers') }}" class="btn btn-secondary mb-3">
                {{ __('supplier.back_to_list') }}
            </a>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
