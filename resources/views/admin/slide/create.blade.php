@extends('admin.layout.panel')
@section('contenido')
<div id="main">
    <div class="row">
        <div id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s12 m6 l6">
                        <h5 class="breadcrumbs-title">Crear Slide</h5>
                    </div>
                    <div class="col s12 m6 l6 right-align-md">
                        <ol class="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{route('admin.gallery.slide.list',['id'=>$id])}}">Slides</a> </li>
                            <li class="breadcrumb-item active">Crear Slide </li>
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
                                <i class="fas fa-exclamation-triangle"></i> LOS CAMPOS EN COLOR ROJO SON OBLIGATORIOS
                                <br><br>
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
                        <form method="post" action="{{route('admin.gallery.slide.store')}}" enctype="multipart/form-data">
                            <input type="hidden" name="is_insert" value="1">
                            <input type="hidden" name="id_galeria" value="{{$id}}">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col s12 ">
                                    <div class="row">
                                      
                                        <div class="input-field col s12">

                                            <div class="file-field input-field">
                                                <div class="btn btn-main">
                                                    <span>File</span>
                                                    <input type="file" name="slide">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Upload one or more files">
                                                </div>
                                            </div>
                                            <small class="blue-text text-darken-2">Solo se aceptan imagenes con formato .JPG, .JPEG y .PNG. La imagen debe ser menor a 3 MB y la resolucion optima para esta imagen es de 480 x 615px</small>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                    
                                        {{--@if(Auth::guard('admin')->user()->permisos('add_doctor'))--}}
                                        <div class="input-field col s12">
                                            <button class="btn waves-effect waves-light right btn-main" type="submit" name="action">Crear Instructor
                                                <i class="material-icons right">send</i>
                                            </button>
                                        </div>
                                        {{--@endif--}}
                                    </div>
                                </div>

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