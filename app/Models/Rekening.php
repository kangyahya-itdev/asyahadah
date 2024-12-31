<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'rekening_no', 'rekening_bank'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
