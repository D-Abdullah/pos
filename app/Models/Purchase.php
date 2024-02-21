<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['supplier_id', 'product_id', 'added_by', 'quantity', 'total_price', 'date'];

    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }
    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
