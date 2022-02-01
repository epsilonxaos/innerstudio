@extends('admin.layout.panel')
@push('css')
    <link rel="stylesheet" type="text/css" href={{asset("admin/css/custom/components/datepicker.css")}}>
    <link rel="stylesheet" type="text/css" href={{asset("admin/css/custom/components/fullCalendar.css")}}>
    <style>
            #datepicker .ui-state-active,
            #datepicker .ui-widget-content .ui-state-active,
            #datepicker .ui-widget-header .ui-state-active,
            #datepicker a.ui-button:active,
            #datepicker .ui-button:active,
            #datepicker .ui-button.ui-state-active:hover {background: var(--naranja);}
            #datepicker .ui-datepicker .ui-datepicker-header {background: var(--naranja)}
            #view-full-calendar div.content-switcher span.switcher.switcher-1 input:checked + label,
            #view-full-calendar div.content-switcher span.switcher.switcher-1 input:not(:checked) + label {background: var(--naranja)}
            /* #calendar th.fc-day-header.fc-widget-header.fc-today {background: var(--main) } */
            @media screen and (max-width: 430px) {
                .custom-styles input[name="busqueda"] {width: 100%}
                .custom-styles .p-l-25 {padding-left: 0px !important;}
                .custom-styles #c-change-view-doctor {font-size: 10px; margin-right: 0px !important}
                .custom-styles #c-current-date {display: block}
            }
            @media screen and (max-width: 768px) {
                .custom-styles input[name="busqueda"] {width: 100%}
                .custom-styles .txt-rigth {text-align: center}
            }
            .flatpickr-calendar select{display: inline-block;}
        </style>
