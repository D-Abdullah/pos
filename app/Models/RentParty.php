<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentParty extends Model
{
    use HasFactory;
    protected $table = 'rent_parties';
    protected $fillable = [
        'id',
        'rent_id',
        'party_id',
        'quantity',
        'type',
        'created_at',
        'updated_at'
    ];
    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }
    public function party()
    {
        return $this->belongsTo(Party::class);
    }
}
