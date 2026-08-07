@extends('admin.layouts.app')

@section('title', __('farmer.farmer_list'))

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

@include('includes.navbar')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 col-lg-12 p-4">

    {{-- Country Filter --}}
    <form method="GET" class="mb-3 row g-2">
        <div class="col-9">
            <select name="country_id" class="form-select w-100">
                <option value="">{{ __('farmer.all_countries') }}</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" 
                        {{ request('country_id') == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-3">
            <button type="submit" class="btn btn-primary w-100">
                {{ __('farmer.filter') }}
            </button>
        </div>
    </form>

      <div class="d-flex align-items-center gap-3 justify-content-between mb-4">
        <h4 class="mb-0">{{ __('farmer.farmer_list') }}</h4>
        <a href="{{ url('admin/create-user') }}" class="btn theme-outline py-2">
            <i class="bi bi-plus-lg me-2"></i>{{ __('farmer.add_farmer') }}
        </a>
      </div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <div class="preview-box mb-4 mt-0">      
        <table class="table table-bordered table-striped table-hover mb-0">
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

              {{-- Username removed --}}
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
                  {{ __($statusName) }}
                </span>
              </td>

              <td>
                @if($statusName == 'Pending')

                  {{-- APPROVE --}}
                  <form action="{{ route('admin.user.approve', $user->id) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-secondary">
                        {{ __('farmer.approve') }}
                      </button>
                  </form>

                  {{-- DENY --}}
                  <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $user->id }}">
                      {{ __('farmer.denied') }}
                  </button>

                @endif

                 {{-- EDIT --}}
                <a href="{{ route('admin.edit_user', $user->id) }}" class="btn btn-sm btn-primary">
                  <i class="bi bi-pencil-square"></i>  {{ __('farmer.edit') }}
                </a>

                {{-- VIEW --}}
                <a href="{{ route('admin.user.view', $user->id) }}" class="btn btn-sm btn-success">
                  <i class="bi bi-eye"></i>  {{ __('farmer.view') }}
                </a>

               

                {{-- DELETE --}}
                <form action="{{ route('admin.delete_user', $user->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('{{ __('farmer.confirm_delete') }}')">
                   <i class="bi bi-trash"></i>  {{ __('farmer.delete') }}
                  </button>
                </form>

                {{-- REJECT MODAL --}}
                <div class="modal fade" id="rejectModal{{ $user->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.user.reject', $user->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('farmer.reject_user') }}: {{ $user->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <label class="form-label">{{ __('farmer.reason_reject') }}</label>
                                    <textarea name="reject_message" class="form-control" rows="3" required></textarea>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        {{ __('farmer.close') }}
                                    </button>
                                    <button type="submit" class="btn btn-danger">
                                        {{ __('farmer.submit') }}
                                    </button>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
