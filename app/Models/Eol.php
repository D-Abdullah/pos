<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eol extends Model
{
    protected $table = 'eols';
    protected $fillable = ['product_id', 'quantity', 'reason', 'added_by'];
    protected $hidden = ['created_at', 'updated_at'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
