<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'id',
        'cost',
        'date',
        'is_paid',
        'type',
        'supplier_id',
        'party_id',
        'created_at',
        'updated_at'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }
}
