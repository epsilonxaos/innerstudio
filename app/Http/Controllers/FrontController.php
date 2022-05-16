<?php

namespace App\Http\Controllers;

use App\Conekta_client;
use App\Mat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Customer;
use App\Lesson;
use App\Purchase;
use App\PurchaseData;
use App\Cupon;
use App\Galerias;
use App\Reservation;
use App\Instructor;
use App\Mailq;
use Illuminate\Support\Facades\Mail;
use App\User;
use Auth;
use Jenssegers\Date\Date;
use App\Package;
use App\mat_per_class;
use App\PagoFacil_Descifrado_Descifrar;
use Illuminate\Support\Facades\DB;
use App\Jobs\SendMailJob;
use App\Http\Controllers\MessageController;
use App\Mail\MessageMailq;
use App\Slide;
use Illuminate\Support\Facades\Session;

class FrontController extends Controller
{
    public function index_view(){
       /* $ints = self::instagram();
        $ints = $ints -> data;*/
        $paquetes = self::getClases();
        $front = Galerias::where('seccion',"principal")->get();
        $foo = Galerias::where('seccion',"indexBottom")->get();

        return view('pages.index', ["front"=>$front,"foo"=>$foo,"paquetes" => $paquetes, "instagram" => []]);
    }

    public function compra_view(Request $request, $id ){
        $paquete = Package::where("id_package", $id)-> first();
        $customer = self::getDataCustomer(Auth() -> User() -> id_customer);

        $dataCard = [];

        if($customer->conekta_id){
            $res4 = Conekta_client::getClient($customer->conekta_id);
            $dataCard['marca_tarjeta'] = $res4->payment_sources[0]->brand;
            $dataCard['tarjeta_numeros'] = $res4->payment_sources[0]->last4;
            $dataCard['id_tarjeta'] = $res4->payment_sources[0]->id;
        }

        env('PRO_APP_PAGOS_KEY_S', 'key_2sTgHXfvMrkpEXRyqzAeAw')
            
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.conekta.io/tokens",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\"checkout\":{\"returns_control_on\":\"Token\"}}",
                CURLOPT_HTTPHEADER => [
                    "Accept: application/vnd.conekta-v2.0.0+json",
                    "Authorization: Basic ".base64_encode(env('PRO_APP_PAGOS_KEY_S', 'key_2sTgHXfvMrkpEXRyqzAeAw')),
                    "Content-Type: application/json"
                ],
            ]);
    
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
        

        if ($err) {
        echo "cURL Error #:" . $err;
        return view('pages.compra', ["status"=>400,"paquete" => $paquete, "customer" => $customer]);
        } else {
            $resp = json_decode($response);
            return view('pages.compra', [
                "status"=>200,
                "paquete" => $paquete,
                "customer" => $customer,
                "token"=>$resp->checkout->id,
                "pkey"=>$resp->checkout->name,
                "dataCard" => $dataCard
            ]);
        }
                

       
    }
    public function compra_view_test(){
        return view('pages.testpagofacil');
    }
    public function paquetes_view(){
        $paquetes = self::getClases();

        return view('pages.paquetes', ["paquetes" => $paquetes]);
    }
    public function perfil_view(){
        $params = self::getDataCustomer(Auth::User() -> id_customer);
        $edad = self::getDuration(date('Y-m-d'), $params -> birthdate);
        $purchase = Purchase::where("id_customer", Auth::User() -> id_customer)
            ->whereDate('date_expirate','>=',Date::now())
            ->where('status',3)
            ->sum('no_class');
        // 1 -reservada 2 - asistio  - 3 cancelada
        $clases_reservadas = Reservation::join("purchase", "purchase.id_purchase", "=", "reservation.id_purchase")
            ->where('purchase.status',3)
            ->whereDate('purchase.date_expirate','>=', Date::now())
            ->where("reservation.id_customer", Auth::User() -> id_customer)
            ->whereIn('reservation.status',[1,2,4])
            ->count();
        // $clases_canceladas = Reservation::where("id_customer", Auth::User() -> id_customer)
        //     ->where('status', 3)
        //     ->count();
        $now = Carbon::now() -> format("Y-m-d H:i:s");
        $proximas_clases = Reservation::join("_mat_per_class","_mat_per_class.id_mat_per_class","=","reservation.id_mat_per_class")
            ->join("lesson", "lesson.id_lesson", "=", "_mat_per_class.id_class")
            ->join("mat", "mat.id_mat", "=", "_mat_per_class.id_mat")
            ->join("instructor", "instructor.id_instructor", "=", "lesson.id_instructor")
            ->where("lesson.start", ">", $now)
            ->where("reservation.id_customer", Auth::user() -> id_customer)
            ->where("reservation.status", 1)
            ->orderBy('reservation.created_at', 'DESC')
            ->get();

        //dd($proximas_clases -> toArray());
        $clases_pasadas = Reservation::select("reservation.*", "mat.no_mat", "instructor.name", "lesson.start")
            ->join("_mat_per_class","_mat_per_class.id_mat_per_class","=","reservation.id_mat_per_class")
            ->join("lesson", "lesson.id_lesson", "=", "_mat_per_class.id_class")
            ->join("mat", "mat.id_mat", "=", "_mat_per_class.id_mat")
            ->whereIn("reservation.status", [1,2,3,4])
            ->join("instructor", "instructor.id_instructor", "=", "lesson.id_instructor")
            ->where("reservation.id_customer", Auth::user() -> id_customer)
            ->orderBy('updated_at', 'DESC')
            ->get();

        $compras = Purchase::where("id_customer", Auth::user() -> id_customer) ->where('status', 3)
            ->get();

        return view('pages.perfil', [
            'params' => $params,
            'edad' => $edad,
            'disponibles' => ($purchase - $clases_reservadas),
            // 'canceladas' => $clases_canceladas,
            // 'compensacion' => 0,
            'proximas_clases' => $proximas_clases,
            'clases_pasadas' => $clases_pasadas,
            'compras' => $compras,
            'hoy' => $now
        ]);
    }
    public function reservacion_view($page = 0){
        if($page == 0){
            DB::enableQueryLog();
            $now = Date::parse('today')->format('Y-m-d');
            $future =  Date::parse("+7 days")->format('Y-m-d');
            $params = Lesson::select('lesson.*', 'instructor.name')
            ->leftjoin("instructor","lesson.id_instructor","=","instructor.id_instructor")
                ->whereRaw("lesson.start >= CAST('".$now."' AS DATE) AND lesson.start <= CAST('".$future."' AS DATE) ")
                ->where('lesson.status',1)
                -> orderBy('lesson.start', 'Asc')
                ->get();
            //dd(DB::getQueryLog());
            $fechas = [Date::parse('today')->format('d'),Date::parse("+6 days")->format('d')];
            $mes = Date::parse("+6 days")->format('F');
            $next = Lesson::whereDate('lesson.start',">",$future)->count() > 0 ? true :false ;
            $prev = false;

            $dates =[
                [Date::now()->format('D'),Date::now()->format('d')],
                [Date::parse('+1 day')->format('D'),Date::parse('+1 day')->format('d')],
                [Date::parse('+2 day')->format('D'),Date::parse('+2 day')->format('d')],
                [Date::parse('+3 day')->format('D'),Date::parse('+3 day')->format('d')],
                [Date::parse('+4 day')->format('D'),Date::parse('+4 day')->format('d')],
                [Date::parse('+5 day')->format('D'),Date::parse('+5 day')->format('d')],
                [Date::parse('+6 day')->format('D'),Date::parse('+6 day')->format('d')],
            ];
        }else{
            $now = Date::parse('+'.(7*$page).' days');
            $future = Date::parse('+'.(7*($page+1)).' days');
            $params = Lesson::select('lesson.*', 'instructor.name')
                -> leftjoin("instructor","lesson.id_instructor","=","instructor.id_instructor")
                ->where('lesson.status',1)
                ->whereRaw("lesson.start >= CAST('".$now->format('Y-m-d')."' AS DATE) AND lesson.start <= CAST('".$future->format('Y-m-d ')."' AS DATE) ")
                -> orderBy('lesson.start', 'Asc')
                ->get();
            $fechas = [$now->format('d'),$future->subDay() -> format('d')];
            $mes =  Date::parse('+'.(7*($page+1)).' days')->format('F');
            $next = Lesson::whereDate('lesson.start',">",$future)->count() > 0 ? true :false ;
            $prev = true;
            for($date = $now; $date->lte($future); $date->addDay()) {
                $dates[] = [$date->format('D'),$date->format('d')];
            }
        }

        $paquetes = self::getClases();   

        return view('pages.reservacion', ['params' => $params,'next'=>$next,'prev'=>$prev,'cal'=> $dates,'page'=>$page,'mes'=>Date::now()->format('F'),"paquetes"=>$paquetes, 'days'=>$fechas,'mes'=>$mes]);
    }
    public function reservacion_deta_view($id){
        if(Auth::check()){

            $saltedeaqui = Reservation::join('_mat_per_class','_mat_per_class.id_mat_per_class','=','reservation.id_mat_per_class')
                ->where("_mat_per_class.id_class",$id)
                ->where('reservation.status',1)// 1 -reservada 2 - asistio  - 3 cancelada
                ->where("reservation.id_customer",Auth::User()->id_customer)
                ->count();
        }else{
            $saltedeaqui = 0;
        }


        $mats=[];
        $mats_disabled = [];
        $params = Lesson::leftjoin("instructor","lesson.id_instructor","=","instructor.id_instructor")
            ->where('lesson.id_lesson',$id)->get();
        $mpc = mat_per_class::where('status',1)->where('id_class',$id)->get('id_mat');
        $mds = Mat::where('status', 0)->get('id_mat');
        foreach($mpc as $mat=>$data){
            $mats[$mat] = $data->id_mat;
        }

        foreach ($mds as $mt => $data){
            $mats_disabled[$mt] = $data  -> id_mat;
        }

        $paquetes = self::getClases();

        $matActives = mat::where('status', '=', 1)->count();

        $customerInLesson = 0;
        if(Auth::check()) {
            $customerInLesson = Reservation::select('reservation.id_mat_per_class')
                -> join('_mat_per_class', 'reservation.id_mat_per_class', '=', '_mat_per_class.id_mat_per_class')
                -> where([
                    ['reservation.id_customer', '=', Auth::user() -> id_customer],
                    ['_mat_per_class.id_class', '=', $id]
                ])
                -> count();
        }

        // dd(
        //     $customerInLesson,
        //     Lesson::isfull($id),
        //     Mailq::isfull($id)
        // );

        return view('pages.reservacion-detalle',['data'=>$params,'mats'=>$mats, 'mats_disabled' => $mats_disabled, 'class'=>$id,"paquetes"=>$paquetes,"click"=>$saltedeaqui, "matActives" => $matActives, 'customerInLesson' => $customerInLesson]);
    }

    public function team_view(){
        $paquetes = self::getClases();
        $team = self::getTeam();

        return view('pages.team', ["paquetes" => $paquetes,"team" => $team]);
    }

    static public function getTeam(){
        $team = Instructor::where('status',1)
            ->where('status_externo', 0)
            ->get();

        return $team;
    }

    public function complete_view($free = null, $success = ''){
        if(isset($free) && isset($success)){
            if($free === 1) {
                return view('pages.complete', ['free' => 1]);
            }else {
                return view('pages.complete', [
                    'success' => $success,
                    'error' => (Session::has('error')) ? Session::get('error') : ''
                ]);
            }
        }else{
            return view('pages.complete', [
                'error' => (Session::has('error')) ? Session::get('error') : ''
            ]);
        }
    }

    static public function getDuration($start, $end){
        // dd($end);
        $start = new Carbon($start);
        $end = new Carbon($end);
        // dd($start);
        return $start -> diffInYears($end);
    }

    static public function getClases(){
        $response = Package::select('id_package','title', 'no_class', 'price', 'duration', 'status')
            -> where('status', '=', 1)
            -> orderBy('no_class', 'Asc')
            -> get();

        return $response;
    }


    static public function getDataCustomer($id){
        $response = Customer::where('id_customer', $id)
            -> first();

        return $response;
    }

    public function pagoVerification(Request $request){
        $encriptado = new PagoFacil_Descifrado_Descifrar();
        $apiKey = env('APP_MODE') == 'pro' ? env('PP_KEY_DEC') : env('PP_SAND_KEY_DEC');
        $responseEncode = $encriptado->desencriptar_php72($request -> response, $apiKey);
        $response = json_decode($responseEncode);
        //dd($response);
        if($response -> autorizado){
            if(isset($response -> param1)) {
                $purchase = Purchase::find($response->param1);
                $purchase->status = 3;
                $purchase->method_pay = 'pagofacil';
                $purchase->reference_code = $response->idTransaccion;
                $purchase->date_payment = date('Y-m-d H:i:s');
                $purchase->save();
                //Detecta si existe un cupon en la orden y le aumenta el uso
                if($purchase -> discount > 0){
                    $purchaseData = PurchaseData::where('id_purchase', $purchase -> id_purchase) -> first();
                    if($purchaseData -> cupon_name != ''){
                        if(Cupon::where('title',$purchaseData -> cupon_name) -> where('status', 1) -> exists() ){
                            $cupon = Cupon::where('title', $purchaseData -> cupon_name) -> where('status', 1) -> first();
                            $cupon -> uses = $cupon -> uses + 1;
                            $cupon -> save();
                        }
                    }
                }
                SendMailJob::dispatch("compra", $purchase -> id_customer, $purchase -> id_purchase) ->delay(now()->addMinutes(1));
                SendMailJob::dispatch("compra_staff", "", "") ->delay(now()->addMinutes(1));
            }
        }else{
            if(isset($response -> param1) && isset($response->idTransaccion)) {
                $purchase = Purchase::find($response->param1);
                $purchase->status = 4;
                $purchase->reference_code = $response->idTransaccion;
                $purchase->method_pay = 'pagofacil';
                $purchase->error_pay = $response -> error;
                $purchase->save();
            }
        }
        //dd($response);
        return view('pages.complete', ['response' => $response]);
    }

    public function terminos_view(){
        $paquetes = self::getClases();
        return view('pages.terminos',["paquetes" => $paquetes]);
    }
    public function clases_view(){
        return view('pages.clases');
    }

    public function teamdetalle_view(Request $request,$id){

        $teamdetalle = self::getTeamdetalle($id);

        return view('pages.teamdetalle',['teamdetalle'=>$teamdetalle]);


    }

    public static function getTeamdetalle($id){

        $teamdetalle = Instructor::where('id_instructor',$id)
            ->get();
        return $teamdetalle;

    }

    public static function redirectLogin(){

        return redirect()->route('login.admin');


    }


    public function blog_view(){
        return view('pages.blog');
    }
    public function blogdetalle_view(){
        return view('pages.blogdetalle');
    }

    public function ubicacion_view(){
        return view('pages.ubicacion');
    }

    public function envioContacto(){
        $secret = '6LfqwcMUAAAAAHGnFP6-B2d2nZVwxm8Aldoyrhcv';
    }

    public function ReservationDestroy(Request $request)
    {

        $id = $request -> id_reservacion;
        $res = Reservation::where('id_customer', Auth::user() -> id_customer)
            ->join('_mat_per_class','_mat_per_class.id_mat_per_class','=','reservation.id_mat_per_class')
            ->join("lesson", "lesson.id_lesson", "=", "_mat_per_class.id_class")
            -> where('id_reservation', $id)
            -> get();

        if($res[0] -> start != null){
            $now = Date::now();
            $class = Date::parse($res[0]->start)->subHours(8);

            // si cancela 2 horas antes, no se consume la cosa
            if($now < $class ){
                $res[0] -> update(['status' => 3]);
                $mat = mat_per_class::where('id_mat_per_class', $res[0] -> id_mat_per_class) ->get();
                $mat[0] -> update(['status' => 0]);
            }else{
                $res[0] -> update(['status' => 4]);
                $mat = mat_per_class::where('id_mat_per_class', $res[0] -> id_mat_per_class) ->get();
                $mat[0]->update(['status' => 0]);
            }

            // $correo = new MessageController;
            // $resp = $correo -> mail_cancelacion_usuario();
            // enviar correos a lista en cola
            $data = Reservation::where('id_reservation', $id)
            ->join('_mat_per_class','_mat_per_class.id_mat_per_class','=','reservation.id_mat_per_class')
            ->join("lesson", "lesson.id_lesson", "=", "_mat_per_class.id_class")
            -> first();
            
            $clientes = Mailq::getClientOnq($data -> id_lesson);
            // dd($clientes -> toArray());
            if(count($clientes) > 0) {
                $mails = array();

                foreach ($clientes as $key => $value) {
                    array_push($mails, $value -> email);
                }

                try {
                    Mail::send('emails.message_mailq', ['lessonUrl' => env('APP_URL')."/reservar/clase/detalle/".$data->id_lesson], function ($message) use ($mails) {
                        $message->to($mails)->subject('InnerStudio - Espacio disponible en clase!'); 
                    });
                } catch (\Throwable $th) {}
    
            }
            // SendMailJob::dispatch("cancelacion_usuario", Auth::user() -> id_customer, $id) ->delay(now()->addMinutes(1));
            return back();
        }
    }

    public function createReservation(Request $request)
    {

        //numero de classes disponibles.
        $purchase = Purchase::where("id_customer",  $request -> id)
            ->where('date_expirate','>',Date::now())
            ->where('status',3)
            ->sum('no_class');



        //clase utilizada para la reservacion.
        $purchase_id = Purchase::where("id_customer", $request -> id)
            ->where('date_expirate','>',Date::now())
            ->where('status',3)
            ->orderBy('created_at', 'asc')
            ->get();



        //numero de classess apartadas
        // 1 -reservada 2 - asistio  - 3 cancelada sin penalizacion -4 cancelada con penalizacion
            $class_used = Reservation::join("purchase", "purchase.id_purchase", "=", "reservation.id_purchase")//cambio jorge 30 dic
            ->whereDate('purchase.date_expirate','>', Date::now())
            ->where("reservation.id_customer", $request -> id)
            //->where('reservation.status',1)
            ->whereIn('reservation.status',[1,2,4])
            ->count();


        //reservaciones en la clase
        $saltedeaqui = Reservation::join('_mat_per_class','_mat_per_class.id_mat_per_class','=','reservation.id_mat_per_class')
            ->where("_mat_per_class.id_class",$request->class)
            ->where('reservation.status',1)
            ->where("reservation.id_customer",$request -> id)
            ->count();

        //tapetes ocupados
        $mat_used = mat_per_class::where('status',1)->where('id_class',$request->class)->count();

        //tapetes reservados
        $mats_temp=[];

        $mats = DB::select('select A.no_mat from mat A
        left join (select * from _mat_per_class where id_class = ? AND status = 1 ) B on A.id_mat = B.id_mat
        WHERE A.status = 1 AND B.id_mat IS NULL or B.status != 1 group by A.id_mat order by A.id_mat;', [$request->class]);

        foreach($mats as $mat=>$data){ $mats_temp[$mat] = $data->no_mat;}

        $class = Lesson::where('lesson.id_lesson',$request->class)->get();
        #dd([$request->place,array_values($mats_temp)]);
        if( ($class[0]->limit_people >= $mat_used ) && ($purchase > $class_used) && ($saltedeaqui <= 3) && (in_array($request->place, array_values($mats_temp))) ){
            $i = 0;
            while ($i <= $purchase_id->count()) {
                $used_reservations = Reservation::join("purchase", "purchase.id_purchase", "=", "reservation.id_purchase")
                    ->where('purchase.date_expirate','>', Date::now())
                    ->where("reservation.id_customer", $request -> id)
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

            if($class[0]-> start > Date::now()){
                $mpc = mat_per_class::create([
                    'id_mat' => $request->place,
                    'id_class'=>$request->class,
                ]);
                $reser = Reservation::create([
                    'id_purchase' => $selected_purchase,
                    'id_customer'=>$request -> id,
                    'id_mat_per_class'=>$mpc->id_mat_per_class,
                    'status'=>1
                ]);
                //app('App\Http\Controllers\MessageController')->mail_reservacion($request -> id, $reser -> id_reservation);
                //SendMailJob::dispatch("reservacion", $request -> id, $reser -> id_reservation) -> delay(now() -> addMinutes(1));
                return json_encode(['res'=>1,'fecha'=>Date::parse($class[0]-> start)->format('h:i A'),'tapete'=> $request->place]);
            }else{
                return json_encode(['res'=>3]);
            }

        }else{
            return json_encode(['res'=>2,"clases_usadas"=>$class_used,"clases_disponibles"=>$purchase,"tapetes_apartados en la clase"=>$saltedeaqui]);
        }
    }

    public function checkUser($id){

        $res = User::where('email', '=',$id)->exists();
        return json_encode(['res'=>$res]);
    }

    static public function instagram () {
        $access_token = "6736906812.0f90286.af40b78f15584cd8921a4dd2ba646a4e";
        $photos = 8;
        $user_id = "6736906812";

        $json_link="https://api.instagram.com/v1/users/{$user_id}/media/recent/?";
        $json_link .="access_token={$access_token}&count={$photos}";
        $json = file_get_contents($json_link);

        $expire_time= 5*60;
        $cache_file = resource_path('js/api-instagram.json');
        $api_cache ="";

        if ((file_exists($cache_file) ) && (filesize( $cache_file ) == 0 )){
            $api_cache = $json;
            file_put_contents( $cache_file, $api_cache );
            $api_cache= json_decode(file_get_contents($cache_file), false);
            // dd($api_cache);
        }
        else {
            $api_cache= json_decode(file_get_contents($cache_file), false);
            if (time() - filemtime($cache_file) > $expire_time) {
                file_put_contents($cache_file, $json);
            }
        }

        return $api_cache;
    }

    static public function joinq(Request $request,$id){
        $matActives = mat::where('status', '=', 1)->get();
        $matActives = $matActives->count();

        if((Lesson::isfull($id) >= $matActives) && (Mailq::isfull($id)) ){
            if(Mailq::validCustomerList(Auth::user() -> id_customer, $id)) {
                Mailq::create([
                    'id_class'      => $id,
                    'id_user'       =>  Auth::user() -> id_customer,
                    'status'     => 1,
                ]);

                return redirect()->back()-> with('success', 'Registro realizado!');
            }

            return redirect()->back()-> with('success', 'Ya se encuentra en lista de espera!');

        }
        return redirect()->back()-> with('error', 'La clase no esta llena');
    }

    public function testCorreo (){
        SendMailJob::dispatch("compra", 5, 675);
        return 'Correo enviado';
    }
    public function testCorreo2 (){
        $correo = new MessageController;
        $resp = $correo -> mail_cancelacion_usuario2();
        return $resp.' -- Correo enviado';
    }

 
}
