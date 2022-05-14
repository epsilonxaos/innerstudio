<!-- BEGIN: Header-->
<header class="page-topbar" id="header">
    <div class="navbar navbar-fixed">
        <nav class="navbar-main navbar-color nav-collapsible sideNav-lock">
            <div class="nav-wrapper">
                <ul class="left">
                    <li>
                        <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="{{route('admin.customer.list')}}"><img src="{{asset('admin/images/logo/logo-2.svg')}}" alt="materialize logo"><span class="logo-text hide-on-med-and-down"></span></a></h1>
                    </li>

                </ul>
                <div class="header-search-wrapper hide-on-med-and-down">
                    {{--<input class="header-search-input z-depth-2" type="text" name="Search" placeholder="Explore Materialize">--}}
                    <ul>
                        @if(Auth::user()->checkPermiso("ver_calendario"))
                            <li class="{{( request() -> is ('admin/calendario*') ) ? 'active' : ''}}">
                                <a href="{{route('admin.calendar.list')}}"><span>Calendario</span></a>
                            </li>
                        @endif
                        @if(Auth::user()->checkPermiso("ver_clases"))
                        <li class="{{( request() -> is ('admin/clases*') || request() -> is ('admin/clase*') ) ? 'active' : ''}}">
                            <a href="{{route('admin.lesson.list')}}"><span>Horarios y Clases</span></a>
                        </li>
                        @endif
                        @if(Auth::user()->checkPermiso("ver_ventas"))
                        <li class="{{ (request() -> is ('admin/ventas*') || request() -> is ('admin/venta*')) ? 'active' : '' }}">
                            <a href="{{route('admin.purchase.list')}}"><span>Ventas</span></a>
                        </li>
                        @endif
                        @if(Auth::user()->checkPermiso("ver_reservaciones"))
                        <li class="{{ (request() -> is ('admin/reservations*') ? 'active' : '') }}">
                            <a href="{{route('admin.reservations.list')}}"><span>Reservaciones</span></a>
                        </li>
                        @endif
                        @if(Auth::user()->checkPermiso("ver_clientes"))
                        <li class="{{(request() -> is ('admin/clientes*') || request() -> is ('admin/cliente*')) ? 'active' : ''}}">
                            <a href="{{route('admin.customer.list')}}"><span>Clientes</span></a>
                        </li>
                        @endif




                        <li class="{{( request() -> is ('admin/cupones*') || request() -> is ('admin/paquetes*') || request() -> is ('admin/instructores*') || request() -> is ('admin/tapetes*') ) ? 'active' : ''}}">

                            <a class="dropdown-menu" href="#" data-target="other"><span>Más opciones</span></a>
                            <ul class="dropdown-content dropdown-horizontal-list" id="other">
                                @if(Auth::user()->checkPermiso("ver_cupones"))
                                <li class="{{ (request() -> is ('admin/cupones*') ? 'active' : '') }}" data-menu="">
                                    <a href="{{route('admin.cupon.list')}}">Cupones</a>
                                </li>
                                @endif
                                <li class="{{ (request() -> is ('admin/gallery*') ? 'active' : '') }}" data-menu="">
                                    <a href="{{route('admin.gallery.list')}}">Galerias</a>
                                </li>
                                @if(Auth::user()->checkPermiso("ver_paquetes"))
                                <li class="{{( request() -> is ('admin/paquetes*') ) ? 'active' : ''}}" data-menu="">
                                    <a href="{{route('admin.package.list')}}"><span>Paquetes</span></a>
                                </li>
                                @endif
                                @if(Auth::user()->checkPermiso("ver_instructor"))
                                <li class="{{( request() -> is ('admin/instructores*') ) ? 'active' : ''}}" data-menu="">
                                    <a href="{{route('admin.instructor.list')}}"><span>Instructor</span></a>
                                </li>
                                @endif
                                @if(Auth::user()->checkPermiso("ver_lugares"))
                                <li class="{{( request() -> is ('admin/tapetes*') ) ? 'active' : ''}}" data-menu="">
                                    <a href="{{route('admin.mat.list')}}"><span>Lugares</span></a>
                                </li>
                                @endif
                                @if(Auth::user()->checkPermiso("ver_cuentas"))
                                <li class="{{( request() -> is ('admin/accounts*') ) ? 'active' : ''}}" data-menu="">
                                    <a href="{{route('admin.accounts.list')}}"><span>Cuentas</span></a>
                                </li>
                                @endif
                                @if(Auth::user()->checkPermiso("ver_roles"))
                                <li class="{{( request() -> is ('admin/rol*') ) ? 'active' : ''}}" data-menu="">
                                    <a href="{{route('admin.rol.list')}}"><span>Roles</span></a>
                                </li>
                                @endif
                            </ul>
                        </li>
                       {{-- @if(Auth::guard('admin')->user()->permisos('see_calendar'))
                        <li class="{{( request() -> is ('full-calendar') ) ? 'active' : ''}}"><a href="{{route('fullcalendar')}}"><span>Calendario</span></a>
                        </li>
                        @endif
                        @if(Auth::guard('admin')->user()->permisos('see_pacient'))
                        <li class="{{( request() -> is ('pacientes') ) ? 'active' : ''}}"><a href="{{route('paciente.list')}}"><span>Pacientes</span></a>
                        </li>
                        @endif
                        @if(Auth::guard('admin')->user()->permisos('see_doctor'))
                        <li class="{{( request() -> is ('doctores') ) ? 'active' : ''}}"><a href="{{route('doctor.list')}}"><span>Doctores</span></a>
                        </li>
                        @endif
                        @if(Auth::guard('admin')->user()->permisos('see_solicitud'))
                        <li class="{{( request() -> is ('solicitud') ) ? 'active' : ''}}"><a href="{{route('solicitud.list')}}"><span>Solicitudes</span></a>
                        </li>
                        @endif
                        @if(Auth::guard('admin')->user()->permisos('see_new_pacient'))
                        <li class="{{( request() -> is ('prepaciente') ) ? 'active' : ''}}"><a href="{{route('prepaciente.list')}}"><span>Prepacientes</span></a>
                        </li>
                        @endif
                            @if(Auth::guard('admin')->user()->permisos('see_noticia'))
                                <li class="{{( request() -> is ('promocion') ) ? 'active' : ''}}"><a href="{{route('promocion.list')}}"><span>Noticias</span></a>
                                </li>
                            @endif--}}
                    </ul>
                </div>
                <ul class="navbar-list right">

                    <li class="hide-on-med-and-down">
                        <a class="waves-effect waves-block waves-light toggle-fullscreen" href="javascript:void(0);"><i class="material-icons">settings_overscan</i></a>
                    </li>
                  {{-- <li class="hide-on-large-only"><a class="waves-effect waves-block waves-light search-button" href="javascript:void(0);"><i class="material-icons">search         </i></a></li>
                    <li><a class="waves-effect waves-block waves-light notification-button" href="javascript:void(0);" data-target="notifications-dropdown"><i class="material-icons">notifications_none<small class="notification-badge orange accent-3">5</small></i></a></li>--}}
                    <li>
                        <a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown"><span class="avatar-status avatar-online"><img src="{{asset('admin/images/avatar.png')}}" alt="avatar"><i></i></span></a>
                    </li>

                    {{--@if(Auth::guard('admin')->user()->permisos('see_user_admin') || Auth::guard('admin')->user()->permisos('see_permission'))
                    <li class="hide-on-med-and-down">
                        <a class="waves-effect waves-block waves-light translation-button" style="line-height: 1;" href="javascript:void(0);" data-target="translation-dropdown"><i class="material-icons">settings</i></a>
                    </li>
                    @endif--}}

                   {{-- <li><a class="waves-effect waves-block waves-light sidenav-trigger" href="#" data-target="slide-out-right"><i class="material-icons">format_indent_increase</i></a></li>--}}
                </ul>
                <!-- translation-button-->
                <ul class="dropdown-content" id="translation-dropdown">
                    {{--@if(Auth::guard('admin')->user()->permisos('see_user_admin'))
                    <li><a class="grey-text text-darken-1" href="{{route('admin.list')}}"><i class="material-icons">people</i> Usuarios</a></li>
                    @endif
                    @if(Auth::guard('admin')->user()->permisos('see_permission'))
                    <li><a class="grey-text text-darken-1" href="{{route('admin.rol.list')}}"><i class="material-icons">lock</i> Permisos</a></li>
                    @endif--}}
                </ul>
                <!-- profile-dropdown-->
                <ul class="dropdown-content" id="profile-dropdown">
                   {{-- @if(Auth::guard('admin')->user()->id != 1)
                    <li><a class="grey-text text-darken-1" href="{{route('admin.edit', Auth::guard('admin')->user()->id)}}"><i class="material-icons">person_outline</i> Perfil</a></li>
                    @endif
                    <li><a class="grey-text text-darken-1" href="{{route('logout')}}"><i class="material-icons">keyboard_tab</i> Logout</a></li>--}}
                    <li><a class="grey-text text-darken-1" href="{{route('admin.logout')}}"><i class="material-icons">keyboard_tab</i> Logout</a></li>
                </ul>
            </div>
            <nav class="display-none search-sm">
                <div class="nav-wrapper">
                    <form>
                        <div class="input-field">
                            <input class="search-box-sm" type="search" required="">
                            <label class="label-icon" for="search"><i class="material-icons search-sm-icon">search</i></label><i class="material-icons search-sm-close">close</i>
                        </div>
                    </form>
                </div>
            </nav>
        </nav>
        <!-- BEGIN: Horizontal nav start-->
        {{--<nav class="white hide-on-med-and-down" id="horizontal-nav">
            <div class="nav-wrapper">
                <ul class="left hide-on-med-and-down" id="ul-horizontal-nav" data-menu="menu-navigation">
                    <li><a href="{{route('fullcalendar')}}" data-target="DashboardDropdown"><i class="material-icons">today</i><span>Calendario</span></a>
                    </li>
                </ul>
            </div>
        </nav>--}}
        <!-- END: Horizontal nav start-->
    </div>
