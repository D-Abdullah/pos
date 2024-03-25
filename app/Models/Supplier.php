<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['id', 'name', 'email', 'phone', 'address', 'payment_type', 'added_by', 'created_at', 'updated_at'];

    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
