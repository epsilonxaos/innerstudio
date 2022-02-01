<?php

namespace App\Http\Controllers;

use App\Cupon;
use App\Package;
use App\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Auth;
class CuponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cupon.list');
    }


    /**
     * @param DataTables $dataTables
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function data(DataTables $dataTables)
    {
        $builder = Cupon::query()->select('id_cupon', 'id_package', 'title', 'type', 'discount', 'start', 'end', 'directed', 'limit_use', 'uses', 'status') -> where('status', '!=', 3) -> orderBy('id_cupon', 'DESC');

        return $dataTables->eloquent($builder)
            ->editColumn('id_cupon', function ($row) {
                $input = '<label>
                            <input type="checkbox" name="foo" value="'.$row -> id_cupon.'" />
                            <span></span>
                        </label>';
                return $input;
            })
            ->addColumn('price', function($row){
                return $row -> type == 1 ? number_format($row -> discount, 0).' %' : '$ '.$row -> discount;
            })
            ->editColumn('directed', function($row){
                if($row -> directed == 'paquete'){
                    $package = Package::where('id_package', $row -> id_package) -> first();
                    return 'Solo para el paquete: <b>'.$package -> title.'</b><br> <b>Limite: </b>'.$row -> limit_use.'<br> <b>Usados: </b>'.$row-> uses;
                }else{
                    return 'Publico <br> <b>Limite: </b>'.$row -> limit_use.'<br> <b>Usados: </b>'.$row-> uses;
                }

            })
            ->addColumn('duration', function($row){
                return '<b>Incia:</b> '.$row -> start.'<br><b>Termina:</b> '.$row -> end;
            })
            ->addColumn('actions', function($row){
                $btn = '<a class="btn btn-cafe" href="cupon/editar/'.$row -> id_cupon.'"><i class="far fa-edit"></i></a>';
                if(Auth::user()->checkPermiso("acc_cupones")){
                    if($row -> status){
                        $btn .= ' <a class="btn btn-cafe do-change" data-id="'.$row -> id_cupon.'" data-status="0" href="javascript:;"><i class="fas fa-eye"></i></a>';
                    }else{
                        $btn .= ' <a class="btn grey white-text do-change" data-id="'.$row -> id_cupon.'" data-status="1" href="javascript:;"><i class="fas fa-eye-slash"></i></a>';
                    }
                    $btn .= ' <a class="btn red do-delete white-text" data-id="'.$row -> id_cupon.'" href="javascript:;"><i class="fas fa-trash"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['id_cupon', 'price', 'directed', 'duration', 'actions'])
            ->make();
    }

    public function create()
    {
        $packages = Package::where('status',1)->get();
        return view('admin.cupon.create', ['packages' => $packages]);
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
            'type.required'     => 'El campo tipo es obligatorio',
            'discount.required' => 'El campo cantidad es obligatorio',
            'directed.required' => 'El campo dirigido es obligatorio',
            'start.required'    => 'El campo fecha inicio es obligatorio',
            'end.required'      => 'El campo fecha final es obligatorio',
            'limit_use.required' => 'El campo limite de uso es obligatorio',
        ];
        $this -> validate($request, [
            'title'     => 'required',
            'type'      => 'required',
            'discount'  => 'required',
            'directed'  => 'required',
            'start'     => 'required',
            'end'       => 'required',
            'limit_use' => 'required',
        ], $custom_message);

        $cupon = Cupon::create([
            'id_package' => $request -> id_package,
            'title'      => $request -> title,
            'type'       => $request -> type,
            'discount'   => $request -> discount,
            'directed'   => $request -> directed,
            'start'      => $request -> start,
            'end'        => $request -> end,
            'limit_use'  => $request -> limit_use,
            'status'     => 1,
        ]);
        return redirect()
            -> back()
            -> with('message', 'Se ha creado el cupon correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cupon = Cupon::find($id);
        $packages = Package::get();
        return view('admin.cupon.edit', ['cupon' => $cupon, 'packages' => $packages]);
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
            'title.required'    => 'El campo título es obligatorio',
            'type.required'     => 'El campo tipo es obligatorio',
            'discount.required' => 'El campo cantidad es obligatorio',
            'directed.required' => 'El campo dirigido es obligatorio',
            'start.required'    => 'El campo fecha inicio es obligatorio',
            'end.required'      => 'El campo fecha final es obligatorio',
            'limit_use.required' => 'El campo limite de uso es obligatorio',
        ];
        $this -> validate($request, [
            'title'     => 'required',
            'type'      => 'required',
            'discount'  => 'required',
            'directed'  => 'required',
            'start'     => 'required',
            'end'       => 'required',
            'limit_use' => 'required',
        ], $custom_message);


        $update = Cupon::where('id_cupon', $id) -> update([
            'id_package' => $request -> id_package,
            'title'      => $request -> title,
            'type'       => $request -> type,
            'discount'   => $request -> discount,
            'directed'   => $request -> directed,
            'start'      => $request -> start,
            'end'        => $request -> end,
            'limit_use'  => $request -> limit_use,
            'status'     => 1,
        ]);

        return redirect()
            -> back()
            -> with('message', 'Se ha modificado el cupon correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cupon = Cupon::find($request -> id) -> delete();
        return redirect() -> route('admin.cupon.list') -> with('success', 'Se ha eliminado este registro con éxito');
    }

    public function changeStatus(Request $request){

        $cupon = Cupon::find($request -> id);
        $cupon -> status = $request -> status;
        $cupon -> save();
        return redirect() -> route('admin.cupon.list') -> with('success', 'Se ha modificado el estatus de este registro con éxito');
    }

    public function applyCupon(Request $request){
        $today = date('Y-m-d');
        if( Cupon::where('title', '=', $request -> cupon)->where('status', '!=', 3)->exists() ){
            $cupon = Cupon::where('title', $request -> cupon)->where('status', '!=', 3) -> first();
            //Porcentaje
            if($cupon -> status == 1){
                if($cupon -> uses < $cupon -> limit_use){
                    if(self::validateRangeDate($today, $today, $cupon -> id_cupon)){
                        if(self::validateExistCuponPerCustomer($request -> id_customer, $request -> cupon)){
                            if($cupon -> directed == 'publico'){
                                $cupon_discount = $cupon -> discount;
                                if($cupon -> type == 1){
                                    $discount = $cupon_discount * $request -> total / 100;
                                    return response() -> json(Array('cupon_discount' => $cupon_discount, 'discount' => $discount, 'cupon_type' => 1, 'show_text' => $cupon_discount.' %', 'discount_text' => '-$'.number_format($discount), 'msg' => 'Descuento aplicado'));
                                }else{
                                    $discount = $cupon_discount;
                                    return response() -> json(Array('cupon_discount' => $cupon_discount, 'discount' => $discount, 'cupon_type' => 2, 'show_text' => '$'.$cupon_discount, 'discount_text' => '-$'.number_format($discount), 'msg' => 'Descuento aplicado'));
                                }
                            }else{
                                if($cupon -> id_package == $request -> id_package){
                                    $cupon_discount = $cupon -> discount;
                                    if($cupon -> type == 1){
                                        $discount = $cupon_discount * $request -> total / 100;
                                        return response() -> json(Array('cupon_discount' => $cupon_discount, 'discount' => $discount, 'cupon_type' => 1, 'show_text' => $cupon_discount.' %', 'discount_text' => '-$'.number_format($discount), 'msg' => 'Descuento aplicado'));
                                    }else{
                                        $discount = $cupon_discount;
                                        return response() -> json(Array('cupon_discount' => $cupon_discount, 'discount' => $discount, 'cupon_type' => 2, 'show_text' => '$'.$cupon_discount, 'discount_text' => '-$'.number_format($discount), 'msg' => 'Descuento aplicado'));
                                    }
                                }else{
                                    $package = Package::where('id_package', $cupon -> id_package) -> first();
                                    return response() -> json(Array('cupon_discount' => 0.00, 'discount' => 0.00, 'cupon_type' => 0, 'show_text' => '', 'discount_text' => '$0.00', 'msg' => 'Este cupon solo esta disponible para el paquete: '.$package -> title));
                                }
                            }
                        }else{
                            return response() -> json(Array('cupon_discount' => 0.00, 'discount' => 0.00, 'cupon_type' => 0, 'show_text' => '', 'discount_text' => '$0.00', 'msg' => 'Ya haz usado este cupon'));
                        }

                    }else{
                        return response() -> json(Array('cupon_discount' => 0.00, 'discount' => 0.00, 'cupon_type' => 0, 'show_text' => '', 'discount_text' => '$0.00', 'msg' => 'Este cupon ha expirado'));
                    }

                }else{
                    return response() -> json(Array('cupon_discount' => 0.00, 'discount' => 0.00, 'cupon_type' => 0, 'show_text' => '', 'discount_text' => '$0.00', 'msg' => 'Este cupon ha alcanzado el limite de uso'));
                }

            }else{
                return response() -> json(Array('cupon_discount' => 0.00, 'discount' => 0.00, 'cupon_type' => 0, 'show_text' => '', 'discount_text' => '$0.00', 'msg' => 'Este cupon este desactivado'));
            }
        }else{
            return response() -> json(Array('cupon_discount' => 0.00, 'discount' => 0.00, 'cupon_type' => 0, 'show_text' => '', 'discount_text' => '$0.00', 'msg' => 'No se ha encontrado ese cupon'));
        }

    }

    static public function validateRangeDate($start, $end, $id_cupon){
        $sql = "SELECT id_cupon FROM cupon WHERE id_cupon = {$id_cupon} AND ((('{$start}' <= start) AND ('{$end}' > start)) OR (('{$start}' >= start)AND('{$start}' < end)))";
        $cita = DB::select($sql);
        return count($cita) ? true : false;
    }

    static public function validateExistCuponPerCustomer($id_customer, $cupon){
        if( Purchase::join('purchase_data', 'purchase.id_purchase', '=', 'purchase_data.id_purchase') -> where('purchase.id_customer', $id_customer) -> where('purchase.status', 3) -> where('purchase_data.cupon_name', $cupon) -> exists() ){
            return false; //Si existe retornamos falso
        }else{
            return true; //Si no existe retornamos true
        }
    }

}
