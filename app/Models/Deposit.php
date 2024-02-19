<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = ['cost', 'date', 'type', 'purchase_id', 'bill_id'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
