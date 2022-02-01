<?php

namespace App\Jobs;

use Auth;
use Exception;
use App\Customer;
use App\Reservation;
use App\Purchase;
use App\Mail\MessageContact;
use App\Mail\MessageWelcome;
use App\Mail\MessageReservation;
use App\Mail\MessageCancelUser;
use App\Mail\MessageCancelLesson;
use App\Mail\MessageCancelPurchase;
use App\Mail\MessagePurchase;
use App\Mail\MessageStaff;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $mailStaff;
    protected $operacion;
    protected $info_1;
    protected $info_2;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($operacion, $info_1, $info_2)
    {
        $this -> mailStaff = "info@innerstudio.com";
        $this -> operacion = $operacion;
        $this -> info_1 = $info_1;
        $this -> info_2 = $info_2;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this -> operacion == "bienvenida"){
            self::mail_bienvenida($this -> info_1);
        }
        else if ($this -> operacion == "reservacion"){
            self::mail_reservacion($this -> info_1, $this -> info_2);
        }
        else if ($this -> operacion == "cancelacion_venta"){
            self::mail_cancelacion_venta();
        }
        else if ($this -> operacion == "cancelacion_usuario"){
            self::mail_cancelacion_usuario($this -> info_1, $this -> info_2);
        }
        else if ($this -> operacion == "cancelacion_clase"){
            self::mail_cancelacion_clase($this -> info_1, $this -> info_2);
        }
        else if ($this -> operacion == "compra"){
            self::mail_compra($this -> info_1, $this -> info_2);
        }
        else if ($this -> operacion == "compra_staff"){
            self::mail_staff();
        }
    }
    // ----------- Correo de bienvenida -----------
    public function mail_bienvenida($correo){
        Mail::to($correo) -> send(new MessageWelcome);
    }
    // ----------- Correo de reservacion -----------
    public function mail_reservacion($id_customer, $id_reservation){
        $customer = self::getCustomer($id_customer);
        $class = self::getClase($id_reservation);

        Mail::to($customer -> email) ->cc("reservas@innerstudio.mx") -> send(new MessageReservation($customer -> name, $class[0]));
    }
    // ----------- Correo de cancelacion de venta -----------
    // No funcional
    public function mail_cancelacion_venta(){
        Mail::to($this -> mailStaff) ->cc("cancelaciones@innerstudio.mx") -> send(new MessageCancelPurchase());
    }
    // ----------- Correo de cancelacion por parte del usuario -----------
    public function mail_cancelacion_usuario($id_customer, $id_reservation){
        $customer = self::getCustomer($id_customer);
        $class = self::getClase($id_reservation);

        Mail::to($customer -> email) ->cc("cancelaciones@innerstudio.mx") -> send(new MessageCancelUser($customer -> name, $class[0]));
    }
    // ----------- Correo de cancelacion de la clase entera -----------
    //Preparado
    public function mail_cancelacion_clase($id_customer, $id_reservation){
        $customer = self::getCustomer($id_customer);
        $class = self::getClase($id_reservation);

        Mail::to($customer -> email) -> send(new MessageCancelLesson($customer -> name, $class[0]));
    }
    // ----------- Correo de confirmacion de compra -----------
    public function mail_compra($id_customer, $id_purchase){
        $customer = self::getCustomer($id_customer);
        $purchase = self::getPurchase($id_purchase);

        Mail::to($customer -> email) -> send(new MessagePurchase($customer -> name, $purchase[0]));
    }
    // ----------- Correo de confirmacion de compra para Staff -----------
    public function mail_staff(){
        Mail::to($this -> mailStaff) -> send(new MessageStaff);
    }
    // ----------- Correo de contacto -----------
    // public function mail_contacto(Request $request){
    //     $custom_message = [
    //         'nombre.required' => 'El campo nombre es obligatorio',
    //         'apellido.required' => 'El campo Apellido es obligatorio',
    //         'email.required' => 'El campo correo es obligatorio',
    //         'telefono.required' => 'El campo telefono es obligatorio',
    //         'mensaje.required' => 'El campo contraseña es obligatorio',
    //     ];

    //     $this -> validate($request, [
    //         'nombre' => 'required',
    //         'apellido' => 'required',
    //         'email' => 'required|email',
    //         'telefono' => 'required',
    //         'mensaje' => 'required'
    //     ], $custom_message);

    //     Mail::to($this -> mailStaff) -> send(new MessageContact($request));
    // }


    // ------------------------------------------------------
    // Funciones Generales
    // ------------------------------------------------------
    static public function getCustomer($id){
        $response = Customer::where('id_customer', $id)
            -> first();

        return $response;
    }
    static public function getClase($id){
        $response = Reservation::select('reservation.id_reservation', 'lesson.tipo', 'lesson.start', 'instructor.name', 'mat.no_mat')
        ->join('_mat_per_class', '_mat_per_class.id_mat_per_class', '=', 'reservation.id_mat_per_class')
        ->join('mat', 'mat.id_mat', '=', '_mat_per_class.id_mat')
        ->join('lesson', 'lesson.id_lesson', '=', '_mat_per_class.id_class')
        ->join('instructor', 'instructor.id_instructor', '=', 'lesson.id_instructor')
        ->where('reservation.id_reservation', $id)
        ->get();

        return $response;
    }
    static public function getPurchase($id){
        $response = Purchase::select('purchase.id_purchase', 'package.title', 'purchase.no_class', 'package.duration')
        ->join('package', 'package.id_package', '=', 'purchase.id_package')
        ->where('purchase.id_purchase', $id)
        ->get();

        return $response;
    }
}
