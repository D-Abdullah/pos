<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransactionType extends Model
{
    protected $table = 'financial_transaction_types';
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
