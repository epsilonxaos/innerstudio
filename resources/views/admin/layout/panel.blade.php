<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta charset="UTF-8">
@if(request()->is(['admin/calendario/asistencia*']))
    <title>Lista: {{$instructor -> name}}, Hora: {{$string_date}}</title>
@else
    <title>INNER | PANEL</title>
@endif
@include('admin.include.metas')
@stack('css')
</head>
<!-- END: Head-->
<body class="horizontal-layout page-header-light horizontal-menu 2-columns {{( !request() -> is ('/') ) ? '' : 'login-bg '}} {{( request() -> is (['clientes']) ) ? 'app-page' : ''}} blank-page blank-page" data-open="click" data-menu="horizontal-menu" data-col="2-columns">

@if(!request()->is('/'))
@include('admin.include.header')
@endif

@yield('contenido')

@include('admin.include.scripts')
@stack('js')
</body>
</html>