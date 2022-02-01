<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    public $primaryKey = 'id_reservation';
    public $table = 'reservation';
    public $fillable = ['id_reservation', 'id_purchase', 'id_customer', 'id_mat_per_class', 'status'];

}
