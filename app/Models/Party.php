<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = ['client_id', 'added_by', 'name', 'address', 'ststus', 'date'];
    protected $hidden = ['created_at', 'updated_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function getAddedByAttribute($value)
    {
        return User::find($value)->first()->name;
    }
}
