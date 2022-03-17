{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}
    <link rel="stylesheet" href="{{asset('css/paquetes.css')}}">
    <style>
        body {background-position: center}
        .paquetes {min-height: 500px;}
        .paquetes h3 {font-size: 30px; line-height: initial;}
        @media screen and (min-width: 768px){
            .paquetes {min-height: 600px;}
            .paquetes h3 {font-size: 55px}
        }
    </style>
@endpush

@section('contenido')
    <section class="paquetes text-center align-items-center justify-content-center">
        @if(isset($success))
            @if($success === 'complete')
                <h3 class="d-inline-block">¡MUCHAS GRACIAS POR <br> SU COMPRA! <br> <a href="{{route('front.reservar')}}" class="btn btn-main d-inline-block pt-2">Aceptar</a></h3>
            @else
                <h3 class="d-inline-block">:( <br> ¡HA OCURRIDO UN ERROR <br> INTENTELO MÁS TARDE!</h3>
                <div class="row"></div>
                <p> ERROR: {{$error }} <br> </p>
                <a href="{{route('index')}}" class="btn btn-main d-inline-block pt-2">Regresar</a>
            @endif
        @elseif(isset($free))
            <h3 class="d-inline-block">¡MUCHAS GRACIAS POR <br> SU COMPRA! <br> <a href="{{route('front.reservar')}}" class="btn btn-main d-inline-block pt-2">Aceptar</a></h3>
        @else
            <h3 class="d-inline-block">:( <br> ¡HA OCURRIDO UN ERROR <br> INTENTELO MÁS TARDE!</h3>
        @endif
    </section>
@endsection

@push('js')
    {{-- Aqui van los scripts para esta vista     --}}

@endpush