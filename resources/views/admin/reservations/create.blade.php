@extends('admin.layout.panel')

@section('contenido')
<style>
    .fix{overflow: unset !important;}
    </style>
<div id="main">
        <div class="row">
            <div id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title">Crear Reservacion</h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs">
                                <li class="breadcrumb-item"><a href="{{route('admin.reservations.list')}}">Reservaciones</a>
                                </li>
                                <li class="breadcrumb-item active">Crear Reservacion
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="container">
                    @if ($errors->any())
                        <div class="card-alert card red">
                            <div class="card-content white-text">
                                <p>
                                    <i class="fas fa-exclamation-triangle"></i> LOS CAMPOS EN COLOR ROJO SON OBLIGATORIOS <br><br>
                                    @foreach($errors->all() as $message)
                                        {{$message}} <br>
                                    @endforeach
                                </p>
                            </div>
                            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @elseif(session()->has('message'))
                        <div class="card-alert card green">
                            <div class="card-content white-text">
                                <p>
                                    <i class="fas fa-check"></i>
                                    {{ session()->get('message') }}
                                </p>
                            </div>
                            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @elseif(session()->has('error'))
                        <div class="card-alert card red">
                            <div class="card-content white-text">
                                <p>
                                    <i class="fas fa-exclamation-triangle"></i>
                                    {{ session()->get('error') }}
                                </p>
                            </div>
                            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    <div class="card overflow-unset fix">
                        <div class="card-content">
                            <form method="post" action="{{route('admin.reservations.store.admin')}}" id="formulario">
                                <input type="hidden" name="is_insert" value="1">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col s12 m10 offset-m1 l8 offset-l2">
                                        <div class="row">
                                        <div class="col s12 m12">
                                            <label>Elija un Cliente</label>
                                            <select name="cliente" id="id_cliente" class="browser-default @error('id_instructor') invalid @enderror">
                                            <option value="" selected>Cliente</option>
                                                @foreach($clientes as $cliente)
                                                    @if($cliente -> name)
                                                    <option value="{{$cliente->id_customer}}">{{$cliente->name.' '.$cliente->lastname}}</option>
                                                    @endif
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col s12 m12">
                                            <label>Elija una Clase</label>
                                            <select name="clase" id="id_clase" class="browser-default @error('id_clase') invalid @enderror">
                                             @foreach($clases as $clase)
                                                    <option value="{{$clase->id_lesson}}">{{$clase->tipo.'  - '.Date::parse($clase->start)->format('d l  H:i') }} - {{$clase -> name}}</option>
                                                @endforeach 
                                            </select>
                                        </div>
                                        <div class="col s12 m12">
                                            <label>Elija un Tapete</label>
                                            <select name="mat" id="id_mat" class="browser-default @error('id_clase') invalid @enderror">
                                                @foreach($mats as $mat)
                                                    <option value="{{$mat->id_mat}}" >{{$mat->no_mat }}</option>
                                                @endforeach 
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    {{--@if(Auth::guard('admin')->user()->permisos('add_doctor'))--}}
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right btn-main" type="submit" name="action" id="btn-send-formulario">Crear Reservacion
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                    {{--@endif--}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('admin/js/custom/reservations_create.js')}}"></script>
    <script type="text/javascript">
        document.getElementById("formulario").addEventListener('submit', function () {
            this.getElementById("btn-send-formulario").setAttribute('disabled', "disabled");
        });
    </script>
@endpush