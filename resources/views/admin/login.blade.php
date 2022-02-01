{{-- Extendida del layout de front --}}
@extends('admin.layout.app')

@push('css')
{{-- Aqui van estilos de esta vista --}}
<style>
    body {
        background-image: radial-gradient(circle, rgba(116,106,104,0.9009978991596639) 0%, rgba(116,106,104,1) 100%), url(/images/logininner.jpg);
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    body .tlo {
        color: #ec7a4f;
        font-weight: 500;
        text-transform: capitalize;
    }
    .input-field > label,
    p label {
        color: #2b2b2b;
    }
    .input-field .prefix ~ input {
        border-radius: 30px;
        padding: 0 20px;
        width: calc(100% - 90px);
        border: none;
        box-shadow: 0 22px 20px -25px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }
    .input-field > input[type]:-webkit-autofill:not(.browser-default) + label {
        -webkit-transform: translateY(-24px) scale(.8);
        transform: translateY(-24px) scale(.8)
    }
    input[type=text]:not(.browser-default):focus:not([readonly]),
    input[type=password]:not(.browser-default):focus:not([readonly]) {
        border-bottom: none;
        box-shadow: 0 19px 10px -20px rgb(251, 183, 144);
    }
    .input-field.col .prefix ~ label,
    .input-field.col .prefix ~ .validate ~ label {
        width: -webkit-calc(100% - 4rem - 1.5rem);
        width: calc(100% - 4rem - 1.5rem);
    }
    .input-field .prefix ~ label {margin-left: 4rem}
    .btn-grad {background-image: linear-gradient(45deg, #ff9a9e 0%, #fad0c4 99%, #fad0c4 100%) !important}
</style>
@endpush

@section('contenido')
<div class="row">
    <div class="col s12">
        <div class="container">
            <div id="login-page" class="row">
                <div class="col s12 m10 l8 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8" style="max-width: 530px">
                    <form class="login-form" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="input-field col s12 center-align">
                                <h5 class="ml-4 tlo">Inner Studio</h5>
                            </div>
                        </div>
                        <div class="row margin">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">person_outline</i>
                                <input id="username" name="username" type="text">
                                <label for="username" class="center-align">Username</label>
                            </div>
                        </div>
                        <div class="row margin">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">lock_outline</i>
                                <input id="password" name="password" type="password">
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m12 l12 ml-2 center-align">
                                <p class="mt-0">
                                    <label>
                                        <input type="checkbox" />
                                        <span>Recuerdame</span>
                                    </label>
                                </p>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="input-field col s12 center-align">
                                <button type="submit" class="btn waves-effect waves-light border-round btn-grad">Iniciar Sesión</button>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="input-field col s6 m6 l6">
                                <p class="margin medium-small"><a href="user-register.html">Register Now!</a></p>
                            </div>
                            <div class="input-field col s6 m6 l6">
                                <p class="margin right-align medium-small"><a href="user-forgot-password.html">Forgot
                                        password ?</a>
                                </p>
                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
{{-- Aqui van los scripts para esta vista --}}
@endpush