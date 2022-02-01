<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseData extends Model
{
    public $primaryKey = 'id_purchase_data';
    public $table = 'purchase_data';
    public $timestamps = false;
    public $fillable = ['id_purchase', 'name', 'lastname', 'phone', 'email', 'address', 'city', 'state', 'country', 'zip', 'cupon_name', 'cupon_type', 'cupon_value'];
}
