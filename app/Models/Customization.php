<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customization extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'employee_id',
        'grade_Allowance',
        'allowance_boys_1',
        'allowance_boys_2',
        'termination_service',
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
