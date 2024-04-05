<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = ['cost', 'added_by', 'date'];

    public function getAddedByAttribute($value)
    {
        if ($value === null) {
            return "لم يتم التعيين";
        }
        return User::where('id', $value)->first()->name;
    }
}
