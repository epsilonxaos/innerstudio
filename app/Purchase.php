<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public $primaryKey = 'id_purchase';
    public $table = 'purchase';
    public $fillable = ['id_customer', 'id_package', 'price', 'no_class', 'use_class', 'duration', 'status', 'view', 'reference_code', 'date_expirate', 'date_payment', 'method_pay', 'discount', 'error_pay'];
}
