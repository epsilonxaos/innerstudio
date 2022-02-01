<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use App\Customer;
use App\Reservation;
use App\Purchase;
use App\Correos;
use App\Mail\MessageContact;
use App\Mail\MessageWelcome;
use App\Mail\MessageReservation;
use App\Mail\MessageCancelUser;
use App\Mail\MessageCancelLesson;
use App\Mail\MessageCancelPurchase;
use App\Mail\MessagePurchase;
use App\Mail\MessageStaff;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public $mailStaff;
    public $espera;

    public function __construct () {
       $this -> mailStaff = "wilberthg16@gmail.com";
       $this -> espera = now() -> addMinutes(1);
    }
    // ----------- Correo de bienvenida -----------
    public function mail_bienvenida($correo){
        try {
            Mail::to($correo)->later($this -> espera, new MessageWelcome);
        } catch (\Throwable $th) {

        }
    }
    // ----------- Correo de reservacion -----------
    public function mail_reservacion($id, $id_reservation){
        $customer = self::getCustomer($id);
        $class = self::getClase($id_reservation);

        // ->later($this -> espera, );
        try {
            Mail::to($customer -> email)
            ->queue(new MessageReservation($customer -> name, $class[0]));
        } catch (\Throwable $th) {

        }
    }
    // ----------- Correo de cancelacion de venta -----------
    public function mail_cancelacion_venta($id, $id_reservation){
        $customer = self::getCustomer($id);
        $class = self::getClase($id_reservation);

        try {
            Mail::to($customer -> email)->later($this -> espera, new MessageCancelPurchase($customer -> name, $class[0]));
        } catch (\Throwable $th) {

        }
    }
    // ----------- Correo de cancelacion por parte del usuario -----------
    public function mail_cancelacion_usuario($id, $id_reservation){
        $customer = self::getCustomer($id);
        $class = self::getClase($id_reservation);

        Mail::to($customer -> email)->send(new MessageCancelUser($customer -> name, $class[0]));
    }
    public function mail_cancelacion_usuario2(){
        $cor = new Correos();
        return $cor -> enviar();
        // $customer = self::getCustomer($id);
        // $class = self::getClase($id_reservation);

        // Mail::to($customer -> email)->send(new MessageCancelUser($customer -> name, $class[0]));
    }
    // ----------- Correo de cancelacion de la clase entera -----------
    public function mail_cancelacion_clase($id, $id_reservation){
        $customer = self::getCustomer($id);
        $class = self::getClase($id_reservation);

        try {
            Mail::to($customer -> email)->later($this -> espera, new MessageCancelLesson($customer -> name, $class[0]));
        } catch (\Throwable $th) {

        }
    }
    // ----------- Correo de confirmacion de compra -----------
    public function mail_compra($id, $id_purchase){
        $customer = self::getCustomer($id);
        $purchase = self::getPurchase($id_purchase);

        try {
            Mail::to($customer -> email)->later($this -> espera, new MessagePurchase($customer -> name, $purchase[0]));
        } catch (\Throwable $th) {

        }
    }
    // ----------- Correo de confirmacion de compra para Staff -----------
    public function mail_staff(){
        try {
            Mail::to($this -> mailStaff)->later($this -> espera, new MessageStaff);
        } catch (\Throwable $th) {

        }
    }
    // ----------- Correo de contacto -----------
    public function mail_contacto(Request $request){
        $custom_message = [
            'nombre.required' => 'El campo nombre es obligatorio',
            'apellido.required' => 'El campo Apellido es obligatorio',
            'email.required' => 'El campo correo es obligatorio',
            'telefono.required' => 'El campo telefono es obligatorio',
            'mensaje.required' => 'El campo contraseña es obligatorio',
        ];

        $this -> validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
            'mensaje' => 'required'
        ], $custom_message);

        try {
            Mail::to($this -> mailStaff) -> send(new MessageContact($request));
        } catch (\Throwable $th) {

        }

        return back()
            -> with('message', 'Correo enviado');
    }

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
        $response = Purchase::select('purchase.id_purchase', 'package.title', 'package.no_class', 'package.duration')
        ->join('package', 'package.id_package', '=', 'purchase.id_package')
        ->where('purchase.id_purchase', $id)
        ->get();

        return $response;
    }
}
