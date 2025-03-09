<?php

namespace App\Imports;

use App\Models\BanksEmployees;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BanksEmployeesImport implements ToModel,WithHeadingRow,SkipsOnError
{
    use SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $num_accont = $row['aadd_hsabath'];
        $employee_id =  $row['rkm_almothf'];
        $num_default = $row['rkm_alhsab_alasasy'];
        for ($i=1; $i <= $num_accont ; $i++) {
            $default = ($num_default == $i) ? 1 : 0;
            BanksEmployees::create([
                'employee_id' => $employee_id,
                'bank_id' => $row['rkm_albnk'.$i],
                'account_number' => $row['rkm_alhsab'.$i],
                'default' => $default,
            ]);
        }
        // return new BanksEmployees();
    }
}
