<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Reservation;
use App\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Auth;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.customer.list');
    }


    /**
     * @param DataTables $dataTables
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function data(DataTables $dataTables)
    {
        $builder = User::join('customer', 'users.id_customer', '=', 'customer.id_customer')
            -> select(
                'users.id',
                'customer.id_customer',
                'customer.name',
                'customer.lastname',
                'customer.email',
                'customer.phone',
                'customer.status'
            )
            -> where('customer.status', '!=', 3)
            -> where('users.type', '=', 1)
            -> orderBy('customer.id_customer', 'DESC');

        // dd($builder);
        // $builder = Customer::query()
        //     -> select('id_customer', 'name', 'lastname', 'email', 'phone', 'status')
        //     -> where('status', '!=', 3)
        //     -> orderBy('id_customer', 'DESC');

        return $dataTables->eloquent($builder)
            ->editColumn('id_customer', function ($row) {
                $input = '<label>
                            <input type="checkbox" name="foo" value="'.$row -> id_customer.'" />
                            <span></span>
                        </label>';
                return $input;
            })
            ->editColumn('name', function($row){
                return $row -> name.' '.$row -> lastname;
            })
            ->addColumn('actions', function($row){
                $btn = '<a class="btn btn-cafe" href="cliente/editar/'.$row -> id_customer.'"><i class="far fa-edit"></i></a> ';
                $btn .= '<a class="btn btn-cafe" href="cliente/preview/'.$row -> id_customer.'"><i class="fas fa-id-card"></i></a>';
                if(Auth::user()->checkPermiso("acc_clientes")){
                    if($row -> status){
                        $btn .= ' <a class="btn btn-cafe do-change" data-id="'.$row -> id_customer.'" data-status="0" href="javascript:;"><i class="fas fa-eye"></i></a>';
                    }else{
                        $btn .= ' <a class="btn grey white-text do-change" data-id="'.$row -> id_customer.'" data-status="1" href="javascript:;"><i class="fas fa-eye-slash"></i></a>';
                    }
                    $btn .= ' <a class="btn red do-delete white-text" data-id="'.$row -> id_customer.'" href="javascript:;"><i class="fas fa-trash"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['id_customer', 'name', 'actions'])
            ->make();
    }

    public function create($clase = 0)
    {
        return view('admin.customer.create',['clase_redirect' => $clase]);

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $customer = Customer::where('email', $request -> email) -> get();
        $custom_message = [
            'name.required' => 'El campo nombre es obligatorio',
            'lastname.required' => 'El campo Apellido es obligatorio',
            'email.required' => 'El campo correo es obligatorio',
            'email.unique' => 'Este correo ya existe intente con otro',
            'phone.required' => 'El campo telefono es obligatorio',
            'password.required' => 'El campo contraseña es obligatorio',
            'password.min' => 'El minimo de caracteres para la contraseña son de 6 caractéres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ];
        $this -> validate($request, [
            'name' => 'required',
            'lastname' => 'required',
            'email' => [
                'required',
                Rule::unique(
                    'customer',
                    'email'
                ) -> ignore($customer)
            ],
            'phone' => 'required',
            'password' => 'required|min:6|confirmed',
        ], $custom_message);

        $customer = Customer::create([
            'name'     => $request -> name,
            'lastname' => $request -> lastname,
            'email'    => $request -> email,
            'phone'    => $request -> phone,
            'address'  => $request -> address,
            'colony'   => $request -> colony,
            'city'     => $request -> city,
            'state'    => $request -> state,
            'country'  => $request -> country,
            'zip'      => $request -> zip,
            'birthdate'=> $request -> birthdate,
            'status'   => 1,
        ]);

        $user = User::create([
            'id_customer' => $customer -> id_customer,
            'email' => $customer -> email,
            'type' => 1,
            'password' => Hash::make($request -> password)
        ]);

        if($request -> clase_redirect == 'customer') {
            return redirect()->route('admin.purchase.create')->with('id_customer', $customer->id_customer);
        }else{
            return redirect()
                -> back()
                -> with('message', 'Se ha creado el cliente correctamente');
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
        $customer = Customer::find($id);
        return view('admin.customer.edit', ['customer' => $customer]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::where('email', $request -> email)->where('status', 1) -> get();
        $custom_message = [
            'name.required' => 'El campo name es obligatorio',
            'lastname.required' => 'El campo Apellido Paterno es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.unique' => 'Este email ya existe intente con otro',
            'phone.required' => 'El campo phone es obligatorio',
            'password.required_if' => 'El campo contraseña es obligatorio',
            'password.min' => 'El minimo de caracteres para la contraseña son de 6 caractéres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ];
        $this -> validate($request, [
            'name' => 'required',
            'lastname' => 'required',
            'email' => [
                'required_if:editar_mail,1',
                Rule::unique(
                    'customer',
                    'email'
                ) -> ignore($customer)
            ],
            'phone' => 'required',
            'password' => 'required_if:editar_pass,1|min:6|confirmed',
        ], $custom_message);

        $update = Customer::where('id_customer', $id) -> update([
            'name'     => $request -> name,
            'lastname' => $request -> lastname,
            'phone'    => $request -> phone,
            'address'  => $request -> address,
            'colony'   => $request -> colony,
            'birthdate'=> $request -> birthdate,
            'city'     => $request -> city,
            'state'    => $request -> state,
            'country'  => $request -> country,
            'zip'      => $request -> zip
        ]);
        $customer_upd = Customer::find($id);
        $user_upd = User::where('id_customer', $id) -> first();
        if($request -> editar_mail){
            $customer_upd -> email = $request -> email;
            $customer_upd -> save();
            $user_upd -> email = $request -> email;
            $user_upd -> save();
        }

        if($request -> editar_pass){
            $user_upd -> password = Hash::make($request -> password);
            $user_upd -> save();
        }

        return redirect()
            -> back()
            -> with('message', 'Se ha modificado el cliente correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $customer = Customer::find($request -> id);
        $customer -> status = 3;
        $customer -> save();
        return redirect() -> route('admin.customer.list') -> with('success', 'Se ha eliminado este registro con éxito');
    }

    public function changeStatus(Request $request){

        $customer = Customer::find($request -> id);
        $customer -> status = $request -> status;
        $customer -> save();
        return redirect() -> route('admin.customer.list') -> with('success', 'Se ha modificado el estatus de este registro con éxito');
    }
    public function profile(Request $request,$id){

        $customer = Customer::find($request -> id);
        return redirect() ->view('admin.customer.profile',['customer'=>$customer]);
    }

    public function preview(Request $request, $id){
        $params = self::getDataCustomer($id);
        $edad = self::getDuration(date('Y-m-d'), $params -> birthdate);
        $purchase = Purchase::where("id_customer", $id)
            ->whereDate('date_expirate','>=',Date::now())
            ->where('status',3)
            ->sum('no_class');
        // 1 -reservada 2 - asistio  - 3 cancelada
        $clases_reservadas = Reservation::join("purchase", "purchase.id_purchase", "=", "reservation.id_purchase")
            ->whereDate('purchase.date_expirate','>=', Date::now())
            ->where('purchase.status',3)
            ->where("reservation.id_customer", $id)
            ->whereIn('reservation.status',[1,2,4])
            ->count();

            //where("id_customer", $id)
        // $clases_canceladas = Reservation::where("id_customer", $id)
        //     ->where('status', 3)
        //     ->count();
        $now = Carbon::now() -> format("Y-m-d H:i:s");
        $proximas_clases = Reservation::join("_mat_per_class","_mat_per_class.id_mat_per_class","=","reservation.id_mat_per_class")
            ->join("lesson", "lesson.id_lesson", "=", "_mat_per_class.id_class")
            ->join("mat", "mat.id_mat", "=", "_mat_per_class.id_mat")
            ->join("instructor", "instructor.id_instructor", "=", "lesson.id_instructor")
            ->where("lesson.start", ">", $now)
            ->where("reservation.id_customer",$request -> id)
            ->where("reservation.status", 1)
            ->orderBy('reservation.created_at', 'DESC')
            ->get();

        $clases_pasadas = Reservation::select("reservation.*", "mat.no_mat", "instructor.name", "lesson.start")
            ->join("_mat_per_class","_mat_per_class.id_mat_per_class","=","reservation.id_mat_per_class")
            ->join("lesson", "lesson.id_lesson", "=", "_mat_per_class.id_class")
            ->join("mat", "mat.id_mat", "=", "_mat_per_class.id_mat")
            ->join("instructor", "instructor.id_instructor", "=", "lesson.id_instructor")
            ->whereIn("reservation.status", [1,2,3,4])
            ->where("reservation.id_customer",$request -> id)
            ->orderBy('updated_at', 'DESC')
            ->get();

        $compras = Purchase::where("id_customer", $id)
            ->where("status", 3)
            ->get();

        return view('admin.customer.preview', [
            'params' => $params,
            'edad' => $edad,
            'disponibles' => ($purchase - $clases_reservadas),
            // 'canceladas' => $clases_canceladas,
            // 'compensacion' => 0,
            'purchase'=>$purchase,
            'proximas_clases' => $proximas_clases,
            'clases_pasadas' => $clases_pasadas,
            'compras' => $compras
        ]);
    }

    static public function getDataCustomer($id){
        $response = Customer::where('id_customer', $id)
            -> first();

        return $response;
    }
    static public function getDuration($start, $end){
        // dd($end);
        $start = new Carbon($start);
        $end = new Carbon($end);
        // dd($start);
        return $start -> diffInYears($end);
    }

}
