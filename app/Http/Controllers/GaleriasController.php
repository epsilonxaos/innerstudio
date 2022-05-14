<?php

namespace App\Http\Controllers;

use App\Galerias;
use App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Yajra\Datatables\Html\Builder;

class GaleriasController extends Controller
{
    private $directorio = "public/galerias";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.galeria.list");
    }

    public function galeria_data()
    {
        $builder = Galerias::query()->select('id','cover');
        


        return DataTables::eloquent($builder)
            ->addColumn('actions', function($row){
                $btn = '<a class="btn white-text btn-cafe" href="'.route('admin.gallery.edit', ['id' => $row -> id]).'"><i class="far fa-edit"></i></a>';
                $btn .= '<a class="btn white-text red do-delete" style="margin-left: 10px" data-id="'.$row -> id.'" href="javascript:;"><i class="fas fa-trash"></i></a>';
                return $btn;
            })
            ->editColumn('cover', function($row){
                return '<div class="bg" style="background-image: url('.asset($row -> cover).')"></div>';
            })
            ->rawColumns(['id', 'cover', 'actions'])
            ->make();

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.galeria.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request -> file('cover');
        $cover = Helpers::addFileStorage($file, $this -> directorio);
        $add = new Galerias();
        $add -> cover = $cover;
        $add -> title = $request -> title;
        $add -> seccion = $request -> seccion;
        $add -> save();

        return redirect() -> back() -> with('message', 'Slide guardado correctamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Galeria  $galeria
     * @return \Illuminate\Http\Response
     */
    public function show(Galerias $galeria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Galeria  $galeria
     * @return \Illuminate\Http\Response
     */
    public function edit(Int $id)
    {
        $slide = Galerias::find($id);

        return view('admin.galeria.edit', ['data' => $slide]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Galeria  $galeria
     * @return \Illuminate\Http\Response
     */
    public function update(Int $id, Request $request)
    {
        $add = Galerias::find($id);
        if($request -> hasFile('cover')) {
            $file = $request -> file('cover');
            Helpers::deleteFileStorage('galerias', 'cover', $id);
            $cover = Helpers::addFileStorage($file, $this -> directorio);
            $add -> cover = $cover;
            $add -> save();
        }

        $add -> title = $request -> title;
        $add -> seccion = $request -> seccion;
        $add -> save();

        return redirect() -> back() -> with('message', 'Slide actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Galeria  $galeria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Helpers::deleteFileStorage('galerias', 'cover', $request -> id);
        Galerias::find($request -> id) -> delete();

        return redirect() -> back() -> with('message', 'Slide eliminado correctamente!');
    }
}
