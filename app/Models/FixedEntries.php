<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FixedEntries extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'month',
        'administrative_allowance',
        'scientific_qualification_allowance',
        'transport',
        'extra_allowance',
        'salary_allowance',
        'ex_addition',
        'mobile_allowance',
        'health_insurance',
        'f_Oredo',
        'association_loan',
        'tuition_fees',
        'voluntary_contributions',
        'savings_loan',
        'shekel_loan',
        'paradise_discount',
        'other_discounts',
        'proportion_voluntary',
        'savings_rate',
    ];

    // Relationship
    public function employee():BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
