<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name','address','phone','added_by','is_active','payment_type','email'];

    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
