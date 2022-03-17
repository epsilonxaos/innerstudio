<?php

namespace App\Http\Controllers;

use App\Instructor;
use App\Lesson;
use Carbon\Carbon;
use Carbon\Factory;
use DateTime;
use DateInterval;
use DatePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Auth;
use App\Reservation;
use App\mat_per_class;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.lesson.list');
    }


    /**
     * @param DataTables $dataTables
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function data(DataTables $dataTables)
    {
        $builder = Lesson::from('lesson as A')
            ->join('instructor as B', DB::raw('A.id_instructor'), '=', DB::raw('B.id_instructor'))
            ->leftJoin('_mat_per_class AS C', function($left){
                $left->on( DB::raw('A.id_lesson'), '=', DB::raw('C.id_class') )
                    -> where('C.status', 1);
            })
            ->leftJoin('reservation AS D', function($left){
                $left->on( DB::raw('C.id_mat_per_class'), '=', DB::raw('D.id_mat_per_class') )
                    ->where('D.status', '!=', 3);
            })
            ->select(DB::raw("A.id_lesson, A.tipo, A.start, A.end, A.limit_people, B.name, COUNT(C.id_mat_per_class) AS total_appointment, A.status"))
            -> where('A.status', '!=', 3)
            -> orderBy('A.id_lesson', 'DESC')
            ->groupBy(DB::raw('A.id_lesson'));

        return $dataTables->eloquent($builder)
            ->editColumn('id_lesson', function ($row) {
                $input = '<label>
                            <input type="checkbox" name="foo" value="'.$row -> id_lesson.'" />
                            <span></span>
                        </label>';
                return $input;
            })
            ->addColumn('schedule', function($row){
                $johnDateFactory = new Factory([
                    'locale' => 'es_MX',
                    'timezone' => 'America/merida',
                ]);
                $gameStart = Carbon::parse($row -> start, 'UTC');
                $parseDay = $johnDateFactory->make($gameStart)->isoFormat('D MMMM YYYY');
                $start_hour = date('h:i a', strtotime($row -> start));
                $end_hour = date('h:i a', strtotime($row -> end));
                return '<b>'.$parseDay.'</b><br><b>Horario:</b> '.$start_hour.' - '.$end_hour;
            })
            ->addColumn('disponibilidad', function($row){
                $total = $row -> limit_people - $row -> total_appointment;
                return $row -> limit_people.'/'.$total;
            })
            ->addColumn('actions', function($row){
                $btn = '<a class="btn white-text btn-cafe" href="clase/editar/'.$row -> id_lesson.'"><i class="far fa-edit"></i></a>
                        <a class="btn white-text btn-cafe" href="'.route('admin.calendar.asistencia.list',[$row -> id_lesson]).'"><i class="fas fa-tasks"></i></a>';
                if(Auth::user()->checkPermiso("acc_clases")){
                    if($row -> status){
                        $btn .= ' <a class="btn btn-cafe do-change white-text" data-id="'.$row -> id_lesson.'" data-status="0" href="javascript:;"><i class="fas fa-eye"></i></a>';
                    }else{
                        $btn .= ' <a class="btn grey lighten-1 do-change white-text" data-id="'.$row -> id_lesson.'" data-status="1" href="javascript:;"><i class="fas fa-eye-slash"></i></a>';
                    }

                    if($row -> start >=Carbon::now()->format('Y-m-d')){
                        $btn .= ' <a class="btn red do-delete white-text" data-id="'.$row -> id_lesson.'" href="javascript:;"><i class="fas fa-trash"></i></a>';
                    }

                }
                return $btn;
            })
            ->rawColumns(['id_lesson', 'schedule', 'disponibilidad', 'actions'])
            ->make();
    }

    public function create(Request $request)
    {
        $instructores = Instructor::get();
        /*$period_hours = self::generate_hour('06:00', '23:00');
        $minutes = self::generateDuration('5', 36);*/
        return view('admin.lesson.create', ['instructores' => $instructores, 'p_fecha' => $request -> p_fecha, 'p_hora' => $request -> p_hora]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $custom_message = [
            'id_instructor.required'    => 'El campo instructor es obligatorio',
            'tipo.required' => 'El campo tipo es obligatorio',
            'fecha.required'    => 'El campo fecha es obligatorio',
            'start_hour_select.required'    => 'El campo hora inicio es obligatorio',
            'end_hour_select.required' => 'El campo hora final es obligatorio',
            'limit.required' => 'El campo limite es obligatorio',
        ];
        $this -> validate($request, [
            'id_instructor'    => 'required',
            'tipo' => 'required',
            'fecha'    => 'required',
            'start_hour_select' => 'required',
            'end_hour_select' => 'required',
            'limit' => 'required',
        ], $custom_message);

        $start = $request -> fecha.' '.$request -> start_hour_select;
        //$end = date('Y-m-d H:i:s', strtotime($start.' +'.$request -> duration.' minutes'));
        $end = $request -> fecha.' '.$request -> end_hour_select;
        if ($this->validateRangeDate($start, $end,null, $request -> id_instructor)) {
            $lesson = Lesson::create([
                'id_instructor'      => $request -> id_instructor,
                'tipo'       => $request -> tipo,
                'descripcion'       => $request -> descripcion,
                'color'       => $request -> color,
                'start'      => $start,
                'end'   => $end,
                'limit_people' => $request -> limit,
                'status'     => 1,
            ]);
            return redirect()
                -> route('admin.lesson.list')
                -> with('message', 'Se ha creado la clase correctamente');
        }else{
            return redirect()
                ->back()
                ->with('error', 'Ya existe una clase previa en esta fecha, verifica el calendario y selecciona un horario libre.')
                ->withInput($request->input());
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
        $instructores = Instructor::get();
        $period_hours = self::generate_hour('06:00', '23:00');
        $minutes = self::generateDuration('5', 36);

        $lesson = Lesson::find($id);
        foreach ($lesson as $les){
            $lesson -> start_show = date('Y-m-d', strtotime($lesson -> start));
            $lesson -> fecha = date('Y-m-d', strtotime($lesson -> start));
            $lesson -> start_hour = date('H:i', strtotime($lesson -> start));
            $lesson -> end_hour = date('H:i', strtotime($lesson -> end));
            //$lesson -> duration   = self::getDuration($lesson->start, $lesson->end);
        }

        return view('admin.lesson.edit', ['lesson' => $lesson, 'instructores' => $instructores, 'hours' => $period_hours, 'minutes' => $minutes]);
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
            'id_instructor.required'    => 'El campo instructor es obligatorio',
            'tipo.required' => 'El campo tipo es obligatorio',
            'fecha.required'    => 'El campo fecha es obligatorio',
            'start_hour_select.required'    => 'El campo hora inicio es obligatorio',
            'end_hour_select.required' => 'El campo hora final es obligatorio',
            'limit.required' => 'El campo limite es obligatorio',
        ];
        $this -> validate($request, [
            'id_instructor'    => 'required',
            'tipo' => 'required',
            'fecha'    => 'required',
            'start_hour_select' => 'required',
            'end_hour_select' => 'required',
            'limit' => 'required',
        ], $custom_message);


        $start = $request -> fecha.' '.$request -> start_hour_select;
        $end = $request -> fecha.' '.$request -> end_hour_select;
        //$end = date('Y-m-d H:i:s', strtotime($start.' +'.$request -> duration.' minutes'));
        if ($this->validateRangeDate($start, $end, $id,$request -> id_instructor)) {
            $lesson = Lesson::where('id_lesson', $id) -> update([
                'id_instructor' => $request -> id_instructor,
                'tipo'          => $request -> tipo,
                'descripcion'   => $request -> descripcion,
                'color'         => $request -> color,
                'start'         => $start,
                'end'           => $end,
                'limit_people'  => $request -> limit,
                'status'        => 1,
            ]);
            return redirect()
                -> route('admin.lesson.list')
                -> with('message', 'Se ha modificado la clase correctamente');
        }else{
            return redirect()
                ->back()
                ->with('error', 'Ya existe una clase previa en esta fecha, verifica el calendario y selecciona un horario libre.')
                ->withInput($request->input());
        }
    }

       /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkLesson($id)
    {
        $class_used = Reservation::join("_mat_per_class", "_mat_per_class.id_mat_per_class", "=", "reservation.id_mat_per_class")
        ->where("_mat_per_class.id_class",$id)
        ->where('reservation.status',1)
        ->count();
        return json_encode(['res'=>$class_used]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $class_used = Reservation::join("_mat_per_class", "_mat_per_class.id_mat_per_class", "=", "reservation.id_mat_per_class")
        ->where("_mat_per_class.id_class",$request -> id)
        ->where('reservation.status',1)
        ->get();

        foreach($class_used as $res){
            Reservation::where('id_reservation',$res->id_reservation)->update(['status' => 3]);
            mat_per_class::where('id_mat_per_class',$res->id_mat_per_class)->update(['status' => 0]);
        }

        $l = Lesson::where('id_lesson',$request -> id)->update(['status' => 3]);
      
        return redirect() -> route('admin.lesson.list') -> with('success', 'Se ha eliminado este registro con éxito');
    }

    public function changeStatus(Request $request){

        $lesson = Lesson::find($request -> id);
        $lesson -> status = $request -> status;
        $lesson -> save();
        return redirect() -> route('admin.lesson.list') -> with('success', 'Se ha modificado el estatus de este registro con éxito');
    }


    static public function generate_hour($_start = '', $_end = ''){
        $begin = new DateTime($_start);
        $end   = new DateTime($_end);
        $interval = DateInterval::createFromDateString('30 min');
        $times    = new DatePeriod($begin, $interval, $end);
        $hours = array();
        foreach ($times as $time) {
            array_push($hours,$time->format('H:i'));
        }
        return $hours;
    }

    static public function generateDuration($interval, $end){
        $minutes = Array();
        for ($n = 1; $n <= $end; $n++) {
            $minute['value'] = $n*$interval;
            $minute['show'] = ($n*$interval).' Minutos';
            array_push($minutes, $minute);
        }
        return $minutes;
    }

    public function validateRangeDate($start, $end, $idCita = null,$id_instructor){
        $upd_cita = isset($idCita) ? " AND id_lesson != {$idCita} " : "";
        $sql = "SELECT id_lesson FROM lesson l WHERE 1 = 1 AND status = 1 {$upd_cita} AND id_instructor = {$id_instructor} AND (('{$start}' <= l.start AND '{$end}' > l.start) OR  ('{$start}' >= l.start AND '{$end}' <= l.end) OR  ('{$start}' <= l.end   AND '{$end}' >= l.end))";
        $cita = DB::select($sql);
        return count($cita) ? false : true;
    }

    static public function getDuration($start, $end){
        $start = new Carbon($start);
        $end = new Carbon($end);
        return $start -> diffInMinutes($end);
    }

}
