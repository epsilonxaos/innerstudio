@extends('admin.layout.panel')
@push('css')
    <link rel="stylesheet" type="text/css" href={{asset("admin/css/custom/lesson.css")}}>
    <style>
        .flatpickr-calendar select{display: inline-block;}
    </style>
@endpush
@section('contenido')
    <div id="main">
        <div class="row">
            <div id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title">Crear Clase</h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs">
                                <li class="breadcrumb-item"><a href="{{route('admin.lesson.list')}}">Clases</a>
                                </li>
                                <li class="breadcrumb-item active">Crear Clase
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="content-wrapper-before"></div> --}}
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
                                    <i class="fas fa-check"></i>
                                    {{ session()->get('error') }}
                                </p>
                            </div>
                            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif

                    <div class="card overflow-unset">
                        <div class="card-content">
                            <form method="post" action="{{route('admin.lesson.insert')}}">
                                <input type="hidden" name="is_insert" value="1">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col s12 m10 offset-m1 l8 offset-l2">
                                        <div class="row">
                                            <div class="col s12 m6">
                                                <label>Elije un instructor</label>
                                                <select name="id_instructor" id="id_instructor" class="browser-default @error('id_instructor') invalid @enderror">
                                                    <option value="" selected>Instructores</option>
                                                    @foreach($instructores as $in)
                                                        <option {{ session('id_instructor') ? 
                                                            (session('id_instructor') == $in['id_instructor'] ? 'selected' : '')
                                                            :
                                                            (old('id_instructor') == $in['id_instructor'] ? 'selected' : '') }} value="{{ $in['id_instructor'] }}">{{$in['name']}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col s12 m6">
                                                <label>Elije un tipo</label>
                                                <select name="tipo" id="tipo" class="browser-default @error('tipo') invalid @enderror">
                                                    <!-- añadir old-->
                                                    <option value="" selected>Tipo</option>
                                                    <option {{(old('tipo') == 'classic') ? 'selected' : '' }}  value="classic">Classic</option>
                                                    <option {{(old('tipo') == 'power') ? 'selected' : '' }}  value="power">Power</option>
                                                    <option {{(old('tipo') == 'interval') ? 'selected' : '' }}  value="interval">Interval</option>
                                                    <option {{(old('tipo') == 'sculpt') ? 'selected' : '' }}  value="sculpt">Sculpt</option>
                                                    <option {{(old('tipo') == 'full body flow') ? 'selected' : '' }}  value="full body flow">Full Body Flow</option>
                                                    <option {{(old('tipo') == 'yoga') ? 'selected' : '' }}  value="yoga">Yoga</option>
                                                </select>
                                            </div>
                                            <div class="col s12" style="padding-top: 10px; padding-bottom: 10px">
                                                <label>Elije un color</label> <br>
                                                <input  name="color" id="color" type="color" class="browser-default ">
                                            </div> 
                                            <div class="col s12 input-field">
                                                <label for="descripcion">Subtitulo</label>
                                                <input type="text" id="descripcion" name="descripcion"></input>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input type="hidden" name="start" id="start" value="{{old('start')}}">
                                                <input name="fecha" id="fecha" type="text"  value="{{ (old('fecha') != '' )? old('fecha') : $p_fecha }}" class="@error('fecha') invalid @enderror">
                                                <label for="fecha">Fecha</label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input type="hidden" name="start_hour" id="start_hour" value="{{old('start_hour')}}">
                                                <input name="start_hour_select" id="start_hour_select" type="text"  value="{{ (old('start_hour_select') != '' )? old('start_hour_select') : $p_hora }}" class="@error('start_hour_select') invalid @enderror">
                                                <label for="start_hour_select">Hora Inicio</label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input type="hidden" name="end_hour" id="end_hour" value="{{old('end_hour')}}">
                                                <input name="end_hour_select" id="end_hour_select" type="text"  value="{{ old('end_hour_select') }}" class="@error('end_hour_select') invalid @enderror">
                                                <label for="end_hour_select">Hora Final</label>
                                            </div>
                                            <div class="col s12"></div>
                                            <div class="input-field col s12 m6">
                                                <input id="limit" name="limit" type="number"  value="{{ old('limit') ? old('limit') : 20 }}" class="@error('limit') invalid @enderror">
                                                <label for="limit">Limite de cupo</label>
                                            </div>
                                        </div>
                                    </div>
                                    {{--@if(Auth::guard('admin')->user()->permisos('add_doctor'))--}}
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right btn-main" type="submit" name="action">Crear Clase
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
    <script src="{{asset('admin/js/custom/lesson.js')}}"></script>
@endpush
