@extends('app')
@section('content')
<div class="container">
	<div class="row">
	@if (count($set->data) == 0) 
   		<div class="col-xs-12">
			Keine Photos vorhanden	
		</div>
	@else
		@foreach($set->data as $photo)
   		<div class="col-xs-12 col-md-6">
			<div class="row">
   				<div class="col-xs-12">
					<img class="img-responsive img-rounded" src="{!! url('/01/fc/op?id='.$photo->id) !!}" />	
				</div>
   				<div class="col-xs-6"> 
					<b>{!! $photo->object->partner->name !!}</b><br/>
					{!! $photo->object->address1 !!}<br/>{!! $photo->object->address2 !!}
				</div>
   				<div class="col-xs-6"> 
				<span class="pull-right">
					{!! $photo->created_at !!}
				</span>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	@endif
</div>
@endsection
