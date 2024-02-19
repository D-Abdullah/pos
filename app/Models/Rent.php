<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $fillable = ['name','rent_price','sale_price','added_by','is_active','quantity'];


    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
