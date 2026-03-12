<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'total_price',
        'status',
        'payment_method',
        'shipping_address',
    ];
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
