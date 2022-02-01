<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
    public $primaryKey = 'id_cupon';
    public $table = 'cupon';
    public $fillable = ['id_package', 'title', 'type', 'discount', 'directed', 'start', 'end', 'limit_use', 'uses',  'status'];
}
