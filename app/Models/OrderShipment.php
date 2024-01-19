<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShipment extends Model
{
    use HasFactory;

    protected $table = 'orders_shipments';

    protected $fillable = ['order_id', 'shipment_id', 'route_id'];

    public function getCreatedAtAttribute($attr)
    {
        return Carbon::parse($attr)->format('Y-m-d h:m:s A'); //Change the format to whichever you desire
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
