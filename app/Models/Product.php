<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'department_id',
        'added_by',
        'quantity',
        'image',
        'created_at',
        'updated_at'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getAddedByAttribute($value)
    {
        if ($value === null) {
            return "لم يتم التعيين";
        }
        return User::where('id', $value)->first()->name;
    }

    public function eol()
    {
        return $this->hasMany(Eol::class);
    }
}
