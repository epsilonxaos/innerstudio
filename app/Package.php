<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public $primaryKey = 'id_package';
    public $table = 'package';
    public $fillable = ['no_class', 'price', 'duration', 'title', 'single_use', 'status'];
}
