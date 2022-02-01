<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mat_per_class extends Model
{
    public $primaryKey = 'id_mat_per_class';
    public $table = '_mat_per_class';
    public $fillable = ['id_mat', 'id_class','status'];
}
