<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id', 'name', 'category', 'code', 'stock', 'cost_price', 'sell_price'
    ];

    // Cálculo dinámico del margen de ganancia
    public function getMarginAttribute()
    {
        if ($this->cost_price <= 0) return 0;
        return (($this->sell_price - $this->cost_price) / $this->cost_price) * 100;
    }
}