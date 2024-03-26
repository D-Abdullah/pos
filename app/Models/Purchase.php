<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'id',
        'date',
        'quantity',
        'total_price',
        'unit_price',
        'added_by',
        'product_id',
        'supplier_id',
        'created_at',
        'updated_at',
    ];

    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
