<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    public $primaryKey = 'id_instructor';
    public $table = 'instructor';
    public $fillable = ['name', 'description', 'avatar', 'embed', 'email', 'phone', 'status','color','status_externo'];
}
