<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyMetric extends Model
{
    use HasFactory;

    // Campos que permitimos llenar masivamente
    protected $fillable = [
        'user_id',
        'date',
        'income',
        'expenses',
        'low_stock_alerts'
    ];

    // Relación: Una métrica pertenece a un usuario (Dueño de tienda)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}