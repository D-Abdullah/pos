<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['id', 'name', 'description', 'added_by', 'created_at', 'updated_at', 'updated_at'];


    public function product()
    {
        return $this->hasMany(Product::class);
    }
    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
