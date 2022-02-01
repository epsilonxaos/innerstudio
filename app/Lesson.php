<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public $primaryKey = 'id_lesson';
    public $table = 'lesson';
    public $fillable = ['id_instructor', 'tipo', 'start', 'end', 'limit_people', 'status'];

    public static function isfull($id){
        return self::join('_mat_per_class','lesson.id_lesson','=','_mat_per_class.id_class')
        ->where('lesson.id_lesson',$id)
        ->where('_mat_per_class.status',1)
        ->count();
    }

     public static function inTime($id){
        $clase = self::where('id_lesson',$id)->first();
        $to = \Carbon\Carbon::parse(' - 15 minutes');
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $clase->start);
        return $from > $to ? true : false;
    }

}
