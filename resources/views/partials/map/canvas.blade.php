@section('map')
	@if ($edit->model->zipcode && $edit->status == 'show')
		<div class="col-xs-12 col-md-6">
		<fieldset><legend>Karte</legend>
			<div class="map_container">
    			<div id="map_canvas" class="map_canvas"></div>
			</div>
			<div class="map_info">
				{!! $edit->model->geosource !!}: 
					( {!! $edit->model->lat !!}, {!! $edit->model->lng !!} )
			</div>
		</fieldset>
		</div>
	@endif
@endsection

