@section('notes')
	@if (count($edit->model->notes))
		<div class="col-xs-12 col-md-6">
			<fieldset><legend>{!! isset($heading)?$heading:'Notizen' !!} <span class="pull-right">{!! count($edit->model->notes) !!}</span></legend>
			<div class="row">
			@foreach ($edit->model->notes as $note)
			<div class="col-xs-12 ">
				<div class="row note">

					<div class="col-xs-12">
						{!!  $note->text  !!}
					</div>

					<div class="col-xs-4">
						Angelegt am {!!  $note->created_at  !!}
						von {!!  $note->createdBy ? (string)  $note->createdBy : 'System'  !!}
					</div>

					<div class="col-xs-4">
						@if($note->updated_at == $note->created_at)
						@else
						Geändert am {!!  $note->updated_at  !!}
						von {!! $note->updatedBy ? (string) $note->updatedBy : 'System'  !!}
						@endif
					</div>

					<div class="col-xs-4 pull-right">
						<a href="{!! url($base.'/note?modify='.$note->id) !!}" class="btn btn-default">{!! FA::icon('pencil') !!}</a>
						<a href="{!! url($base.'/note?do_delete='.$note->id) !!}" class="btn btn-default">{!! FA::icon('trash') !!}</a>
					</div>

				</div>	
			</div>
			@endforeach
			</div>
			</fieldset>
		</div>
	@endif
@endsection
