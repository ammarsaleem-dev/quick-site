<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Shipment extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle', 'driver_name', 'driver_number'];

    public function orders()
    {
        return $this->belongsToMany(Order::class,'orders_shipments','shipment_id','order_id');
    }
}
