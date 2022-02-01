<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Permiso;
use App\Rol_permisos;
use App\Rol;
use App\AdminInfo;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Auth;
class AdminController extends Controller
{
    function index()
    {
        return view('admin.Users.list');
    }

    public function data(DataTables $dataTables)
    {
        $builder = User::query()->where('type',0)
            ->select('id','email','name','id_rol');


        return $dataTables->eloquent($builder)
            ->editColumn('email', function ($row) {
                return $row -> email;

            })
            ->editColumn('name', function ($row) {
                return $row -> name;

            })
            ->addColumn('rol', function($row){
                $rol = Rol::where('id_rol',$row -> id_rol)->first();
                return $rol -> rol;
            })
            ->addColumn('actions', function($row){
                $btn = '<a class="btn white-text btn-cafe" href="'.route('admin.accounts.edit',['id'=>$row -> id]).'"><i class="far fa-edit"></i></a>';
                if(Auth::user()->checkPermiso("acc_cuentas")){
                $btn .= ' <a class="btn red do-cancel" data-id="'.$row -> id.'" href="javascript:;"><i class="fas fa-trash"></a>';
                }
                return $btn;
            })
            ->rawColumns(['email','name','rol','actions'])
            ->make();


    }

    public function create()
    {
        $roles = Rol::get();
        return view('admin.Users.create',['roles'=>$roles]);
    }

    public function store(Request $request)
    {
        $admins = User::where('email', $request -> email) -> get();
        $custom_message = [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo correo es obligatorio',
            'email.unique' => 'Este correo ya existe intente con otro',
            'rol.required' => 'El campo rol es obligatorio',
            'password.required' => 'El campo contraseña es obligatorio',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ];
        $this -> validate($request, [
            'name' => 'required',
            'email' => ['required',Rule::unique('users','email') -> ignore($admins)],
            'rol'=>'required',
            'password' => 'required|confirmed',
        ], $custom_message);

        $user = User::create([
            'email' => $request -> email,
            'type' => 0,
            'password' => Hash::make($request -> password),
            'name'=>$request ->name,
            'id_rol'=>$request ->rol
        ]);
        $roles = Rol::get();
        return view('admin.Users.create',['roles'=>$roles]);
    }

    public function edit($id)
    {
        $roles = Rol::get();
        $user = User::find($id);
        return view('admin.Users.edit',['user'=>$user,'roles'=>$roles]);
    }


    public function update(Request $request)
    {
        $custom_message = [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo correo es obligatorio',
            'email.unique' => 'Este correo ya existe ',
            'rol.required' => 'El campo rol es obligatorio',
            'password.required' => 'El campo contraseña es obligatorio',
        ];

        $admins =  User::where('id',$request -> id_user)->get();


        $this -> validate($request, [
            'name' => 'required',
            'email' => ['required',Rule::unique('users','email') -> ignore($admins)],
            'rol'=>'required',
            'password' => 'required_if:edit_pass,on',
            'email' => ['required_if:edit_email,on',Rule::unique('users','email') -> ignore($admins)],
        ], $custom_message);

        $user = User::find($request -> id_user);

        $user -> name = $request -> name;
        $user -> id_rol = $request -> rol;

        if($request -> edit_pass ){
            $user -> password =  Hash::make($request -> password);
        }
        if($request -> edit_email){
            $user -> email =  $request -> email;
        }

       $user -> save();

        return redirect()->back()->  with('message', 'Cuenta Modificada');
    }

    public function delete(Request $request)
    {
        $admins = User::where('email', $request -> email) -> get();
        return view('admin.Users.create',['roles'=>$roles]);
    }


}
