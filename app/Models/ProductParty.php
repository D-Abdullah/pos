<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductParty extends Model
{
    use HasFactory;
    protected $table = 'product_parties';
    protected $fillable = [
        'id',
        'product_id',
        'party_id',
        'quantity',
        'type',
        'created_at',
        'updated_at'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function party()
    {
        return $this->belongsTo(Party::class);
    }
}
