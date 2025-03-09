<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class SystemOperationsController extends Controller
{
    public function createBackup()
    {
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $backupFileName = $database . '_' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
        $backupFilePath = storage_path('app/backups/' . $backupFileName);

        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$database} > {$backupFilePath}";

        // code in the win server
        // $backupFilePath = storage_path('app\backups\financial_management_system_' . $backupFileName);
        // $command = 'D:\xampp\mysql\bin\mysqldump.exe --user='. $username .' --password='. $password .' --host=' . $host .' '. $database .' >'. $backupFilePath;

        $output = array();
        $result = null;
        exec($command, $output, $result);

        if ($result === 0) {
            return response()->download($backupFilePath)->deleteFileAfterSend(true);
        } else {
            return redirect()->route('home')->with('danger', 'حدث خطاء في عملية النسخ الاحتياطي يرجى مراجعة المهندس');
        }
    }

}
