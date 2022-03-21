<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Galeria;
use File;
use App\Slide;
use Auth;

class SlideController extends Controller
{
    function Slide_index($id)
    {
        return view('admin.slide.list',['id'=>$id]);
    }

    public function Slide_data(DataTables $dataTables,$id)
    {
        $builder = Slide::query()->select('id_slide','slide','id_gal')->where('id_gal',$id);


        return $dataTables->eloquent($builder)
        ->editColumn('slide',function($row){
            $col = '<img style="width: 80px;margin: 0 auto;display: block;" src="'.asset($row -> slide).'" alt="">';
            return $col;
        })
            ->addColumn('actions', function($row){
                #$btn = '<a class="btn white-text btn-cafe" href="'.route('admin..slide.edit',['slide'=>$row -> id_slide]).'"><i class="far fa-edit"></i></a>';
                #if(Auth::user()->checkPermiso("acc_Slide")){
                $btn = ' <a class="btn red do-cancel" data-id="'.$row -> id_slide.'" href="javascript:;"> <i class="fas fa-trash"></i></a>';
                #}
                return $btn;
            })
            ->rawColumns(['id_slide','slide','actions'])
            ->make();
    }

    public function Slide_create($id)
    {
        return view('admin.slide.create',['id'=>$id]);
    }

    public function Slide_update(Request $request)
    {
        if($request -> name != null && $request -> name != ''){
            Slide::where('id_slide',$request -> id)->update(['name'=>$request -> titulo]);
        }
        return redirect()->back()->  with('message', 'Slide Modificado');
    }

    public function Slide_store(Request $request)
    {
        if($request->hasFile('slide')){
            $path_cover = $request->slide->store('public/images/slides');
            $_exploded = explode('/', $path_cover);
            $_exploded[0] = 'storage';
            $path_cover = implode('/', $_exploded);
        }
        $count =  Slide::where('id_gal',$request -> id_galeria)->count();
        $gal = Slide::create(
            [
                'name'=>$request->titulo,
                'slide'=>$path_cover,
                'id_gal'=>$request->id_galeria,
                'alt'=>$request->id_galeria || null,
                'order'=>$count,
                'status'=>1
            ]);
        return redirect()
        -> back()
        -> with('message', 'Se ha creado el slide correctamente');
        
    }

    public function Slide_edit($gal)
    {

        $y = Galeria::where('id_slide',$gal)->first();
        return view('admin.slide.edit',[ 'name'=>$request->titulo,
            'slide'=>path_cover,
            'id_gal'=>$request->id_galeria,
            'alt'=>$request->id_galeria || null,
            'order'=>$count,
            'status'=>1
            ]);

    }

  

    public function Slide_destroy(Request $request){
        
       
            $slide = Slide::find($request->id);
            if(file_exists($slide -> slide)){
                File::delete($slide -> slide);
            }
            $slide -> delete();

            return redirect()-> back()-> with('message', 'Se ha eliminado el slide correctamente');
        
    }
    

}