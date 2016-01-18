@extends('edit')

@if ($edit->status == 'show')
	@include('partials.blame')
{{--
	@include('partials.map.canvas')
	@include('partials.map.script')
--}}
	@include('partials.list.notes',['base'=>'/task','heading' => 'Notizen zur Aufgabe'])
@endif

@section('edit')
	<div class="col-xs-12 col-lg-6">
		<fieldset><legend>Aufgabe</legend>
			{!! $edit !!}
		</fieldset>
	</div>
@endsection

@section('content')
<div class="container">
	<div class="row">
		@yield('edit')
		@if ($edit->status == 'show')
			@yield('notes')
			@yield('blame')
		@endif
	</div>
</div>
@endsection
