<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mailq extends Model
{
    public $primaryKey = 'id';
    public $table = 'mailq';
    public $fillable = ['id_class', 'id_user', 'status'];

    public static function isfull($id){
        $onQ =  self::where('id_class',$id)->count();
        return $onQ < 5 ? true : false;
        
    }
    
    public static function getClientOnq($id){
        return self::select('customer.email') -> join('customer','mailq.id_user','=','customer.id_customer')
            -> where('mailq.id_class', $id)    
            -> get();
    }

    public static function validCustomerList($customer_id, $lesson_id)
    {
        $exist = self::where([
            ['id_class', '=', $lesson_id],
            ['id_user', '=', $customer_id]
        ]) -> count();

        return ($exist > 0) ? false : true;
    }

}
