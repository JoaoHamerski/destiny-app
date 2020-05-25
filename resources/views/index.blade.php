@extends('layout')

@section('title', 'Destiny App')

@section('content')
  
    <div class="card-group">
      @foreach($items as $item)
        <div class="col-6 col-xs-6 col-md-3 px-1 mb-2">
          <div class="card item-card bg-secondary">
            <div class="row no-gutters">
              <img src="{{ Helper::resolveIcon($item) }}" class="card-img" alt="...">

              <div class="col">
                <div class="card-body py-0 px-2 pt-2">
                  <h6 class="card-title my-0 py-0 text-white font-weight-bold">
                    {!!  Helper::resolveName($item) !!}
                  </h6>

                  <p class="card-description">
                    <small class="text-light">
                      {{ __($DBH->getTableNameByHash(json_decode($item->json)->hash)) }}
                      
                      @if (! is_null($itemType = json_decode($item->json)->itemTypeDisplayName ?? null)
                      && ! empty($itemType))
                        &bull; {{ $itemType }}
                      @endif
                    </small>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    
    <div class="col mt-3">
      {{ $items->links() }}
    </div>
@endsection