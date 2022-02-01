<?php

namespace App\Http\Controllers;

use App\Mat;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.mat.list');
    }

    /**
     * @param DataTables $dataTables
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function data(DataTables $dataTables)
    {
        $builder = Mat::query()->select('id_mat','no_mat', 'status') -> where('status', '!=', 3) -> orderBy('id_mat', 'DESC');

        return $dataTables->eloquent($builder)
            ->editColumn('id_mat', function ($row) {
                $input = '<label>
                            <input type="checkbox" name="foo" value="'.$row -> id_mat.'" />
                            <span></span>
                        </label>';
                return $input;
            })
            ->addColumn('actions', function($row){
                $btn = '';
                //if(Auth::guard('admin')->user()->permisos('del_mat')){
                if($row -> status){
                    $btn .= ' <a class="btn btn-cafe do-change" data-id="'.$row -> id_mat.'" data-status="0" href="javascript:;"><i class="fas fa-eye"></i></a>';
                }else{
                    $btn .= ' <a class="btn grey white-text do-change" data-id="'.$row -> id_mat.'" data-status="1" href="javascript:;"><i class="fas fa-eye-slash"></i></a>';
                }
                //}
                return $btn;
            })
            ->rawColumns(['id_mat', 'actions'])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeStatus(Request $request){

        $instructor = Mat::find($request -> id);
        $instructor -> status = $request -> status;
        $instructor -> save();
        return redirect() -> route('admin.mat.list') -> with('success', 'Se ha modificado el estatus de este registro con éxito');
    }
}
