{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}
    <link rel="stylesheet" href="{{asset('css/clases.css')}}">
@endpush

@section('contenido')
    <section class="clases">
      <div class="container contenedor">

        <div class="row justify-content-center clase">
            <h2 class="h2clases mb-5">CLASES</h2>
        </div>
        <div class="row justify-content-center classicpower">
            <div class="col-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                <div class="row justify-content-between positionflex">
                    <div class="text-center col-12 col-sm-8 col-md-5 col-lg-5 col-xl-5 mb-5  p-0">
                        <div class="imgcontainer">
                            <img src="{{asset('images/decoraciones/classic.png')}}" alt="">
                            <div class="p">
                                <h4>Si tu objetivo es tonificar y compactar.</h4>
                                <p>
                                    Esta clase es la ideal. Trabajas fuerza, resistencia y flexibilidad cada músculo del cuerpo en zona de tensión con movimientos cortos y controlados. 100% bajo impacto.
                                </p>
                                <p class="pt-1"><b>Duración: 55 min</b></p>
                            </div>
                            <!-- /.p -->
                        </div>
                    </div>
                    <div class="power text-center col-12 col-sm-8 col-md-5 col-lg-5 col-xl-5 mb-5 p-0">
                        <div class="imgcontainer">
                            <img src="{{asset('images/decoraciones/power.png')}}" alt="">
                            <div class="p">
                                <h4>CARDIO+FUERZA</h4>
                                <p>
                                    Es una clase de cardio en la que trabajas el cuerpo completo. Va al ritmo de la música. Se utilizan polainas en las muñecas durante toda la clase. Eleva tu ritmo cardiaco y acelera tu metabolismo. 

                                </p>
                                <p><b>Duración: 45 min</b></p>
                            </div>
                            <!-- /.p -->
                        </div>
                    </div>
                    <div class="text-center col-12 col-sm-8 col-md-5 col-lg-5 col-xl-5 mb-5 p-0">
                        <div class="imgcontainer">
                            <img src="{{asset('images/decoraciones/sculpt.png')}}" alt="">
                            <div class="p">
                                <h4>BARRE</h4>
                                <p>
                                    Es una clase en barra donde combinas movimientos cortos con largos utilizando tu propio peso. Inspirada en pasos básico de Ballet y ejercicios funcionales.    
                                </p>
                                <p><b>Duración: 55 min</b></p>
                            </div>
                            <!-- /.p -->
                        </div>
                    </div>
                    <div class="text-center col-12 col-sm-8 col-md-5 col-lg-5 col-xl-5 mb-5 p-0">
                        <div class="imgcontainer">
                            <img src="{{asset('images/decoraciones/interval.png')}}" alt="">
                            <div class="p">
                                <h4>BARRE</h4>
                                <p>
                                    Es una clase de coreografía en barra, con intervalos de hit. Mantiene un flow sin parar donde trabajas todo el cuerpo. ¡Es la combinación perfecta de cardio, fuerza y resistencia! Estarás quemando grasa y haciendo musculo al mismo tiempo.
                                </p>
                                <p><b>Duración: 60 min</b></p>
                            </div>
                            <!-- /.p -->
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
      </div>
    </section>
@endsection

@push('js')
    {{-- Aqui van los scripts para esta vista     --}}

@endpush