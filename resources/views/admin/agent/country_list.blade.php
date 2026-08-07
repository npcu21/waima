@extends('admin.layouts.app')

@section('title', 'Agent List')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@include('countryadmin.layouts.nav')




<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 col-lg-12 p-4">

    

    <div class="card shadow-sm mb-3">
      <!-- <div class="card-header bg-white">
          <h5 class="mb-0">Filter Agent List</h5>
      </div>       -->


    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
      <h4 class="mb-0">{{ __('agent.agent_list') }}</h4>
      <a href="{{ route('country.agent.create') }}" class="btn theme-outline py-2">
        <i class="bi bi-plus-lg me-2"></i>{{ __('agent.add_agent') }}
      </a>
     
    </div>

    <table class="table table-bordered table-striped align-middle">
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
              {{ $statusName }}
            </span>
          </td>

          <td>{{ $agent->created_at ? \Carbon\Carbon::parse($agent->created_at)->format('Y-m-d') : '' }}</td>

          <td class="text-center">

            @if($statusName == 'Pending')


              {{-- APPROVE --}}
              <form action="{{ route('admin.agent.approve_country', $agent->id) }}" method="POST" class="d-inline">
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

     <a href="{{ route('admin.agent.edit_country', $agent->id) }}" class="btn btn-primary btn-sm">
              <i class="bi bi-pencil-square"></i> {{ __('agent.edit') }}
            </a>



            <form action="{{ route('agents.country.delete', $agent->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm"
            onclick="return confirm('Are you sure you want to delete this agent?')">
        {{ __('agent.delete') }}
    </button>
</form>




          </td>
        </tr>

        {{-- REJECT MODAL (unique per agent) --}}
        <div class="modal fade" id="rejectModal{{ $agent->id }}" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title">{{ __('agent.reject_agent') }}  {{ $agent->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>

                
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

    <div class="d-flex justify-content-center mt-3">
      {{ $agents->links() }}
    </div>

    </div>
  </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
