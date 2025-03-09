<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\CreateBackup;
use App\Jobs\CreateSalary;
use App\Models\Accreditation;
use App\Models\Employee;
use App\Models\Salary;
use App\Models\WorkData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Spatie\Backup\Config\Config;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;

class HomeController extends Controller
{
    public function index(){
        $employees = Employee::get();
        // تصنيف الموظفين حسب المناطق
        $areas = Employee::select('area')->distinct()->pluck('area')->toArray();
        $employeesPerArea = collect($areas)->map(function ($areas) {
            return [
                "count" => Employee::where("area", "=", $areas)->count(),
                'name' => $areas
            ];
        });
        $employeesPerArea = $employeesPerArea->pluck('count')->toArray();
        $chartEmployeesArea = app()->chartjs
            ->name('employeesPerArea')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($areas)
            ->datasets([
                [
                    "label" => "عدد الموظفين حسب المناطق",
                    'backgroundColor' => ['#1abc9c', '#16a085', '#2ecc71', '#27ae60', '#3498db', '#2980b9', '#9b59b6', '#8e44ad', '#e74c3c'],
                    'data' => $employeesPerArea
                ],
            ])
            ->options([
                "scales" => [
                    "y" => [
                        "beginAtZero" => true
                        ]
                    ]
        ]);

        // تصنيف الموظفين حسب المؤهل العلمي
        $scientific_qualification = Employee::select('scientific_qualification')->distinct()->pluck('scientific_qualification')->toArray();
        $employeesPerScientificQualification = collect($scientific_qualification)->map(function ($scientific_qualification) {
            return [
                "count" => Employee::where("scientific_qualification", "=", $scientific_qualification)->count(),
                'name' => $scientific_qualification
            ];
        });
        $employeesPerScientificQualification = $employeesPerScientificQualification->pluck('count')->toArray();
        $chartEmployeesScientificQualification = app()->chartjs
            ->name('employeesPerScientificQualification')
            ->type('pie')
            ->size(['width' => 400, 'height' => 300])
            ->labels($scientific_qualification)
            ->datasets([
                [
                    'backgroundColor' => ['#3498db', '#2ecc71', '#e74c3c'],
                    'hoverBackgroundColor' => ['#5dade2', '#58d68d', '#f1948a'],
                    'data' => $employeesPerScientificQualification
                ]
            ])
            ->options([]);

        // تصنيف الموظفين حسب المؤهل العلمي
        $typeAppointment = WorkData::select('type_appointment')->distinct()->pluck('type_appointment')->toArray();
        $employeesPerTypeAppointment = collect($typeAppointment)->map(function ($typeAppointment) {
            return [
                "count" => WorkData::where("type_appointment", "=", $typeAppointment)->count(),
                'name' => $typeAppointment
            ];
        });
        $employeesPerTypeAppointment = $employeesPerTypeAppointment->pluck('count')->toArray();
        $chartLineTypeAppointment = app()->chartjs
                    ->name('lineChartTest')
                    ->type('line')
                    ->size(['width' => 400, 'height' => 200])
                    ->labels($typeAppointment)
                    ->datasets([
                        [
                            "label" => "عدد الموظفين حسب التعين",
                            'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                            'borderColor' => "rgba(38, 185, 154, 0.7)",
                            "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                            "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                            "pointHoverBackgroundColor" => "#fff",
                            "pointHoverBorderColor" => "rgba(220,220,220,1)",
                            "data" => $employeesPerTypeAppointment,
                            "fill" => false,
                        ],
                    ])
                    ->options([]);





        $countEmployees = Employee::count();

        $lastAccreditations = Accreditation::latest()->first();
        $monthDownload = ($lastAccreditations  != null) ? Carbon::parse($lastAccreditations->month)->addMonth()->format('Y-m') : '2024-07' ;

        $net_salary = Salary::where('month', $monthDownload)->sum('net_salary');

        $workplaces = WorkData::select('workplace')->distinct()->pluck('workplace')->toArray();
        return view('dashboard.index', compact('chartEmployeesArea','chartEmployeesScientificQualification','chartLineTypeAppointment','countEmployees','net_salary','monthDownload','workplaces'));
    }

}

