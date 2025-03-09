<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\WorkData;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToModel, WithHeadingRow//, SkipsOnError
{
    // use SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        DB::beginTransaction();
        try {
            $date_of_birth = date('Y-m-d', strtotime(Employee::convertDateExcel($row['tarykh_almylad'])));
            $employee = Employee::create([
                'name' => $row['asm_almothf'],
                'employee_id' => $row['rkm_alhoy'],
                'date_of_birth' => $date_of_birth,
                'age' =>  Carbon::now()->format('Y') - Carbon::parse($date_of_birth)->format('Y'), // معادلة
                'gender' => $row['algns'],
                'matrimonial_status' => $row['alhal_alzogy'],
                'number_wives' => rand(0, 1),
                'number_children' => $row['aadd_alaolad'],
                'number_university_children' => $row['aadd_aolad_algamaa'],
                'scientific_qualification' => $row['almohl_alaalmy'],
                'specialization' => $row['altkhss'],
                'university' => $row['algamaa'],
                'area' => $row['almntk'],
                'address' => $row['alaanoan'],
                'email' => $row['alaymyl'],
                'phone_number' => $row['rkm_alhatf'],
            ]);
            $date_installation = date('Y-m-d', strtotime(Employee::convertDateExcel($row['tarykh_altthbyt'])));
            $workData = WorkData::create([
                'employee_id' => $employee->id,
                'working_status' => $row['hal_aldoam'],
                'type_appointment' => $row['noaa_altaayn'],
                'field_action' => $row['mgal_alaaml'],
                'percentage_allowance' => $row['nsb_aalao_tbyaa_alaaml'],
                'allowance' => $row['alaalao'],
                'grade' => $row['aldrg'],
                'grade_allowance_ratio' => $row['nsb_aalao_drg'],
                'dual_function' => $row['mzdog_othyf'],
                'years_service' => Carbon::now()->format('Y') - Carbon::parse($date_installation)->format('Y'), // معادلة
                'nature_work' => $row['tbyaa_alaaml'],
                'state_effectiveness' => $row['hal_alfaaaly'],
                'association' => $row['algmaay'],
                'workplace' => $row['mkan_alaaml'],
                'section' => $row['alksm'],
                'dependence' => $row['altbaay'],
                'working_date' => date('Y-m-d', strtotime(Employee::convertDateExcel($row['tarykh_alaaml']))),
                'date_installation' => $date_installation,
                'date_retirement' => Carbon::parse($date_of_birth)->addYears(60)->format('Y-m-d'), // معادلة
                'payroll_statement' => $row['byan_alratb'],
                'establishment' => $row['almnsha'],
                'foundation_E' => $row['almosse'],
                'salary_category' => $row['fy_alratb'],
            ]);
            DB::commit();


            return [$employee, $workData];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function chunkSize(): int
    {
        return 100; // حجم القطعة الواحدة
    }
}
