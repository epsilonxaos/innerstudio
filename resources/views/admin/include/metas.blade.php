<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta name="description" content="Panel de administracion de inner">
<meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard">
<meta name="author" content="ThemeSelect">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="apple-touch-icon" href={{asset("admin/images/favicon/medytec_favicon.ico")}}>
<link rel="apple-touch-icon" href={{asset("admin/images/favicon/medytec_favicon.ico")}}>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- BEGIN: VENDOR CSS-->
<link rel="stylesheet" type="text/css" href={{asset("admin/vendors/vendors.min.css")}}>
<!-- END: VENDOR CSS-->
<!-- BEGIN: Page Level CSS-->
{{--<link rel="stylesheet" type="text/css" href={{asset("admin/css/themes/vertical-gradient-menu-template/materialize.css")}}>
<link rel="stylesheet" type="text/css" href={{asset("admin/css/themes/vertical-gradient-menu-template/style.css")}}>--}}
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/themes/horizontal-menu-template/materialize.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/themes/horizontal-menu-template/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/layouts/style-horizontal.css')}}">
@if(request()->is(['admin/calendario*','admin/clientes*', 'admin/instructores*', 'admin/paquetes*', 'admin/tapetes*', 'admin/clases*', 'admin/ventas*', 'admin/cupones*','admin/reservations*','admin/accounts*','admin/rol*']))
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/pages/app-sidebar.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/pages/app-contacts.css')}}">
@endif
<link rel="stylesheet" type="text/css" href={{asset("admin/fonts/fontawesome/css/all.css")}}>
<link rel="stylesheet" type="text/css" href={{asset("admin/css/pages/login.css?v=1.0")}}>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- END: Page Level CSS-->
<!-- BEGIN: Custom CSS-->
 <link rel="stylesheet" type="text/css" href={{asset("admin/css/custom/custom.css?v=1.2")}}>
<link rel="stylesheet" type="text/css" href={{asset("admin/css/custom/general.css")}}>
<!-- END: Custom CSS-->
<script>
    var _PATH = '{{asset('')}}';
</script>