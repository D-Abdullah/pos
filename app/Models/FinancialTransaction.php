<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    protected $table = 'financial_transactions';
    use HasFactory;
    protected $fillable = [
        'id',
        'type', // 'income', 'expense'
        'description',
        'amount',
        'party_id',
        'financial_transaction_type_id',
        'from', // 'custody', 'safe'
        'employee_id',
        'safe_id',
        'added_by',
        'created_at',
        'updated_at'
    ];
    public function party()
    {
        return $this->belongsTo(Party::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function financial_transaction_type()
    {
        return $this->belongsTo(FinancialTransactionType::class);
    }
    public function safe()
    {
        return $this->belongsTo(Safe::class);
    }
    public function getAddedByAttribute($value)
    {
        if ($value === null) {
            return "لم يتم التعيين";
        }
        return User::where('id', $value)->first()->name;
    }
}
