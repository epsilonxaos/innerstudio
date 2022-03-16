@extends('admin.layout.panel')
@section('contenido')
    @push('css')
        <link rel="stylesheet" type="text/css" href="{{asset('admin/vendors/data-tables/css/jquery.dataTables.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('admin/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
        <style>
            .buttons-print,
            .buttons-print:hover,
            .buttons-print:active,
            .buttons-print:focus,
            .buttons-print:focus:active {background-color: var(--naranja); color: var(--blanco);}
        </style>
    @endpush
    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="m-0 sidebar-title"><i class="fas fa-users"></i> Coach: {{$instructor -> name}}, asistencia (<span id="total-entries"></span>) </h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs">
                                <li class="breadcrumb-item"><a href="{{route('admin.calendar.list')}}">Calendario</a>
                                <li class="breadcrumb-item active">Asistencia</li>
                            </ol>
                            <a class="btn btn-default buttons-print" style="margin-bottom: 10px" href="{{ route('admin.calendar.asistencia.export',["id_lesson"  => $lesson['id_lesson']]) }}">excel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="content-wrapper-before brown lighten-4"></div> --}}
        <div class="row">
            <div class="col s12">
                <div class="container">
                <!-- Content Area Starts -->
                    <div class="content-area content-right">
                        <div class="app-wrapper">
                            <div class="datatable-search">
                                <i class="material-icons mr-2 search-icon">search</i>
                                <input type="text" placeholder="Buscar Asistente" class="app-filter" id="global_filter">
                            </div>
                            <div id="button-trigger" class="card card card-default scrollspy border-radius-6 fixed-width table-area">
                                <div class="card-content">
                                    <table id="data-table-contact" class="display" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Telefono</th>
                                            <th>Lugar</th>
                                            <th>Firma</th>
                                            <th>Asistencia</th>
                                            <!-- <th class="background-image-none"><i class="material-icons">star_border</i></th>
                                            <th class="background-image-none"><i class="material-icons">delete_outline</i></th> -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{--<tr>
                                            <td class="center-align">
                                                <label>
                                                    <input type="checkbox" name="foo" />
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td><span class="avatar-contact avatar-online"><img src="../../../app-assets/images/avatar/avatar-1.png"
                                                                                                alt="avatar"></span></td>
                                            <td>John</td>
                                            <td>john@domain.com</td>
                                            <td>202-555-0119</td>
                                            <td><span class="favorite"><i class="material-icons"> star_border </i></span></td>
                                            <td><i class="material-icons delete">delete_outline</i></td>
                                        </tr>--}}

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Area Ends --><!-- START RIGHT SIDEBAR NAV -->
                </div>
            </div>
        </div>
    </div>
    <div id="modal-delete" class="modal md-modal">
        <div class="modal-content">
            <div class="card-alert card brown darken-4">
                <div class="card-content white-text">
                    <p>
                        <i class="material-icons">warning</i> ¿Estás seguro que deseas eliminar este registro?
                    </p>
                </div>
            </div>
            <p></p>
        </div>
        <div class="modal-footer">
            <form method="POST" action="{{--{{route('admin.customer.delete')}}--}}">
                @method('DELETE')
                @csrf
                <input type="hidden" name="id" value="">
                <a href="#!" class="modal-close waves-effect deep-orange accent-1 btn-flat white-text">Cancelar</a>
                <button class="modal-close waves-effect brown darken-4 btn-flat white-text" type="submit">Continuar</button>
            </form>
        </div>
    </div>

    <div id="modal-change-status" class="modal md-modal">
        <div class="modal-content">
            <div class="card-alert card brown darken-4">
                <div class="card-content white-text">
                    <p>
                        <i class="material-icons">warning</i> ¿Estás seguro que deseas modificar este registro?
                    </p>
                </div>
            </div>
            <p></p>
        </div>
        <div class="modal-footer">
            <form method="POST" action="{{route('admin.calendar.reservation.change.status')}}">
                @method('PUT')
                @csrf
                <input type="hidden" name="id_lesson" value="{{$lesson -> id_lesson}}">
                <input type="hidden" name="id" value="">
                <input type="hidden" name="status" value="">
                <a href="#!" class="modal-close waves-effect deep-orange accent-1 btn-flat white-text">Cancelar</a>
                <button class="modal-close waves-effect brown darken-4 btn-flat white-text" type="submit">Continuar</button>
            </form>
        </div>
    </div>

@endsection
@push('js')
    <script>
        var _id_lesson = '{{$lesson -> id_lesson}}', _instructor = '{{$instructor -> name}}', _string_date = '{{$string_date}}';
    </script>
    <script src="{{asset('admin/vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.1/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/sc-1.5.0/datatables.min.js"></script>
    <script src="{{asset('admin/js/custom/asistencia.js')}}"></script>
    <script src="{{asset('admin/js/scripts/app-contacts.js')}}"></script>
@endpush

