@extends('admin.layout.panel')
@section('contenido')
    <div id="main">
        <div class="row">
            <div id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title">Modificar Instructor</h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs">
                                <li class="breadcrumb-item"><a href="{{route('admin.instructor.list')}}">Instructores</a>
                                </li>
                                <li class="breadcrumb-item active">Modificar Instructor
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
                            <form method="POST" action="{{route('admin.instructor.update', [$instructor -> id_instructor])}}" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col s12 m6 l6">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="name" name="name" type="text"  value="{{ old('name') ? old('name') : $instructor -> name  }}" class="@error('name') invalid @enderror">
                                                <label for="name">Nombre</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="email" name="email" type="email"  value="{{ old('email') ? old('email') : $instructor -> email }}" class="@error('email') invalid @enderror" >
                                                <label for="email">Correo</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="phone" name="phone" type="text"  value="{{ old('phone') ? old('phone') : $instructor -> phone }}" class="@error('phone') invalid @enderror">
                                                <label for="phone">Télefono</label>
                                            </div>
                                        <div class="col s12" >@if($instructor -> avatar) <img style="width: 80px;margin: 0 auto;display: block;" src="{{asset($instructor -> avatar)}}" alt="">@endif</div>
                                            <div class="input-field col s12">
                                                <div class="file-field input-field">
                                                    <div class="btn">
                                                        <span>File</span>
                                                    <input type="file" name="coach">
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                        <input class="file-path validate" type="text"  >
                                                        </div>
                                                </div>
                                                <small class="blue-text text-darken-2">Solo se aceptan imagenes con formato .JPG, .JPEG y .PNG. La imagen debe ser menor a 3 MB y la resolución óptima para esta imagen es de 480 x 615px</small>
                                            </div>
                                            <div class="input-field col s12">
                                                <p>
                                                    <label>
                                                        <input type="checkbox" name="externo" {{ $instructor -> status_externo  ? "checked" : "" }}/>
                                                        <span>Coach Externo</span>
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l6">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea id="description" name="description" class="materialize-textarea">{{ old('description') ? old('description') : $instructor -> description }}</textarea>
                                                <label for="description">Descripción</label>
                                            </div>
                                            <div class="input-field col s12">
                                                <textarea id="embed" name="embed" class="materialize-textarea">{{ old('embed') ? old('embed') : $instructor -> embed}}</textarea>
                                                <label for="embed">Embed spotify</label>
                                            </div>
                                            <div class="col s12 mb-2">
                                                <div id="demo-component" class="file-field">
                                                    <div class="btn btn-color-picker"></div>
                                                    <div class="file-path-wrapper">
                                                        <input type="text" name="color" class="@error('color') invalid @enderror" value="{{ old('color') ? old('color') : $instructor -> color  }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(Auth::user()->checkPermiso("acc_instructor"))
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right btn-main" type="submit" name="action">Modificar Instructor
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
<link rel="stylesheet" type="text/css" href="{{asset('admin/js/colorpicker/css/bootstrap-colorpicker.min.css')}}">
<script src="{{asset('admin/js/colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{asset('admin/js/custom/instructor_create.js') }}"></script>    
@endpush