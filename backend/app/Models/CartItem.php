<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'client_id',
        'product_id',
        'quantity',
    ];
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
