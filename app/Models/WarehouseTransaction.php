<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseTransaction extends Model
{
    protected $fillable = ['id', 'product_id', 'quantity', 'from', 'to'];
    protected $hidden = ['created_at', 'updated_at'];
    public function getProductIdAttribute($value)
    {
        return Product::find($value)->first()->name;
    }
}
