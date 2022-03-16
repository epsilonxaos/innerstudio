<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    public $primaryKey = 'id_slide';
    public $table = 'slide';
    public $fillable = ['id_slide','slide', 'id_gal', 'alt','order','status'];

}
