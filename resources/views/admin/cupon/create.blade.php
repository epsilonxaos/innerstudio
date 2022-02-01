@extends('admin.layout.panel')
@section('contenido')
    <div id="main">
        <div class="row">
            <div id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title">Crear Cupon</h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs">
                                <li class="breadcrumb-item"><a href="{{route('admin.cupon.list')}}">Cupones</a>
                                </li>
                                <li class="breadcrumb-item active">Crear Cupon
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
                            <form method="post" action="{{route('admin.cupon.insert')}}">
                                <input type="hidden" name="is_insert" value="1">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col s12 m10 offset-m1 l8 offset-l2">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="title" name="title" type="text"  value="{{ old('title') }}" class="@error('title') invalid @enderror">
                                                <label for="title">Título</label>
                                            </div>
                                            <div class="col s6">
                                                <p class="mb-2">Tipo de descuento:</p>
                                                <label>
                                                    <input name="type" type="radio" value="1" checked/>
                                                    <span>Porcentaje</span>
                                                </label>
                                                <label>
                                                    <input name="type" type="radio" value="2"/>
                                                    <span>Efectivo</span>
                                                </label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="discount" name="discount" type="text"  value="{{ old('discount') }}" class="@error('discount') invalid @enderror">
                                                <label for="discount">Cantidad</label>
                                            </div>
                                            <div class="col s6">
                                                <p class="mb-2">Dirigido a:</p>
                                                <label>
                                                    <input name="directed" type="radio" value="publico" checked/>
                                                    <span>Publico</span>
                                                </label>
                                                <label>
                                                    <input name="directed" type="radio" value="paquete"/>
                                                    <span>Paquete</span>
                                                </label>
                                            </div>
                                            <div class="col s12 m6">
                                                <label>Elije un paquete</label>
                                                <select name="id_package" id="id_package" class="browser-default @error('id_package') invalid @enderror">
                                                    <option value="" selected>Paquete</option>
                                                    @foreach($packages as $pk)
                                                        <option {{ session('id_package') ? session('id_package') == $pk['id_package'] ? 'selected' : '' : old('id_package') == $pk['id_package'] ? 'selected' : '' }} value="{{ $pk['id_package'] }}">{{$pk['title']}} ${{$pk['price']}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input type="hidden" name="start" id="start" value="">
                                                <input id="start_show" name="start_show" data-toggle="datepicker" type="text"  value="{{ old('start_show') }}" class="@error('start_show') invalid @enderror">
                                                <label for="start_show">Fecha Inicio</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input type="hidden" name="end" id="end" value="">
                                                <input id="end_show" name="end_show" type="text" data-toggle="datepicker"  value="{{ old('end_show') }}" class="@error('end_show') invalid @enderror">
                                                <label for="end_show">Fecha Final</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="limit_use" name="limit_use" type="number"  value="{{ old('limit_use') }}" class="@error('limit_use') invalid @enderror">
                                                <label for="limit_use">Limite</label>
                                            </div>
                                        </div>
                                    </div>
                                    {{--@if(Auth::guard('admin')->user()->permisos('add_doctor'))--}}
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right btn-main" type="submit" name="action">Crear Cupon
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
    <script src="{{asset('admin/js/custom/cupon.js')}}"></script>
@endpush