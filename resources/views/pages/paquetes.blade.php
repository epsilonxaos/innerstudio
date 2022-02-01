{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}
    <link rel="stylesheet" href="{{asset('css/paquetes.css')}}">
@endpush

@section('contenido')
    <section class="paquetes">
        <h3 class="text-center">¡NUESTROS PAQUETES!</h3>
        <div class="planes-clases">
            <div class="container">
                <div class="row">
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
                                    <h2>1</h2>
                                    <p>Clase</p>
                                    <hr>
                                    <h4>$200</h4>
                                    <hr>
                                    <small>Vigencia: 30 días</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-2 mb-1 p-0">
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
    {{-- Aqui van los scripts para esta vista     --}}

@endpush