<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['id', 'name', 'address', 'phone', 'added_by', 'payment_type', 'email'];

    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
