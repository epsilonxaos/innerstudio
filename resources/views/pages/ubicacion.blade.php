{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}
    <link rel="stylesheet" href="{{asset('css/ubicacion.css')}}">
@endpush

@section('contenido')
    <section class="ubicacion">
        <div class="ubicacion--1">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center m20"><h3 class="text-uppercase">Ubicación</h3></div>
                    <div class="col-12 col-md-6 m20"><div id="mapa"></div></div>
                    <div class="col-12 col-md-4 m20">
                        <p>Datos de contacto</p>
                        <ul>
                            <li>T: (999) 931 2760</li>
                            <li>C: info@innerstudio.mx</li>
                            <li>D: Calle 61 #140 Colonia Montes de Amé, Local 202 Buyan Edificio. Mérida, Yucatán, México</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="ubicacion--2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                        <form action="{{route('mail.contacto')}}" method="POST">
                            @csrf
                            <div class="row">
                                @if ($errors->any())
                                    <div class="col-12">
                                        <small class="text-danger">Faltan campos por llenar</small>
                                        @foreach($errors->all() as $message)
                                            <small class="text-danger">{{$message}}</small><br>
                                        @endforeach
                                    </div>
                                @elseif(session()->has('message'))
                                    {{ session()->get('message') }}
                                @endif
                                <div class="col-12 col-md-6">
                                    <input class="w-100" type="text" name="nombre" placeholder="Nombre">
                                    <input class="w-100" type="text" name="apellido" placeholder="Apellido">
                                    <input class="w-100" type="email" name="email" placeholder="Email">
                                    <input class="w-100" type="text" name="telefono" placeholder="Teléfono">
                                </div>
                                <div class="col-12 col-md-6">
                                    <textarea name="mensaje" placeholder="Mensaje" cols="30" rows="10"></textarea>
                                    <div class="g-recaptcha centrar" data-sitekey="6LfqwcMUAAAAALDaY6FPF6weReqEg-XKTZKmlXWD"></div>
                                    <div class="checkbox-terms m15">
                                        <input type="checkbox" id="terminos" name="terminos" value="1">
                                        <label for="terminos"><span></span> Acepto <a href="" target="_blank">Términos y Condiciones</a></label>
                                    </div>
                                    <div class="text-center"> <button class="btn btn-main" type="submit">Enviar</button> </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-md-8 col-lg-4 col-xl-6 text-center">
                        <img src="{{asset('images/decoraciones/barre-trazo2.png')}}" alt="" class="studio">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    {{-- Aqui van los scripts para esta vista     --}}
    <script type="text/javascript" src='https://www.google.com/recaptcha/api.js?hl=es'></script>
    <script>
        var lat = 21.037713;
        var lng = -89.6177137;

        var map;
        function initMap() {
            var uluru = {lat: lat, lng: lng};
            map = new google.maps.Map(document.getElementById('mapa'), {
                zoom: 14,
                center: uluru
            });

            var marker = new google.maps.Marker({
                position: uluru,
                map: map,
                icon: PATH+'/images/pin.png',
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuu1Q0hHmlO30h7YRDZ0mWYof-SM-edns&callback=initMap"></script>
    <script src="{{asset('js/ubicacion.js')}}"></script>
@endpush