<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Galerias extends Model
{
    protected $table = 'galerias';
    protected $primaryKey = 'id';
    protected $fillable = [
        'cover',
        'title',
        'seccion',
        'status'
    ];
}
