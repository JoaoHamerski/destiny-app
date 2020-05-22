@extends('layout')

@section('title', 'Destiny App')

@section('content')
	<div class="container">
	
		@foreach($items as $item)
			<div class="alert alert-danger"></div>
			
			{!! \Helper::displayDataRecursively($item) !!}
		@endforeach

		
		<div>Exibindo <strong>{{ $items->count() }} de {{ $items->total() }}</strong></div>
		
		{{ $items->links() }}


	</div>

@endsection