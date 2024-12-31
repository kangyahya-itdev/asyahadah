<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'status'
    ];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function commissions(){
        return $this->hasMany(Commission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getTotalPriceAttribute()
    {
        return $this->orderItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
}
