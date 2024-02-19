<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'party_id',
        'product_id',
        'from',
        'name',
        'quantity',
        'rent_price',
        'unit_price',
        'total_price',
        'type',
        'status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
