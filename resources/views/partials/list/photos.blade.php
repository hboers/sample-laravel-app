@section('photos')
	@if (count($edit->model->photos))
		<div class="col-xs-12">

				<div class="row">
				@foreach ($edit->model->photos as $photo)

				<div class="col-xs-4">
				<a href="{!! url('/photo/edit?show='.$photo->id) !!}"><img 
					style="width:100%" 
					src="{!! url('/01/fc/op?id='.$photo->id) !!}" 
					alt="{!! $photo->object->address1 !!}, {!! $photo->object->address2 !!}"
				/></a>	
				</div>

				@endforeach
				</div>

		</div>
	@endif
@endsection
