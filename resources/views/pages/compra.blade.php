{{-- Extendida del layout de front --}}
@extends('layouts.front')

@push('style')
    {{-- Aqui van estilos de esta vista --}}
    <link rel="stylesheet" href="{{asset('css/comprar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/card.css')}}">
@endpush

@section('contenido')
    <section class="compra">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-lg-3 col-xl-3 info-paquete text-center">
                    <h5>Paquete</h5>
                    <p class="m30">{{$paquete -> title}}</p>
                    <h5>Precio</h5>
                    <p class="m30">
                        ${{number_format($paquete -> price)}} MXN
                        <br>
                        <div id="content-descuento" style="display: none">
                            <small><strong>Descuento</strong> (<span id="cupon_text">0%</span>)</small> <br>
                            <small><span id="cupon_value">$0</span> MXN</small> <br>
                        </div>
                        <small><strong>Total</strong> </small> <br>
                        <small>$<span id="total_value_new">{{number_format($paquete -> price)}}</span> MXN</small>
                    </p>
                    <h5>Expiración</h5>
                    <p>Vigencia {{$paquete -> duration}} {{($paquete -> duration == 1) ? "día" : "dias"}}</p>
                </div>
                <div class="col-12 col-lg-1 col-xl-1 line-break"></div>
                <div class="col-12 col-lg-8 col-xl-6" id="compraForm">
                    <input type="hidden" getform name="cupon_discount" value="0">
                    <input type="hidden" getform name="cupon_type" value="0">
                    <input type="hidden" getform name="subtotal" value="{{$paquete -> price}}">
                    <input type="hidden" getform name="discount" value="0">
                    <input type="hidden" getform name="total" value="{{$paquete -> price}}">
                    @if (env('APP_PAGOS') == 'CONEKTA')
                    <form id="pago" method="POST" action="{{ route('comprarConecta')}}">
                        @csrf
                    @else
                    <form id="3ds-form" method="post">
                    @endif
                        <input type="hidden" getform name="id_package" value="{{$paquete -> id_package}}">
                        <input type="hidden" getform name="id_customer" value="{{$customer -> id_customer}}">
                        <input type="hidden" name="monto" id="monto" value="{{$paquete -> price}}">
                        <input type="hidden" name="idServicio" id="idServicio" value="1">
                    @if(env('APP_MODE') == 'pro')
                        <input type="hidden" name="idSucursal" id="idSucursal" value="{{env('PP_SUCURSAL')}}">
                        <input type="hidden" name="idUsuario" id="idUsuario" value="{{env('PP_USER')}}">
                    @else
                        <input type="hidden" name="idSucursal" id="idSucursal" value="{{env('PP_SAND_SUCURSAL')}}">
                        <input type="hidden" name="idUsuario" id="idUsuario" value="{{env('PP_SAND_USER')}}">
                    @endif
                        <input type="hidden" name="param1" id="param1" value="">
                        <input type="hidden" name="httpUserAgent" id="httpUserAgent">
                        <input type="hidden" name="email" id="email" value="{{$customer -> email}}">
                        <input type="hidden" name="telefono" id="telefono" value="9999235689">
                        <div class="row">
                            <div class="col-12"><h5 class="m20">Datos Personales</h5></div>
                            <div class="col-12 col-md-6"><input class="w-100" type="text" getform name="nombre" id="nombre" placeholder="Nombre" value="{{$customer -> name}}" required></div>
                            <div class="col-12 col-md-6"><input class="w-100" type="text" getform name="apellidos" id="apellidos" placeholder="Apellido" value="{{$customer -> lastname}}" required></div>
                            <div class="col-12 col-md-6"><input class="w-100" required type="text" getform name="celular" id="celular" placeholder="Celular" value="{{$customer -> phone}}" mask-phone></div>
                            <div class="col-12 col-md-6"><input class="w-100" required type="text" getform name="cp" id="cp" placeholder="C.P." value="{{$customer -> zip}}" mask-cp></div>
                            <div class="col-12 col-md-12"><input class="w-100" required type="text" getform name="calleyNumero" id="calleyNumero" placeholder="Calle y Número" value="{{$customer -> address}}"></div>
                            <div class="col-12 col-md-6"><input class="w-100" required type="text" getform name="colonia" id="colonia" placeholder="Colonia" value="{{$customer -> colony}}"></div>
                            <div class="col-12 col-md-6"><input class="w-100" required type="text" getform name="estado" id="estado" placeholder="Estado" value="{{$customer -> state}}"></div>
                            <div class="col-12 col-md-6"><input class="w-100" required type="text" getform name="municipio" id="municipio" placeholder="Municipio" value="{{$customer -> city}}"></div>
                            <div class="col-12 col-md-6"><input class="w-100" required type="text" getform name="pais" id="pais" placeholder="País" value="{{$customer -> country}}"></div>
                        </div>
                        <div class="row">
                            <div class="col-12"><h5 class="m20">Método de Pago</h5></div>
                            <div class="col-12 col-md-12">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h6 class="m15">Cupón de descuento</h6>
                                        <input class="text-center" type="text" name="cupon" getform placeholder="Código de descuento">
                                        <button class="btn btn-main apply-cupon" type="button">Aplicar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                            @if (env('APP_PAGOS') == 'CONEKTA')

                                
                                @if(count($dataCard) > 0)

                                    @include('pages.components.card-info')

                                    <div class="checkbox-terms m15">
                                        <input type="checkbox" id="new_Card" name="new_Card" value="1" onclick="showIframe()">
                                        <label for="new_Card"><span></span> Usar una nueva tarjeta</label>
                                    </div>
                                    
                                    <input type="hidden" value="{{$dataCard['id_tarjeta']}}"/>
                                    
                                    <div style="display: none" id="iframeAdd">
                                        <div id="conektaIframeContainer" style="height: 568px;" class="row"></div>
                                    </div>
                                @else
                                    <div id="conektaIframeContainer" style="height: 568px;" class="row"></div>
                                @endif
                            @else
                                <div class="row">
                                    <div class="col-12"><input type="text" name="numeroTarjeta" id="numeroTarjeta" placeholder="Número de tarjeta" value="" required mask-tarjeta></div>
                                    <div class="col-12 col-md-6">
                                        <select name="mesExpiracion" id="mesExpiracion" required>
                                            <option value="01">01 Ene</option>
                                            <option value="02">02 Feb</option>
                                            <option value="03">03 Mar</option>
                                            <option value="04">04 Abr</option>
                                            <option value="05">05 May</option>
                                            <option value="06">06 Jun</option>
                                            <option value="07">07 Jul</option>
                                            <option value="08">08 Ago</option>
                                            <option value="09">09 Sep</option>
                                            <option value="10">10 Oct</option>
                                            <option value="11">11 Nov</option>
                                            <option value="12">12 Dic</option>
                                        </select>
                                    </div>
                                </div>
                                    <div class="col-12 col-md-6">
                                        <select name="anyoExpiracion" id="anyoExpiracion" required>
                                            <option value="19">2019</option>
                                            <option value="20">2020</option>
                                            <option value="21">2021</option>
                                            <option value="22">2022</option>
                                            <option value="23">2023</option>
                                            <option value="24">2024</option>
                                            <option value="25">2025</option>
                                            <option value="26">2026</option>
                                            <option value="27">2027</option>
                                            <option value="28">2028</option>
                                            <option value="29">2029</option>
                                            <option value="30">2030</option>
                                            <option value="31">2031</option>
                                            <option value="32">2032</option>
                                            <option value="33">2033</option>
                                            <option value="34">2034</option>
                                            <option value="35">2035</option>
                                        </select>
                                    </div>
                                    <div class="col-12"><input type="password" name="cvt" id="cvt" placeholder="CVC" value="" required mask-cvv></div>
                                </div>
                            @endif
                            </div>
                            <div class="col-12 text-center">
                                <small class="mr-1">Aceptamos</small>
                                <img style="width: 50px; background-color: #fef8f3; border-radius: 4px; margin-right: 5px" src="{{asset('images/icons/icon-american-express-2.svg')}}" alt="">
                                <img style="width: 50px; background-color: #fef8f3; border-radius: 4px" src="{{asset('images/icons/icon-mastercard-2.svg')}}" alt="">
                                <img style="width: 50px; background-color: #fef8f3; border-radius: 4px" src="{{asset('images/icons/icon-visa.svg')}}" alt="">
                            </div>
                            <div class="col-12 text-center">
                                <div class="checkbox-terms m15">
                                    <input type="checkbox" id="terminos" name="terminos" value="1" required>
                                    <label for="terminos"><span></span> Acepto <a href="" target="_blank">Términos y Condiciones</a></label>
                                </div>
                                <button class="btn btn-main do-pay" type="submit" >Comprar</button>
                                <!--<button class="btn btn-main do-pay" type="submit" id="do-pay">Comprar</button>-->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@endsection

