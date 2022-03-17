<?php

namespace App\Http\Controllers;

use App\Cupon;
use App\Customer;
use App\mat_per_class;
use App\Package;
use App\PagoFacil;
use App\Reservation;
use Carbon\Carbon;
use Carbon\Factory;
use App\Purchase;
use App\PurchaseData;
use App\Jobs\SendMailJob;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Conekta_client;

use Conekta\Charge;
use Conekta\Conekta;
use Conekta\Customer as ConektaCustomer;
use Conekta\Handler;
use Conekta\Order;
use Conekta\ParameterValidationError;
use Conekta\ProcessingError;





class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.purchase.list');
    }


    /**
     * @param DataTables $dataTables
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function data(DataTables $dataTables)
    {
        $builder = Purchase::join('purchase_data', 'purchase.id_purchase', '=', 'purchase_data.id_purchase')
            ->select('purchase.id_purchase', 'purchase.id_customer', 'purchase.id_package', 'purchase.price', 'purchase.no_class', 'purchase.duration', 'purchase.date_expirate', 'purchase.status', 'purchase.reference_code', 'purchase.created_at', 'purchase.method_pay', 'purchase_data.name', 'purchase_data.lastname') -> orderBy('purchase.id_purchase', 'DESC');

        return $dataTables->eloquent($builder)
            ->editColumn('id_purchase', function ($row) {
                $input = '<label>
                            <input type="checkbox" name="foo" value="'.$row -> id_purchase.'" />
                            <span></span>
                        </label>';
                return $input;
            })
            ->editColumn('reference_code', function($row){
                return $row -> reference_code ? $row -> reference_code : $row -> id_purchase;
            })
            ->editColumn('price', function($row){
                return '$'.number_format($row -> price,2);
            })
            ->addColumn('fullname', function($row){
                return $row -> name.' '.$row -> lastname;
            })
            ->editColumn('id_package', function($row){
                $package = Package::where('id_package', $row -> id_package) -> first();
                return '<strong>'.$package -> title.':</strong> <br> '.$row -> no_class.' clase(s)';
            })
            ->editColumn('date_expirate', function($row){
                $johnDateFactory = new Factory([
                    'locale' => 'es_MX',
                    'timezone' => 'America/merida',
                ]);
                $gameStart = Carbon::parse($row -> date_expirate, 'UTC');
                $parseDay = $johnDateFactory->make($gameStart)->isoFormat('dddd D MMMM YYYY');
                return $parseDay;
            })
            ->editColumn('method_pay', function($row){
                return self::getMethod($row -> method_pay);
            })
            ->editColumn('created_at', function($row){
                $johnDateFactory = new Factory([
                    'locale' => 'es_MX',
                    'timezone' => 'America/merida',
                ]);
                $gameStart = Carbon::parse($row -> created_at, 'UTC');
                $parseDay = $johnDateFactory->make($gameStart)->isoFormat('ddd D MMM YYYY');
                return $parseDay;
            })
            ->editColumn('status', function($row){
                return self::getStatus($row -> status);
                //return date('d-m-Y', strtotime($row -> date_expirate));
            })
            ->addColumn('actions', function($row){
                $btn = '<a class="btn btn-cafe" href="venta/editar/'.$row -> id_purchase.'">Ver compra</a>';
                return $btn;
            })
            ->rawColumns(['id_purchase','fullname', 'id_package', 'method_pay', 'status', 'actions'])
            ->make();
    }

    public function create()
    {
        $packages = Package::where('status', 1)->get();
        $customers = Customer::where('status', 1)->get();
        return view('admin.purchase.create', ['packages' => $packages, 'customers' => $customers]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $custom_message = [
            'id_package.required'    => 'Selecciona un paquete para poder continuar',
            'id_customer.required' => 'Selecciona un cliente para poder continuar',
            'method_pay.required'    => 'El campo metodo de pago es obligatorio',
        ];
        $this -> validate($request, [
            'id_package'  => 'required',
            'id_customer' => 'required',
            'method_pay'  => 'required',
        ], $custom_message);

        $today = date('Y-m-d H:i:s');
        if(self::validatePackage($request -> id_package, $request -> id_customer)){
            $package = Package::where('id_package', $request -> id_package) -> first();
            $duration = $package -> duration;
            $purchase = Purchase::create([
                'id_customer'      => $request -> id_customer,
                'id_package'   => $request -> id_package,
                'price'      => $package -> price,
                'no_class' => $package -> no_class,
                'duration'   => $duration,
                'status'     => 3,
                'date_expirate' => date('Y-m-d H:i:s', strtotime($today.' +'.$duration.' days')),
                'method_pay' => $request -> method_pay,
                'discount' => $request -> discount
            ]);
            if($purchase -> id_purchase){
                $customer = Customer::where('id_customer', $request -> id_customer) -> first();
                $purchase_data = PurchaseData::create([
                    'id_purchase' => $purchase -> id_purchase,
                    'name'        => $customer -> name,
                    'lastname'    => $customer -> lastname,
                    'phone'       => $customer -> phone,
                    'email'       => $customer -> email,
                    'address'     => $customer -> address,
                    'cupon_name'  => $request -> cupon,
                    'cupon_type'  => $request -> cupon_type,
                    'cupon_value' => $request -> cupon_discount
                ]);
                //Detecta si existe un cupon en la orden y le aumenta el uso
                if($request -> discount > 0){
                    if($request -> cupon != ''){
                        if(Cupon::where('title',$request -> cupon) -> exists() ){
                            $cupon = Cupon::where('title', $request -> cupon)->first();
                            $cupon -> uses = $cupon -> uses + 1;
                            $cupon -> save();
                        }
                    }
                }
                #SendMailJob::dispatch("compra", $purchase -> id_customer, $purchase -> id_purchase) ->delay(now()->addMinutes(1));
                #SendMailJob::dispatch("compra_staff", "", "") ->delay(now()->addMinutes(1));
                return redirect()
                    -> back()
                    -> with('message', 'Se ha creado la venta correctamente');
            }

        }else{
            return redirect()
                -> back()
                -> with('package', 'Este paquete ya no aplica para este cliente')
                -> withInput($request -> input());
        }


    }

    public function storeTest(Request $request)
    {
        /*$custom_message = [
            'id_package.required'    => 'Selecciona un paquete para poder continuar',
            'id_customer.required' => 'Selecciona un cliente para poder continuar',
        ];
        $this -> validate($request, [
            'id_package'  => 'required',
            'id_customer' => 'required',
            'method_pay'  => 'required',
        ], $custom_message);*/

        $today = date('Y-m-d H:i:s');
        if(self::validatePackage($request -> id_package, $request -> id_customer)){
            $package = Package::where('id_package', $request -> id_package) -> first();
            $duration = $package -> duration;
            $purchase = Purchase::create([
                'id_customer'      => $request -> id_customer,
                'id_package'   => $request -> id_package,
                'price'      => $package -> price,
                'no_class' => $package -> no_class,
                'duration'   => $duration,
                'status'     => 1,
                'date_expirate' => date('Y-m-d H:i:s', strtotime($today.' +'.$duration.' days')),
                'method_pay' => 'tarjeta',
                'discount' => 0.00
            ]);
            if($purchase -> id_purchase){
                $purchase_data = PurchaseData::create([
                    'id_purchase' => $purchase -> id_purchase,
                    'name'        => $request -> nombre,
                    'lastname'    => $request -> apellidos,
                    'phone'       => $request -> celular,
                    'email'       => $request -> email,
                    'address'     => $request -> calleyNumero,
                    'cupon_name'  => '',
                    'cupon_type'  => '',
                    'cupon_value' => ''

                ]);

                $_user_id = '64727f5ad8b9227461b0032473fc52bbff04c0ba';
                $_sucursal_id = 'a85826d97c5ab47969f701e0708c9f426d688fae';

                $pagofacil = new PagoFacil($_sucursal_id, $_user_id);
                $pagofacil -> setMode(false);
                $charge = Array(
                    'data[nombre]' =>$request -> nombre,
                    'data[apellidos]' => $request -> apellidos,
                    'data[numeroTarjeta]' => $request -> numeroTarjeta,
                    'data[cvt]' => $request -> cvt,
                    'data[mesExpiracion]' => $request -> mesExpiracion,
                    'data[anyoExpiracion]' => $request -> anyoExpiracion,
                    'data[monto]' => $package->price - $request -> discount,
                    'data[idPedido]' => $purchase -> id_purchase
                );
                $customer = Array(
                    'data[email]' => $request -> email,
                    'data[telefono]' => $request -> celular,
                    'data[celular]' => $request -> celular,
                    'data[calleyNumero]' => $request -> calleyNumero,
                    'data[colonia]' => $request -> colonia,
                    'data[municipio]' => $request -> municipio,
                    'data[estado]' => $request -> estado,
                    'data[pais]' => 'México',
                    'data[cp]' => $request -> cp
                );
                $pagofacil -> createCharge($charge);
                $pagofacil -> createCustomer($customer);
                $pagofacil -> executePay();
                $success = 0;
                $item_number = $pagofacil -> response -> data -> idPedido;
                $id = $pagofacil -> response -> idTransaccion;
                if($pagofacil -> response ->  status == 'success'){
                    if($pagofacil -> response -> autorizado){
                        $success = 1;
                        $purchase -> status = 3;
                        $purchase -> reference_code = $id;
                        $purchase -> date_payment = date('Y-m-d H:i:s');
                        $purchase -> save();
                        return redirect()
                            -> route('compra');
                    }else{
                        $purchase -> status = 4;
                        $purchase -> save();
                        return redirect()
                            -> back()
                            -> with('error', $pagofacil -> response -> pf_message)
                            -> withInput($request -> input());
                    }
                }else{
                    $purchase -> status = 4;
                    $purchase -> save();
                    return redirect()
                        -> back()
                        -> with('error', $pagofacil -> response -> pf_message)
                        -> withInput($request -> input());
                }

            }

        }else{
            return redirect()
                -> back()
                -> with('error', 'Este paquete ya no aplica para este cliente')
                -> withInput($request -> input());
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = Purchase::where('id_purchase',$id)->first();
        $purchase_data = PurchaseData::where('id_purchase', $id)->first();
        $package = Package::find($purchase -> id_package);

        return view('admin.purchase.edit', ['purchase' => $purchase, 'purchase_data' => $purchase_data, 'package' => $package]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $custom_message = [
            'title.required'     => 'El campo título es obligatorio',
            'no_class.required'  => 'El campo numero de clases es obligatorio',
            'price.required'     => 'El campo precio es obligatorio',
            'duration.required'  => 'El campo duración es obligatorio',
        ];
        $this -> validate($request, [
            'title'    => 'required',
            'no_class' => 'required',
            'price'    => 'required',
            'duration' => 'required',
        ], $custom_message);

        $update = Purchase::where('id_purchase', $id) -> update([
            'title'      => $request -> title,
            'no_class'   => $request -> no_class,
            'price'      => $request -> price,
            'duration'   => $request -> duration,
            'single_use' => $request -> single_use,
        ]);

        return redirect()
            -> back()
            -> with('message', 'Se ha modificado el paquete correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(Reservation::where('id_purchase', $request -> id) -> where('status', 1) -> exists()){
            $reservations = Reservation::join('_mat_per_class','_mat_per_class.id_mat_per_class','=','reservation.id_mat_per_class')
                ->join("lesson", "lesson.id_lesson", "=", "_mat_per_class.id_class")
                ->where('reservation.id_purchase', $request -> id)->where('reservation.status', 1)->get();
            foreach ($reservations as $res){
                Reservation::where('id_reservation',$res->id_reservation)->update(['status' => 4]);
                mat_per_class::where('id_mat_per_class',$res->id_mat_per_class)->update(['status' => 0]);
            }
        }

        $purchase = Purchase::find($request -> id);
        $purchase -> status = 5;
        $purchase -> save();
        return redirect() -> route('admin.purchase.list') -> with('success', 'Se ha eliminado este registro con éxito');
    }

    public function changeStatus(Request $request){

        $purchase = Purchase::find($request -> id);
        $purchase -> status = $request -> status;
        $purchase -> save();
        return redirect() -> route('admin.purchase.list') -> with('success', 'Se ha modificado el estatus de este registro con éxito');
    }

    static public function validatePackage($id_package, $id_customer){
        $package = Package::where('id_package', $id_package) -> first();
        if($package -> single_use){
            if(Purchase::where('id_customer', $id_customer) -> where('id_package', $id_package) -> where('status', 3) -> exists()){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }

    public function compra_data_conekta(Request $request){
        $today = date('Y-m-d H:i:s');
        $package = Package::where('id_package', $request -> id_package) -> first();
        $duration = $package -> duration;
        $Client = Customer::where('id_customer', $request -> id_customer) -> update([
            'name' => $request -> nombre,
            'lastname' => $request -> apellidos,
            'phone' => $request -> celular,
            'address' => $request -> calleyNumero,
            'colony' => $request -> colonia,
            'city' => $request -> municipio,
            'state' => $request -> estado,
            'country' => $request -> pais,
            'zip' => $request -> cp,
            'status' => 1,
        ]);
        $Client = Customer::where('id_customer', $request -> id_customer)->first();
        if(self::validatePackage($request -> id_package, $request -> id_customer)){
            $purchase = Purchase::create([
                'id_customer' => $request -> id_customer,
                'id_package' => $request -> id_package,
                'price' => $package -> price,
                'no_class' => $package -> no_class,
                'duration' => $duration,
                'status' => 1,
                'discount' => $request -> discount,
                'date_expirate' => date('Y-m-d H:i:s', strtotime($today.' +'.$duration.' days')),
                'method_pay' => "tarjeta",
                'discount' => $request -> discount
            ]);
            PurchaseData::create([
                'id_purchase' => $purchase -> id_purchase,
                'name' => $Client -> name,
                'lastname' => $Client -> lastname,
                'phone' => $Client -> phone,
                'email' => $Client -> email,
                'address' => $Client -> address,
                'cupon_name' => $request -> cupon,
                'cupon_type' => $request -> cupon_type,
                'cupon_value' => $request -> cupon_discount
            ]);
        }else{
            return redirect() -> back() -> with('error', 'Error en algo');
        }
        $conekta = new Conekta_client();

        $customer_k = $conekta->newClient(
            array(
                "name" => $request -> nombre.' '.$request -> apellidos,
                "email" => $Client -> email,
                "phone" => $request -> celular,
                "payment_sources" => [
                    [
                        "type" => "card",
                        "token_id" => $request -> token
                    ]
                ]
            )
        );
       

        if($request -> discond > 0)
        {
            $info_descuento = Array(
                array(
                    "code" => $request -> cupon,
                    "type" => "coupon",
                    "amount" => $request -> cupon_discount
                )
            );
        }else{
            $info_descuento = [];
        }

        $order = $conekta->newOrder([
            'currency' => 'mxn',
            'line_items'=> [
                [
                    'id'=> $request ->id_package,
                    'name'        => 'Paquete de clases',
                    'unit_price'  => $request ->monto*100,
                    'quantity'    => 1,
                ]
            ],
            'discount_lines'=>$info_descuento,
            'charges'  => [
                [
                    "payment_method" => [
                        "type" => "default",
                    ],
                    'amount' => $request ->monto*100,
                ]
            ],
            'customer_info' => [
                "customer_id" => $customer_k -> id
            ]
        ]);
        if(isset($order) && $order->payment_status == "paid"){
            $purchase -> status = 3;
            $free = false;
            if($request -> discount > 0 && $request -> total == 0 && $request -> cupon != ''){ //Detectamos si existe algun descuento
                    if(Cupon::where('title',$request -> cupon) -> exists() ){ //Verificamos que exista ese cupon
                            $purchase -> method_pay = 'gratis';
                            $cupon = Cupon::where('title', $request -> cupon)->first(); //Obtenemos el registro del cupon con el titulo
                            $cupon -> uses = $cupon -> uses + 1; //Amentamos el uso del cupon
                            $cupon -> save(); //Guardamos ese aumento
                            $free = true;
                        }
                    }
                    //mails
                    // SendMailJob::dispatch("compra", $purchase -> id_customer, $purchase -> id_purchase) ->delay(now()->addMinutes(1));
                    // SendMailJob::dispatch("compra_staff", "", "") ->delay(now()->addMinutes(1));
            $purchase -> save();
            return redirect() -> route('completado', ['free' => $free, 'success' => true, 'error' => '']);

        }

        return redirect() -> route('completado', ['free' => false, 'success' => false, 'error' => $order]);      
    }

    public function compra_update_data_conekta(Request $request){
        $today = date('Y-m-d H:i:s');
        Customer::where('id_customer', $request -> id_customer) -> update([
            'name' => $request -> nombre,
            'lastname' => $request -> apellidos,
            'phone' => $request -> celular,
            'address' => $request -> calleyNumero,
            'colony' => $request -> colonia,
            'city' => $request -> municipio,
            'state' => $request -> estado,
            'country' => $request -> pais,
            'zip' => $request -> cp,
            'status' => 1,
        ]);

        if(self::validatePackage($request -> id_package, $request -> id_customer)){
            $package = Package::where('id_package', $request -> id_package) -> first();
            $duration = $package -> duration;
            $purchase = Purchase::create([
                'id_customer' => $request -> id_customer,
                'id_package' => $request -> id_package,
                'price' => $package -> price,
                'no_class' => $package -> no_class,
                'duration' => $duration,
                'status' => 1,
                'date_expirate' => date('Y-m-d H:i:s', strtotime($today.' +'.$duration.' days')),
                'method_pay' => "conekta",
                'discount' => $request -> discount
            ]);

            //si la compra se crea el purchase data
            if($purchase -> id_purchase){
                $client = Customer::where('id_customer', $request -> id_customer)->first();

                PurchaseData::create([
                    'id_purchase' => $purchase -> id_purchase,
                    'name' => $client -> name,
                    'lastname' => $client -> lastname,
                    'phone' => $client -> phone,
                    'email' => $client -> email,
                    'address' => $client -> address,
                    'cupon_name' => $request -> cupon,
                    'cupon_type' => $request -> cupon_type,
                    'cupon_value' => $request -> cupon_discount
                ]);
                
                Conekta::setApiKey(env('APP_PAGOS_KEY_S'));
                Conekta::setApiVersion('2.0.0');
                
                $success_customer = false;

                // Creamos el pago y decimos que esta en proceso

                try {
                    $customerConekta = ConektaCustomer::create(
                        array(
                            "name" => $request -> nombre.' '.$request -> apellidos,
                            "email" => $client -> email,
                            "phone" => $request -> celular,
                            "payment_sources" => [
                                [
                                    "type" => "card",
                                    "token_id" => $request -> token
                                ]
                            ]
                        )//customer
                    );

                    $success_customer = true;
                } catch (ProcessingError $error) {
                    $er = $error->getMesage();
                } catch (ParameterValidationError $error) {
                    $er = $error->getMessage();
                } catch (Handler $error) {
                    $er = $error->getMessage();
                }

                if($success_customer)
                {
                    $success = false;

                    try {
                        $preOrder = array(
                            "line_items" => array(
                                array(
                                    "name" => 'Paquete de clases',
                                    'unit_price' => $request -> monto * 100,
                                    'quantity' => 1,
                                )
                            ),
                            "currency" => 'MXN',
                            "customer_info" => array(
                                "customer_id" => $customerConekta -> id
                            ),
                            "charges" => array(
                                array(
                                    "payment_method" => array(
                                        "type" => "default",
                                    )
                                )
                            )
                        );

                        if($request -> discond > 0)
                        {
                            $preOrder['discount_lines'] = Array(
                                array(
                                    "code" => $request -> cupon,
                                    "type" => "coupon",
                                    "amount" => $request -> cupon_discount
                                )
                            );
                        }

                        $order = Order::create( $preOrder );

                        $success = true;
                    } catch (\Conekta\ProcessingError $error) {
                        $error = 'Error: ' . $error->getMessage();
                    } catch (\Conekta\ParameterValidationError $error) {
                        $error = 'Error: ' . $error->getMessage();
                    } catch (\Conekta\Handler $error) {
                        $error = 'Error: ' . $error->getMessage();
                    } catch (\Conekta\ResourceNotFoundError $error) {
                        $error = 'Error: ' . $error->getMessage();
                    }

                    if($success)
                    {
                        $status = $order -> charges[0] -> status;
                        $free = 0;
                        switch ($status) {
                            case 'paid':
                                $purchase -> status = 3;
                                if($request -> discount > 0){ //Detectamos si existe algun descuento
                                    $total = $request -> total; //Calculamos el total a pagar aplicando el cupon
                                    if($total == 0){ //Verificamos si el total es igual a 0
                                        $purchase -> method_pay = 'gratis';
                                        if($request -> cupon != ''){ //Detectamos que el titulo del cupon no venga vacio
                                            if(Cupon::where('title',$request -> cupon) -> exists() ){ //Verificamos que exista ese cupon
                                                $cupon = Cupon::where('title', $request -> cupon)->first(); //Obtenemos el registro del cupon con el titulo
                                                $cupon -> uses = $cupon -> uses + 1; //Amentamos el uso del cupon
                                                $cupon -> save(); //Guardamos ese aumento

                                                $free = 1;
                                            }
                                        }
                                        // SendMailJob::dispatch("compra", $purchase -> id_customer, $purchase -> id_purchase) ->delay(now()->addMinutes(1));
                                        // SendMailJob::dispatch("compra_staff", "", "") ->delay(now()->addMinutes(1));
                                    }
                                }

                                $purchase -> save();
                                // dd($order);
                                return redirect() -> route('completado', ['free' => $free, 'success' => 'complete']);
                            default:
                                return redirect() -> route('completado', ['free' => $free, 'success' => 'fail']) -> with('error', $error);
                                break;
                        }
                    }
                    else
                    {
                        return redirect() -> route('completado', ['free' => false, 'success' => 'fail']) -> with('error', $error);
                    }
                }
                else 
                {
                    return redirect() -> route('completado', ['free' => false, 'success' => 'fail']) -> with('error', $error);
                }
            }
        }

        return redirect() -> route('completado', ['free' => false, 'success' => 'fail']) -> with('error', 'Desconocido');
    }

        
    public function compra_update_data(Request $request){
        $today = date('Y-m-d H:i:s');
        $updateCustomer = Customer::where('id_customer', $request -> id_customer) -> update([
            'name' => $request -> nombre,
            'lastname' => $request -> apellidos,
            'phone' => $request -> celular,
            'address' => $request -> calleyNumero,
            'colony' => $request -> colonia,
            'city' => $request -> municipio,
            'state' => $request -> estado,
            'country' => $request -> pais,
            'zip' => $request -> cp,
            'status' => 1,
        ]);
        $redirect = false;
        if(self::validatePackage($request -> id_package, $request -> id_customer)){
            $package = Package::where('id_package', $request -> id_package) -> first();
            $duration = $package -> duration;
            //modificar para añadir metodo de pago conekta
            $purchase = Purchase::create([
                'id_customer' => $request -> id_customer,
                'id_package' => $request -> id_package,
                'price' => $package -> price,
                'no_class' => $package -> no_class,
                'duration' => $duration,
                'status' => 1,
                'date_expirate' => date('Y-m-d H:i:s', strtotime($today.' +'.$duration.' days')),
                'method_pay' => "pagofacil",
                'discount' => $request -> discount
            ]);

            //si la compra se crea el purchase data
            if($purchase -> id_purchase){
                $customer = Customer::where('id_customer', $request -> id_customer) -> first();
                $purchase_data = PurchaseData::create([
                    'id_purchase' => $purchase -> id_purchase,
                    'name' => $customer -> name,
                    'lastname' => $customer -> lastname,
                    'phone' => $customer -> phone,
                    'email' => $customer -> email,
                    'address' => $customer -> address,
                    'cupon_name' => $request -> cupon,
                    'cupon_type' => $request -> cupon_type,
                    'cupon_value' => $request -> cupon_discount
                ]);
                $redirect = true;
                $pago_completo = false;
                if($request -> discount > 0){ //Detectamos si existe algun descuento
                    $total = $request -> total; //Calculamos el total a pagar aplicando el cupon
                    if($total <= 10){ //Verificamos is el total es menos igual a 10
                        if($total == 0){ //Verificamos si el total es igual a 0
                            $purchase -> status = 3; //Cambiomos a status 3 pagado porque es un cupon con el 100% de descuento
                            $purchase -> method_pay = 'gratis';
                            $purchase -> save(); //Guardamos esto a la orden
                            if($request -> cupon != ''){ //Detectamos que el titulo del cupon no venga vacio
                                if(Cupon::where('title',$request -> cupon) -> exists() ){ //Verificamos que exista ese cupon
                                    $cupon = Cupon::where('title', $request -> cupon)->first(); //Obtenemos el registro del cupon con el titulo
                                    $cupon -> uses = $cupon -> uses + 1; //Amentamos el uso del cupon
                                    $cupon -> save(); //Guardamos ese aumento
                                }
                            }
                            SendMailJob::dispatch("compra", $purchase -> id_customer, $purchase -> id_purchase) ->delay(now()->addMinutes(1));
                            SendMailJob::dispatch("compra_staff", "", "") ->delay(now()->addMinutes(1));
                            $redirect = false; //no se puede redireccionar porque el total es igual a 0
                            $pago_completo = true;
                        }else{
                            $purchase -> method_pay = '';
                            $purchase -> error_pay = 'El pago es menor del minimo de compra';
                            $purchase -> save();
                            $pago_completo = false;
                            $redirect = false; //El total es menor a 10 pero no menor a 0 entonces no se puede pagar
                        }
                    }
                }

                return json_encode(['response' => true, 'id_purchase' => $purchase -> id_purchase, 'redirect' => $redirect, 'complete_payment' => $pago_completo]);
            }else{
                return json_encode(['response' => false, 'id_purchase' => null]);
            }

        }else{
            return json_encode(['response' => false, 'id_purchase' => null]);
        }
    }

    public function updatePurchaseAnyDate(){
        $purchases = Purchase::where('id_package', 113)->where('status', 3)->get();
        foreach ($purchases as $p){
            $fecha_inicio = $p -> created_at;
            $duration = 45;
            $p -> duration = $duration;
            $p -> date_expirate = date('Y-m-d H:i:s', strtotime($fecha_inicio.' +'.$duration.' days'));
            $p -> save();
        }
    }

    static public function getStatus($status){
        switch ($status){
            case '1':
                return '<span class="badge cyan darken-1">Creada</span>';
                break;
            case '2':
                return '<span class="badge amber darken-1">Procesando</span>';
                break;
            case '3':
                return '<span class="badge light-green darken-1">Pago completado</span>';
                break;
            case 4:
                return '<span class="badge deep-purple darken-1">Error al pagar</span>';
                break;
            case 5:
                return '<span class="badge red darken-4">Cancelado</span>';
                break;
            default:
                return '<span class="badge brown darken-1">Error</span>';
            break;
        }
    }

    static public function getMethod($method){
        switch ($method){
            case 'tarjeta':
                return '<span class="badge orange darken-4"><i class="far fa-credit-card"></i> Tarjeta</span>';
            break;
            case 'efectivo':
                return '<span class="badge green darken-4"><i class="fas fa-hand-holding-usd"></i> Efectivo</span>';
            break;
            case 'pagofacil':
                return '<span class="badge light-blue darken-4"><i class="far fa-gem"></i> Pago Fácil</span>';
            break;
            case 'gratis':
                return '<span class="badge pink darken-1"><i class="fas fa-gift"></i> Gratis</span>';
            break;
            default:
                return '<span class="badge grey darken-4"><i class="fas fa-ban"></i> Incompleto</span>';
            break;
        }
    }
}
