<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'employee_id',
        'month',
        'percentage_allowance',
        'grade_Allowance',
        'initial_salary',
        'secondary_salary',
        'allowance_boys',
        'nature_work_increase',
        'termination_service',
        'gross_initial_salary',
        'z_Income',
        'gross_secondary_salary',
        'late_receivables',
        'total_discounts',
        'gross_salary',
        'net_salary',
        'amount_letters',
        'payroll_statement',
        'bank',
        'branch_number',
        'account_number',
        'resident_exemption',
        'annual_taxable_amount',
        'tax',
        'exemptions',
        'amount_tax',
        'savings_loan',
        'shekel_loan',
        'association_loan',
        'savings_rate',
    ];

    // Relationships
    public function employee():BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
