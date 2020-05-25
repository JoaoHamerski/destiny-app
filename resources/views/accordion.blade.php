<ul class="list-unstyled">

@foreach($item as $key => $value)
	@if (is_object($value) || is_array($value))
		<li class="py-1 @if(count((array) $value) > 0) collapsible @endif">
			<strong>{{ $key }}</strong>
		</li>
	
			@include('accordion', ['item' => $value])
	@else
		<li class="py-1">
			<strong>{{ (string) $key }}</strong>: {{ Resolve::value($value) }}
		</li>
	@endif
@endforeach

</ul>
