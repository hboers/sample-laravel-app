@extends('app')

@if ($edit->status == 'show')
		@include('partials.list.notes',['base'=>'/photo'])
@endif

@section('edit')
	<div class="col-xs-12 col-md-6">
		{!! $edit !!}
	</div>
@endsection

@section('content')
<div class="container">
	<div class="row">
		@yield('edit')
		@if ($edit->status == 'show')
			@yield('notes')
		@endif
	</div>
</div>
@endsection
