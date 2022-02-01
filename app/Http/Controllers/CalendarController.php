<?php

namespace App\Http\Controllers;

use App\Instructor;
use App\Lesson;
use App\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CalendarController extends Controller
{
    function index()
    {
        $instructors = Instructor::where('status', 1)->get();
        return view('admin.calendar.calendar', ['instructors' => $instructors]);
    }

    public function listLessons($start, $end, $gp = true, $id_instructor = null)
    {
        DB::enableQueryLog();
        if ($gp) {
            $lessons = Lesson::from('lesson as A')
                ->join('instructor as B', DB::raw('A.id_instructor'), '=', DB::raw('B.id_instructor'))
                ->select(DB::raw("B.id_lesson AS id, CONCAT(B.nombre, ' ', B.apPaterno, ' ', B.apMaterno ) AS title, CONCAT(B.nombre, ' ', B.apPaterno, ' ', B.apMaterno ) AS name_instructor, B.color AS eventColor, B.color AS eventBackgroundColor,  B.color AS borderColor, A.start, A.type_for"))
                ->where(DB::raw('A.status'), '!=', '2')
                ->where(DB::raw('DATE(A.start)'), '>=', $start)
                ->where(DB::raw('DATE(A.end)'), '<=', $end)
                ->groupBy(DB::raw('A.id_instructor'))
                ->get();
        } else {
            DB::enableQueryLog();
            $lessons = Lesson::from('lesson as A')
                ->join('instructor as B', DB::raw('A.id_instructor'), '=', DB::raw('B.id_instructor'))
                ->leftJoin('_mat_per_class AS C', function($left){
                    $left->on( DB::raw('A.id_lesson'), '=', DB::raw('C.id_class') )
                        -> where('C.status', 1);
                })
                ->leftJoin('reservation AS D', function($left){
                    $left->on( DB::raw('C.id_mat_per_class'), '=', DB::raw('D.id_mat_per_class') )
                        ->where('D.status', '!=', 3);
                })
                ->select(DB::raw("A.id_lesson AS id, A.tipo, A.id_instructor as resourceId, A.start, A.end, A.limit_people, B.name AS title, COUNT(C.id_mat_per_class) AS total_appointment"))
                ->where(DB::raw('A.status'), '=', '1')
                ->where(DB::raw('DATE(A.start)'), '>=', $start)
                ->where(DB::raw('DATE(A.end)'), '<=', $end)
                ->groupBy(DB::raw('A.id_lesson'))
                -> when($id_instructor, function ($q) use ($id_instructor){
                    $in_doctors = '';
                    foreach ($id_instructor as $k => $id){
                        $coma = end($id_instructor) == $id ? '' : ',';
                        $in_doctors .= $id.$coma;
                    }
                    $q -> whereRaw("A.id_instructor IN ({$in_doctors})");
                })
                ->get();
            //dd(DB::getQueryLog());
        }
        foreach ($lessons as $lesson){
            $total = $lesson -> limit_people - $lesson -> total_appointment;
            $lesson -> allDay = false;
            //$cita -> title = html_entity_decode($cita -> title);
            $lesson -> title =  html_entity_decode($lesson -> title);
            $lesson -> disp = $total.'/'.$lesson -> limit_people;
            //$cita -> aDescripcion = $cita -> aDescripcion;
            //$cita -> cita_from = 'Paciente';
        }
        //dd(DB::getQueryLog());
        return $lessons;
    }

    public  function listInstructorPerDay($fecha, $group_by = false){
        $gp = $group_by ? " GROUP BY B.id_instructor" : "";
        $SQL = "SELECT B.id_instructor AS id, B.name as title, A.start 
                FROM lesson A 
                INNER JOIN instructor B ON A.id_instructor = B.id_instructor
                WHERE DATE(A.start) = '{$fecha}'
                '{$gp}'";
        return DB::select($SQL);
    }

    function listInstructorPerDayParse($fecha){
        $citas = $this -> listInstructorPerDay($fecha);
        $result = [
            'citas' => $citas,
        ];
        return $result;
    }

    function listLessonsAndInstructors(Request $request, $start, $end){
        $citas = $this -> listLessons($start, $end, false, $request -> input('id_doctors'));
        $result = [
            'citas' => $citas,
        ];

        return $result;
    }

    public function asistenciaList($id_lesson){
        $lesson = Lesson::where('id_lesson', $id_lesson) -> first();
        $instructor = Instructor::find($lesson -> id_instructor);
        $day = Carbon::parse($lesson -> start) -> format('d/M');
        $start = Carbon::parse($lesson -> start) -> format('h:i A');
        $end = Carbon::parse($lesson -> end) -> format('h:i A');
        return view('admin.calendar.asistencia', ['lesson' => $lesson, 'instructor' => $instructor, 'string_date' => $day.' '.$start.'-'.$end]);
    }

    public function dataAsistencia(DataTables $dataTables, Request $request)
    {
        DB::enableQueryLog();
        $builder = Reservation::join('_mat_per_class', 'reservation.id_mat_per_class', '=', '_mat_per_class.id_mat_per_class')
            -> join('customer', 'reservation.id_customer', '=', 'customer.id_customer')
            -> join('lesson', function($q){
                $q -> on('_mat_per_class.id_class', '=', 'lesson.id_lesson')
                    -> where('lesson.status', 1);
            })
            -> join('mat', '_mat_per_class.id_mat', '=', 'mat.id_mat')
            -> select(
                'reservation.id_reservation',
                'lesson.id_lesson',
                'customer.name',
                'customer.lastname',
                'customer.email',
                'customer.phone',
                'mat.no_mat',
                'reservation.status'
            )
            -> where('lesson.id_lesson', $request -> id_lesson)
            -> whereIn('reservation.status', [1,2])
            -> orderBy('customer.name', 'ASC');
        //dd(DB::getQueryLog());
        // dd($builder);
        // $builder = Customer::query()
        //     -> select('id_customer', 'name', 'lastname', 'email', 'phone', 'status')
        //     -> where('status', '!=', 3)
        //     -> orderBy('id_customer', 'DESC');

        return $dataTables->eloquent($builder)
            ->editColumn('name', function($row){
                return $row -> name.' '.$row -> lastname;
            })
            ->addColumn('firma', function($row){
                return '';
            })
            ->addColumn('actions', function($row){
                //$btn = '<a class="btn" href="cliente/editar/'.$row -> id_customer.'">Modificar</a>';
                $btn = '';
                //if(Auth::guard('admin')->user()->permisos('del_customer')){
                if($row -> status == 1){
                    $btn .= ' <a class="btn grey do-change" data-id="'.$row -> id_reservation.'" data-status="2" href="javascript:;"><i class="fas fa-user-times"></i></a>';
                }else if($row -> status == 2){
                    $btn .= ' <a class="btn green do-change" data-id="'.$row -> id_reservation.'" data-status="1" href="javascript:;"><i class="fas fa-user-check"></i></a>';
                }
                //$btn .= ' <a class="btn red do-delete" data-id="'.$row -> id_customer.'" href="javascript:;"><i class="fas fa-trash"></i></a>';
                //}
                return $btn;
            })
            ->rawColumns(['name', 'firma', 'actions'])
            ->make();
    }

}