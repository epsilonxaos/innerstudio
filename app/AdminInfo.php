<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminInfo extends Model
{
    public $primaryKey = 'id_admin_info';
    public $table = 'admin_info';
    public $fillable = ['id_admin_info', 'name', 'rol'];
}
