<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $primaryKey = 'id_customer';
    public $table = 'customer';
    protected $fillable = [
        'name',
        'lastname',
        'phone',
        'email',
        'birthdate',
        'address',
        'colony',
        'city',
        'state',
        'country',
        'zip',
        'status'
    ];
}
