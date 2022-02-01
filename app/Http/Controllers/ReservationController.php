<?php

namespace App\Http\Controllers;
use Jenssegers\Date\Date;
use yajra\Datatables\Datatables;
use App\Jobs\SendMailJob;
use Illuminate\Http\Request;
use App\Reservation;
use App\mat_per_class;
use App\Purchase;
use App\Customer;
use App\Lesson;
use App\Instructor;
use Auth;
use App\Mat;
use DB;
use Carbon\Carbon;
use Carbon\Factory;


class ReservationController extends Controller
{
    //status  1 -reservada 2 - asistio  - 0 cancelada
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.reservations.list');
    }

    /**
     * @param DataTables $dataTables
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function data(DataTables $dataTables)
    {
        DB::enableQueryLog();
        $builder = DB::table('reservation AS A')
            ->join('customer AS B', 'A.id_customer', '=', 'B.id_customer')
            ->join('_mat_per_class AS C', 'A.id_mat_per_class', '=', 'C.id_mat_per_class')
            ->join('lesson AS D', 'C.id_class', '=', 'D.id_lesson')
            ->join('instructor AS E', 'E.id_instructor', '=', 'D.id_instructor')
            ->join('mat AS F', 'C.id_mat', '=', 'F.id_mat')
            ->select('A.id_reservation', 'A.status', 'D.tipo', 'D.start', 'D.end', 'E.name AS instructor_name', 'B.name', 'B.lastname', 'F.no_mat')
            ->groupBy('A.id_reservation')
            ->orderBy('A.id_reservation', 'DESC');
        //dd(DB::getQueryLog());
        return $dataTables->of($builder)
            ->addColumn('fullname', function($row){
                return $row -> name.' '.$row -> lastname;
            })
            ->addColumn('clase', function($row){
                $johnDateFactory = new Factory([
                    'locale' => 'es_MX',
                    'timezone' => 'America/merida',
                ]);
                $gameStart = Carbon::parse($row -> start, 'UTC');
                $parseDay = $johnDateFactory->make($gameStart)->isoFormat('D MMMM YYYY');
                $start_hour = date('h:i a', strtotime($row -> start));
                $end_hour = date('h:i a', strtotime($row -> end));
                return '<b>'.$row->tipo.'</b><br><b>'.$parseDay.'</b><br>Horario: '.$start_hour.' - '.$end_hour;
            })
            ->editColumn('status', function($row){
                if($row -> status == 3){
                    return  '<b class="red-text">Cancelada</b>' ;
                }else if($row -> status == 1){
                    return  "<b>Reservada</b>" ;
                }else if($row -> status == 4){
                    return  '<b class="red-text text-darken-4">Cancelacion penalizada</b>' ;
                }
                else{
                    return  "<b>Asistio</b>" ;
                }
            })
            ->addColumn('actions', function($row){
                $btn = "";
                if(Auth::user()->checkPermiso("acc_reservaciones")){
                    if($row -> status == 1){
                        $btn = ' <a class="btn red do-cancel white-text" data-id="'.$row -> id_reservation.'" href="javascript:;"><i class="fas fa-ban"></i></a>';
                    }
                }
                return $btn;
            })
            ->rawColumns(['fullname','clase','status','actions'])
            ->escapeColumns()
            ->make(true);


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Customer::get(['id_customer','name','lastname']);
        //$clases = Lesson::whereDate('start','>=',date('Y-m-d'))->where('status',1)->orderBy('start', 'asc')->get(['id_lesson','tipo','start','end']);
        $clases = Lesson::join('instructor', 'lesson.id_instructor', '=', 'instructor.id_instructor')
            -> select('lesson.id_lesson', 'lesson.tipo', 'lesson.start', 'lesson.end', 'instructor.name')
            -> whereDate( 'start','>=', Date::parse('-3 day') ->format('Y-m-d') )
            ->where('lesson.status',1)
            ->orderBy('start', 'asc')->get();

        $mats = DB::select('
        select A.id_mat,A.no_mat from mat A
        left join (select * from _mat_per_class where id_class = ?  AND status = 1) B on A.id_mat = B.id_mat
        WHERE A.status = 1 AND B.id_mat IS NULL or B.status != 1 group by A.id_mat order by A.id_mat;', [$clases[0]->id_lesson]);

        return view('admin.reservations.create',['clientes'=>$clientes,'clases'=>$clases,'mats'=>$mats]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function store(Request $request)
    {
        // dd($request -> all());

        if(Auth::check() && Auth::User()->type == 0){

            //numero de classes disponibles
            $purchase = Purchase::where("id_customer",Auth::User()->id_customer)
                ->where('date_expirate','>',Date::now())
                ->where('status',3)
                ->sum('no_class');
            $purchase_id = Purchase::where("id_customer",Auth::User()->id_customer)
                ->where('date_expirate','>',Date::now())
                ->where('status',3)
                ->orderBy('created_at', 'asc')
                ->get();
            //numero de classess apartadas
            $class_used = Reservation::join("purchase", "purchase.id_purchase", "=", "reservation.id_purchase")
                ->whereDate('purchase.date_expirate','>', Date::now())
                ->where("reservation.id_customer",Auth::User()->id_customer)
                ->where('reservation.status',1)
                ->count();
            //reservaciones en la clase

            $saltedeaqui = Reservation::join('_mat_per_class','_mat_per_class.id_mat_per_class','=','reservation.id_mat_per_class')
                ->where("_mat_per_class.id_class",$request->clase)
                ->where('reservation.status',1)
                ->where("reservation.id_customer",$request->cliente)
                ->count();
            //tapetes reservados
            $mats = DB::select('select A.id_mat,A.no_mat from mat A
            left join (select * from _mat_per_class where id_class = ? ) B on A.id_mat = B.id_mat
            WHERE A.status = 1 AND B.id_mat IS NULL or B.status != 1 group by A.id_mat order by A.id_mat;', [$clases->last()->id_lesson]);

            if($purchase > $class_used && $saltedeaqui <= 3 && in_array($request->place,$mats)){
                $class = Lesson::where('lesson.id_lesson',$request->class)->get();
                $i = 0;
                while ($i <= $purchase_id->count()) {
                    $used_reservations = Reservation::join("purchase", "purchase.id_purchase", "=", "reservation.id_purchase")
                        ->where('purchase.date_expirate','>', Date::now())
                        ->where("reservation.id_customer",$request->cliente)
                        ->where("reservation.id_purchase", $purchase_id[$i]->id_purchase)
                        ->whereIn('reservation.status',[1,2,4])
                        ->count();
                    dd($purchase_id);
                    if($purchase_id[$i]->no_class == $used_reservations)
                    {
                        $i += 1;
                    }else{
                        $selected_purchase= $purchase_id[$i]->id_purchase;
                        break;
                    }
                }
                if($class[0]-> start > Date::now()){
                    $mpc = mat_per_class::create([
                        'id_mat' => $request->place,
                        'id_class'=>$request->class,
                    ]);
                    Reservation::create([
                        'id_purchase' => $selected_purchase,
                        'id_customer'=>Auth::User()->id_customer,
                        'id_mat_per_class'=>$mpc->id_mat_per_class,
                        'status'=>1
                    ]);

                    return json_encode(['res'=>1,'fecha'=>Date::parse($class[0]-> start)->format('h:i A'),'tapete'=> $request->place]);
                }else{
                    return json_encode(['res'=>3]);
                }

            }else{
                return json_encode(['res'=>2]);
            }
        }

    }*/

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
    public function destroy($iduser, $id)
    {
        $res = Reservation::join('_mat_per_class','_mat_per_class.id_mat_per_class','=','reservation.id_mat_per_class')
            ->join("lesson", "lesson.id_lesson", "=", "_mat_per_class.id_class")
            ->where('id_reservation',$id)->get();
        if($res[0]->start != null){
            $now = Date::now();
            $class = Date::parse($res[0]->start)->subHours(8);
            //si cancela 2 horas antes, no se consume la cosa

            if($now < $class ){
                Reservation::where('id_reservation',$res[0]->id_reservation)->update(['status' => 3]);
                mat_per_class::where('id_mat_per_class',$res[0]->id_mat_per_class)->update(['status' => 0]);
            }else{
                Reservation::where('id_reservation',$res[0]->id_reservation)->update(['status' => 4]);
                mat_per_class::where('id_mat_per_class',$res[0]->id_mat_per_class)->update(['status' => 0]);
            }

            SendMailJob::dispatch("cancelacion_usuario", $iduser, $id) ->delay(now()->addMinutes(1));

            return back();
        }
    }

    public function changeStatus(Request $request)
    {
        //dd($request -> all());
        $res = Reservation::join('_mat_per_class','_mat_per_class.id_mat_per_class','=','reservation.id_mat_per_class')
            ->join("lesson", "lesson.id_lesson", "=", "_mat_per_class.id_class")
            ->where('id_reservation',$request -> id)
            ->get();
        //dd($res[0]);
        if($res[0]->start != null){

            $now = Date::now();
            $class = Date::parse($res[0]->start)->subHours(8);
            //si cancela 2 horas antes, no se consume la cosa

            if($now < $class ){
                Reservation::where('id_reservation',$res[0]->id_reservation)->update(['status' => 3]);
                mat_per_class::where('id_mat_per_class',$res[0]->id_mat_per_class)->update(['status' => 0]);
            }else{
                Reservation::where('id_reservation',$res[0]->id_reservation)->update(['status' => 4]);
                mat_per_class::where('id_mat_per_class',$res[0]->id_mat_per_class)->update(['status' => 0]);
            }
        }
        return redirect() -> route('admin.reservations.list') -> with('success', 'Se ha modificado el estatus de este registro con éxito');
    }

    public function paseLista(Request $request){
        $reservation = Reservation::find($request -> id);
        $reservation -> status = $request -> status;
        $reservation -> save();
        return redirect() -> route('admin.calendar.asistencia.list',['id_lesson' => $request -> id_lesson]) -> with('success', 'Se ha modificado el estatus de este registro con éxito');
    }

    Public function mats($id){
        return $mats = DB::select('select A.id_mat,A.no_mat from mat A
        left join (select * from _mat_per_class where id_class = ? AND status = 1) B on A.id_mat = B.id_mat
        WHERE A.status = 1 AND B.id_mat IS NULL or B.status != 1 group by A.id_mat order by A.id_mat;', [$id]);

    }

    public function storeAdmin(Request $request)
    {

        $custom_message = [
            'cliente.required'    => 'Seleccione un cliente',
            'clase.required'     => 'Seleccione una clase',
            'mat.required' => 'Selecione un tapete',

        ];
        $this -> validate($request, [
            'cliente'     => 'required',
            'clase'      => 'required',
            'mat'  => 'required',

        ], $custom_message);


        //numero de classes disponibles
        $purchase = Purchase::where("id_customer",$request->cliente)
            ->where('date_expirate','>',Date::now())
            ->where('status',3)
            ->sum('no_class');


        //clase utilizada para la reservacion
        $purchase_id = Purchase::where("id_customer",$request->cliente)
            ->where('date_expirate','>',Date::now())
            ->where('status',3)
            ->orderBy('created_at', 'asc')
            ->get();

        //numero de classess apartadas
        // 1 -reservada 2 - asistio  - 3 cancelada sin penalizacion -4 cancelada con penalizacion
        $class_used = Reservation::join("purchase", "purchase.id_purchase", "=", "reservation.id_purchase")
            ->whereDate('purchase.date_expirate','>', Date::now())
            ->where("reservation.id_customer",$request->cliente)
            //->where('reservation.status',1)
            ->whereIn('reservation.status',[1,2,4])
            ->count();

        //reservaciones en la clase
        $saltedeaqui = Reservation::join('_mat_per_class','_mat_per_class.id_mat_per_class','=','reservation.id_mat_per_class')
            ->where("_mat_per_class.id_class",$request->clase)
            ->where('reservation.status',1)
            ->where("reservation.id_customer",$request->cliente)
            ->count();


        //clase de la reservacion
        $class = Lesson::where('lesson.id_lesson',$request->clase)->first();

        //tapetes ocupados
        $mat_used = mat_per_class::where('status',1)->where('id_class',$request->clase)->count();

        //tapetes reservados
        $mats_temp=[];

        $mats = DB::select('select A.no_mat from mat A
           left join (select * from _mat_per_class where id_class = ? AND status = 1) B on A.id_mat = B.id_mat
           WHERE A.status = 1 AND B.id_mat IS NULL or B.status != 1 group by A.id_mat order by A.id_mat;', [$class->id_lesson]);

        foreach($mats as $mat=>$data){ $mats_temp[$mat] = $data->no_mat;}


        //&& in_array($request->place,$mats)
        //dd($class_used);
        if($class->limit_people >= $mat_used ){
        if(in_array($request->mat,array_values($mats_temp))){
            if($saltedeaqui <= 3){
                if($purchase > $class_used){
                    $i = 0;
                    while ($i <= $purchase_id->count()) {
                        $used_reservations = Reservation::join("purchase", "purchase.id_purchase", "=", "reservation.id_purchase")
                            ->where('purchase.date_expirate','>', Date::now())
                            ->where("reservation.id_customer",$request->cliente)
                            ->where("reservation.id_purchase", $purchase_id[$i]->id_purchase)
                            ->whereIn('reservation.status',[1,2,4])
                            ->count();
                        if($purchase_id[$i]->no_class >$used_reservations)
                        {
                            $selected_purchase= $purchase_id[$i]->id_purchase;
                            break;
                        }else{
                            $i += 1;
                        }
                    }
                    //validacion de inicio de clase
                    if($class-> start > Date::now()){
                        $mpc = mat_per_class::create(['id_mat' => $request->mat,'id_class'=>$request->clase]);
                        $wardiado = Reservation::create(['id_purchase' => $selected_purchase,'id_customer'=>$request->cliente,'id_mat_per_class'=>$mpc->id_mat_per_class,'status'=>1]);
                        //app('App\Http\Controllers\MessageController')->mail_reservacion($request->cliente, $wardiado -> id_reservation);
                        SendMailJob::dispatch("reservacion", $request->cliente, $wardiado -> id_reservation) -> delay(now() -> addMinutes(1));
                        return redirect()->back() -> with('message', 'Reservacion exitosa!');
                    }else{
                        $mpc = mat_per_class::create(['id_mat' => $request->mat,'id_class'=>$request->clase]);
                        $wardiado = Reservation::create(['id_purchase' =>  $selected_purchase,'id_customer'=>$request->cliente,'id_mat_per_class'=>$mpc->id_mat_per_class,'status'=>2]);
                        return redirect()->back() -> with('message', 'Reservacion exitosa!');
                    }

                }else{return redirect()->back() -> with('error', 'El cliente no cuenta con clases disponibles');}

            }else{return redirect()->back() -> with('error', 'El cliente ya reservo el limite de tapetes por clase');}

        }else{ return redirect()->back() -> with('error', 'El tapete que eligio ya ah sido reservado'); }

        }else{  return redirect()->back() -> with('error', 'Se ah alcanzado el limite de tapetes para esta clase'); }
    }


}