@endpush
@section('contenido')
    <div id="main">
        <div class="row">
            <div class="col s12">
                <div class="container mw1500" id="view-full-calendar">
                    @if(session()->has('success'))
                        <div class="card-alert card blue darken-4">
                            <div class="card-content white-text">
                                <p>
                                    <i class="material-icons">check_circle</i>  {{ session()->get('success') }}
                                </p>
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-content custom-styles">
                            <div class="row">
                                <div class="col s12 m12 l12 xl6">
                                    <div class="row">
                                        {{--<div class="col s12 m6">
                                            <form method="POST" action="{{route('cita.busqueda.list')}}">
                                                @method('PUT')
                                                @csrf
                                                <div class="input-field flt-left">
                                                    <i class="material-icons prefix">search</i>
                                                    <input id="icon_prefix" type="text" name="busqueda" class="validate m-b-3">
                                                    <label for="icon_prefix">Buscar</label>
                                                </div>
                                            </form>
                                        </div>--}}
                                        <div class="col s12 m6">
                                            <div class="flt-left p-l-25">
                                                <a class="waves-effect mt-1 waves-light btn btn-round m-r-20 btn-main" id="c-change-view-doctor"><i class="material-icons left">person</i> VER CITAS POR INSTRUCTOR </a>
                                                <a class="waves-effect mt-1 waves-light btn btn-round m-r-20 hide" id="c-change-view-week"><i class="material-icons left">today</i> VER CITAS POR SEMANA </a>
                                               {{-- <a class="btn-floating mt-1 waves-effect waves-light modal-trigger" href="#modal_print_schedule">
                                                    <i class="material-icons">print</i>
                                                </a>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l6 xl3">
                                    <div class="content-switcher mt-1">
                                        <span class="switcher switcher-1">
                                           <input type="checkbox" id="switcher-1">
                                           <label for="switcher-1"></label>
                                        </span>
                                    </div>
                                </div>
                                <div class="col s12 m6 l6 xl3">
                                    <div class="input-field txt-rigth">
    
                                        {{-- <a class="btn-floating mt-1 waves-effect waves-light" id="c-change-view-week">
                                             <i class="material-icons">today</i>
                                         </a>
                                         <a class="btn-floating mt-1 waves-effect waves-light" id="c-change-view-doc">
                                             <i class="material-icons">perm_contact_calendar</i>
                                         </a>--}}
                                        <a class="btn-floating mt-1 waves-effect waves-light m-l-15" id="c-prev">
                                            <i class="material-icons">keyboard_arrow_left</i>
                                        </a>
                                        <a class="btn-floating mt-1 waves-effect waves-light" id="c-next">
                                            <i class="material-icons">keyboard_arrow_right</i>
                                        </a>
                                        <span class="m-l-15 mt-1" id="c-current-date">22 Abril 2019</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 l3 xl2 no-pad">
                            <div class="card">
                                <div id="datepicker"></div>
                                <div class="divisor">INSTRUCTORES</div>
                                <div class="card-content">
                                    <div class="doctor-list">
                                        <center>
                                            <a id="filter-doctors" class="btn waves-effect btn-round waves-light btn-main">Filtrar instructores</a>
                                        </center>
                                        <ul id="doctor-list">
                                            @foreach($instructors as $ins)
                                                <li style="border-left: 5px solid {{$ins['color']}}">
                                                    <i class="fas fa-user"></i>
                                                    <span>{{$ins['name']}}</span>
                                                    <label for="doctor-{{$ins['id_instructor']}}" class="right">
                                                        <input name="id_doctor" type="checkbox" class="filled-in" id="doctor-{{$ins['id_instructor']}}" value="{{$ins['id_instructor']}}" />
                                                        <span></span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 l9 xl10">
                            <div class="card">
                                <div class="load-events"></div>
                                <div class="calendar" id="calendar"></div>
                            </div>
                        </div>
                    </div>
                    {{--@if(Auth::guard('admin')->user()->permisos('add_calendar'))
                        <div style="bottom: 50px; right: 19px;" class="fixed-action-btn direction-top">
                            <a href="#" class="waves-effect btn btn-floating btn-large gradient-shadow  modal-trigger"><i class="material-icons">add</i></a>
                            <ul>
                                <li>
                                    <a href="{{route('cita.estudio.new')}}" class="btn btn-floating cita-estudio" style="opacity: 0; transform: scale(0.4) translateY(40px) translateX(0px);">
                                        <img class="w-25" src="{{asset('assets/images/icon/cita_estudio.svg')}}" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('citaNew')}}" class="btn btn-floating cita-paciente" style="opacity: 0; transform: scale(0.4) translateY(40px) translateX(0px);">
                                        <img class="w-25" src="{{asset('assets/images/icon/cita_paciente.svg')}}" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif--}}
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Structure -->
    <div id="modal-add-cita" class="modal">
        <div class="modal-header">
            <h6>AGENDAR NUEVA CITA</h6>
        </div>
        <div class="modal-content">
            <div class="row">
                <form class="col s12">
                    <div class="row">
                        <div class="col s12 l4 xl4">
                            <h6>Fecha Seleccionada</h6>
                            <p>
                                <strong>Día:</strong> <span id="select_date">12-AGO-2019</span> <br>
                                <strong>Hora:</strong> <span id="select_hour">12:30 PM</span>
                            </p>
                        </div>
                        <div class="col s12 l8 xl8">
                            <a id="link-cita-paciente" href="" class="btn waves-effect btn-large btn-modal-agenda">
                                <br>
                                <i class="fas fa-calendar-alt"></i> <br>
                                <p>Crear <br> Clase</p>
                            </a>
                            {{--<a id="link-cita-estudio" href="" class="btn waves-effect btn-large btn-modal-agenda">
                                <img class="w-25" src="{{asset('assets/images/icon/cita_estudio.svg')}}" alt="">
                                <p>Agendar <br> Estudio</p>
                            </a>--}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="modal_print_schedule" class="modal">
        <div class="modal-header">
            <h6>IMPRIMIR EVENTOS DE AGENDA</h6>
        </div>
        <div class="modal-content">
            <div class="row">
                <form method="POST" action="{{--{{route('admin.calendar.export')}}--}}" class="col s12">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12 m6">
                                <input id="day" name="day" type="text" class="validate datepicker" value="">
                                <label for="day">Selecciona el día</label>
                            </div>
                            <input type="hidden" name="tipo" value="instructor">
                            <div class="col s12 mb-2" id="content-select-doctors">
                                <label>Selecciona una opción</label>
                                <select name="id_doctor" id="id_doctor" class="browser-default" >
                                    <option value="" selected>Todos</option>
                                    @foreach($instructors as $ins)
                                        <option value="{{$ins['id_instructor']}}">{{$ins['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 l8 offset-l2 foot-btn">
                        <center>
                            <button class="btn"><i class="fas fa-print"></i> Imprimir</button>
                            <button class="btn grey darken-4"><i class="fas fa-times"></i> Cancelar</button>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="modal-delete" class="modal md-modal">
        <div class="modal-content">
            <div class="card-alert card brown darken-4">
                <div class="card-content white-text">
                    <p>
                        <i class="material-icons">warning</i><span id="modalmsg">¿Estás seguro que deseas eliminar este registro?</span>
                    </p>
                </div>
            </div>
            <p></p>
        </div>
        <div class="modal-footer">
            <form method="POST" action="{{route('admin.lesson.delete')}}">
                @method('DELETE')
                @csrf
                <input type="hidden" name="id" value="">
                <a href="#!" class="modal-close waves-effect deep-orange accent-1 btn-flat white-text">Cancelar</a>
                <button class="modal-close waves-effect brown darken-4 btn-flat white-text" type="submit">Continuar</button>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('admin/js/custom/calendar.js?v=2')}}"></script>
@endpush