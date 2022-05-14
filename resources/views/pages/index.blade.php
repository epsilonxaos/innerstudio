{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}
    <link rel="stylesheet" href="{{asset('css/inicio-plugins.css')}}">
    <link rel="stylesheet" href="{{asset('css/inicio.css')}}">
@endpush

@section('contenido')
    {{-- Slider principal --}}
    <div class="container-fluid p-0 mw1600 slider-fullscreen deco">
        <div class="swiper-container">
            <div class="swiper-wrapper">
               {{-- <div class="swiper-slide">
                   <a target="_blank" href="https://home.innerstudio.mx/" ><div class="bg" style="background-image: url({{asset('images/slider/6.jpg')}})"><img src="{{asset('images/blank-rect.png')}}" alt=""></div></a>
                </div>--}}
                @if(count($front) > 0)
                    @foreach ($front as $slides)
                        <div class="swiper-slide">
                            <div class="bg" style="background-image: url({{asset($slides->cover)}})"><img src="{{asset('images/blank-rect.png')}}" alt=""></div>
                        </div>
                    @endforeach
                @else
                    <div class="swiper-slide">
                        <div class="bg" style="background-image: url({{asset('images/slider/5.jpg')}})"><img src="{{asset('images/blank-rect.png')}}" alt=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg" style="background-image: url({{asset('images/slider/2.jpg')}})"><img src="{{asset('images/blank-rect.png')}}" alt=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg" style="background-image: url({{asset('images/slider/3.jpg')}})"><img src="{{asset('images/blank-rect.png')}}" alt=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg" style="background-image: url({{asset('images/slider/4.jpg')}})"><img src="{{asset('images/blank-rect.png')}}" alt=""></div>
                    </div>
                @endif
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

    {{-- Conocenos --}}
    <div class="conocenos">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-7">
                    <h2 class="m30">¡Bienvenida a INNER!</h2>
                    <p class="m20">Somos un estudio fitness que ofrece una variedad de clases divertidas que van al ritmo de la música, diseñadas para que encuentres el balance perfecto entre mente y cuerpo. El método Barre está basado en las técnicas de ballet, pilates y yoga con ejercicios funcionales e isométricos. Nuestra disciplina es de bajo impacto con mucha fuerza, resistencia y cardio. Nuestro objetivo es trabajar todos los grupos musculares, enfocados en estilizar, compactar y alargar el cuerpo. Te aseguramos tu tonificación muscular y la perdida de grasa. En INNER tu eres nuestra prioridad y nuestro objetivo principal es que alcances tus metas.</p>
                   
                    
                </div>
                <div class="col-12 col-lg-5 text-center">
                    <img class="deco" src="{{asset('images/decoraciones/barre-studio.png')}}" alt="Barre Studio">
                </div>
            </div>
        </div>
    </div>

    {{-- Compra de clases --}}
    <div class="planes-clases">
        <div class="container">
            <div class="row">
                <div class="col-12"><h3 class="text-center m40">Comprar Clases</h3></div>
                @foreach ($paquetes as $temp)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-2 mb-1 p-0">
                        @if (Auth::check())
                            <a href="{{ route('comprar', ["id"  => $temp['id_package']]) }}">
                        @else
                            <a data-toggle="modal" data-target="#mdLogin" class="pointer">
                        @endif
                            <div class="card text-center">
                                <div class="card-body">
                                    <h2>{{number_format($temp['no_class'])}}</h2>
                                    <p>{{$temp['title']}}</p>
                                    <hr>
                                    <h4>${{number_format($temp['price'])}}</h4>
                                    <hr>
                                    <small>Vigencia: {{$temp['duration']}} {{($temp['duration'] == 1) ? "día" : "dias"}}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                {{-- <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-2 mb-1 p-0">
                    <a href="{{url('compra')}}">
                        <div class="card text-center">
                            <div class="card-body">
                                <h2>5</h2>
                                <p>Clases</p>
                                <hr>
                                <h4>$875</h4>
                                <hr>
                                <small>Vigencia: 60 días</small>
                            </div>
                        </div>
                    </a>
                </div> --}}
            </div>
        </div>
    </div>

    {{-- Slider --}}
    <div class="slider bg-main deco">
        <div class="container">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                @if(count($foo) > 0)
                    @foreach ($foo as $slides)
                    <div class="swiper-slide">
                        <div class="bg" style="background-image: url({{asset($slides->cover)}})"><img src="{{asset('images/blank-rect.png')}}" alt=""></div>
                    </div>
                    @endforeach
                @else
                    <div class="swiper-slide">
                        <div class="bg" style="background-image: url({{asset('images/galeria/1.jpg')}})"><img src="{{asset('images/blank-rect.png')}}" alt=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg" style="background-image: url({{asset('images/galeria/2.jpg')}})"><img src="{{asset('images/blank-rect.png')}}" alt=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg" style="background-image: url({{asset('images/galeria/3.jpg')}})"><img src="{{asset('images/blank-rect.png')}}" alt=""></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg" style="background-image: url({{asset('images/galeria/4.jpg')}})"><img src="{{asset('images/blank-rect.png')}}" alt=""></div>
                    </div>
                @endif
                    {{-- <div class="swiper-slide">
                        <div class="bg" style="background-image: url({{asset('images/galeria/5.jpg')}})"><img src="{{asset('images/blank-rect.png')}}" alt=""></div>
                    </div> --}}
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>

    @if (count($instagram) > 0)
        <div class="instagram d-none">
            <div class="container">
                <h4><a href="http://www.instagram.com/{{$instagram[0] -> user -> username}}">@innerstudiomx</a></h4>
                <div class="row">
                    @foreach ($instagram as $int)
                        <div class="col-12 col-md-4 col-lg-3 m30">
                            <a href="{{$int -> link}}" target="_blank">
                                <div class="bg" style="background-image: url({{$int -> images -> low_resolution -> url}})">
                                    <img src="{{asset('images/blank.gif')}}" alt="">
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection

@push('js')
    {{-- Aqui van los scripts para esta vista     --}}
    <script type="text/javascript" src="{{asset('js/inicio.js')}}"></script>
@endpush
