

@foreach($array as $item)
	@assertTrue($loop->first)
	@break
	@assertFalse(true, 'Break should exit the loop')
@endforeach

@foreach($array as $key => $val)
	@assertTrue($loop->first)
	@break
@endforeach

@foreach($getArray() as $key)
	@assertTrue($loop->first)
	@break
@endforeach


@foreach(array_merge($array, $getArray()) as $key)
	@assertTrue($loop->first)
	@break
@endforeach

@foreach($getArray(true) as $key => $val)
	@assertTrue($loop->first)
	@break
@endforeach

@foreach($dataClass->array as $key => $val)
	@assertTrue($loop->first)
	@break
@endforeach

@foreach($dataClass->getArray() as $key => $val)
	@assertTrue($loop->first)
	@break
@endforeach

@foreach($dataClass->getArray(true) as $key => $val)
	@assertTrue($loop->first)
	@break
@endforeach


@foreach($dataClass->getArray(true) as $key => $val)
	@assertTrue($loop->first)
	@break

	@foreach($dataClass->getArray() as $key2 => $val2)
		@assertTrue(is_int($loop->index))

	@endforeach
@endforeach



@set('testArray', $dataClass->getArray())
@set('total', count($testArray))

@foreach($dataClass->getArray() as $key => $val)

	@assertTrue($loop instanceof \Radic\BladeExtensions\Core\LoopItemInterface, '$loop should be an instance of LoopItemInterface')
	@assertTrue($loop->index == $key, 'index')
	@assertTrue($loop->index1 == $key + 1, '1 based index')
	@assertTrue($loop->revindex == ($total - 1) - $key, 'revindex')
	@assertTrue($loop->revindex1 == $total - $key, '1 based revindex')

	@if($key == 0)
		@assertTrue($loop->length == $total, 'total')

		@assertTrue($loop->first, 'first should be true')
		@assertNotTrue($loop->last, 'last should be false')

		@assertTrue($loop->even, 'even should be true')
		@assertNotTrue($loop->odd, 'odd should be false')
	@elseif($key == 1)
		@assertTrue($loop->odd, 'odd should be true')
		@assertNotTrue($loop->even, 'even should be false')

		@assertNotTrue($loop->first, 'first should be false')
		@assertNotTrue($loop->last, 'last should be false')
	@elseif($key == $total - 1)
		@assertTrue($loop->last, 'last should be true')
		@assertNotTrue($loop->first, 'last should be false')
	@else
		@assertNotTrue($loop->first, 'first should be false')
		@assertNotTrue($loop->last, 'last should be false')
	@endif



	@foreach($dataClass->getArray() as $key2 => $val2)

		@assertTrue($loop instanceof \Radic\BladeExtensions\Core\LoopItemInterface, '$loop should be an instance of LoopItemInterface')
		@assertTrue($loop->index == $key2, 'index')
		@assertTrue($loop->index1 == $key2 + 1, '1 based index')
		@assertTrue($loop->revindex == ($total - 1) - $key2, 'revindex')
		@assertTrue($loop->revindex1 == $total - $key2, '1 based revindex')

		@if($key2 == 0)
			@assertTrue($loop->length == $total, 'total')

			@assertTrue($loop->first, 'first should be true')
			@assertNotTrue($loop->last, 'last should be false')

			@assertTrue($loop->even, 'even should be true')
			@assertNotTrue($loop->odd, 'odd should be false')
		@elseif($key2 == 1)
			@assertTrue($loop->odd, 'odd should be true')
			@assertNotTrue($loop->even, 'even should be false')

			@assertNotTrue($loop->first, 'first should be false')
			@assertNotTrue($loop->last, 'last should be false')
		@elseif($key2 == $total - 1)
			@assertTrue($loop->last, 'last should be true')
			@assertNotTrue($loop->first, 'last should be false')
		@else
			@assertNotTrue($loop->first, 'first should be false')
			@assertNotTrue($loop->last, 'last should be false')
		@endif


		{{-- test parent loop --}}
		@if($key == 0)
			@assertTrue($loop->parent->first, 'first should be true')
			@assertNotTrue($loop->parent->last, 'last should be false')
		@endif
		@if($key == $key2)
			@assertTrue($val == $val2, 'Assert both parent and child are the same')
		@endif

	@endforeach


@endforeach

@assertNull($loop, 'End of loop stack should be null but is not null')
