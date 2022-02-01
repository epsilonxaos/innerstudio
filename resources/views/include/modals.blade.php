{{-- Login --}}
<div class="modal deco fade" tabindex="-1" role="dialog" id="mdLogin">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form method="POST" action="{{ route('login') }}" id="formLogin">
                    @csrf
                    <h5 class="color-orange m20">Iniciar Sesión</h5>
                    <input class="m20" type="text" name="username" autocomplete placeholder="Email">
                    <input class="m20" type="password" name="password" autocomplete placeholder="Contraseña">
                    @if(session() -> has('message_login'))
                        <small class="text-danger d-block m20">{{ session()->get('message_login') }}</small>
                    @endif
                    <button type="submit" class="btn btn-main m20">Iniciar Sesión</button>
                    <p class="pointer" data-dismiss="modal" data-toggle="modal" data-target="#mdReset">¿olvidaste tu contraseña? </p>
                    <p>¿No tienes sesión? <a href="" data-dismiss="modal" data-toggle="modal" data-target="#mdRegistro">Regístrate</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Registro --}}
<div class="modal deco fade" tabindex="-1" role="dialog" id="mdRegistro">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form method="POST" action="{{ route('registerCustomer') }}" id="formRegistro">
                    @csrf
                    <h5 class="color-orange m20">Regístrate</h5>
                    <input class="m20" type="email" name="email" autocomplete placeholder="Email">
                    <input class="m20" type="password" name="password" autocomplete placeholder="Contraseña">
                    <input class="m5" type="password" name="password_confirmation" autocomplete placeholder="Confirmar Contraseña">
                    <small class="d-block m15">Tamaño minimo de contraseña: 6 caracteres</small>
                    <button type="submit" class="btn btn-main m20">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Seleccion --}}
<div class="modal deco fade" tabindex="-1" role="dialog" id="mdSeleccion">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pt-5 mt-3">
                <h5>Seleccionaste el tapete <span id="mat_place">10</span>, este será tu lugar durante la clase</h5>
                <h5 class="color-main">¿Estás de acuerdo?</h5>
                <div class="row mt-5">
                    <input type="hidden" name="reserve" id="reserve">
                    <div class="col-12 col-md-6 text-md-right"><button class="btn btn-white m15" data-dismiss="modal">Cancelar</button></div>
                    <div class="col-12 col-md-6 text-md-left"><button id="reservebtn" class="btn btn-main m15">Aceptar</button></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- compra --}}
<div class="modal deco fade" tabindex="-1" role="dialog" id="mdCompra">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pt-5 mt-3">
                <h5>No cuenta con clases disponbles, por favor adquiera un nuevo paquete</h5>
                <div class="row mt-5">
                    <input type="hidden" name="reserve" id="reserve">
                    <div class="col-12 col-md-6 text-md-right"><button class="btn btn-white" data-dismiss="modal">Cancelar</button></div>
                    <div class="col-12 col-md-6 text-md-left"><a href="{{url('/paquetes')}}" class="d-inline-block"><button id="reservebtn" class="btn btn-main" >Paquetes</button></a></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Agradecimiento --}}
<div class="modal deco fade" tabindex="-1" role="dialog" id="mdThx" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-5 d-none d-md-block">
                        <img src="{{asset('images/decoraciones/silueta-mujer3.svg')}}" alt="">
                    </div>
                    <div class="col-12 col-md-7 pt-5 text-center text-md-left">
                        <h5>¡Gracias!</h5>
                        <h5>Se ha confirmado tu asistencia a la clase de las <span id="hrs">7:10 am</span> en el tapete <span id="matSel">10</span></h5>
                        <h5 class="color-main m20">¡Te esperamos!</h5>
                        <a href="{{route('profile')}}"><button class="btn btn-main" >Aceptar</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Error --}}
<div class="modal deco fade" tabindex="-1" role="dialog" id="mdEnd">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-5">
                        <img src="{{asset('images/decoraciones/silueta-mujer3.svg')}}" alt="">
                    </div>
                    <div class="col-12 col-md-7 pt-5">
                        <h5>¡Lo sentimos!</h5>
                        <h5>La clase que ha solicitad, ya ah empezado!, pruebe otra clase</h5>
                        <button class="btn btn-main" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- recuperacion --}}
<div class="modal deco fade" tabindex="-1" role="dialog" id="mdReset">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <form id="formReset" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <h5 class="color-orange m20">Recuperar contraseña</h5>
                        
                        <input class="m20" id="emailReset" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus  placeholder="Email">
                        <small id="error_reset" class="text-green d-block m20 invisible">La cuenta que ingreso no existe!</small>
                        @if(session() -> has('message_reset'))
                        <small class="text-green d-block m20">{{ session()->get('message_reset') }}</small>
                        @endif
                        <button id="resetClick" type="submit" class="btn btn-main m20">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




