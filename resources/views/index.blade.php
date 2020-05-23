@extends('layout')

@section('title', 'Destiny App')

@section('content')
  
    <div class="card-group">
      @foreach($items as $item)
        <div class="col-md-3 px-1 mb-2">
          <div class="card item-card bg-secondary">
            <div class="row no-gutters">
              <div class="col-md-4">
                <img src="{{ Helper::resolveIcon($item) }}" class="card-img" alt="...">
              </div>

              <div class="col-md-8">
                <div class="card-body py-0 pt-2">
                  <h6 class="card-title my-0 py-0 text-white font-weight-bold">
                    {!!  Helper::resolveName($item) !!}
                  </h6>

                  <p class="card-description">
                    <small class="text-light">{!! Str::limit(Helper::resolveDescription($item), 30) !!}</small>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    
    <div class="col  mt-3">
    {{ $items->links() }}
    </div>
@endsection