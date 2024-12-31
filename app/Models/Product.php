<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];
    public function getFormattedPriceAttribute()
    {
        return 'Rp '. number_format($this->price, 0, ',', '.');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function commissionProducts()
    {
        return $this->hasOne(CommissionProduct::class);
    }
    
}
