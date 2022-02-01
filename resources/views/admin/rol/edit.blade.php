@extends('admin.layout.panel')
@section('contenido')

    <div id="main">
        <div class="row">
            <div class="pt-1 pb-0" id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title">Modificar Rol</h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs mb-0">
                                <li class="breadcrumb-item"><a href="{{route('admin.rol.list')}}">Roles</a>
                                </li>
                                <li class="breadcrumb-item active">Modificar Rol
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
                            <form method="post" action="{{route('admin.rol.update')}}">
                            <input type="hidden" name="id" value="{{$id}}">
                                {{csrf_field()}}
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
                                            <input id="name" name="name" type="text"  value="{{ $name}}" class="@error('name') invalid @enderror">
                                            <label for="name">Nombre</label>
                                        </div>
                                       
                                       @foreach($permisos as $permiso)
                                                <div class="input-field col s6 l4">
                                                    <p>
                                                        <label>
                                                        <input type="checkbox" name="permisos[{{$permiso -> id_permiso}}]" {{in_array($permiso -> id_permiso,$rol)? 'checked':''}}  />
                                                            <span>{{$permiso -> placeholder}}</span>
                                                        </label>
                                                    </p>
                                                </div>       
                                        @endforeach
                                        <div class="col s12 m12">
                                        </div>
                                        </div>
                                    </div>
                                    @if(Auth::user()->checkPermiso("acc_roles"))
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right" type="submit" name="action">Modificar Rol
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