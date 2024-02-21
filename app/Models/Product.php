<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'added_by', 'quantity', 'department_id', 'is_active', 'description'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
    public function getDepartmentIdAttribute($value)
    {
        return Department::find($value)->first()->name;
    }

    public function eol()
    {
        return $this->hasMany(Eol::class);
    }
}
