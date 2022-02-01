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
                    <p class="m20">1 Clase</p>
                    <h5>Precio</h5>
                    <p class="m20">$200</p>
                    <h5>Expiración</h5>
                    <p>Vigencia 30 días</p>
                </div>
                <div class="col-12 col-lg-1 col-xl-1 line-break"></div>
                <div class="col-12 col-lg-8 col-xl-6">
                    <form id="3ds-form" method="post">
                        <input type="hidden" name="monto" id="monto" value="100">
                        <input type="hidden" name="idServicio" id="idServicio" value="1">
                        <input type="hidden" name="idSucursal" id="idSucursal" value="7a810b55878a1b006015c28f0171c5f9318bd8fe">
                        <input type="hidden" name="idUsuario" id="idUsuario" value="d6d15e44a37dede2380313ee11ee0afe9154d367">
                        <input type="hidden" name="httpUserAgent" id="httpUserAgent">
                        <input type="hidden" name="email" id="email" value="luisjcaamal@gmail.com">
                        <input type="hidden" name="telefono" id="telefono" value="9999235689">
                        <div class="row">
                            <div class="col-12 col-md-6"><input type="text" name="nombre" id="nombre" placeholder="Nombre" value="Luis"></div>
                            <div class="col-12 col-md-6"><input type="text" name="apellidos" id="apellidos" placeholder="Apellido" value="Caamal"></div>
                            <div class="col-12 col-md-6"><input type="text" name="estado" id="estado" placeholder="Estado" value="Yucatan"></div>
                            <div class="col-12 col-md-6"><input type="text" name="pais" id="pais" placeholder="País" value="Mexico"></div>
                            <div class="col-12 col-md-6"><input type="text" name="celular" id="celular" placeholder="Celular" value="9999235689"></div>
                            <div class="col-12 col-md-6"><input type="text" name="cp" id="cp" placeholder="C.P." value="97250"></div>
                            <div class="col-12 col-md-6">
                                <input type="text" name="calleyNumero" id="calleyNumero" placeholder="Calle y Número" value="77 #540">
                                <input type="text" name="colonia" id="colonia" placeholder="Colonia" value="Centro">
                                <input type="text" name="municipio" id="municipio" placeholder="Municipio" value="Merida">
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
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
                                    <div class="col-12"><input type="text" name="cvt" id="cvt" placeholder="CVC" value="123"></div>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <div class="checkbox-terms m15">
                                    <input type="checkbox" id="terminos" name="terminos" value="1">
                                    <label for="terminos"><span></span> Acepto <a href="" target="_blank">Términos y Condiciones</a></label>
                                </div>
                                <button class="btn btn-main do-pay" type="button">Comprar</button>
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
@endpush