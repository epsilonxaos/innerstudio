@extends('admin.layout.panel')
@section('contenido')
    <div id="main">
        <div class="row">
            <div id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title">Crear Paquete</h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs">
                                <li class="breadcrumb-item"><a href="{{route('admin.package.list')}}">Paquetes</a>
                                </li>
                                <li class="breadcrumb-item active">Crear Paquete
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
                            <form method="post" action="{{route('admin.package.insert')}}">
                                <input type="hidden" name="is_insert" value="1">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col s12 m6 offset-m3 l6 offset-l3">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="title" name="title" type="text"  value="{{ old('title') }}" class="@error('title') invalid @enderror">
                                                <label for="title">Título</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="no_class" name="no_class" type="text"  value="{{ old('no_class') }}" class="@error('no_class') invalid @enderror">
                                                <label for="no_class">No. de sesiones</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="price" name="price" type="text"  value="{{ old('price') }}" class="@error('price') invalid @enderror">
                                                <label for="price">Precio</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="duration" name="duration" type="number"  value="{{ old('duration') }}" class="@error('duration') invalid @enderror">
                                                <label for="duration">Vigencia</label>
                                            </div>
                                            <div class="col s12 m6">
                                                <label for="single_use">
                                                    <p class="mb-2">Uso único o de primera vez</p>
                                                    <input type="hidden" name="single_use" value="0">
                                                    <input name="single_use" type="checkbox" class="filled-in" id="single_use" value="1" />
                                                    <span>Si</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    {{--@if(Auth::guard('admin')->user()->permisos('add_doctor'))--}}
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right btn-main" type="submit" name="action">Crear Paquete
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