<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'payment_type',
        'added_by',
        'created_at',
        'updated_at'
    ];

    public function getAddedByAttribute($value)
    {
        if ($value === null) {
            return "لم يتم التعيين";
        }
        return User::where('id', $value)->first()->name;
    }
    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
