<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = ['cost', 'added_by', 'date'];

    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
