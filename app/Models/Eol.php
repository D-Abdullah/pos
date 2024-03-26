<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eol extends Model
{
    protected $table = 'eols';
    protected $fillable = [
        'id',
        'quantity',
        'reason',
        'added_by',
        'product_id',
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
