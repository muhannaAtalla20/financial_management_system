<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivablesLoans extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'totals';

    protected $fillable = [
        'total_receivables',
        'total_savings',
        'total_association_loan',
        'total_savings_loan',
        'total_shekel_loan',
    ];


    // Relationships
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }

    // Accessors
    // add , in number form the table
    public function getTotalReceivablesViewAttribute()
    {
        return number_format($this->total_receivables, 2, '.', ',');
    }

    //total_savings
    public function getTotalSavingsViewAttribute()
    {
        return number_format($this->total_savings, 2, '.', ',');
    }

    //total_AssociationLoan
    public function getTotalAssociationLoanViewAttribute()
    {
        return number_format($this->total_association_loan, 2, '.', ',');
    }

    // total_ShekelLoan
    public function getTotalShekelLoanViewAttribute()
    {
        return number_format($this->total_shekel_loan, 2, '.', ',');
    }

    //	total_SavingsLoan
    public function getTotalSavingsLoanViewAttribute()
    {
        return number_format($this->total_savings_loan, 2, '.', ',');
    }
}

