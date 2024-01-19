<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrdersProducts::class, 'order_id');
    }
    public function shipments()
    {
        return $this->belongsToMany(Shipment::class, 'orders_shipments', 'order_id', 'shipment_id');
    }
    public function routes()
    {
        return $this->belongsToMany(Route::class, 'orders_shipments', 'order_id', 'route_id');
    }
}
