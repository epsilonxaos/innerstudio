<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol_permisos extends Model
{
    public $primaryKey = 'id';
    public $table = 'rol_permisos';
    public $fillable = ['id_rol','id_permiso'];
}
