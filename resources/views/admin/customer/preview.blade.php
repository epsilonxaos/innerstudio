@extends('admin.layout.panel')
@push('css')
    <style>
        :root {
            --text: #2b2b2b;
            --main: #FBB790;
            --naranja: #ec7a4f;
            --color1: #f4f0ee;
            --color2: #FEF8F3;
            --color3: #746a68;
            --blanco: #fff;
            --negro: #000;
        }

        .card-information {background-color: var(--blanco);}
        .card-information .card-title {color: var(--naranja); font-size: 25px; font-weight: 600}
        .card-information p {letter-spacing: 0.5px;}
        .card-information p + p {margin-top: 15px !important; font-size: 14px}
        .card-information .disponible {color: var(--text); font-size: 18px;}
        .card-information .disponible span {font-weight: 500; font-size: 35px}
        .card-information small {font-size: 14px}
        .card-information strong {color: var(--negro)}

        .tabs {background-color: transparent;}
        .tabs .tab a {color: var(--negro); font-weight: bold; font-size: 18px;}
        .tabs .tab a:hover,
        .tabs .tab a.active { color: var(--negro) }
        .tabs .indicator {background-color: #fbb790e8; height: 8px}

        .tab-container {padding-top: 40px !important;}
        .cancelacion { background-color: #b30b2a1f; border-bottom: 1px solid var(--blanco) !important; }
        .cancelacion-consecuencia { background-color: #f5a8b6; border-bottom: 1px solid var(--blanco) !important; }
        .leyenda small::before { content: ""; width: 15px; height: 15px; background-color: #ed143d1f; border-radius: 50%; border: 1px solid #dc143c88; display: inline-block; position: relative; top: 2px; margin-right: 5px; }
        @media screen and (max-width: 992px) {
            table .pd-special {padding: 36px 10px;}
        }
        @media only screen and (min-width: 993px){
            .container {
                width: 70%;
                max-width: 1280px;
            }
        }
    </style>
@endpush
@section('contenido')
    <div id="main">
        <div class="row">
            <div class="pt-1 pb-0" id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title">Datos cliente</h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs mb-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.customer.list')}}">Clientes</a> </li>
                                <li class="breadcrumb-item active">Datos cliente</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="container">
                    <div class="row">
                        <div class="col s12">
                            <div class="card card-information">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col s12 m12"> <span class="card-title">{{($params -> name != '') ? ' '.$params -> name.' '.$params -> lastname : 'Sin nombre'}}</span> </div>
                                        <div class="col s12 m6">
                                            <p class="disponible">Clases disponibles <span>{{number_format($disponibles)}}</span></p>
                                            {{-- @if ($compensacion != 0)
                                                <small>Clases compesadas: <strong>{{number_format($compensacion)}}</strong></small><br>
                                            @endif
                                            @if ($canceladas != 0)
                                                <small>Clases canceladas: <strong>{{number_format($canceladas)}}</strong></small>
                                            @endif --}}
                                        </div>
                                        <div class="col s12 m6">
                                            <p><strong>Edad: </strong>{{($params -> birthdate != '') ? $edad.' años' : '--'}}</p>
                                            <p><strong>Correo: </strong>{{$params -> email}}</p>
                                            <p><strong>Celular: </strong>{{($params -> phone != '') ? $params -> phone : '--'}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <ul class="tabs align-center">
                                <li class="tab col m3"><a class="active" href="#test1">Próximas clases</a></li>
                                <li class="tab col m3"><a href="#test2">Clases pasadas</a></li>
                                <li class="tab col m3"><a href="#test3">Compras</a></li>
                            </ul>
                        </div>
                        <div id="test1" class="col s12 tab-container">
                            <table class="centered custom-table responsive-table">
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
                                                <td>{{ Date::parse($temp['start']) -> format("d F Y ") }}</td>
                                                <td>{{Date::parse($temp['start']) -> format("h:i A")}}</td>
                                                <td>{{$temp['no_mat']}}</td>
                                                <td>{{$temp['name']}}</td>
                                                <td><a class="waves-effect waves-light btn red white-text" href="{{route('admin.reservations.delete', ["iduser" => $params -> id_customer, "id" => $temp['id_reservation']])}}"><i class="fas fa-ban"></i></a></td>
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
                        <div id="test2" class="col s12 tab-container">
                            <table class="centered custom-table responsive-table">
                                <thead>
                                    <tr>
                                        <th class="pd-special">Fecha</th>
                                        <th>Hora</th>
                                        <th>Lugar</th>
                                        <th>Instructor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($clases_pasadas) > 0)
                                        @foreach ($clases_pasadas as $temp)
                                            @if ($temp['status'] == 3 || $temp['status'] == 4)
                                                <tr class="cancelacion{{($temp['status'] == 3? '' : '-consecuencia')}}">
                                                    <td>
                                                        {{ Date::parse($temp['start']) -> format("d F Y ") }}
                                                        <br>
                                                        <small><strong>Fecha de cancelación</strong></small><br>
                                                        <small>{{ Date::parse($temp['updated_at']) -> format("d F Y h:i A") }}</small><br>
                                                    </td>
                                                    <td>{{Date::parse($temp['start']) -> format("h:i A")}}</td>
                                                    <td>{{$temp['no_mat']}}</td>
                                                    <td>{{$temp['name']}}</td>
                                                </tr>
                                            @endif
                                            @if ($temp['start'] < Carbon\Carbon::now() -> format("Y-m-d H:i:s") && $temp['status'] == 1 || $temp['start'] < Carbon\Carbon::now() -> format("Y-m-d H:i:s") &&  $temp['status'] == 2 )
                                                <tr>
                                                    <td>{{ Date::parse($temp['start']) -> format("d F Y ") }} </td>
                                                    <td>{{Date::parse($temp['start']) -> format("h:i A")}}</td>
                                                    <td>{{$temp['no_mat']}}</td>
                                                    <td>{{$temp['name']}}</td>
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
                        <div id="test3" class="col s12 tab-container">
                            <table class="centered custom-table responsive-table">
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
                                                <td>{{$temp['no_class']}}</td>
                                                <td>${{number_format($temp['price'])}} MXN</td>
                                                <td>{{Date::parse($temp['created_at']) -> format('d F Y')}}</td>
                                                <td>{{Date::parse($temp['date_expirate']) -> format('d F Y')}}</td>
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
    </div>
@endsection
@push('js')
    <script src="{{asset('admin/js/custom/customer.js')}}"></script>
    <script>

        
    </script>
@endpush