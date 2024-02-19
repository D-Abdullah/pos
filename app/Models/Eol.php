<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eol extends Model
{
    protected $fillable = ['product_id', 'quantity', 'reason', 'added_by'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
