<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Permiso;
use App\Rol_permisos;
use Yajra\DataTables\DataTables;
use App\Rol;
use Auth;

class RolController extends Controller
{
    function rol_index()
    {
        return view('admin.rol.list');
    }

    public function rol_data(DataTables $dataTables)
    {
        $builder = Rol::query()->select('id_rol','rol');


        return $dataTables->eloquent($builder)
            ->editColumn('rol', function ($row) {
                return $row -> rol;
            })
            ->addColumn('actions', function($row){
                $btn = '<a class="btn white-text btn-cafe" href="'.route('admin.rol.edit',['rol'=>$row -> id_rol]).'"><i class="far fa-edit"></i></a>';
                if(Auth::user()->checkPermiso("acc_roles")){
                $btn .= ' <a class="btn red do-cancel" data-id="'.$row -> id_rol.'" href="javascript:;"> <i class="fas fa-trash"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['rol','actions'])
            ->make();
    }

    public function rol_create()
    {
        $permiso = Permiso::get();
        return view('admin.rol.create',['permisos'=>$permiso]);
    }

    public function rol_update(Request $request)
    {
        if($request -> name != null && $request -> name != ''){
            Rol::where('id_rol',$request -> id)->update(['rol'=>$request -> name]);
        }
        Rol_permisos::where('id_rol',$request -> id)->delete();
        foreach(array_keys($request->permisos) as $permiso){
            Rol_permisos::create(['id_rol'=>$request -> id,'id_permiso'=>$permiso]);
        }

        return redirect()->back()->  with('message', 'Rol Modificado');
    }

    public function rol_store(Request $request)
    {
        $rol = Rol::create(['rol'=>$request->name]);

        foreach(array_keys($request->permisos) as $permiso){
            Rol_permisos::create(['id_rol'=>$rol->id_rol,'id_permiso'=>$permiso]);
        }
        return redirect()
        -> back()
        -> with('message', 'Se ha creado el rol correctamente');
        
    }

    public function rol_edit($rol)
    {

        $permisos = Permiso::get();
        $roles = Rol::where('rol.id_rol',$rol)->join('rol_permisos','rol.id_rol','=','rol_permisos.id_rol')->get(['rol_permisos.id_permiso']);
        $data=[];
        foreach($roles as $r){ array_push($data,$r->id_permiso);}
        $y = Rol::where('id_rol',$rol)->first();
        return view('admin.rol.edit',['permisos'=>$permisos,'rol'=>$data,'name'=> $y->rol,'id'=>$rol]);

    }

  

    public function rol_destroy($id){
        
        if(User::where('id_rol',$id)->exists())
        {
            return redirect()
            -> back() -> with('message', 'Existen usuarios con este rol, cambia el rol de los usuarios antes de eliminar este rol');
        }
        else
        {
            $rol = Rol::find($id);
            $rol -> delete();

            return redirect()
            -> back()-> with('message', 'Se ha eliminado el rol correctamente');;
        }
    }
    

}