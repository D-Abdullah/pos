<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name','description','is_active','added_by'];


    public function product(){
        return $this->hasMany(Product::class);
    }
    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
