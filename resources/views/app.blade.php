<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    {!! Rapyd::styles() !!}
    {!! FA::css() !!}
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><img src="{!! url("/images/logo_oben.png") !!}" alt="KUNDENNAME"/></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li @if(Request::is('home*') || Request::is('/')) class="active" @endif><a href="{{ url('/') }}">{!! FA::icon('home') !!} Home</a></li>

					<li @if(Request::is('partner*')) class="active" @endif><a href="{{ url('/partner') }}">{!! FA::icon('building') !!} Partner</a></li>
					<li @if(Request::is('object*')) class="active" @endif><a href="{{ url('/object') }}">{!! FA::icon('square-o') !!} Standorte</a></li>
					<li @if(Request::is('task*')) class="active" @endif><a href="{{ url('/task') }}">{!! FA::icon('wrench') !!} Aufgaben</a></li>
					<li @if(Request::is('photo*')) class="active" @endif><a href="{{ url('/photo') }}">{!! FA::icon('camera') !!} Fotos</a></li>

				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">{!! FA::icon('sign-in') !!} Anmelden</a></li>
						<li><a href="{{ url('/auth/register') }}">{!! FA::icon('send-o') !!} Registrieren</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
								aria-expanded="false"><img class="profile img-responsive img-circle" 
								src="{{ url( '/01/fc/pp?id='.Auth::user()->id ) }}" />{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/home/profile/edit?show='.Auth::user()->id) }}">{!! FA::icon('user') !!} Mein Profil</a></li>
								<li><a href="{{ url('/auth/logout') }}">{!! FA::icon('sign-out') !!} Abmelden</a></li>
							</ul>
						</li>
					@endif
				</ul>

			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	{!! Rapyd::scripts() !!}
	<script src="{!! url('/js/app.js') !!}"></script>
	@yield('script')
</body>
</html>
