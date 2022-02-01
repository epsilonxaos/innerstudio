
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
                <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
                        <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="row">
                            <div class="input-field col s12 center-align">
                                <h5 class="ml-4 tlo">Recuperacion de Correo</h5>
                            </div>
                        </div>
                        <div class="row margin">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">person_outline</i>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
    
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="email" class="center-align">email</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">lock_outline</i>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <label for="password_confirmation" class="center-align">Password</label>
                            </div>
                        </div>
                        <div class="row margin">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">lock_outline</i>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
    
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="input-field col s12 center-align">
                                <button type="submit" class="btn waves-effect waves-light border-round btn-grad">  {{ __('Reset Password') }}</button>
                            </div>
                        </div>

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