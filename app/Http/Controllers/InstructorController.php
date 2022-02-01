<?php

namespace App\Http\Controllers;

use App\Instructor;
use File;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Auth;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.instructor.list');
    }


    /**
     * @param DataTables $dataTables
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function data(DataTables $dataTables)
    {
        $builder = Instructor::query()->select('id_instructor','avatar', 'name', 'email', 'phone', 'status') -> where('status', '!=', 3) -> orderBy('id_instructor', 'DESC');

        return $dataTables->eloquent($builder)
            ->editColumn('id_instructor', function ($row) {
                $input = '<label>
                            <input type="checkbox" name="foo" value="'.$row -> id_instructor.'" />
                            <span></span>
                        </label>';
                return $input;
            })
            ->addColumn('actions', function($row){
                $btn = '<a class="btn btn-cafe" href="instructor/editar/'.$row -> id_instructor.'"><i class="far fa-edit"></i></a>';
                if(Auth::user()->checkPermiso("acc_instructor")){
                if($row -> status){
                    $btn .= ' <a class="btn btn-cafe do-change" data-id="'.$row -> id_instructor.'" data-status="0" href="javascript:;"><i class="fas fa-eye"></i></a>';
                }else{
                    $btn .= ' <a class="btn grey white-text do-change" data-id="'.$row -> id_instructor.'" data-status="1" href="javascript:;"><i class="fas fa-eye-slash"></i></a>';
                }
                $btn .= ' <a class="btn red white-text do-delete" data-id="'.$row -> id_instructor.'" href="javascript:;"><i class="fas fa-trash"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['id_instructor', 'actions'])
            ->make();
    }

    public function create()
    {
        return view('admin.instructor.create');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if($request->externo){
            $custom_message = [
                'name.required'      => 'El campo nombre es obligatorio',
                'color.required'      => 'El campo color es obligatorio',
            ];
            $this -> validate($request, [
                'name'     => 'required',
                'color'     => 'required',
            ], $custom_message);
    
            $instructor = Instructor::create([
                'name'    => $request -> name,
                'status_externo'=>1,
                'status'    => 1,
                'color'=> $request -> color

            ]);
            return redirect()
                -> back()
                -> with('message', 'Se ha creado el instructor externo correctamente');


        }else{

            $custom_message = [
                'name.required'      => 'El campo nombre es obligatorio',
                'email.required'     => 'El campo correo es obligatorio',
                'phone.required'     => 'El campo telefono es obligatorio',
                 'coach.required'     => 'El campo imagen es obligatorio',
                 'color.required'     => 'El campo color es obligatorio',
            ];
            $this -> validate($request, [
                'name'     => 'required',
                'email'    => 'required',
                'phone'    => 'required',
                 'coach'    => 'required',
                 'color' => 'required'
            ], $custom_message);

            if($request->hasFile('coach')){
                $path_cover = $request->coach->store('public/images/coach');
                $_exploded = explode('/', $path_cover);
                $_exploded[0] = 'storage';
                $path_cover = implode('/', $_exploded);
            }
    
    
            $instructor = Instructor::create([
                'name'    => $request -> name,
                'email'    => $request -> email,
                'phone'  => $request -> phone,
                'description'  => $request -> description,
                'embed'  => $request -> embed,
                'avatar' => $path_cover,
                'status_externo'=>0,
                'color'=> $request -> color,
                'status'    => 1
            ]);
            return redirect()
                -> back()
                -> with('message', 'Se ha creado el instructor correctamente');
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
        $instructor = Instructor::find($id);
        return view('admin.instructor.edit', ['instructor' => $instructor]);
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
        if($request->externo){
            $instructor = Instructor::where('email', $request -> email) -> get();
            $custom_message = [
                'name.required'      => 'El campo nombre es obligatorio',
                'color.required'     => 'El campo color es obligatorio',
            ];
            $this -> validate($request, [
                'name'     => 'required',
                'color'    => 'required',
            ], $custom_message);


            $update = Instructor::where('id_instructor', $id) -> update([
                'name'    => $request -> name,
                'color' => $request -> color,
            ]);
        }else{
            $instructor = Instructor::where('email', $request -> email) -> get();
            $custom_message = [
                'name.required'      => 'El campo nombre es obligatorio',
                'email.required'     => 'El campo correo es obligatorio',
                'phone.required'     => 'El campo telefono es obligatorio',
                 'color.required'     => 'El campo color es obligatorio',
            ];
            $this -> validate($request, [
                'name'     => 'required',
                'email'    => 'required',
                'phone'    => 'required',
                 'color' => 'required'
            ], $custom_message);
    
            if($request->hasFile('coach')){
                if(file_exists($instructor[0] -> avatar)){
                    File::delete($instructor[0] -> avatar);
                }
    
                $path_cover = $request->coach->store('public/images/coach');
                $_exploded = explode('/', $path_cover);
                $_exploded[0] = 'storage';
                $path_cover = implode('/', $_exploded);
            }
    
    
            $update = Instructor::where('id_instructor', $id) -> update([
                'name'    => $request -> name,
                'email'    => $request -> email,
                'phone'  => $request -> phone,
                'description'  => $request -> description,
                'embed'  => $request -> embed,
                'avatar' => $request->hasFile('coach')? $path_cover : $instructor[0] -> avatar,
                'color' => $request -> color,
            ]);

        }

        return redirect()
            -> back()
            -> with('message', 'Se ha modificado el instructor correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $instructor = Instructor::find($request -> id);
        $instructor -> status = 3;
        $instructor -> save();


        return redirect() -> route('admin.instructor.list') -> with('success', 'Se ha eliminado este registro con éxito');
    }

    public function changeStatus(Request $request){

        $instructor = Instructor::find($request -> id);
        $instructor -> status = $request -> status;
        $instructor -> save();
        return redirect() -> route('admin.instructor.list') -> with('success', 'Se ha modificado el estatus de este registro con éxito');
    }
}
