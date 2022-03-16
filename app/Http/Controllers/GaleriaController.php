<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Galeria;
use App\Slide;
use Auth;

class GaleriaController extends Controller
{
    function galeria_index()
    {
        return view('admin.galeria.list');
    }

    public function galeria_data(DataTables $dataTables)
    {
        $builder = Galeria::query()->select('id_galeria','name');


        return $dataTables->eloquent($builder)
            ->addColumn('actions', function($row){
                $btn = '<a class="btn white-text btn-cafe" href="'.route('admin.gallery.slide.list',['id'=>$row -> id_galeria]).'"><i class="far fa-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['id_galeria','actions'])
            ->make();
    }

    public function gal_create()
    {
        return view('admin.galeria.create');
    }

    public function gal_update(Request $request)
    {
        if($request -> name != null && $request -> name != ''){
            Galeria::where('id_galeria',$request -> id_galeria)->update(['name'=>$request -> titulo]);
        }
        return redirect()->back()->  with('message', 'Galeria Modificada');
    }

    public function rol_store(Request $request)
    {
        $gal = Galeria::create(['name'=>$request->titulo]);
        return redirect()
        -> back()
        -> with('message', 'Se ha creado la galeria correctamente');
        
    }

    public function rol_edit($gal)
    {

        $y = Galeria::where('id_galeria',$gal)->first();
        return view('admin.rol.edit',['name'=> $y->name,'id'=>$gal]);

    }

  

    public function gal_destroy($id){
        
        if(Slide::where('id_gal',$id)->exists())
        {
            return redirect()
            -> back() -> with('message', 'Existen Slides en esta galeria, elimanlas antes de eliminar esta galeria');
        }
        else
        {
            $rol = Galeria::find($id);
            $rol -> delete();

            return redirect()
            -> back()-> with('message', 'Se ha eliminado la galeria correctamente');;
        }
    }
    

}