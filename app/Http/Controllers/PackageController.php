<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Auth;
class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.package.list');
    }


    /**
     * @param DataTables $dataTables
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function data(DataTables $dataTables)
    {
        $builder = Package::query()->select('id_package','title', 'no_class', 'price', 'duration', 'status') -> where('status', '!=', 3) -> orderBy('id_package', 'DESC');

        return $dataTables->eloquent($builder)
            ->editColumn('id_package', function ($row) {
                $input = '<label>
                            <input type="checkbox" name="foo" value="'.$row -> id_package.'" />
                            <span></span>
                        </label>';
                return $input;
            })
            ->editColumn('price', function($row){
                return '$'.number_format($row -> price, 2);
            })
            ->editColumn('no_class', function($row){
                return $row -> no_class.' Clases';
            })
            ->editColumn('duration', function($row){
                return $row -> duration.' Dias';
            })
            ->addColumn('actions', function($row){
                $btn = '<a class="btn btn-cafe" href="paquete/editar/'.$row -> id_package.'"><i class="far fa-edit"></i></a>';
                if(Auth::user()->checkPermiso("acc_paquetes")){
                    if($row -> status){
                        $btn .= ' <a class="btn btn-cafe do-change" data-id="'.$row -> id_package.'" data-status="0" href="javascript:;"><i class="fas fa-eye"></i></a>';
                    }else{
                        $btn .= ' <a class="btn grey white-text do-change" data-id="'.$row -> id_package.'" data-status="1" href="javascript:;"><i class="fas fa-eye-slash"></i></a>';
                    }
                    $btn .= ' <a class="btn red white-text do-delete" data-id="'.$row -> id_package.'" href="javascript:;"><i class="fas fa-trash"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['id_package', 'actions'])
            ->make();
    }

    public function create()
    {
        return view('admin.package.create');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $custom_message = [
            'title.required'    => 'El campo título es obligatorio',
            'no_class.required' => 'El campo numero de clases es obligatorio',
            'price.required'    => 'El campo precio es obligatorio',
            'duration.required' => 'El campo duración es obligatorio',
        ];
        $this -> validate($request, [
            'title'    => 'required',
            'no_class' => 'required',
            'price'    => 'required',
            'duration' => 'required',
        ], $custom_message);

        $package = Package::create([
            'title'      => $request -> title,
            'no_class'   => $request -> no_class,
            'price'      => $request -> price,
            'duration'   => $request -> duration,
            'single_use' => $request -> single_use,
            'status'     => 1,
        ]);
        return redirect()
            -> back()
            -> with('message', 'Se ha creado el paquete correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::find($id);
        return view('admin.package.edit', ['package' => $package]);
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


        $update = Package::where('id_package', $id) -> update([
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
        $package = Package::find($request -> id);
        $package -> status = 3;
        $package -> save();
        return redirect() -> route('admin.package.list') -> with('success', 'Se ha eliminado este registro con éxito');
    }

    public function changeStatus(Request $request){

        $package = Package::find($request -> id);
        $package -> status = $request -> status;
        $package -> save();
        return redirect() -> route('admin.package.list') -> with('success', 'Se ha modificado el estatus de este registro con éxito');
    }
}
