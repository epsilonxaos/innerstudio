<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mat extends Model
{
    public $primaryKey = 'id_mat';
    public $table = 'mat';
    public $fillable = ['no_mat', 'status'];
}
