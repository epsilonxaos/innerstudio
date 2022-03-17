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
                            <h5 class="breadcrumbs-title">Modificar Clase</h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs">
                                <li class="breadcrumb-item"><a href="{{route('admin.lesson.list')}}">Clases</a>
                                </li>
                                <li class="breadcrumb-item active">Modificar Clase
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
                    @endif
                    <div class="card overflow-unset">
                        <div class="card-content">
                            <form method="POST" action="{{route('admin.lesson.update', [$lesson -> id_lesson])}}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col s12 m10 offset-m1 l8 offset-l2">
                                        <div class="row">
                                            <div class="col s12 m6">
                                                <label>Elije un instructor</label>
                                                <select name="id_instructor" id="id_instructor" class="browser-default @error('id_instructor') invalid @enderror">
                                                    <option value="" selected>Instructores</option>
                                                    @foreach($instructores as $in)
                                                        <option {{ $lesson -> id_instructor == $in['id_instructor'] ? 'selected' : '' }} value="{{ $in['id_instructor'] }}">{{$in['name']}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col s12 m6">
                                                <label>Elije un tipo</label>
                                                <select name="tipo" id="tipo" class="browser-default @error('tipo') invalid @enderror">
                                                    <option value="" selected>Tipo</option>
                                                    <option {{ ($lesson -> tipo == 'classic') ? 'selected' : '' }} value="classic">Classic</option>
                                                    <option {{ ($lesson -> tipo == 'power') ? 'selected' : '' }} value="power">Power</option>
                                                    <option {{ ($lesson -> tipo == 'interval') ? 'selected' : '' }} value="interval">Interval</option>
                                                    <option {{ ($lesson -> tipo == 'sculpt') ? 'selected' : '' }} value="sculpt">Sculpt</option>
                                                    <option {{ ($lesson -> tipo == 'full body flow') ? 'selected' : '' }} value="full body flow">Full body flow</option>
                                                    <option {{ ($lesson -> tipo == 'yoga') ? 'selected' : '' }} value="yoga">Yoga</option>


                                                </select>
                                            </div>
                                            <div class="col s12" style="padding-top: 10px; padding-bottom: 10px">
                                                <label>Elije un color</label> <br>
                                                <input  name="color" id="color" type="color" class="browser-default " value="{{$lesson -> color}}">
                                            </div> 
                                            <div class="col s12 input-field">
                                                <label for="descripcion">Subtitulo</label>
                                                <input type="text" id="descripcion" name="descripcion" value="{{$lesson -> descripcion}}"></input>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input type="hidden" name="start" id="start" value="{{old('start') ? old('start') : $lesson -> start_show}}">
                                                <input  data-toggle="fecha" name="fecha" id="fecha" type="text"  value="{{ old('fecha') ? old('fecha') : $lesson -> fecha }}" class="@error('fecha') invalid @enderror">
                                                <label for="no_class">Fecha</label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input type="hidden" name="start_hour" id="start_hour" value="{{old('start_hour')}}">
                                                <input name="start_hour_select" id="start_hour_select" type="text"  value="{{ old('start_hour_select') ? old('start_hour_select') : $lesson -> start_hour }}" class="@error('start_hour_select') invalid @enderror">
                                                <label for="start_hour_select">Hora Inicio</label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input type="hidden" name="end_hour" id="end_hour" value="{{old('end_hour')}}">
                                                <input name="end_hour_select" id="end_hour_select" type="text"  value="{{ old('end_hour_select') ? old('end_hour_select') : $lesson -> end_hour}}" class="@error('end_hour_select') invalid @enderror">
                                                <label for="end_hour_select">Hora Final</label>
                                            </div>
                                            {{--<div class="col s12 m4 mt-1">
                                                <label>Elije una hora</label>
                                                <select name="start_hour" id="start_hour" class="browser-default @error('start_hour') invalid @enderror">
                                                    @foreach($hours as $h)
                                                        <option {{ old('start_hour') ? old('start_hour') == $h ? 'selected' : '' : $lesson -> start_hour == $h ? 'selected' : '' }} value="{{ $h }}">{{$h}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col s12 m4 mt-1">
                                                <label>Elige la duración</label>
                                                <select name="duration" id="duration" class="browser-default @error('duration') invalid @enderror">
                                                    @foreach($minutes as $m)
                                                        <option {{ old('duration') ? old('duration') == $m['value'] ? 'selected' : '' : $lesson -> duration == $m['value'] ? 'selected' : '' }} value="{{ $m['value'] }}">{{$m['show']}}</option>
                                                    @endforeach

                                                </select>
                                            </div>--}}
                                            <div class="col s12"></div>
                                            <div class="input-field col s12 m6">
                                                <input id="limit" name="limit" type="number"  value="{{ old('limit') ? old('limit') : $lesson -> limit_people }}" class="@error('limit') invalid @enderror">
                                                <label for="limit">Limite de cupo</label>
                                            </div>
                                        </div>
                                    </div>
                                    @if(Auth::user()->checkPermiso("acc_clases"))
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right btn-main" type="submit" name="action">Modificar Clase
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
    <script src="{{asset('admin/js/custom/lesson.js')}}"></script>
@endpush
