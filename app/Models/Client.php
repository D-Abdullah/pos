<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'id',
        'name',
        'phone',
        'added_by',
        'created_at',
        'updated_at'
    ];

    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