</header>
<!-- END: Header-->

<!-- BEGIN: SideNav-->
<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-fixed hide-on-large-only">
    <div class="brand-sidebar sidenav-light"></div>
    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed hide-on-large-only menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
        <li class="navigation-header"><a class="navigation-header-text">Opciones Panel</a><i class="navigation-header-icon material-icons">more_horiz</i>
        </li>
        @if(Auth::user()->checkPermiso("ver_calendario"))
        <li class="bold"><a class="waves-effect waves-cyan " href="{{route('admin.calendar.list')}}"><i class="material-icons">today</i><span class="menu-title" data-i18n="">Calendario</span></a>
        </li>
        @endif
        @if(Auth::user()->checkPermiso("ver_clases"))
        <li class="bold"><a class="waves-effect waves-cyan " href="{{route('admin.lesson.list')}}"><i class="material-icons">today</i><span class="menu-title" data-i18n="">Clases</span></a>
        </li>
        @endif
        @if(Auth::user()->checkPermiso("ver_ventas"))
        <li class="bold"><a class="waves-effect waves-cyan " href="{{route('admin.purchase.list')}}"><i class="material-icons">today</i><span class="menu-title" data-i18n="">Ventas</span></a>
        </li>
        @endif
        @if(Auth::user()->checkPermiso("ver_reservaciones"))
        <li class="bold"><a class="waves-effect waves-cyan " href="{{route('admin.reservations.list')}}"><i class="material-icons">today</i><span class="menu-title" data-i18n="">reservaciones</span></a>
        </li>
        @endif
        @if(Auth::user()->checkPermiso("ver_clientes"))
        <li class="bold"><a class="waves-effect waves-cyan " href="{{route('admin.customer.list')}}"><i class="material-icons">today</i><span class="menu-title" data-i18n="">Clientes</span></a>
        </li>
        @endif
        @if(Auth::user()->checkPermiso("ver_cupones"))
        <li class="bold"><a class="waves-effect waves-cyan " href="{{route('admin.cupon.list')}}"><i class="material-icons">today</i><span class="menu-title" data-i18n="">Cupones</span></a>
        </li>
        @endif
        @if(Auth::user()->checkPermiso("ver_paquetes"))
        <li class="bold"><a class="waves-effect waves-cyan " href="{{route('admin.package.list')}}"><i class="material-icons">today</i><span class="menu-title" data-i18n="">Paquetes</span></a>
        </li>
        @endif
        @if(Auth::user()->checkPermiso("ver_instructor"))
        <li class="bold"><a class="waves-effect waves-cyan " href="{{route('admin.instructor.list')}}"><i class="material-icons">today</i><span class="menu-title" data-i18n="">Instructores</span></a>
        </li>
        @endif
        @if(Auth::user()->checkPermiso("ver_lugares"))
        <li class="bold"><a class="waves-effect waves-cyan " href="{{route('admin.mat.list')}}"><i class="material-icons">today</i><span class="menu-title" data-i18n="">Lugares</span></a>
        </li>
        @endif
        @if(Auth::user()->checkPermiso("ver_cuentas"))
        <li class="bold"><a class="waves-effect waves-cyan " href="{{route('admin.accounts.list')}}"><i class="material-icons">today</i><span class="menu-title" data-i18n="">Cuentas</span></a>
        </li>
        @endif
        @if(Auth::user()->checkPermiso("ver_roles"))
        <li class="bold"><a class="waves-effect waves-cyan " href="{{route('admin.rol.list')}}"><i class="material-icons">today</i><span class="menu-title" data-i18n="">Roles</span></a>
        </li>
        @endif
   
       
   
      
      
        
     
        
    </ul>
    <div class="navigation-background"></div><a class="sidenav-trigger btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>
<!-- END: SideNav-->
