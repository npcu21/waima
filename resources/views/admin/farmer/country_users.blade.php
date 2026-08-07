@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Navbar -->
@include('countryadmin.layouts.nav')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 col-lg-12 p-4">

      <div class="d-flex align-items-center gap-3 justify-content-between mb-4">
        <h4 class="mb-0">{{ __('farmer.farmer_list') }}</h4>
        <a href="{{ url('admin/country/farmer/add') }}" class="btn btn-primary py-2">{{ __('farmer.add_farmer') }}</a>
      </div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <div class="preview-box mb-4 mt-0">
        <table class="table table-bordered table-striped table-hover" id="farmerTable">
          <thead class="table-dark">
            <tr>
                            <th>{{ __('farmer.id') }}</th>
              {{-- Username removed --}}
              <th>{{ __('farmer.name') }}</th>
              <th>{{ __('farmer.email') }}</th>
              <th>{{ __('farmer.user_type') }}</th>
              <th>{{ __('farmer.status') }}</th>
              <th>{{ __('farmer.actions') }}</th>
            </tr>
          </thead>

          <tbody>
            @foreach($users as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <!-- <td>{{ $user->username }}</td> -->
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->usertype->type_name ?? '-' }}</td>

              @php
                $statusName = \App\Models\Status::where('id', $user->status_id)->value('name') ?? 'Pending';
              @endphp

              <td>
                <span class="badge 
                  @if($statusName == 'Pending') bg-warning
                  @elseif($statusName == 'Approved') bg-success
                  @elseif($statusName == 'Deny') bg-danger
                  @else bg-secondary
                  @endif">
                  {{ $statusName }}
                </span>
              </td>

              <td>
                @if($statusName == 'Pending')
                  {{-- APPROVE --}}
                  <a href="{{ route('admin.country.approve', $user->id) }}" 
                     class="btn btn-sm btn-success mb-1"
                     onclick="return confirm('Are you sure you want to approve this user?')">
                    {{ __('farmer.approve') }}
                  </a>

                  {{-- DENIED --}}
                  <button class="btn btn-sm btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $user->id }}">
                        {{ __('farmer.denied') }}
                  </button>
                @endif

                {{-- VIEW --}}
               <a href="{{ route('admin.country.farmer.view', $user->id) }}" 
   class="btn btn-sm btn-info mb-1">
    {{ __('farmer.view') }}
</a>


                {{-- EDIT --}}
                <a href="{{ route('admin.country.farmer.edit', $user->id) }}" class="btn btn-sm btn-primary mb-1">{{ __('farmer.edit') }}</a>

                {{-- DELETE --}}
                <form action="{{ route('admin.delete.country', $user->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure you want to delete this user?')">{{ __('farmer.delete') }}</button>
                </form>

                {{-- REJECT MODAL --}}
                <div class="modal fade" id="rejectModal{{ $user->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.country.reject', $user->id) }}" method="GET">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('farmer.reject_user') }}: {{ $user->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="form-label">{{ __('farmer.reason_reject') }}</label>
                                    <textarea name="reject_message" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">  {{ __('farmer.close') }}</button>
                                    <button type="submit" class="btn btn-danger">  {{ __('farmer.submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

              </td>

            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        $('#farmerTable').DataTable();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
