{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}
    <link rel="stylesheet" href="{{asset('css/perfil-plugins.css')}}">
    <link rel="stylesheet" href="{{asset('css/perfil.css')}}">
@endpush

@section('contenido')
    <section class="perfil">
        <div class="container">
            <div class="row deco">
                {{-- Informacion --}}
                <div class="col-12 col-lg-4 bg-white">
                    <div class="row">
                        <div class="col-12 col-md-5 col-lg-12">
                            <div class="text-center text-lg-left">
                                <h3>¡Hola{{($params -> name != '') ? ' '.$params -> name.' '.$params -> lastname.'!' : '!'}}</h3>
                                    <div class="m30">
                                        <p class="upper m5">Clases Disponibles <span>{{(($disponibles > 0)? (number_format($disponibles)) : 0)}}</span></p>
                                        {{-- @if ($compensacion != 0)
                                            <small class="upper m5 d-block">Clases Compensadas <strong>{{number_format($compensacion)}}</strong></small>
                                        @endif
                                        @if ($canceladas != 0)
                                            <small class="upper d-block">Clases Canceladas <strong>{{number_format($canceladas)}}</strong></small>
                                        @endif --}}
                                    </div>
                                    <a href="{{url('paquetes')}}" class="d-inline-block"> <button class="btn btn-main m80">Comprar clases</button> </a>
                            </div>
                        </div>
                        <div class="col-12 col-md-7 col-lg-12">
                            <h5 class="text-center text-lg-left m20">MIS DATOS</h5>
                            <div class="m30">
                                <p><strong>Nombre:</strong> {{($params -> name != '') ? $params -> name : '--'}}</p>
                                <p><strong>Apellido:</strong> {{($params -> lastname != '') ? $params -> lastname : '--'}}</p>
                                <p><strong>Edad:</strong> {{($params -> birthdate != '') ? $edad.' años' : '--'}}</p>
                                <p><strong>Correo:</strong> {{$params -> email}}</p>
                                <p><strong>Celular:</strong> {{($params -> phone != '') ? $params -> phone : '--'}}</p>
                            </div>
                            @if ($errors->any())
                                <small class="d-block mb-2"> <i class="fas fa-exclamation-triangle"></i> Algo sucedio! <br> Asegurese de no dejar campos vacios. <br> </small>
                            @elseif(session()->has('message'))
                                <small class="d-block mb-2"> <i class="fas fa-check"></i> Datos actualizados! </small>
                            @endif
                            <div class="text-center text-lg-left">
                                <button class="btn btn-main m15 mw" data-toggle="modal" data-target="#mdDatosP" >Editar Datos</button>
                                {{-- <button class="btn btn-main m15 mw">Cambiar Contraseña</button> --}}
                                <a class="d-inline-block" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <button class="btn btn-white m15 mw">Cerrar Sesión</button>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                        </div>
                    </div>
                </div>
                {{-- Tabs con tablas --}}
                <div class="col-12 col-lg-8 bg-main">
                    <div class="text-center">
                        <div class="dropdown d-block d-sm-block d-md-none">
                            <button class="btn btn-main dropdown-toggle btn-nav-m" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Próximas clases
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item nav-link active" id="nav-proximas-tab" data-toggle="tab" href="#nav-proximas" role="tab" aria-controls="nav-proximas" aria-selected="true">Próximas clases</a>
                                <a class="dropdown-item nav-link" id="nav-pasadas-tab" data-toggle="tab" href="#nav-pasadas" role="tab" aria-controls="nav-pasadas" aria-selected="false">Clases pasadas</a>
                                <a class="dropdown-item nav-link" id="nav-compras-tab" data-toggle="tab" href="#nav-compras" role="tab" aria-controls="nav-compras" aria-selected="false">Compras</a>
                            </div>
                        </div>
                    </div>
                    <nav class="d-none d-sm-none d-md-block">
                        <div class="nav nav-tabs justify-content-between" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-proximas-tab" data-toggle="tab" href="#nav-proximas" role="tab" aria-controls="nav-proximas" aria-selected="true">Próximas clases</a>
                            <a class="nav-item nav-link" id="nav-pasadas-tab" data-toggle="tab" href="#nav-pasadas" role="tab" aria-controls="nav-pasadas" aria-selected="false">Clases pasadas</a>
                            <a class="nav-item nav-link" id="nav-compras-tab" data-toggle="tab" href="#nav-compras" role="tab" aria-controls="nav-compras" aria-selected="false">Compras</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane pt-5 pb-5 fade show active" id="nav-proximas" role="tabpanel" aria-labelledby="nav-proximas-tab">
                            <table class="style-table rwd-table">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Lugar</th>
                                        <th>Instructor</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($proximas_clases) > 0)
                                        @foreach ($proximas_clases as $temp)
                                            <tr>
                                                <td data-th="Fecha" class="text-capitalize">{{ Date::parse($temp['start']) -> format("d F Y ") }}</td>
                                                <td data-th="Hora" class="text-capitalize">{{Date::parse($temp['start']) -> format("h:i A")}}</td>
                                                <td data-th="Lugar">{{$temp['no_mat']}}</td>
                                                <td data-th="Instructor">{{$temp['name']}}</td>
                                                <td data-th="Cancelar">
                                                    <img src="{{asset('images/icons/icon-cancel.svg')}}" width="25px" alt="" title="Cancelar" data-toggle="modal" data-target="#mdCancelar" class="pointer btn-cancel-reservacion" data-reservacion="{{$temp['id_reservation']}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">Sin clases proximas</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane pt-5 pb-5 fade" id="nav-pasadas" role="tabpanel" aria-labelledby="nav-pasadas-tab">
                            <div class="text-right leyenda">
                                <small class="d-inline-block mb-2">Clases canceladas</small>
                            </div>
                            <table class="style-table rwd-table">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Lugar</th>
                                        <th>instructor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($clases_pasadas) > 0)
                                        @foreach ($clases_pasadas as $temp)
                                            @if ($temp['status'] == 3 || $temp['status'] == 4)
                                                <tr class="cancelacion">
                                                    <td data-th="Fecha" class="text-capitalize">
                                                        {{ Date::parse($temp['start']) -> format("d F Y ") }}
                                                        <br>
                                                        <small><strong>Fecha de cancelación</strong></small><br>
                                                        <small>{{ Date::parse($temp['update_at']) -> format("d F Y ") }}</small><br>
                                                        
                                                    </td>
                                                    <td data-th="Hora" class="text-capitalize">{{Date::parse($temp['start']) -> format("h:i A")}}</td>
                                                    <td data-th="Lugar">{{$temp['no_mat']}}</td>
                                                    <td data-th="Instructor">{{$temp['name']}}</td>
                                                </tr>
                                            @endif
                                            @if ($temp['start'] < Carbon\Carbon::now() -> format("Y-m-d H:i:s") && $temp['status'] == 1 || $temp['start'] < Carbon\Carbon::now() -> format("Y-m-d H:i:s") &&  $temp['status'] == 2)
                                                <tr>
                                                    <td data-th="Fecha" class="text-capitalize"> {{ Date::parse($temp['start']) -> format("d F Y ") }} </td>
                                                    <td data-th="Hora" class="text-capitalize">{{Date::parse($temp['start']) -> format("h:i A")}}</td>
                                                    <td data-th="Lugar">{{$temp['no_mat']}}</td>
                                                    <td data-th="Instructor">{{$temp['name']}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4">Sin clases pasadas</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane pt-5 pb-5 fade" id="nav-compras" role="tabpanel" aria-labelledby="nav-compras-tab">
                            <table class="style-table rwd-table">
                                <thead>
                                    <tr>
                                        <th>Clases</th>
                                        <th>Precio</th>
                                        <th>Compra</th>
                                        <th>Expiración</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($compras) > 0)
                                        @foreach ($compras as $temp)
                                            <tr>
                                                <td data-th="Clases">{{$temp['no_class']}}</td>
                                                <td data-th="Precio">${{number_format($temp['price'])}} MXN</td>
                                                <td data-th="Compra" class="text-capitalize">{{Date::parse($temp['created_at']) -> format('d F Y')}}</td>
                                                <td data-th="Expiración" class="text-capitalize">{{Date::parse($temp['date_expirate']) -> format('d F Y')}}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4">No tienes compras realizadas</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Registro --}}
    <div class="modal fade normalStyle" tabindex="-1" role="dialog" id="mdDatosP">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-end">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <form method="POST" id="formUpdate" action="{{route('updateDatosCustomer', ['id' => $params -> id_customer])}}">
                        @method('PUT')
                        @csrf
                        <h5 class="color-orange m20">Editar datos personales</h5>
                        <div class="row m20">
                            <div class="col-12 col-md-6 col-lg-4 m15"><input type="text" name="name" required placeholder="Nombre" value="{{($params -> name != '') ? $params -> name : ''}}"></div>
                            <div class="col-12 col-md-6 col-lg-4 m15"><input type="text" name="lastname" required placeholder="Apellidos" value="{{($params -> lastname != '') ? $params -> lastname : ''}}"></div>
                            <div class="col-12 col-md-6 col-lg-4 m15"><input type="text" name="phone" required placeholder="Teléfono" value="{{($params -> phone != '') ? $params -> phone : ''}}" mask-phone></div>
                            <div class="col-12 col-md-6 col-lg-4 m15">
                                <input type="text" name="birthdate" placeholder="Fecha de nacimiento" value="{{($params -> birthdate != null) ? $params -> birthdate : '' }}" mask-fecha />
                                <small style="position: absolute; bottom: -3px; left: 0; width: 80%; text-align: left; right: 0; margin: auto; font-size: 11px;">Año-Mes-Día</small>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 m15">
                                <p class="mb-2">¿Quieres cambiar el email?</p>
                                <div class="form-group mb-0">
                                    <input type="checkbox" id="editar_mail" name="editar_mail" class="chkbx-toggle" value="1">
                                    <label for="editar_mail" class="mb-0 toggle-change" data-toggle=".ce"></label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 m15"><input class="ce" type="text" name="email" required placeholder="Email" disabled value="{{($params -> email != '') ? $params -> email : ''}}"></div>
                        </div>
                        <div class="row justify-content-center m20">
                            <div class="col-12">
                                <h5 class="color-orange m20">Cambiar contraseña</h5>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 m15">
                                <p class="mb-2">¿Quieres cambiar tu contraseña?</p>
                                <div class="form-group mb-0">
                                    <input type="checkbox" id="editar_pass" name="editar_pass" class="chkbx-toggle" value="1">
                                    <label for="editar_pass" class="mb-0 toggle-change" data-toggle=".cps"></label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 m15">
                                <input class="cps" type="password" name="password" placeholder="Contraseña" disabled>
                                <small class="d-block mt-2">Tamaño minimo de contraseña: 6 caracteres</small>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 m15">
                                <input class="cps" type="password" name="password_confirmation" placeholder="Confirmar contraseña" disabled>
                            </div>
                        </div>
                        <div class="row m20">
                            <div class="col-12"> <h5 class="color-orange m20">Editar datos de dirección</h5> </div>
                            <div class="col-12 col-md-6 col-lg-4 m15"><input type="text" name="address" placeholder="Calle y número" value="{{($params -> address != '') ? $params -> address : ''}}"></div>
                            <div class="col-12 col-md-6 col-lg-4 m15"><input type="text" name="city" placeholder="Ciudad" value="{{($params -> city != '') ? $params -> city : ''}}"></div>
                            <div class="col-12 col-md-6 col-lg-4 m15"><input type="text" name="state" placeholder="Estado" value="{{($params -> state != '') ? $params -> state : ''}}"></div>
                            <div class="col-12 col-md-6 col-lg-4 m15"><input type="text" name="country" placeholder="País" value="{{($params -> country != '') ? $params -> country : ''}}"  /></div>
                            <div class="col-12 col-md-6 col-lg-4 m15"><input type="text" name="zip" placeholder="Codigo Postal" value="{{($params -> zip != '') ? $params -> zip : ''}}" mask-cp></div>
                        </div>
                        <button type="submit" class="btn btn-main m20">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Cancelar --}}
    <div class="modal fade normalStyle" tabindex="-1" role="dialog" id="mdCancelar">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-end">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h5 class="color-orange m20">Cancelar clase</h5>
                    <p class="m30">Puedes cancelar hasta <strong>8 horas</strong> antes sin que se consuma tu clase. ¿Estás seguro de cancelar?</p>
                    <form action="{{route('cancelarReservacion')}}" method="POST" id="formCancelReservacion">
                        @csrf
                        <input type="hidden" name="id_reservacion" value="0">
                        <div class="row">
                            <div class="col-12 col-md-6"> <button type="button" class="btn btn-main m20" data-dismiss="modal">Regresar</button> </div>
                            <div class="col-12 col-md-6"> <button type="submit" class="btn btn-danger text-white m20">Confirmar</button> </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{-- Aqui van los scripts para esta vista--}}
    <script type="text/javascript" src="{{asset('js/perfil.js')}}"></script>
@endpush