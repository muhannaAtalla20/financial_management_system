<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class BanksEmployees extends Pivot
{
    use HasFactory;
    protected $table = 'banks_employees';
    protected $fillable = [
        'employee_id',
        'bank_id',
        'account_number',
        'default'
    ];


    // relationship
    public function employee() :BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id');

    }
    public function bank() :BelongsTo
    {
        return $this->belongsTo(Bank::class,'bank_id');

    }
}
