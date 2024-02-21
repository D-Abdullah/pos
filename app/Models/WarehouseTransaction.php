<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseTransaction extends Model
{
    protected $table = "warehouse_transactions";
    protected $fillable = ['id', 'product_id', 'quantity', 'from', 'to'];
    protected $hidden = ['created_at', 'updated_at'];
    public function getProductIdAttribute($value)
    {
        return Product::find($value)->first()->name;
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
