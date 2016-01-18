@extends('edit')

@if ($edit->status == 'show')
	@include('partials.blame')
	@include('partials.map.canvas')
	@include('partials.map.script')
	@include('partials.list.objects')
	@include('partials.list.notes',['base'=>'/partner'])
@endif

@section('edit')
	<div class="col-xs-12 col-md-6">
		<fieldset><legend>Partner</legend>
			{!! $edit !!}
		</fieldset>
	</div>
@endsection

@section('content')
<div class="container">
	<div class="row">
		@yield('edit')
		@if ($edit->status == 'show')
			@yield('objects')
			@yield('notes')
			@yield('map')
			@yield('blame')
		@endif
	</div>
</div>
@endsection
