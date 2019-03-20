<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<title>My app</title>
</head>
<body>
	<nav class="navbar  navbar-dark bg-dark">
		<a class="navbar-brand" href="/">
			Home
		</a>
		<a class="navbar-nav" href="/admin">
			Admin home
		</a>
	</nav>

	<div class="flex-center position-ref full-height">
		<div class="container">
			@if ($errors->any())
			<div class="row mt-5"></div>
			<div class="alert alert-danger ">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			@if (\Session::has('success'))
			<div class="row mt-5"></div>
			<div class="alert alert-success">
			{!! \Session::get('success') !!}
			</div>
			@endif
			@yield('content')
		</div>
	</div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
</html>
