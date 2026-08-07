@php
    // Ensure $item is defined
    $item = $item ?? null;
@endphp

@if($item)
<div class="card shadow-sm mb-4">
    <div class="card-body">

        <h5 class="mb-4 text-primary text-capitalize">
            {{ __('labels.categories.'.Str::slug($category,'_')) }}
        </h5>

        {{-- DETAILS --}}
        <div class="row">
            @foreach((array)$item as $key => $value)

                @if(!in_array($key, [
                        'id','supplier_id','status_id',
                        'created_at','updated_at',
                        'table_name','qr_code_path',
                        'language_id','created_by','agent_id','product_id'
                    ]))
                    <div class="col-md-4 mb-3">
                        <strong>{{ __('labels.'.$key) }} :</strong><br>
                        <span class="text-muted">{{ $value ?? 'N/A' }}</span>
                    </div>
                @endif

            @endforeach
        </div>

        <hr>

        {{-- SUPPLIER & STATUS --}}
        <div class="row mt-3">
            <div class="col-md-4">
                <strong>{{ __('labels.supplier') }} :</strong><br>
                {{ DB::table('suppliers')->where('id', $item->supplier_id)->value('name') ?? 'N/A' }}
            </div>

            <div class="col-md-4">
                <strong>{{ __('labels.status') }} :</strong><br>
                @switch($item->status_id)
                    @case(1)
                        {{ __('labels.pending') }}
                        @break
                    @case(2)
                        {{ __('labels.approved') }}
                        @break
                    @case(3)
                        {{ __('labels.deny') }}
                        @break
                    @default
                        {{ __('labels.unknown') }}
                @endswitch
            </div>
        </div>

    </div>
</div>
@endif
