<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Safe extends Model
{
    protected $table = 'safes';
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
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
}
