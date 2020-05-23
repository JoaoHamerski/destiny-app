@foreach($item as $key => $value)
	@if (is_object($value) || is_array($value))
		<div class="alert alert-danger">ITERAÇÃO: {{ $loop->iteration }}</div>

		<ul class="list-group">
			<li class="list-group-item bg-primary text-white">{{ $key }}</li>
		</ul>

		@include('accordion', ['item' => $value])

	@else
		<ul class="list-group">
			<li class="list-group-item">{{ $key }}: {{ Helper::resolveValue($key, $value) }}</li>
		</ul>
	@endif
@endforeach