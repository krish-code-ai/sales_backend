<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer',
        'item_category',
        'source',
        'geo_location',
        'order_date',
    ];


}
