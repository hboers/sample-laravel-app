@section('script')
	@if ($edit->model->zipcode)
		<script>
			$(function(){
				var element = document.getElementById("map_canvas");
				if (element) {
					element.create( {!! $edit->model->lat !!},{!! $edit->model->lng !!} );
					element.marker( {!! $edit->model->lat !!},{!! $edit->model->lng !!}, '{!! (string)$edit->model !!}' );
				}
			});
		</script>
	@endif
@endsection
