<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;

class Employee extends User
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'password',
        'employee_id',
        'date_of_birth',
        'age',
        'gender',
        'matrimonial_status',
        'number_wives',
        'number_children',
        'number_university_children',
        'scientific_qualification',
        'specialization',
        'university',
        'area',
        'address',
        'email',
        'phone_number',
    ];

    protected static function booted()
    {

    }

    // Relationships
    public function banks() :BelongsToMany
    {
        return $this->belongsToMany(
            Bank::class,     // Related Model
            'banks_employees',  // Pivot table name
        )->as('accounts')->withPivot(['account_number','default']);
    }
    public function workData() :HasOne
    {
        return $this->hasOne(WorkData::class);
    }
    public function totals() :HasOne
    {
        return $this->hasOne(ReceivablesLoans::class);
    }
    public function fixedEntries() :HasMany
    {
        return $this->hasMany(FixedEntries::class,'employee_id');
    }
    public function exchanges() :HasMany
    {
        return $this->hasMany(Exchange::class,'employee_id');
    }
    public function salaries() :HasMany
    {
        return $this->hasMany(Salary::class,'employee_id');
    }
    public function specificSalaries() :HasMany
    {
        return $this->hasMany(SpecificSalary::class,'employee_id');
    }
    public function customizations() :HasMany
    {
        return $this->hasMany(Customization::class,'employee_id');
    }

    // rolue
    public static function rules($id = 0){
        return  [
            // 'employee_id' => [
            //     'required',
            //     'string',
            //     "unique:employees,employee_id,$id,employee_id"
            //     // Rule::unique('employees', 'id')->ignore($id),
            // ],
        ];
    }
    public static function messages(){
        return  [
            'required' => 'هذا الحقل مطلوب',
        ];
    }


    // functions
    public static function convertDateExcel($date){
        $unix_date = ($date - 25569) * 86400;
        $excel_date = 25569 + ($unix_date / 86400);
        $unix_date = ($excel_date - 25569) * 86400;
        $date_f = gmdate("Y-m-d", $unix_date);
        return $date_f;
    }
}
