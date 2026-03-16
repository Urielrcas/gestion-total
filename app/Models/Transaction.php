<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'concept',
        'amount',
        'type'
    ];

    // Relación: Una transacción pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}