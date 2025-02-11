<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'proof_image',
        'status',
    ];
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
