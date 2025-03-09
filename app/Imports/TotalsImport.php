<?php

namespace App\Imports;

use App\Models\ReceivablesLoans;
use App\Models\WorkData;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TotalsImport implements ToModel,WithHeadingRow,SkipsOnError
{
    use SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {


        return new ReceivablesLoans([
            'employee_id' => $row['rkm_almothf'],
            'total_receivables' => $row['agmaly_almsthkat'],
            'total_savings' => $row['agmaly_aladkharat'],
            'total_association_loan' => $row['agmaly_krd_algmaay'],
            'total_shekel_loan' => $row['agmaly_krd_allgn_alshykl'],
            'total_savings_loan' => $row['agmaly_krd_aladkhar'],
        ]);
    }
}