@push('js')
    <script type="text/javascript" src="{{asset('js/compra.js?v=1.0.4')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.12.0/alertify.min.js" integrity="sha512-Gnn8QFymbPDnz7C6NMHEKh2MosYchPK+vikiwNQiyEYA6CSqNfvNMCNoCXuS/q3R00DuaWktPimB5E9DQpDEQg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.12.0/css/alertify.min.css" integrity="sha512-XZbnmcIg60BDZy/AWhTVqZRe/JoFy+EXdi7EozU73a3AxhPOxLzA1/nguU50EzCS9PlMZ/GiANuIeTO8YBlvyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        const addtoform = (info)=>{
            let input = document.createElement("input");
            input.type = "hidden";
            input.name = "token";
            input.value = info.id;
            document.getElementById("pago").appendChild(input);
            alertify.success("Tarjeta añadida!").dismissOthers();
        }


    const showForm = (x,y)=>{
        window.ConektaCheckoutComponents.Card({
        targetIFrame: "#conektaIframeContainer",
        allowTokenization: true, 
        checkoutRequestId: x, // Checkout request ID, es el mismo ID generado en el paso 1
        publicKey: y, // Llaves: https://developers.conekta.com/docs/como-obtener-tus-api-keys
        options: {
            styles: {
            inputType: 'rounded',
            buttonType: 'rounded',          
            states: {
                empty: {
                borderColor: '#FFAA00' // Código de color hexadecimal para campos vacíos
                },
                invalid: {
                borderColor: '#FF00E0' // Código de color hexadecimal para campos inválidos
                },
                valid: {
                borderColor: '#0079c1' // Código de color hexadecimal para campos llenos y válidos
                }
            }
            },
            languaje: 'es', 
            button: {
            colorText: '#ffffff', // Código de color hexadecimal para el color de las palabrás en el botón de: Alta de Tarjeta | Add Card
            text: 'Agregar Tarjeta', //Nombre de la acción en el botón ***Se puede personalizar
            backgroundColor: '#301007' // Código de color hexadecimal para el color del botón de: Alta de Tarjeta | Add Card
            },
        
            iframe: {
            colorText: '#65A39B',  // Código de color hexadecimal para el color de la letra de todos los campos a llenar
            backgroundColor: '#FFFFFF' // Código de color hexadecimal para el fondo del iframe, generalmente es blanco.
            }
        },
        onCreateTokenSucceeded: addtoform ,
        onCreateTokenError: function(error) {
            console.log(error)
        }
        })
    }

    showForm('{{$token}}','{{env("PRO_APP_PAGOS_KEY_P")}}')


    function showIframe() {
        // Get the checkbox
        var checkBox = document.getElementById("new_Card");
        // Get the output text
        var text = document.getElementById("iframeAdd");

        // setTimeout(() => {
        //     document.querySelector('.frontino-button__content').innerHTML = 'Guardar tarjeta'
        // }, 1000);

        // If the checkbox is checked, display the output text
        if (checkBox.checked == true){
            text.style.display = "block";
        } else {
            text.style.display = "none";
        }
    }
</script>
    {{-- Aqui van los scripts para esta vista     --}}
    @if(count($dataCard) > 0)
        
    @else
        <script>
            // setTimeout(() => {
            //     document.querySelector('.frontino-button__content').innerHTML = 'Guardar tarjeta'
            // }, 1000);
        </script>
    @endif

@endpush
