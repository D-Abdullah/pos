<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $table = "rents";
    protected $fillable = ['name', 'rent_price', 'sale_price', 'added_by', 'is_active', 'quantity'];
    protected $hidden = ['created_at', 'updated_at'];

    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
