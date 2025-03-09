<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Models\Customization;
use App\Models\Employee;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CustomizationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customizations =Customization::with('employee')->get();
        return view("dashboard.customizations.index", compact("customizations"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customization = new Customization();
        $employee = new Employee();
        return view("dashboard.customizations.create", compact("customization",'employee'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Customization::create($request->all());
        $salary = Salary::where('employee_id',$request->employee_id)->where('month',Carbon::now()->format('Y-m'))->first();
        if($salary != null){
            $employee = Employee::findOrFail($request->employee_id);
            AddSalaryEmployee::addSalary($employee);
        }
        return redirect()->route('customizations.index')->with('success', 'تم اضافة التخصيصات لموظف');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customization $customization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customization $customization)
    {
        $btn_label = 'تعديل';
        return view("dashboard.customizations.edit", compact("customization",'btn_label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customization $customization)
    {
        $customization->update($request->all());
        $salary = Salary::where('employee_id',$request->employee_id)->where('month',Carbon::now()->format('Y-m'))->first();
        if($salary != null){
            $employee = Employee::findOrFail($request->employee_id);
            AddSalaryEmployee::addSalary($employee);
        }
        return redirect()->route('customizations.index')->with('success', 'تم تعديل التخصيصات لموظف');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customization $customization)
    {
        $customization->delete();
        return redirect()->route('customizations.index')->with('danger', 'تم حذف التخصيصات لموظف');
    }
}
