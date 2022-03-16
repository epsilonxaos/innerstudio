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
        return self::join('customer','mailq.id_user','=','customer.id_customer')->get();
    }

}
