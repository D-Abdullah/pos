<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposits';
    protected $fillable = [
        'id',
        'cost',
        'date',
        'is_paid', # bool
        'type', # supplier or client
        'supplier_id',
        'client_id',
        'from',
        'employee_id',
        'safe_id',
        'created_at',
        'updated_at'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function safe()
    {
        return $this->belongsTo(Safe::class);
    }
}
