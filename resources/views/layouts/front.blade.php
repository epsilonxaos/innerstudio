<!DOCTYPE html>
<html lang="es">
	<head>
		@include('include.metas')

		@stack('style')
	</head>
	<body class="fade-in">
		@include('include.header')

		@yield('contenido')

		@include('include.footer')

		@include('include.modals')

		@include('include.scripts')

		@stack('js')
	</body>
</html>