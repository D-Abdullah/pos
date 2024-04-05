<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $table = "rents";
    protected $fillable = [
        'id',
        'name',
        'rent_price',
        'sale_price',
        'quantity',
        'added_by',
        'created_at',
        'updated_at'
    ];

    public function getAddedByAttribute($value)
    {
        if ($value === null) {
            return "لم يتم التعيين";
        }
        return User::where('id', $value)->first()->name;
    }
}
