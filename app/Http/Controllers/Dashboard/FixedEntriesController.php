<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Http\Requests\FixedEntryRequest;
use App\Models\Accreditation;
use App\Models\Employee;
use App\Models\FixedEntries;
use App\Models\Salary;
use App\Models\ReceivablesLoans;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FixedEntriesController extends Controller
{

    use AuthorizesRequests;
    protected $thisYear;
    protected $thisMonth;
    protected $monthNow;



    public function __construct(){
        $this->thisYear = Carbon::now()->format('Y'); //
        $this->thisMonth = Carbon::now()->format('m'); //
        $this->monthNow = Carbon::now()->format('Y-m') ; //
        $lastAccreditations = Accreditation::latest()->first();
        $lastMonth = ($lastAccreditations  != null) ? Carbon::parse($lastAccreditations->month)->addMonth()->format('m') : '07' ;
        $this->thisMonth = $lastMonth; //
        $this->monthNow = ($lastAccreditations  != null) ? Carbon::parse($lastAccreditations->month)->addMonth()->format('Y-m') : '2024-07' ;
        $this->thisYear = ($lastAccreditations  != null) ? Carbon::parse($lastAccreditations->month)->addMonth()->format('Y') : '2024' ; //

    }
    public function updateEntries($request,$fieldName,$fieldNameMonth) {
        if($request->{$fieldNameMonth} != ""){
            for($i=1;$i<=12;$i++){
                if($i<10){
                    $month = '0'.$i;
                }else{
                    $month = $i;
                }
                if($month >= $this->thisMonth){
                    FixedEntries::updateOrCreate([
                        'employee_id' => $request->employee_id,
                        'month' => $this->thisYear.'-'.$month,
                    ],[
                        "$fieldName" => $request->{$fieldNameMonth},
                    ]);
                    if($request["$month"] != 0){
                        FixedEntries::updateOrCreate([
                            'employee_id' => $request->employee_id,
                            'month' => $this->thisYear.'-'.$month,
                        ],[
                            "$fieldName" => $request["$month"],
                        ]);
                    }
                }
            }
        }
        if($request->{$fieldNameMonth} == ""  || $request->{$fieldNameMonth} == null){
            for($i=1;$i<=12;$i++){
                if($i<10){
                    $month = '0'.$i;
                }else{
                    $month = $i;
                }
                if($month >= $this->thisMonth){
                    FixedEntries::updateOrCreate([
                        'employee_id' => $request->employee_id,
                        'month' => $this->thisYear.'-'.$month,
                    ],[
                        "$fieldName" => $request["$month"],
                    ]);
                }
            }
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('view', FixedEntries::class);
        // تغير الشهر
        if($request->monthChange == true){
            $fixed_entries = FixedEntries::with(['employee'])->where('month',$request->month)->get();
            return $fixed_entries;
        }
        $year = $this->thisYear;
        $month = $this->thisMonth;
        $monthNow = $this->monthNow;

        $lastAccreditations = Accreditation::latest()->first();
        $lastMonth = ($lastAccreditations  != null) ? Carbon::parse($lastAccreditations->month)->addMonth()->format('m') : '07' ;

        $title = "جدول التعديلات الثابتة للموظفين";

        $fixed_entries = FixedEntries::with(['employee'])->where('month',$this->monthNow)->get();
        $employees = Employee::get();
        return view('dashboard.fixed_entries.viewForm', compact('fixed_entries','monthNow','lastMonth','employees','year','month','title'));
    }

    // public function viewForm(Request $request)
    // {
    //     $this->authorize('edit', FixedEntries::class);
    //     // تغير الشهر
    //     if($request->monthChange == true){
    //         $fixed_entries = FixedEntries::with(['employee'])->where('month',$request->month)->get();
    //         return $fixed_entries;
    //     }
    //     $monthNow = Carbon::now()->format('Y-m');
    //     $year = Carbon::now()->format('Y');
    //     $month = Carbon::now()->format('m');

    //     $fixed_entries = FixedEntries::with(['employee'])->where('month',$monthNow)->get();
    //     $employees = Employee::get();
    //     return view('dashboard.fixed_entries.viewForm', compact('employees','fixed_entries','monthNow','year','month'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create(FixedEntryRequest $request)
    {
        $this->authorize('create', FixedEntries::class);
        $fixed_entrie = new FixedEntries();
        $fixed_entrie->employee = new Employee();
        $month = $this->thisMonth;
        $year = $this->thisYear;
        $total_association_loan_old = "";
        $total_shekel_loan_old = "";
        $total_savings_loan_old = "";


        return view('dashboard.fixed_entries.create', compact('fixed_entrie','month','year','total_association_loan_old','total_shekel_loan_old','total_savings_loan_old'));
    }

    /**
     * Store a newly created resource in storage.
     */
        // $request->validate([
    //     'employee_id' => [
    //         'required',
    //         Rule::unique('fixed_entries')->where(function ($query) {
    //             return $query->where('month', $this->month );
    //         }),],
    //     'month' =>"required|date_format:Y-m",
    // ]);
    public function store(FixedEntryRequest $request)
    {
        $this->authorize('create', FixedEntries::class);
        $fields = [
            'administrative_allowance',
            'scientific_qualification_allowance',
            'transport',
            'extra_allowance',
            'salary_allowance',
            'ex_addition',
            'mobile_allowance',
            'health_insurance',
            'f_Oredo',
            'tuition_fees',
            'voluntary_contributions',
            'savings_loan',
            'shekel_loan',
            'paradise_discount',
            'other_discounts',
            'proportion_voluntary',
            'savings_rate',
        ];
        foreach ($fields as $field) {
            if($request->{$field."_create"} == true) {
                $this->updateEntries($request, $field, $field.'_months');
            }
        }
        $fieldsLoan = [
            'association_loan',
            'savings_loan',
            'shekel_loan',
        ];
        foreach ($fieldsLoan as $field) {
            if($request->{$field."_create"} == true) {
                $this->updateEntries($request, $field, $field.'_months');
            }
        }
        $salary = Salary::where('employee_id',$request->employee_id)->where('month',$this->monthNow)->first();
        if($salary != null){
            $employee = Employee::findOrFail($request->employee_id);
            AddSalaryEmployee::addSalary($employee,$this->monthNow);
        }
    }
    // public Function

    /**
     * Display the specified resource.
     */
    public function show(Request $request, FixedEntries $fixedEntries)
    {
        if ($request->showModel == true) {
            if($request->has('month')){
                $monthNow = $request->month;
                $fixed_entrie = FixedEntries::with('employee')->where('month',$monthNow)->find($request->fixed_entrie);
                return  $fixed_entrie;
            }
            if($request->has('monthT')){
                $fixed_entrie = FixedEntries::with('employee')->find($request->fixed_entrie);
                $fixed_entrie = FixedEntries::with('employee')->where('employee_id',$fixed_entrie->employee_id)->where('month',$request->monthT)->first();
                return  $fixed_entrie;
            }
            return "fixed entrie";
        }
        return redirect()->route('employees.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FixedEntryRequest $request, $id)
    {
        $this->authorize('edit', FixedEntries::class);
        $fixed_entrie = FixedEntries::with(['employee'])->where('employee_id',$id)->get();
        $fixed_entrie['employee'] = FixedEntries::with(['employee'])->where('employee_id',$id)->first()->employee;
        $total_association_loan_old = (ReceivablesLoans::where('employee_id',$id)->first() == null) ? 0 : ReceivablesLoans::where('employee_id',$id)->first()['total_association_loan'];
        $total_shekel_loan_old = (ReceivablesLoans::where('employee_id',$id)->first() == null) ? 0 : ReceivablesLoans::where('employee_id',$id)->first()['total_shekel_loan'];
        $total_savings_loan_old = (ReceivablesLoans::where('employee_id',$id)->first() == null) ? 0 : ReceivablesLoans::where('employee_id',$id)->first()['total_savings_loan'];
        $btn_label = "تعديل";
        $month = $this->thisMonth;
        $year = $this->thisYear;
        return view('dashboard.fixed_entries.edit', compact('fixed_entrie','btn_label','month','year','total_association_loan_old','total_shekel_loan_old','total_savings_loan_old'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FixedEntryRequest $request, $id)
    {
        $this->authorize('edit', FixedEntries::class);
        $employee = Employee::findOrFail($id);
        $salary = Salary::where('employee_id',$id)->where('month',$this->monthNow)->first();
        if($salary != null){
            AddSalaryEmployee::addSalary($employee,$this->monthNow);
        }
        return redirect()->route('fixed_entries.index')->with('success','تم تحديث الثوابت بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FixedEntryRequest $request ,$id)
    {
        $this->authorize('delete', FixedEntries::class);
        $fixedEntries = FixedEntries::findOrFail($id);
        $fixedEntries->delete();
        return redirect()->route('fixed_entries.index')->with('danger','تم حذف الثوابت للموضف بنجاح');
    }


    // others Functions
    public function getFixedEntriesData(Request $request){
        $fixed_entrie = FixedEntries::where('employee_id',$request->employee_id)->where('month',$this->monthNow)->first();
        if($fixed_entrie != null){
            return [
                'link_edit_fixed_entries' => route('fixed_entries.edit',$request->employee_id),
            ];
        }
        $employee_name = Employee::findOrFail($request->employee_id)->name;
        $totals = ReceivablesLoans::where('employee_id',$request->employee_id)->first();
        if($totals == null){
            return  0.00;
        }
        return [
            'employee_name' => $employee_name,
            'total_association_loan' => $totals->total_association_loan,
            'total_shekel_loan' => $totals->total_shekel_loan,
            'total_savings_loan' => $totals->total_savings_loan,
            'link_edit_fixed_entries' => false
        ];
    }
    public function getFixedEntriesFialds($employee_id,$year,$month,$filedName){
        $month = $year . '-' . $month;
        $reslut = FixedEntries::where('employee_id',$employee_id)->where('month',$month)->first();
        if($reslut == null){
            return $reslut = 0;
        }
        return $reslut[$filedName];
    }
    public function getFixedEntriesFialdsArray($employee_id,$month){
        $reslut = FixedEntries::where('employee_id',$employee_id)->where('month',$month)->first();
        if($reslut == null){
            return $reslut = [];
        }
        return $reslut;
    }

    public function getModalForm(Request $request){
        $year = $this->thisYear;
        $type =  $request->post('type');
        $employee_id =  $request->post('employee_id');

        $fixed_entrie = FixedEntries::where('employee_id',$employee_id)->first();
        if($fixed_entrie == null){
            $reslut = [];
            for($i=1;$i<=12;$i++){
                if($i<10){
                    $month = '0'.$i;
                }else{
                    $month = $i;
                }
                $reslut[$type . '_month-' . $i] = 0;
            }
            return $reslut;
        }

        $reslut = [];
        for($i=1;$i<=12;$i++){
            if($i<10){
                $month = '0'.$i;
            }else{
                $month = $i;
            }

            $reslut[$type . '_month-' . $i] = $this->getFixedEntriesFialds($employee_id,$year,$month,$type);
        }

        return $reslut;
    }

    public function getModalFormLoan(Request $request){
        $year = $this->thisYear;
        $type =  $request->post('type');
        $employee_id =  $request->post('employee_id');

        $fixed_entrie = FixedEntries::where('employee_id',$employee_id)->first();
        $reslut = [];
        if($type == 'association_loan'){
            $reslut['total_association_loan_old'] = (ReceivablesLoans::where('employee_id',$employee_id)->first() == null) ? 0 : ReceivablesLoans::where('employee_id',$employee_id)->first()['total_association_loan'];
        }
        if($type == 'shekel_loan'){
            $reslut['total_shekel_loan_old'] = (ReceivablesLoans::where('employee_id',$employee_id)->first() == null) ? 0 : ReceivablesLoans::where('employee_id',$employee_id)->first()['total_shekel_loan'];
        }
        if($type == 'savings_loan'){
            $reslut['total_savings_loan_old'] = (ReceivablesLoans::where('employee_id',$employee_id)->first() == null) ? 0 : ReceivablesLoans::where('employee_id',$employee_id)->first()['total_savings_loan'];
        }

        if($fixed_entrie == null){
            for($i=1;$i<=12;$i++){
                if($i<10){
                    $month = '0'.$i;
                }else{
                    $month = $i;
                }
                $reslut[$type . '_month-' . $i] = 0;
            }
            return $reslut;
        }

        for($i=1;$i<=12;$i++){
            if($i<10){
                $month = '0'.$i;
            }else{
                $month = $i;
            }
            $reslut[$type . '_month-' . $i] = $this->getFixedEntriesFialds($employee_id,$year,$month,$type);
        }

        return $reslut;
    }
}
