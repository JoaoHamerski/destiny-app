@extends('layout')

@section('content')

  <!-- Modal -->
  <div class="modal fade show" style="display: block;" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          @include('accordion', ['item' => $item])
        </div>

        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    
    <script>
      $('li').click(function() {
        $(this).toggleClass('show');

        console.log($(this).next().prop('scrollHeight'));
      });
    </script>
  @endpush

@endsection