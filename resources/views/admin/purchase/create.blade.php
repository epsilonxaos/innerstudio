@extends('admin.layout.panel')
@section('contenido')
    <div id="main">
        <div class="row">
            <div id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title">Crear Venta</h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs">
                                <li class="breadcrumb-item"><a href="{{route('admin.purchase.list')}}">Ventas</a>
                                </li>
                                <li class="breadcrumb-item active">Crear Venta
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="container">
                    @if ($errors->any())
                        <div class="card-alert card red">
                            <div class="card-content white-text">
                                <p>
                                    <i class="fas fa-exclamation-triangle"></i> LOS CAMPOS EN COLOR ROJO SON OBLIGATORIOS <br><br>
                                    @foreach($errors->all() as $message)
                                        {{$message}} <br>
                                    @endforeach
                                </p>
                            </div>
                            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @elseif(session()->has('message'))
                        <div class="card-alert card green">
                            <div class="card-content white-text">
                                <p>
                                    <i class="fas fa-check"></i>
                                    {{ session()->get('message') }}
                                </p>
                            </div>
                            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @elseif(session()->has('package'))
                        <div class="card-alert card red">
                            <div class="card-content white-text">
                                <p>
                                    <i class="fas fa-check"></i>
                                    {{ session()->get('package') }}
                                </p>
                            </div>
                            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
                    <div class="card overflow-unset">
                        <div class="card-content">
                            <form method="post" action="{{route('admin.purchase.insert')}}" id="formulario">
                                <input type="hidden" name="is_insert" value="1">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col s12 m10 offset-m1 l8 offset-l2">
                                        <div class="row">
                                            <div class="col s12 m12">
                                                <label>Elije un paquete</label>
                                                <select name="id_package" id="id_package" class="browser-default @error('id_package') invalid @enderror">
                                                    <option value="" selected data-precio="0">Paquete</option>
                                                    @foreach($packages as $pk)
                                                        <option {{  session('id_package') == $pk['id_package'] || old('id_package') == $pk['id_package'] ? 'selected' : '' }} value="{{ $pk['id_package'] }}" data-precio="{{$pk['price']}}">{{$pk['title']}} ${{$pk['price']}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col s12 m8">
                                                <label>Elije un cliente</label>
                                                <select name="id_customer" id="id_customer" class="browser-default @error('id_customer') invalid @enderror">
                                                    <option value="" selected>Cliente</option>
                                                    @foreach($customers as $ct)
                                                        <option {{  session('id_customer') == $ct['id_customer'] || old('id_customer') == $ct['id_customer'] ? 'selected' : '' }} value="{{ $ct['id_customer'] }}">{{ $ct['name'] != '' ? $ct['name'].' '.$ct['lastname'] : 'Datos Incompletos' }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col s12 m4 mt-2">
                                                <a href="{{route('admin.customer.create', ['clase' => 'customer'])}}" class="btn btn-round btn-main">Crear Cliente</a>
                                            </div>
                                            <div class="col s12 m12">
                                                <label>Elije un metodo de pago</label>
                                                <select name="method_pay" id="method_pay" class="browser-default @error('method_pay') invalid @enderror">
                                                    <option value="" selected>Metodo Pago</option>
                                                    <option {{old('method_pay') == 'efectivo' ? 'selected' : ''}} value="efectivo">Efectivo</option>
                                                    <option {{old('method_pay') == 'tarjeta' ? 'selected' : ''}} value="tarjeta">Tarjeta</option>
                                                </select>
                                            </div>
                                            <div class="input-field col s12 m8">
                                                <input id="cupon" name="cupon" type="text"  value="{{ old('cupon') }}" class="@error('cupon') invalid @enderror">
                                                <label for="cupon">Ingresa un cupón</label>
                                            </div>
                                            <div class="col s12 m4 mt-2">
                                                <button type="button" class="btn btn-round apply-cupon btn-main">Aplicar descuento</button>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="reference_code" name="reference_code" type="text"  value="{{ old('reference_code') }}" class="@error('reference_code') invalid @enderror">
                                                <label for="reference_code">Referencia Tarjeta</label>
                                            </div>
                                            <div class="col s12 mt-4">
                                                <input type="hidden" name="cupon_discount" value="0">
                                                <input type="hidden" name="cupon_type" value="0">
                                                <input type="hidden" name="subtotal" value="0">
                                                <input type="hidden" name="discount" value="0">
                                                <input type="hidden" name="total" value="0">
                                                <table>
                                                    <tbody>
                                                    <tr>
                                                        <th>Subtotal</th>
                                                        <th>$<span id="subtotal">0.00</span></th>
                                                    </tr>
                                                    <tr>
                                                        <th>Descuento <span id="cupon_text"></span></th>
                                                        <th id="cupon_value">$0.00</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th>$<span id="total">0.00</span></th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {{--@if(Auth::guard('admin')->user()->permisos('add_doctor'))--}}
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right btn-main" id="btn-send-formulario" type="submit" name="action">Crear Venta
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                    {{--@endif--}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('admin/js/custom/purchase.js?v=1.0.2')}}"></script>
    <script type="text/javascript">
        document.getElementById("formulario").addEventListener('submit', function () {
            this.getElementById("btn-send-formulario").setAttribute('disabled', "disabled");
        });
    </script>
@endpush