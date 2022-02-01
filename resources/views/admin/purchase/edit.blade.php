@extends('admin.layout.panel')
@section('contenido')
    <div id="main">
        <div class="row">
            <div id="breadcrumbs-wrapper">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title">Detalle Venta Folio: {{$purchase -> id_purchase}}</h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs">
                                <li class="breadcrumb-item"><a href="{{route('admin.purchase.list')}}">Ventas</a>
                                </li>
                                <li class="breadcrumb-item active">Detalle Venta
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="container">
                    <div class="card overflow-unset">
                        <div class="card-content">
                            <div class="invoice-table">
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <table class="responsive-table custom-table">
                                            <thead>
                                            <tr>
                                                <th data-field="no">ID orden</th>
                                                <th data-field="item">Paquete</th>
                                                <th data-field="uprice">Cliente</th>
                                                <th data-field="price">Status</th>
                                                <th data-field="price">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>{{$purchase -> id_purchase}}</td>
                                                <td>{{$package -> title}}</td>
                                                <td>{{$purchase_data -> name}} {{$purchase_data -> lastname}}</td>
                                                <td><?=\App\Http\Controllers\PurchaseController::getStatus($purchase -> status)?></td>
                                                <td>${{$purchase -> price}}</td>
                                            </tr>
                                            <tr class="border-none">
                                                <td colspan="3"></td>
                                                <td>Sub Total:</td>
                                                <td>$ {{$purchase -> price}}</td>
                                            </tr>
                                            @if($purchase -> discount > 0)
                                            <tr class="border-none">
                                                <td colspan="3"></td>
                                                <td>Descuento ({{$purchase_data -> cupon_name}}: {{$purchase_data -> cupon_type == 1 ? $purchase_data -> cupon_value.' %' : '$'.$purchase_data -> cupon_value}} )</td>
                                                <td>${{$purchase -> discount}}</td>
                                            </tr>
                                            @endif
                                            <tr class="border-none">
                                                <td colspan="3"></td>
                                                <td class="text-main strong pl-1">Total</td>
                                                <td class="text-main strong">$ {{number_format($purchase -> price - $purchase -> discount, 2)}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        @if($purchase -> error_pay)
                                        <div class="card-alert card red">
                                            <div class="card-content white-text">
                                                <p>
                                                    <i class="fas fa-exclamation-triangle"></i> <p>Error Pago: {{$purchase -> error_pay}}</p>
                                                </p>
                                            </div>
                                        </div>
                                        @endif
                                        @if($purchase -> status == 3 && $purchase -> created_at > '2019-12-04')
                                        <div class="input-field col s12">
                                            <button class="btn waves-effect waves-light right btn-main red do-delete" data-id="{{$purchase -> id_purchase}}" type="button" name="action">Cancelar
                                                <i class="material-icons right">cancel</i>
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{--<form method="POST" action="{{route('admin.purchase.update', [$purchase -> id_purchase])}}">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col s12">
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
                                        @endif
                                    </div>
                                    <div class="col s12 m6 offset-m3 l6 offset-l3">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="title" name="title" type="text"  value="{{ old('title') ? old('title') : $purchase -> title }}" class="@error('title') invalid @enderror">
                                                <label for="title">Título</label>
                                            </div>
                                            <div class="input-field col s6">
                                                <input id="no_class" name="no_class" type="text"  value="{{ old('no_class') ? old('no_class') : $purchase -> no_class  }}" class="@error('no_class') invalid @enderror">
                                                <label for="no_class">No. de sesiones</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="price" name="price" type="text"  value="{{ old('price') ? old('price') : $purchase -> price }}" class="@error('price') invalid @enderror" >
                                                <label for="price">Precio</label>
                                            </div>
                                            <div class="input-field col s12 m6">
                                                <input id="duration" name="duration" type="text"  value="{{ old('duration') ? old('duration') : $purchase -> duration }}" class="@error('duration') invalid @enderror">
                                                <label for="duration">Duración</label>
                                            </div>
                                            <div class="col s12 m6">
                                                <label for="single_use">
                                                    <p class="mb-2">Uso único o de primera vez</p>
                                                    <input type="hidden" name="single_use" value="0">
                                                    <input name="single_use" type="checkbox" {{old('single_use') == 1 ? 'checked' : $purchase -> single_use == 1 ? 'checked' : ''}} class="filled-in" id="single_use" value="1" />
                                                    <span>Si</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    --}}{{--@if(Auth::guard('admin')->user()->permisos('upd_purchase'))--}}{{--
                                    <div class="input-field col s12">
                                        <button class="btn waves-effect waves-light right" type="submit" name="action">Modificar Venta
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                    --}}{{--@endif--}}{{--
                                </div>
                            </form>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-delete" class="modal">
        <div class="modal-content">
            <div class="card-alert card brown darken-4">
                <div class="card-content white-text">
                    <p>
                        <i class="material-icons">warning</i> ¿Estás seguro que deseas eliminar este registro? <br> Al hacerlo las reservaciones realizadas se verán afectadas y se le retirarán el numero de sesiones adquiridos.
                    </p>
                </div>
            </div>
            <p></p>
        </div>
        <div class="modal-footer">
            <form method="POST" action="{{route('admin.purchase.delete')}}">
                @method('DELETE')
                @csrf
                <input type="hidden" name="id" value="">
                <a href="#!" class="modal-close waves-effect deep-orange accent-1 btn-flat white-text">Cancelar</a>
                <button class="modal-close waves-effect brown darken-4 btn-flat white-text" type="submit">Continuar</button>
            </form>
        </div>
    </div>

@endsection
@push('js')
    <script src="{{asset('admin/js/custom/purchase.js')}}"></script>
    <script src="{{asset('admin/js/scripts/app-contacts.js')}}"></script>
@endpush