<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseTransaction extends Model
{
    protected $table = "warehouse_transactions";
    protected $fillable = [
        'id',
        'quantity',
        'from',
        'to',
        'product_id',
        'rent_id',
        'type',
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }
}
