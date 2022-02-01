{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}
    <link rel="stylesheet" href="{{asset('css/comprar.css')}}">
@endpush

@section('contenido')
    <section class="compra">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-lg-3 col-xl-3 info-paquete text-center">
                    <h5>Paquete</h5>
                    <p class="m30">{{number_format($paquete -> no_class)}} {{$paquete -> title}}</p>
                    <h5>Precio</h5>
                    <p class="m30">
                        ${{number_format($paquete -> price)}} MXN
                        <br>
                        <small><strong>Descuento</strong> <span id="cupon_text"></span></small> <br>
                        <small><span id="cupon_value">$0</span> MXN</small>
                    </p>
                    <h5>Expiración</h5>
                    <p>Vigencia {{$paquete -> duration}} {{($paquete -> duration == 1) ? "día" : "dias"}}</p>
                </div>
                <div class="col-12 col-lg-1 col-xl-1 line-break"></div>
                <div class="col-12 col-lg-8 col-xl-6">
                    <input type="hidden" getform name="cupon_discount" value="0">
                    <input type="hidden" getform name="cupon_type" value="0">
                    <input type="hidden" getform name="subtotal" value="{{$paquete -> price}}">
                    <input type="hidden" getform name="discount" value="0">
                    <input type="hidden" getform name="total" value="{{$paquete -> price}}">
                    <div class="col-12 col-md-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="m15">Cupón de descuento</h6>
                                <input class="text-center" type="text" name="cupon" placeholder="Código de descuento">
                                <button class="btn btn-main apply-cupon" type="button">Aplicar</button>
                            </div>
                        </div>
                    </div>
                    <form id="3ds-form" action="">
                        <input type="hidden" getform name="id_customer" value="{{$customer -> id_customer}}">
                        <input type="hidden" getform name="id_package" value="{{$paquete -> id_package}}">
                        <input type="hidden" getform name="email" value="{{$customer -> email}}">
                        <input type="hidden" name="celular" value="{{$customer -> phone}}">
                        <input type="hidden" name="monto" id="monto" value="100">
                        <input type="hidden" name="idServicio" id="idServicio" value="1">
                        <input type="hidden" name="idSucursal" id="idSucursal" value="7a810b55878a1b006015c28f0171c5f9318bd8fe">
                        <input type="hidden" name="idUsuario" id="idUsuario" value="d6d15e44a37dede2380313ee11ee0afe9154d367">
                        <input type="hidden" name="httpUserAgent" id="httpUserAgent">
                        <div class="row m30">
                            <div class="col-12"><h5 class="m20">Datos Personales</h5></div>
                            <div class="col-12 col-md-6"><input class="w-100" getform required type="text" name="nombre" placeholder="Nombre" value="{{$customer -> name}}"></div>
                            <div class="col-12 col-md-6"><input class="w-100" getform required type="text" name="apellidos" placeholder="Apellido" value="{{$customer -> lastname}}"></div>
                            <div class="col-12 col-md-6"><input class="w-100" getform required type="text" name="telefono" placeholder="Teléfono" value="{{$customer -> phone}}"></div>
                            <div class="col-12 col-md-6"><input class="w-100" getform required type="text" name="cp" placeholder="C.P." value="{{$customer -> zip}}"></div>
                            <div class="col-12 col-md-12"><input class="w-100" getform required type="text" name="calleyNumero" placeholder="Calle y número" value="{{$customer -> address}}"></div>
                            <div class="col-12 col-md-6"><input class="w-100" getform required type="text" name="colonia" placeholder="Colonia" value="{{$customer -> colony}}"></div>
                            <div class="col-12 col-md-6"><input class="w-100" getform required type="text" name="estado" placeholder="Estado" value="{{$customer -> state}}"></div>
                            <div class="col-12 col-md-6"><input class="w-100" getform required type="text" name="ciudad" placeholder="Ciudad" value="{{$customer -> city}}"></div>
                            <div class="col-12 col-md-6"><input class="w-100" getform required type="text" name="pais" placeholder="País" value="{{$customer -> country}}"></div>
                        </div>
                        <div class="row">
                            <div class="col-12"><h5 class="m20">Método de Pago</h5></div>

                            <div class="col-12 col-md-6">
                                <div class="row text-center">
                                    <div class="col-12"><input type="text" name="numeroTarjeta" id="numeroTarjeta" placeholder="Número de tarjeta" value="4242424242424242"></div>
                                    <div class="col-12 col-md-6">
                                        <select name="mesExpiracion" id="mesExpiracion">
                                            <option value="01">01 Ene</option>
                                            <option selected value="02">02 Feb</option>
                                            <option value="03">03 Mar</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select name="anyoExpiracion" id="anyoExpiracion">
                                            <option value="19">2019</option>
                                            <option value="20">2020</option>
                                            <option selected  value="21">2021</option>
                                            <option value="22">2022</option>
                                        </select>
                                    </div>
                                    <div class="col-12"><input type="text" name="cvt" id="" placeholder="CVC"></div>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <div class="checkbox-terms m15">
                                    <input type="checkbox" id="terminos" name="terminos" value="1">
                                    <label for="terminos"><span></span> Acepto <a href="{{url("teminos")}}" target="_blank">Términos y Condiciones</a></label>
                                </div>
                                <button class="btn btn-main" type="submit" id="btn-compra">Comprar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    {{-- Aqui van los scripts para esta vista     --}}
    <script src="{{asset('js/pagofacil3ds.js')}}"></script>
    <script>
        $(function(){
            $("#3ds-form").enviarPagoFacil3dSecure();
        })
        $('.do-pay').on('click', function(){
            $('#httpUserAgent').val(navigator.userAgent);
            $("#3ds-form").submit();
        });
    </script>
    <script type="text/javascript" src="{{asset('js/compra.js')}}"></script>

@endpush