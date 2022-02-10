@extends('admin.layout.panel')
@section('contenido')
@push('css')
<link rel="stylesheet" type="text/css" href="{{asset('admin/vendors/data-tables/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
@endpush
      <!-- BEGIN: Page Main-->
      <div id="main">
        <div class="row">
            <div id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="m-0 sidebar-title"><i class="fas fa-users"></i> Roles (<span id="total-entries"></span>)</h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs">
                                <li class="breadcrumb-item active">Roles</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="container">
                    <!-- Add new contact popup -->
                    @if(Auth::user()->checkPermiso("cre_roles"))
                        <div style="bottom: 54px; right: 19px;" class="fixed-action-btn direction-top">
                            <a class="btn-floating btn-large primary-text gradient-shadow modal-trigger" href="{{route('admin.rol.create')}}">
                                <i class="material-icons">add</i>
                            </a>
                        </div>
                    @endif
                    
                    <!-- Content Area Starts -->
                    <div class="content-area content-right">
                        <div class="app-wrapper">
                        @if(session()->has('success'))
                        <!-- Mensaje de acción -->
                            <div class="card-alert card brown darken-1">
                                <div class="card-content white-text">
                                    <p>
                                        <i class="material-icons">check_circle</i>  {{ session()->get('success') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                            <div class="datatable-search">
                                <i class="material-icons mr-2 search-icon">search</i>
                                <input type="text" placeholder="Buscar Venta" class="app-filter" id="global_filter">
                            </div>
                            <div id="button-trigger" class="card card card-default scrollspy border-radius-6 fixed-width table-area">
                                <div class="card-content p-0">
                                    <table id="data-table-contact" class="display" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Rol</th>
                                            <th>Acciones</th>
                                            
                                      
                                        </tr>
                                        </thead>
                                        <tbody>
                                 

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

    <div id="modal-cancel" class="modal">
        <div class="modal-content">
            <div class="card-alert card brown darken-4">
                <div class="card-content white-text">
                    <p>
                        <i class="material-icons">warning</i> ¿Estás seguro que deseas cancelar esta reservacion?
                    </p>
                </div>
            </div>
            <p></p>
        </div>
        <div class="modal-footer">
            <form method="POST" action="{{route('admin.reservations.change.status')}}">
                @method('PUT')
                @csrf
                <input type="hidden" name="id" value="">
                <input type="hidden" name="status" value="">
                <a href="#!" class="modal-close waves-effect deep-orange accent-1 btn-flat white-text">Cancelar</a>
                <button class="modal-close waves-effect brown darken-4 btn-flat white-text" type="submit">Continuar</button>
            </form>
        </div>
    </div>

@endsection
@push('js')
    <script src="{{asset('admin/vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/rol.js')}}"></script>
    <script src="{{asset('admin/js/scripts/app-contacts.js')}}"></script>
@endpush
