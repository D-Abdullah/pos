<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';
    protected $fillable = [
        'id',
        'party_id',
        'product_id',
        'rent_id',
        'from',
        'name',
        'quantity',
        'unit_price',
        'total_price',
        'type',
        'eol_reason',
        'status',
        'purchase_price',
        'profit',
        "is_transfared",
        "created_at",
        "updated_at"

    ];

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }
}
