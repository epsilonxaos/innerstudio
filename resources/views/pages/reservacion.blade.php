{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}
    <link rel="stylesheet" href="{{asset('css/reservacion.css')}}">
@endpush

@section('contenido')
    <section class="reservacion">
        {{-- Titulo --}}
        <div class="bg-blanco">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 col-lg-4 text-center m20"><h2 class="text-uppercase">reservar</h2></div>
                    <div class="col-12 col-md-6 col-lg-6 text-center m20"><a href="{{route('front.reservar',['page'=>$page-1])}}" class="btn btn-cafe circle d-inline-block mr-2 " style=" {{ $prev ? '' : 'display:none !important'}}"><img src="{{ asset('images/icons/icon-prev.svg')}}" width="12px" alt=""></a><h4 class="d-inline-block text-uppercase m-0">del {{$days[0]}} al {{$days[1]}} de {{$mes}}</h4><a href="{{route('front.reservar',['page'=>$page+1])}}" class="btn btn-cafe circle d-inline-block ml-2 " style="{{ $next ?  '' : 'display:none !important'}}"><img src="{{asset('images/icons/icon-next.svg')}}" width="12px" alt=""></a></div>
                </div>
            </div>
        </div>
        {{-- Calendario --}}
        <div class="bg-main">
            <div class="calendar-week deco">
                <div class="calendar-week-header d-flex">
                    <div class="calendar-week-title">
                    <h5>{{$cal[0][0]}}.<span>{{$cal[0][1]}}</span></h5>
                    </div>
                    <div class="calendar-week-title">
                        <h5>{{$cal[1][0]}}.<span>{{$cal[1][1]}}</span></h5>
                    </div>
                    <div class="calendar-week-title">
                        <h5>{{$cal[2][0]}}.<span>{{$cal[2][1]}}</span></h5>
                    </div>
                    <div class="calendar-week-title">
                        <h5>{{$cal[3][0]}}.<span>{{$cal[3][1]}}</span></h5>
                    </div>
                    <div class="calendar-week-title">
                        <h5>{{$cal[4][0]}}.<span>{{$cal[4][1]}}</span></h5>
                    </div>
                    <div class="calendar-week-title">
                        <h5>{{$cal[5][0]}}.<span>{{$cal[5][1]}}</span></h5>
                    </div>
                    <div class="calendar-week-title">
                        <h5>{{$cal[6][0]}}.<span>{{$cal[6][1]}}</span></h5>
                    </div>
                </div>
                <div class="calendar-week-body d-flex">
                    <div class="calendar-week-pilar">
                  

                    @foreach($params as $lesson)
                        @if( date('d', strtotime($lesson->start)) === $cal[0][1])
                            <div style="background-color:{{$lesson->color}};"class="calendar-week-card {{ (App\Lesson::inTime($lesson->id_lesson)? '' : 'off-time')}}  {{ (App\Lesson::isfull($lesson->id_lesson) >= 20 ? 'full' : '')}}">
                                <a href="{{route('front.reservar.detalle',['id'=>$lesson->id_lesson])}}" class="d-block">
                                        <h6 class="text-capitalize">{{$lesson->tipo}}</h6>
                                        <p style="width: fit-content;margin: 0 auto;padding: calc(0.1rem + 0.5vw);border-radius: 25px;font-size: calc(.4rem + .5vw);background-color:{{$lesson->color}}; color:#fff">{{$lesson->descripcion}}</p>
                                        <p class="instructor">{{$lesson->name}}</p>
                                        <p class="time">{{date('g:i A',strtotime( $lesson->start))}}</p>
                                    </a>
                                </div>
                        @endif
                    @endforeach
                    </div>
                    <div class="calendar-week-pilar">
                        <!-- <div class="calendar-week-card">
                            <a href="{{url('reservar/clase/detalle')}}" class="d-block">
                                <h6>Classic Barre</h6>
                                <p class="instructor">Caro</p>
                                <p class="time">7:10 AM</p>
                            </a>
                        </div>
                        <div class="calendar-week-card">
                            <a href="{{url('reservar/clase/detalle')}}" class="d-block">
                                <h6>Classic Barre</h6>
                                <p class="instructor">Caro</p>
                                <p class="time">7:10 AM</p>
                            </a>
                        </div>
                        <div class="calendar-week-card full">
                            <a href="{{url('reservar/clase/detalle')}}" class="d-block">
                                <h6>Classic Barre</h6>
                                <p class="instructor">Caro</p>
                                <p class="time">7:10 AM</p>
                            </a>
                        </div>
                        <div class="calendar-week-card off-time">
                            <a href="{{url('reservar/clase/detalle')}}" class="d-block">
                                <h6>Classic Barre</h6>
                                <p class="instructor">Caro</p>
                                <p class="time">7:10 AM</p>
                            </a>
                        </div> -->
                    @foreach($params as $lesson)
                        @if(date('d', strtotime($lesson->start)) === $cal[1][1])
                    
                            <div class="calendar-week-card  {{ (App\Lesson::inTime($lesson->id_lesson)? '' : 'off-time')}}  {{ (App\Lesson::isfull($lesson->id_lesson) >= 20 ? 'full' : '')}}">
                            <a href="{{route('front.reservar.detalle',['id'=>$lesson->id_lesson])}}" class="d-block">
                                    <h6 class="text-capitalize">{{$lesson->tipo}}</h6>
                                    <p style="width: fit-content;margin: 0 auto;padding: calc(0.1rem + 0.5vw);border-radius: 25px;font-size: calc(.4rem + .5vw);background-color:{{$lesson->color}}; color:#fff">{{$lesson->descripcion}}</p>
                                    <p class="instructor">{{$lesson->name}}</p>
                                    <p class="time">{{date('g:i A',strtotime( $lesson->start))}}</p>
                                </a>
                            </div>
                
                        @endif
                    @endforeach
                    </div>
                    <div class="calendar-week-pilar">
                        <!-- <div class="calendar-week-card">
                            <a href="{{url('reservar/clase/detalle')}}" class="d-block">
                                <h6>Classic Barre</h6>
                                <p class="instructor">Caro</p>
                                <p class="time">7:10 AM</p>
                            </a>
                        </div>
                        <div class="calendar-week-card full">
                            <a href="{{url('reservar/clase/detalle')}}" class="d-block">
                                <h6>Classic Barre</h6>
                                <p class="instructor">Caro</p>
                                <p class="time">7:10 AM</p>
                            </a>
                        </div> -->
                        @foreach($params as $lesson)
                        @if(date('d', strtotime($lesson->start)) === $cal[2][1])
                    
                            <div class="calendar-week-card  {{ (App\Lesson::inTime($lesson->id_lesson)? '' : 'off-time')}}  {{ (App\Lesson::isfull($lesson->id_lesson) >= 20 ? 'full' : '')}}">
                                <a href="{{route('front.reservar.detalle',['id'=>$lesson->id_lesson])}}" class="d-block">
                                    <h6 class="text-capitalize">{{$lesson->tipo}}</h6>
                                    <p style="width: fit-content;margin: 0 auto;padding: calc(0.1rem + 0.5vw);border-radius: 25px;font-size: calc(.4rem + .5vw);background-color:{{$lesson->color}}; color:#fff">{{$lesson->descripcion}}</p>
                                    <p class="instructor">{{$lesson->name}}</p>
                                    <p class="time">{{date('g:i A', strtotime($lesson->start))}}</p>
                                </a>
                            </div>
                       
                        @endif
                    @endforeach
                    </div>
                    <div class="calendar-week-pilar">
                        <!-- <div class="calendar-week-card off-time">
                            <a href="{{url('reservar/clase/detalle')}}" class="d-block">
                                <h6>Classic Barre</h6>
                                <p class="instructor">Caro</p>
                                <p class="time">7:10 AM</p>
                            </a>
                        </div>
                        <div class="calendar-week-card">
                            <a href="{{url('reservar/clase/detalle')}}" class="d-block">
                                <h6>Classic Barre</h6>
                                <p class="instructor">Caro</p>
                                <p class="time">7:10 AM</p>
                            </a>
                        </div>
                        <div class="calendar-week-card">
                            <a href="{{url('reservar/clase/detalle')}}" class="d-block">
                                <h6>Classic Barre</h6>
                                <p class="instructor">Caro</p>
                                <p class="time">7:10 AM</p>
                            </a>
                        </div> -->
                        @foreach($params as $lesson)
                        @if(date('d', strtotime($lesson->start)) === $cal[3][1])
               
                            <div class="calendar-week-card  {{ (App\Lesson::inTime($lesson->id_lesson)? '' : 'off-time')}}  {{ (App\Lesson::isfull($lesson->id_lesson) >= 20 ? 'full' : '')}}">
                            <a href="{{route('front.reservar.detalle',['id'=>$lesson->id_lesson])}}" class="d-block">
                                    <h6 class="text-capitalize">{{$lesson->tipo}}</h6>
                                    <p style="width: fit-content;margin: 0 auto;padding: calc(0.1rem + 0.5vw);border-radius: 25px;font-size: calc(.4rem + .5vw);background-color:{{$lesson->color}}; color:#fff">{{$lesson->descripcion}}</p>
                                    <p class="instructor">{{$lesson->name}}</p>
                                    <p class="time">{{date('g:i A', strtotime($lesson->start))}}</p>
                                </a>
                            </div>
                   
                        @endif
                    @endforeach
                    </div>
                    <div class="calendar-week-pilar">
                        <!-- <div class="calendar-week-card full">
                            <a href="{{url('reservar/clase/detalle')}}" class="d-block">
                                <h6>Classic Barre</h6>
                                <p class="instructor">Caro</p>
                                <p class="time">7:10 AM</p>
                            </a>
                        </div>
                        <div class="calendar-week-card">
                            <a href="{{url('reservar/clase/detalle')}}" class="d-block">
                                <h6>Classic Barre</h6>
                                <p class="instructor">Caro</p>
                                <p class="time">7:10 AM</p>
                            </a>
                        </div> -->
                        @foreach($params as $lesson)
                        @if(date('d', strtotime($lesson->start)) === $cal[4][1])
         
                            <div class="calendar-week-card  {{ (App\Lesson::inTime($lesson->id_lesson)? '' : 'off-time')}}  {{ (App\Lesson::isfull($lesson->id_lesson) >= 20 ? 'full' : '')}}">
                            <a href="{{route('front.reservar.detalle',['id'=>$lesson->id_lesson])}}" class="d-block">
                                    <h6 class="text-capitalize">{{$lesson->tipo}}</h6>
                                    <p style="width: fit-content;margin: 0 auto;padding: calc(0.1rem + 0.5vw);border-radius: 25px;font-size: calc(.4rem + .5vw);background-color:{{$lesson->color}}; color:#fff">{{$lesson->descripcion}}</p>
                                    <p class="instructor">{{$lesson->name}}</p>
                                    <p class="time">{{date('g:i A', strtotime($lesson->start))}}</p>
                                </a>
                            </div>
                 
                        @endif
                    @endforeach
                    </div>
                    <div class="calendar-week-pilar">
                    @foreach($params as $lesson)
                        @if(date('d', strtotime($lesson->start)) === $cal[5][1])
    
                            <div class="calendar-week-card  {{ (App\Lesson::inTime($lesson->id_lesson)? '' : 'off-time')}}  {{ (App\Lesson::isfull($lesson->id_lesson) >= 20 ? 'full' : '')}}">
                            <a href="{{route('front.reservar.detalle',['id'=>$lesson->id_lesson])}}" class="d-block">
                                    <h6 class="text-capitalize">{{$lesson->tipo}}</h6>
                                    <p style="width: fit-content;margin: 0 auto;padding: calc(0.1rem + 0.5vw);border-radius: 25px;font-size: calc(.4rem + .5vw);background-color:{{$lesson->color}}; color:#fff">{{$lesson->descripcion}}</p>
                                    <p class="instructor">{{$lesson->name}}</p>
                                    <p class="time">{{date('g:i A', strtotime($lesson->start))}}</p>
                                </a>
                            </div>
                     
                        @endif
                    @endforeach
                    </div>
                    <div class="calendar-week-pilar">
                    @foreach($params as $lesson)
                        @if(date('d', strtotime($lesson->start)) === $cal[6][1])
              
                            <div class="calendar-week-card  {{ (App\Lesson::inTime($lesson->id_lesson)? '' : 'off-time')}}  {{ (App\Lesson::isfull($lesson->id_lesson) >= 20 ? 'full' : '')}}">
                            <a href="{{route('front.reservar.detalle',['id'=>$lesson->id_lesson])}}" class="d-block">
                                    <h6 class="text-capitalize">{{$lesson->tipo}}</h6>
                                    <p style="width: fit-content;margin: 0 auto;padding: calc(0.1rem + 0.5vw);border-radius: 25px;font-size: calc(.4rem + .5vw);background-color:{{$lesson->color}}; color:#fff">{{$lesson->descripcion}}</p>
                                    <p class="instructor">{{$lesson->name}}</p>
                                    <p class="time">{{date('g:i A',strtotime( $lesson->start))}}</p>
                                </a>
                            </div>
                
                        @endif
                    @endforeach
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
    {{-- Aqui van los scripts para esta vista     --}}
    <script type="text/javascript">
        document.querySelectorAll(".calendar-week-body .calendar-week-pilar").forEach(item => {
            if(!item.querySelector(".calendar-week-card")){
                item.innerHTML = "";
            }
        });
    </script>
@endpush