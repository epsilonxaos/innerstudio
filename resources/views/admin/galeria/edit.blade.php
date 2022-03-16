@extends('admin.layout.panel')
@section('contenido')
<div id="main">
    <div class="row">
        <div id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s12 m6 l6">
                        <h5 class="breadcrumbs-title">Actualizar slide</h5>
                    </div>
                    <div class="col s12 m6 l6 right-align-md">
                        <ol class="breadcrumbs">
                            <li class="breadcrumb-item"><a href="{{route('admin.gallery.list')}}">Galerias</a> </li>
                            <li class="breadcrumb-item active">Actualizar slide</li>
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
                        <form method="post" action="{{route('admin.gallery.update', ['id' => $data -> id])}}" enctype="multipart/form-data">
                            <input type="hidden" name="is_insert" value="1">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col s12">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <p for="cover">Cover</p>
                                            <input type="file" name="cover" data-default-file="{{asset($data -> cover)}}" class="dropify" data-height="300" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png" />
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="title" name="title" type="text" value="{{ $data -> title }}" class="@error('title') invalid @enderror">
                                            <label for="email">Titulo</label>
                                        </div>
                                        <div class="col s12">
                                            <label>Seccion</label>
                                            <select name="seccion" id="seccion" class="browser-default @error('seccion') invalid @enderror">
                                                <option {{($data -> seccion === 'principal') ? 'selected' : ''}} value="principal">Slide Principal</option>
                                                <option {{($data -> seccion === 'indexBottom') ? 'selected' : ''}} value="indexBottom">Slide Index Bottom</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="col s12 ">
                                    {{--@if(Auth::guard('admin')->user()->permisos('add_doctor'))--}}
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right btn-main" type="submit" name="action">Actualizar
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                    {{--@endif--}}
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.dropify').dropify();
</script>
@endpush