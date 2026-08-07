@extends('admin.layouts.app')

@section('title', __('agent.agent_list'))

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@include('includes.navbar')

<!-- <form method="GET" action="" class="d-flex ms-auto">
    <select name="lang" onchange="this.form.submit()" class="form-select form-select-sm">
        <option value="en" {{ session('lang') == 'en' ? 'selected' : '' }}>English</option>
        <option value="fr" {{ session('lang') == 'fr' ? 'selected' : '' }}>Français</option>
    </select>
</form> -->

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 col-lg-12 p-4">

      <div class="card shadow-sm mb-3">
        <div class="card-header bg-white">
          <h5 class="mb-0">{{ __('agent.filter_agent_list') }}</h5>
        </div>      

        <div class="card-body">
          <form method="GET" action="{{ route('admin.agent.status') }}" class="row g-2 mb-3">
            <div class="col-6">
              <select name="country" class="form-select">
                <option value="">{{ __('agent.select_country') }}</option>
                @foreach($countries as $country)
                  <option value="{{ $country->id }}" {{ request('country') == $country->id ? 'selected' : '' }}>
                      {{ $country->name }}
                  </option>
              @endforeach
              </select>
            </div>
            <div class="col-3">
              <button class="btn btn-outline-primary w-100" type="submit">{{ __('agent.filter') }}</button>
            </div>
            <div class="col-3">
              <a href="{{ route('admin.agent.status') }}" class="btn pc-reset-btn w-100">{{ __('agent.reset') }}</a>
            </div>
          </form> 
        </div>         
      </div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
        <h4 class="mb-0">{{ __('agent.agent_list') }}</h4>
        <a href="{{ route('admin.create-agent') }}" class="btn theme-outline py-2">
          <i class="bi bi-plus-lg me-2"></i>{{ __('agent.add_agent') }}
        </a>
      </div>
      <div class="preview-box mb-0 mt-0">
        <table class="table table-bordered table-striped align-middle mb-0">
          <thead class="table-dark">
            <tr>
              <th>{{ __('agent.id') }}</th>
              <th>{{ __('agent.name') }}</th>
              <th>{{ __('agent.email') }}</th>
              <!-- <th>{{ __('agent.username') }}</th> -->
              <th>{{ __('agent.status') }}</th>
              <th>{{ __('agent.created_at') }}</th>
              <th>{{ __('agent.action') }}</th>
            </tr>
          </thead>

          <tbody>
            @forelse($agents as $agent)
            <tr>
              <td>{{ $agent->id }}</td>
              <td>{{ $agent->name }}</td>
              <td>{{ $agent->email }}</td>
              <!-- <td>{{ $agent->username }}</td> -->

              @php
                $statusName = \App\Models\Status::where('id', $agent->status_id)->value('name') ?? 'Pending';
              @endphp

              <td>
                <span class="badge 
                  @if($statusName == 'Pending') bg-warning
                  @elseif($statusName == 'Approved') bg-success
                  @elseif($statusName == 'Deny') bg-danger
                  @else bg-secondary
                  @endif">
                  {{ __("agent.$statusName") }}
                </span>
              </td>

              <td>{{ $agent->created_at ? \Carbon\Carbon::parse($agent->created_at)->format('Y-m-d') : '' }}</td>

              <td class="text-center">
                @if($statusName == 'Pending')
                  {{-- APPROVE --}}
                  <form action="{{ route('admin.agent.approve', $agent->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-success">{{ __('agent.approve') }}</button>
                  </form>

                  {{-- REJECT BUTTON (opens modal) --}}
                  <button class="btn btn-sm btn-danger"
                          data-bs-toggle="modal"
                          data-bs-target="#rejectModal{{ $agent->id }}">
                    {{ __('agent.denied') }}
                  </button>
                @endif

                <a href="{{ route('admin.edit-agent', $agent->id) }}" class="btn btn-sm btn-primary">
                  <i class="bi bi-pencil-square"></i> {{ __('agent.edit') }}
                </a>
                <a href="{{ route('admin.view-agent', $agent->id) }}" class="btn btn-sm btn-success text-white">
                  <i class="bi bi-eye"></i> {{ __('agent.view') }}
                </a>

                <form action="{{ route('admin.delete-agent', $agent->id) }}" 
                      method="POST" class="d-inline"
                      onsubmit="return confirm('{{ __('agent.delete_confirm') }}');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">
                    <i class="bi bi-trash"></i> {{ __('agent.delete') }}
                  </button>
                </form>
              </td>
            </tr>

            {{-- REJECT MODAL --}}
            <div class="modal fade" id="rejectModal{{ $agent->id }}" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">{{ __('agent.reject_agent') }} {{ $agent->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>

                  <form action="{{ route('admin.agent.reject', $agent->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                      <label class="form-label">{{ __('agent.reason_for_rejection') }}</label>
                      <textarea name="reject_message" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('agent.close') }}</button>
                      <button type="submit" class="btn btn-danger">{{ __('agent.reject_button') }}</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            @empty
            <tr>
              <td colspan="8" class="text-center text-danger">{{ __('agent.no_agents_found') }}</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="d-flex justify-content-center mt-3">
        {{ $agents->links() }}
      </div>

    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
