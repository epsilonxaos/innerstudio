<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    public $primaryKey = 'id_rol';
    public $table = 'rol';
    public $fillable = ['rol'];
}
