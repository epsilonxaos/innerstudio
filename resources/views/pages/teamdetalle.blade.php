{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}
    <link rel="stylesheet" href="{{asset('css/teamdetalle.css')}}">
@endpush

@section('contenido')
    <section class="teamdetalle">

        <div class="container">
            <div class="row justify-content-around">
                <div class="col-12 col-md-6 col-lg-5 col-xl-5 descripcioninstructor bg-white">
                    <div class="instructor">
                        <h3> {{$teamdetalle[0]->name}}</h3>
                        <p class="mt-4">
                            {{$teamdetalle[0]->description}}
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6 col-xl-6 instructorfondo bg-body">
                    <div class="instructorimg">
                        <img src="{{asset($teamdetalle[0]->avatar)}}" alt="instructor">
                        <div class="mancha"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    {{-- Aqui van los scripts para esta vista --}}
  
@endpush
