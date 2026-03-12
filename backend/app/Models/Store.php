<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Store extends Model
{
    protected $fillable = [
        'vendor_id',
        'name',
        'slug',
        'description',
        'logo',
        'banner',
        'is_active',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
