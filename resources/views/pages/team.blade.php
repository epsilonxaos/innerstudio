{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}
    <link rel="stylesheet" href="{{asset('css/team.css')}}">
@endpush

@section('contenido')
    <section class="team">
        <div class="team--1">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 m20 text-center"> <h3>TEAM</h3> </div>
                    {{-- <div class="col-12 col-md-6 m20 text-center text-md-right">
                        <div class="buscador">
                            <form action="">
                                <input type="search" name="buscar" id="buscar" placeholder="Buscar Instructor">
                                <i class="fas fa-search"></i>
                            </form>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="team--2">
            <div class="container">
                <div class="row">
                    @foreach ($team as $coach)
                        @if($coach -> status_externo == 0)
                            <div class="col-12 col-md-6 line-bottom col-lg-4">
                                <a href="{{route('front.team.detalle',['id' => $coach -> id_instructor])}}">
                                    <div class="card-team">
                                        <div class="name">{{$coach -> name}}</div>
                                        <div class="bg" style="background-image: url('{{asset($coach -> avatar)}}')">
                                            <img src="{{asset('images/blank-team.png')}}" alt="{{$coach -> name}}">
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>

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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{-- Aqui van los scripts para esta vista --}}
@endpush