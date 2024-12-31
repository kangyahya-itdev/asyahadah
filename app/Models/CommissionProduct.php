<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'personal_commission',
        'referral_commission',

    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
