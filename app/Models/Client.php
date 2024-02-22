<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['id', 'name', 'added_by', 'phone'];

    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
