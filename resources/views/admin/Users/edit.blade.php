@extends('admin.layout.panel')
@section('contenido')
    <div id="main">
        <div class="row">
            <div class="pt-1 pb-0" id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title">Modificar Clase</h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs mb-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.lesson.list')}}">Clases</a>
                                </li>
                                <li class="breadcrumb-item active">Modificar Clase
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="container">
                    <div class="card overflow-unset">
                        <div class="card-content">
                            <form method="post" action="{{route('admin.accounts.update')}}">
                                @csrf
                                {{csrf_field()}}
                            <input type="hidden" name="id_user" value="{{$user->id}}">
                                <div class="row">
                                    <div class="col s12">
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
                                    </div>
                                    <div class="col s12 m6 offset-m3 l6 offset-l3">
                                        <div class="row">
                                        <div class="input-field col s12">
                                            <input id="name" name="name" type="text"  value="{{ old('name') ? old('name') : $user->name }}" class="@error('name') invalid @enderror">
                                            <label for="name">Nombre</label>
                                        </div>
                                        <div class="input-field col s4">
                                            <p>
                                                <label>
                                                    <input type="checkbox" name="edit_email" id="edit_email" />
                                                    <span>Editar Email</span>
                                                </label>
                                            </p>
                                        </div>
                                        <div class="input-field col s8">
                                            <input  disabled   id="email" name="email" type="email"  value="{{old('email') ? old('email') : $user->email }}" class="@error('email') invalid @enderror">
                                            <label for="emai">Email</label>
                                        </div>
                                        <div class="input-field col s4">
                                            <p>
                                                <label>
                                                    <input type="checkbox" name="edit_pass" id="edit_pass" />
                                                    <span>Editar contraseña</span>
                                                </label>
                                            </p>
                                        </div>
                                        <div class="input-field col s8">
                                            <input  disabled id="password" name="password" type="password"  value="{{ old('password') }}" class="@error('password') invalid @enderror">
                                            <label for="password">contraseña</label>
                                        </div>
                                        <div class="col s12 m12">
                                            <label>Elija un Rol</label>
                                            <select name="rol" id="rol" class="browser-default @error('rol') invalid @enderror">
                                            @foreach($roles as $rol)
                                                @if($user->id_rol == $rol ->id_rol)
                                                <option value="{{$rol->id_rol}}" selected>{{$rol->rol}}</option>
                                                @else
                                                <option value="{{$rol->id_rol}}">{{$rol->rol}}</option>
                                                @endif
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="col s12 m12">
                                        </div>
                                        </div>
                                    </div>
                                    @if(Auth::user()->checkPermiso("acc_cuentas"))
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right" type="submit" name="action">Modificar Cuenta
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                    @endif
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
    <script src="{{asset('admin/js/custom/users.js')}}"></script>
@endpush