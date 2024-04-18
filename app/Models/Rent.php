<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $table = "rents";
    protected $fillable = [
        'id',
        'name',
        'image',
        'rent_price',
        'sale_price',
        'quantity',
        'supplier_id',
        'total_price',
        'party_id',
        'party_qty',
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
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
