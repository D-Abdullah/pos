<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $table = "parties";
    protected $fillable = ['id', 'client_id', 'added_by', 'name', 'address', 'status', 'date', 'total_price', 'total_profit', 'created_at', 'updated_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function getAddedByAttribute($value)
    {
        if ($value === null) {
            return "لم يتم التعيين";
        }
        return User::where('id', $value)->first()->name;
    }
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}
