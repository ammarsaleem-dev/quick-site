<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Route extends Model
{
    use HasFactory;

    protected $fillable = ['route_code'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($route) {
            $route->route_code = 'RT-' . Str::random(8); // Generate a random string prefixed with RT-
        });
    }

    public function orderShipment()
    {
        return $this->hasMany(OrderShipment::class,'route_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class,'orders_shipments','route_id','order_id');
    }
}
