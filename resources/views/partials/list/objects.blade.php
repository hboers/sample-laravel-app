@section('objects')
	@if (count($edit->model->objects))
		<div class="col-xs-12 col-md-6">
			<fieldset><legend>Standorte <span class="pull-right">{!! count($edit->model->objects) !!}</span></legend>
			<div class="row objects">
			@foreach ($edit->model->objects as $object)
			<div class="col-xs-12 col-sm-6">
				<a href="{!! url('/object/edit?show='.$object->id) !!}" class="btn btn-default">{!! FA::icon('square-o') !!} {!! $object->name !!}</a>
			</div>
			@endforeach
			</div>
			</fieldset>
		</div>
	@endif
@endsection
