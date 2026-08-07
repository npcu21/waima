@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom CSS -->
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@include('countryadmin.layouts.nav')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 p-4">

            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="mb-0">{{ __('supplier.supplier_list') }}</h4>
                <a href="https://fivoflow.com/wclm/public/supplier/addcountry" class="btn theme-outline py-2">
                    <i class="bi bi-plus-lg me-2"></i>{{ __('supplier.add_supplier') }}
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="preview-box mb-4 mt-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>{{ __('supplier.id') }}</th>
                <th>{{ __('supplier.company_name') }}</th>
                <th>{{ __('supplier.manager') }}</th>
                <th>{{ __('supplier.email') }}</th>
                <th>{{ __('supplier.phone') }}</th>
                <th>{{ __('supplier.image') }}</th>
                <th>{{ __('supplier.status') }}</th>
                <th>{{ __('supplier.action') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($suppliers as $supplier)
                                <tr>
                                    <td>{{ $supplier->id }}</td>
                                    <td>{{ $supplier->company_name }}</td>
                                    <td>{{ $supplier->manager_name }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>
                                        @if(!empty($supplier->image))
                                            @php
                                                $img = $supplier->image;
                                                $userImagePath = public_path('uploads/user_images/'.$img);
                                                $supplierImagePath = public_path('uploads/supplier/'.$img);
                                            @endphp

                                            @if(Str::startsWith($img, 'ftp://'))
                                                <img src="{{ $img }}" width="50" height="50" style="object-fit:cover; border-radius:8px;">
                                            @elseif(file_exists($userImagePath))
                                                <img src="{{ asset('uploads/user_images/'.$img) }}" width="50" height="50" style="object-fit:cover; border-radius:8px;">
                                            @elseif(file_exists($supplierImagePath))
                                                <img src="{{ asset('uploads/supplier/'.$img) }}" width="50" height="50" style="object-fit:cover; border-radius:8px;">
                                            @else
                                                <span class="text-muted">{{ __('supplier.no_image') }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">{{ __('supplier.no_image') }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($supplier->status_id == 1)
                                            <span class="badge bg-warning">{{ __('supplier.pending') }}</span>
                                        @elseif ($supplier->status_id == 2)
                                            <span class="badge bg-success">{{ __('supplier.approved') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('supplier.deny') }}</span>
                                        @endif
                                    </td>

                                    <td class="d-flex gap-2 flex-wrap">
                                        @if($supplier->status_id == 1)
                                            <!-- Approve Button -->
                                            <a href="{{ route('supplier.approve', $supplier->id) }}" 
                                               class="btn btn-success btn-sm"
                                               onclick="return confirm('Are you sure you want to approve this supplier?');">
{{ __('supplier.approve') }}                                            </a>

                                            <!-- Reject Button -->
                                            <button onclick="rejectSupplier({{ $supplier->id }})"
                                                    class="btn btn-danger btn-sm">
{{ __('supplier.deny') }}                                            </button>
                                        @endif

                                        <a href="{{ route('supplier.edit.country', $supplier->id) }}" class="btn btn-primary btn-sm">{{ __('supplier.edit') }}</a>

                                        <a href="{{ route('supplier.delete', $supplier->id) }}" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Are you sure you want to delete this supplier?');">
{{ __('supplier.delete') }}
                                        </a>

                       

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $suppliers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Script -->
<script>
function rejectSupplier(id) {
    let message = prompt("Enter reject reason:");
    if (!message) return;

    let form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ url('supplier/reject') }}/${id}`;

    let token = document.createElement('input');
    token.type = 'hidden';
    token.name = '_token';
    token.value = '{{ csrf_token() }}';

    let msgInput = document.createElement('input');
    msgInput.type = 'hidden';
    msgInput.name = 'reject_message';
    msgInput.value = message;

    form.appendChild(token);
    form.appendChild(msgInput);
    document.body.appendChild(form);
    form.submit();
}
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
