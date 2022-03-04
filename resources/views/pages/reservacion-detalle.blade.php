{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}
    <link rel="stylesheet" href="{{asset('css/reservacion.css')}}">
    
    <style>
        svg.plantilla-covid {
            /*background-image: url({{asset('images/inner-rese2021.png')}});*/
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
@endpush

@section('contenido')

    <section class="reservacion-detalle">
        {{-- Titulo --}}
        <div class="bg-blanco">
            <div class="container">
                <div class="row align-items-center justify-content-end">
                    <div class="col-12 col-md-4 col-lg-3 text-center">
                        @if ($data[0] -> tipo == 'classic')
                            <img src="{{asset('images/decoraciones/classic.png')}}" alt="">
                        @endif
                        @if ($data[0] -> tipo == 'interval')
                            <img src="{{asset('images/decoraciones/interval.png')}}" alt="">
                        @endif
                        @if ($data[0] -> tipo == 'power')
                            <img src="{{asset('images/decoraciones/power.png')}}" alt="">
                        @endif
                        @if ($data[0] -> tipo == 'sculpt')
                            <img src="{{asset('images/decoraciones/sculpt.png')}}" alt="">
                        @endif
                        <p>
                            {{-- <span>{{$data[0]->tipo}}</span> <br> --}}
                            <strong>{{date('d M', strtotime($data[0]->start))}}</strong> <br>
                            {{date('g:i A', strtotime($data[0]->start))}}
                        </p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-5">
                        <ul>
                            <li class="disponible d-flex align-items-center"><span>Disponible</span></li>
                            <li class="ocupado d-flex align-items-center"><span>Ocupado</span></li>
                            {{--{{ (App\Lesson::isfull($id) >= 20)? 
                            <li><button>Lista de espera</button></li>
                            : '')}}--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Calendario --}}
        <div class="bg-main deco">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h5>{{$data[0]->name}}</h5>
                        {{-- @include('pages.components.plantilla-tapetes') --}}
                        @include('pages.components.plantilla-tapetes-covid')
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
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-2 mb-1 p-0">
                        <a href="{{url('compra')}}">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h2>10</h2>
                                    <p>Clases</p>
                                    <hr>
                                    <h4>$1,400</h4>
                                    <hr>
                                    <small>Vigencia: 90 días</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-2 mb-1 p-0">
                        <a href="{{url('compra')}}">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h2>25</h2>
                                    <p>Clases</p>
                                    <hr>
                                    <h4>$3,125</h4>
                                    <hr>
                                    <small>Vigencia: 180 días</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-2 mb-1 p-0">
                        <a href="{{url('compra')}}">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h2>50</h2>
                                    <p>Clases</p>
                                    <hr>
                                    <h4>$5,000</h4>
                                    <hr>
                                    <small>Vigencia: 365 días</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-2 mb-1 p-0">
                        <a href="{{url('compra')}}">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h2>70</h2>
                                    <p>Clases</p>
                                    <hr>
                                    <h4>$7,000</h4>
                                    <hr>
                                    <small>Vigencia: 365 días</small>
                                </div>
                            </div>
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    {{-- Aqui van los scripts para esta vista --}}
    <script>
    const class_num = {{$class}};
    @if (Auth::check())
        const id = {{Auth::user() -> id_customer}};
    @endif
    </script>
    <script type="text/javascript" src="{{asset('js/reservacion_detail.js?v=1')}}"></script>
@endpush