<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
    public $primaryKey = 'id_galeria';
    public $table = 'galeria';
    public $fillable = ['name','status'];

}
