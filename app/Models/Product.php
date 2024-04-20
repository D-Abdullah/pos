<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'id',
        'name',
        'quantity',
        'description',
        'department_id',
        'added_by',
        'party_id',
        'party_qty',
        'image',
        'unit_price',
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
