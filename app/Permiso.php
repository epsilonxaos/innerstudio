<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    public $primaryKey = 'id_permiso';
    public $table = 'permisos';
    public $fillable = ['permiso','placeholder'];
}
