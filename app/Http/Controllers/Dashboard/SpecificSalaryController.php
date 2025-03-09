<?php

namespace App\Http\Controllers\Dashboard;
;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\SpecificSalary;
use App\Models\WorkData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecificSalaryController extends Controller
{
    protected $thisMonth;

    public function __construct(){
        $this->thisMonth = Carbon::now()->format('Y-m') ;
    }

    public function index(){
        // خاص private
        $employees_private = Employee::whereHas('workData', function ($query) {
            $query->where('type_appointment', 'خاص');
        })->get();
        // رياض riyadh
        $employees_riyadh = Employee::whereHas('workData', function ($query) {
            $query->where('type_appointment', 'رياض');
        })->get();
        // فصلي fasle
        $employees_fasle = Employee::whereHas('workData', function ($query) {
            $query->where('type_appointment', 'فصلي');
        })->get();
        // مؤقت interim
        $employees_interim = Employee::whereHas('workData', function ($query) {
            $query->where('type_appointment', 'مؤقت');
        })->get();
        // يومي daily
        $employees_daily = Employee::whereHas('workData', function ($query) {
            $query->where('type_appointment', 'يومي');
        })->get();


        $month = '0000-00';
        return view('dashboard.specific_salaries.index', compact('employees_private','employees_riyadh','employees_fasle','employees_interim','employees_daily','month'));

    }
    // النسبة
    public function ratio(Request $request){
        $employees = Employee::whereHas('workData', function ($query) {
            $query->where('type_appointment', 'نسبة');
        })->get();
        $month = $this->thisMonth;
        return view('dashboard.specific_salaries.ratio', compact('employees','month'));
    }
    public function getRatio(Request $request){
        $employees = Employee::with('specificSalaries', 'workData')->whereHas('workData', function ($query) {
            $query->where('type_appointment', 'نسبة');
        })->get();
        $month = $request->month;
        return $employees;
    }
    public function ratioCreate(Request $request){
        DB::beginTransaction();
        try {
            if(Carbon::parse($request->month)->format('m') < Carbon::parse($this->thisMonth)->format('m')){
                return redirect()->back()->with('danger', 'لا يمكن اضافة الراتب الخاص للشهر السابق');
            }
            $salaries = $request->post('salaries');
            foreach ($salaries as $employee_id => $salary) {
                SpecificSalary::updateOrCreate([
                    'employee_id' => $employee_id,
                    'month' => $request->month
                ],[
                    'salary' => $salary,
                ]);
            }
            DB::commit();
        }catch (\Exception $e) {
            return redirect()->back()->with('danger', 'حذث هنالك خطأ بالإدخال يرجى مراجعة المهندس');
        }
        return redirect()->route('specific_salaries.ratio')->with('success', 'تم إعداد الراتب للموظفين النسبة');
    }

    // خاص
    public function privateCreate(Request $request){
        DB::beginTransaction();
        try {
            $salaries = $request->post('salaries');
            foreach ($salaries as $employee_id => $salary) {
                SpecificSalary::updateOrCreate([
                    'employee_id' => $employee_id,
                    'month' => '0000-00'
                ],[
                    'salary' => $salary,
                ]);
            }
            DB::commit();
        }catch (\Exception $e) {
            return redirect()->back()->with('danger', 'حذث هنالك خطأ بالإدخال يرجى مراجعة المهندس');
        }
        return redirect()->route('specific_salaries.private')->with('success', 'تم إعداد الراتب للموظفين الخاص');
    }

    // رياض
    public function riyadhCreate(Request $request){
        DB::beginTransaction();
        try {
            $salaries = $request->post('salaries');
            foreach ($salaries as $employee_id => $salary) {
                SpecificSalary::updateOrCreate([
                    'employee_id' => $employee_id,
                    'month' => '0000-00'
                ],[
                    'salary' => $salary,
                ]);
            }
            DB::commit();
        }catch (\Exception $e) {
            return redirect()->back()->with('danger', 'حذث هنالك خطأ بالإدخال يرجى مراجعة المهندس');
        }
        return redirect()->route('specific_salaries.riyadh')->with('success', 'تم إعداد الراتب لموظفين الرياض');
    }

    // فصلي
    public function fasleCreate(Request $request){
        DB::beginTransaction();
        try {
            $salaries = $request->post('salaries');
            foreach ($salaries as $employee_id => $salary) {
                SpecificSalary::updateOrCreate([
                    'employee_id' => $employee_id,
                    'month' => '0000-00'
                ],[
                    'salary' => $salary,
                ]);
            }
            DB::commit();
        }catch (\Exception $e) {
            return redirect()->back()->with('danger', 'حذث هنالك خطأ بالإدخال يرجى مراجعة المهندس');
        }
        return redirect()->route('specific_salaries.fasle')->with('success', 'تم إعداد الراتب لموظفين الفصلي');
    }

    // مؤقت
    public function interimCreate(Request $request){
        DB::beginTransaction();
        try {
            $salaries = $request->post('salaries');
            foreach ($salaries as $employee_id => $salary) {
                SpecificSalary::updateOrCreate([
                    'employee_id' => $employee_id,
                    'month' => '0000-00'
                ],[
                    'salary' => $salary,
                ]);
            }
            DB::commit();
        }catch (\Exception $e) {
            return redirect()->back()->with('danger', 'حذث هنالك خطأ بالإدخال يرجى مراجعة المهندس');
        }
        return redirect()->route('specific_salaries.interim')->with('success', 'تم إعداد الراتب لموظفين المؤقتين');
    }

    // اليومي
    public function dailyCreate(Request $request){
        DB::beginTransaction();
        try {
            $salaries = $request->post('salaries');
            foreach ($salaries as $employee_id => $salary) {
                SpecificSalary::updateOrCreate([
                    'employee_id' => $employee_id,
                    'month' => '0000-00'
                ],[
                    'number_of_days' => $request->number_of_days[$employee_id],
                    'today_price' => $request->today_price[$employee_id],
                    'salary' => $salary,
                ]);
            }
            DB::commit();
        }catch (\Exception $e) {
            return redirect()->back()->with('danger', 'حذث هنالك خطأ بالإدخال يرجى مراجعة المهندس');
        }
        return redirect()->route('specific_salaries.daily')->with('success', 'تم إعداد الراتب للموظفين اليوميين');
    }
}
