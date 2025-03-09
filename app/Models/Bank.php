<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name','branch','branch_number'
    ];

    // Relationships
    public function employees(){
        return $this->belongsToMany(Employee::class, 'banks_employees')->withPivot(['account_number','default']);
    }
}
