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
            $route->route_code = Str::random(40); // Generate a random string of 40 characters
        });
    }

    // public function ordersShimpments()
    // {
    //     return $this->hasMany(OrderShipment::class);
    // }

    public function orders()
    {
        return $this->belongsToMany(Order::class,'orders_shipments','route_id','order_id');
    }
}
