@section('blame')
<div class="col-xs-12"><hr/></div>
<div class="col-xs-6" >
	<span class="blame">Erstellt 
	am {!! $edit->model->created_at !!}
	von {!! $edit->model->createdBy?(string)$edit->model->createdBy:'System' !!}</span>
</div>
<div class="col-xs-6">
@if ($edit->model->updated_at == $edit->model->created_at)
	{{-- Bisher keine Änderungen --}}
@else
	<span class="blame pull-right">Geändert 
	am {!! $edit->model->updated_at !!}
	von {!! $edit->model->updatedBy?(string)$edit->model->updatedBy:'System' !!}</span>
@endif
</div>
@endsection
