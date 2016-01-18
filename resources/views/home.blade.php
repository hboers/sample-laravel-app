@extends('app')

@section('content')
<div class="container">



	<div class="row">

		<div class="col-xs-12 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Debug Info</div>
				<div class="panel-body">
				</div>
			</div>
		</div>

@if ( count(Auth::user()->roles) > 0 )

		<div class="col-xs-12 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Aktuelle Aufgaben</div>
				<div class="panel-body">
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Aktuelle Termine</div>
				<div class="panel-body">
				</div>
			</div>
		</div>


@else

		<div class="col-md-10 col-md-offset-1 ">
			<div class="panel panel-default">
				<div class="panel-heading">Registerung erfolgreich</div>
				<div class="panel-body">
				<p>
					Sie haben sich für die KUNDENNAME App registriert.
				</p>
				<p>
					Sie haben noch keine Berechtigungen. Der
					Systemadministrator wird Ihre Berechtigungen innerhalb 
					der nächsten 24 Stunde eintragen. Danach können Sie mit
				    derKUNDENNAME App arbeiten.
				</p>
				</div>
			</div>
		</div>

@endif

	</div>
</div>
@endsection
