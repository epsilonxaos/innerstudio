@extends('admin.layout.panel')
@section('contenido')
    <div id="main">
        <div class="row">
            <div id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title">Crear Cliente</h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs">
                                <li class="breadcrumb-item"><a href="{{route('admin.customer.list')}}">Clientes</a>
                                </li>
                                <li class="breadcrumb-item active">Crear Cliente
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
                    @endif
                    <div class="card overflow-unset">
                        <div class="card-content">
                            <form method="post" action="{{route('admin.customer.insert')}}">
                                <input type="hidden" name="clase_redirect" value="{{$clase_redirect}}">
                                <input type="hidden" name="is_insert" value="1">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col s12 m6 l6">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="name" name="name" type="text"  value="{{ old('name') }}" class="@error('name') invalid @enderror">
                                                <label for="name">Nombre</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="lastname" name="lastname" type="text"  value="{{ old('lastname') }}" class="@error('lastname') invalid @enderror">
                                                <label for="lastname">Apellidos</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="email" name="email" type="email"  value="{{ old('email') }}" class="@error('email') invalid @enderror">
                                                <label for="email">Correo</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="phone" name="phone" type="text"  value="{{ old('phone') }}" class="@error('phone') invalid @enderror">
                                                <label for="phone">Télefono</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="birthdate" name="birthdate" type="text"  value="{{ old('birthdate') }}" class="@error('birthdate') invalid @enderror">
                                                <label for="birthdate">Fecha nacimiento</label>
                                                <span class="helper-text" data-error="wrong" data-success="right">Año/Mes/Día</span>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="pass" name="password" type="password"  value="{{ old('password') }}" class="@error('password') invalid @enderror">
                                                <label for="pass">Contraseña</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="repeat-pass" name="password_confirmation" type="password"  value="{{ old('password_confirmation') }}" class="@error('password_confirmation') invalid @enderror">
                                                <label for="repeat-pass">Confirmar contraseña</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col s12 m6 l6">
                                        <div class="row">
                                            {{--<div class="input-field col s4">
                                                <select name="day" class="@error('day') invalid @enderror">

                                                    <option {{old('day') == 'pdf' ? 'selected' : ''}} value="pdf">Archivo PDF</option>
                                                    <option {{old('extension') == 'imagen' ? 'selected' : ''}} value="imagen">Archivo imagen</option>
                                                </select>
                                                <label>Archivo para subir</label>
                                            </div>--}}
                                            <div class="input-field col s12 m12">
                                                <input id="address" name="address" type="text"  value="{{ old('address') }}" class="@error('address') invalid @enderror">
                                                <label for="address">Calle y número</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="colony" name="colony" type="text"  value="{{ old('colony') }}" class="@error('colony') invalid @enderror">
                                                <label for="colony">Colonia</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="city" name="city" type="text"  value="{{ old('city') }}" class="@error('city') invalid @enderror">
                                                <label for="city">Ciudad</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="state" name="state" type="text"  value="{{ old('state') }}" class="@error('state') invalid @enderror">
                                                <label for="state">Estado</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="country" name="country" type="text"  value="{{ old('country') }}" class="@error('country') invalid @enderror">
                                                <label for="country">País</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="zip" name="zip" type="text"  value="{{ old('zip') }}" class="@error('zip') invalid @enderror">
                                                <label for="zip">Código Postal</label>
                                            </div>
                                        </div>
                                    </div>
                                    {{--@if(Auth::guard('admin')->user()->permisos('add_doctor'))--}}
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right btn-main" type="submit" name="action">Crear Cliente
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
    <script src="{{asset('admin/vendors/formatter/jquery.formatter.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/customer.js')}}"></script>
@endpush