<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = "deposits";
    protected $fillable = ['cost', 'date', 'type', 'purchase_id', 'bill_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
