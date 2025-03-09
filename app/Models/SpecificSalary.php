<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecificSalary extends Model
{
    use HasFactory;

    protected $table = 'specific_salaries';

    protected $fillable = [
        'employee_id', 'salary','month','number_of_days','today_price'
    ];

    public function employee() :BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
