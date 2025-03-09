<?php

namespace App\Livewire;

use App\Http\Controllers\Dashboard\EmployeeController;
use App\Models\Currency;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class TableSalaries extends Component
{
    public $salaries;
    public $month;
    public $monthDownload;
    public $USD;
    public $btn_download_salary;
    public $btn_delete_salary;
    public $filterArray = [
        'name' => '',
        'month' => '',
    ];


    public function __construct(){
        $this->USD = Currency::where('code','USD')->first()->value ?? null;
        $this->month = Carbon::now()->format('Y-m');
        $this->filterArray['month'] = $this->month;
    }

    public function mount($salaries, $month,$monthDownload, $btn_download_salary, $btn_delete_salary){
        $this->salaries = $salaries;
        $this->month = $month;
        $this->monthDownload = $monthDownload;
        $this->btn_download_salary = $btn_download_salary;
        $this->btn_delete_salary = $btn_delete_salary;
    }

    public function filter(Request $request = null){
        if($request == null){
            $request = new Request();
        }
        if($this->filterArray['name'] != ''){
            $request->merge([
                'name' => $this->filterArray['name'],
            ]);
        }

        $controller = new EmployeeController();
        $employees = $controller->filterEmployee($request);

        $this->month = ($this->filterArray['month'] != '') ? $this->filterArray['month'] : Carbon::now()->format('Y-m');

        $this->salaries = Salary::whereIn('employee_id', $employees->pluck('id'))->where('salaries.month', $this->month)->get();
    }
    public function render()
    {
        return view('livewire.table-salaries');
    }
}
