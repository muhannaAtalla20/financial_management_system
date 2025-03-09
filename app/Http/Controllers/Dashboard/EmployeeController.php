<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ModelExport;
use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequset;
use App\Imports\EmployeesImport;
use App\Models\Constant;
use App\Models\Employee;
use App\Models\Salary;
use App\Models\SpecificSalary;
use App\Models\WorkData;
use App\Models\ReceivablesLoans;
use App\Models\Bank;
use App\Models\BanksEmployees;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;


class EmployeeController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // $this->authorizeResource(Employee::class, 'employee');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Employee::class);
        $areas = Employee::select('area')->distinct()->pluck('area')->toArray();
        $working_status = WorkData::select('working_status')->distinct()->pluck('working_status')->toArray();
        $nature_work = WorkData::select('nature_work')->distinct()->pluck('nature_work')->toArray();
        $type_appointment = WorkData::select('type_appointment')->distinct()->pluck('type_appointment')->toArray();
        $field_action = WorkData::select('field_action')->distinct()->pluck('field_action')->toArray();
        $matrimonial_status = Employee::select('matrimonial_status')->distinct()->pluck('matrimonial_status')->toArray();
        $scientific_qualification = Employee::select('scientific_qualification')->distinct()->pluck('scientific_qualification')->toArray();
        $state_effectiveness = WorkData::select('state_effectiveness')->distinct()->pluck('state_effectiveness')->toArray();
        $association =  WorkData::select('association')->distinct()->pluck('association')->toArray();
        $workplace = WorkData::select('workplace')->distinct()->pluck('workplace')->toArray();
        $section = WorkData::select('section')->distinct()->pluck('section')->toArray();
        $dependence = WorkData::select('dependence')->distinct()->pluck('dependence')->toArray();
        $establishment = WorkData::select('establishment')->distinct()->pluck('establishment')->toArray();
        $payroll_statement = WorkData::select('payroll_statement')->distinct()->pluck('payroll_statement')->toArray();

        $employees = Employee::get();

        return view('dashboard.employees.index', compact('employees',"areas","working_status","nature_work","type_appointment","field_action","matrimonial_status","scientific_qualification","state_effectiveness","association","workplace","section","dependence","establishment","payroll_statement"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Employee::class);
        $advance_payment_rate = Constant::where('type_constant','advance_payment_rate')->first('value')->value ?? null;
        $advance_payment_permanent = Constant::where('type_constant','advance_payment_permanent')->first('value')->value ?? null;
        $advance_payment_non_permanent = Constant::where('type_constant','advance_payment_non_permanent')->first('value')->value ?? null;
        $advance_payment_riyadh = Constant::where('type_constant','advance_payment_riyadh')->first('value')->value ?? null;
        $areas = Employee::select('area')->distinct()->pluck('area')->toArray();
        $working_status = WorkData::select('working_status')->distinct()->pluck('working_status')->toArray();
        $nature_work = WorkData::select('nature_work')->distinct()->pluck('nature_work')->toArray();
        $type_appointment = WorkData::select('type_appointment')->distinct()->pluck('type_appointment')->toArray();
        $field_action = WorkData::select('field_action')->distinct()->pluck('field_action')->toArray();
        $matrimonial_status = Employee::select('matrimonial_status')->distinct()->pluck('matrimonial_status')->toArray();
        $scientific_qualification = Employee::select('scientific_qualification')->distinct()->pluck('scientific_qualification')->toArray();
        $state_effectiveness = WorkData::select('state_effectiveness')->distinct()->pluck('state_effectiveness')->toArray();
        $association =  WorkData::select('association')->distinct()->pluck('association')->toArray();
        $workplace = WorkData::select('workplace')->distinct()->pluck('workplace')->toArray();
        $section = WorkData::select('section')->distinct()->pluck('section')->toArray();
        $dependence = WorkData::select('dependence')->distinct()->pluck('dependence')->toArray();
        $establishment = WorkData::select('establishment')->distinct()->pluck('establishment')->toArray();
        $foundation_E = WorkData::select('foundation_E')->distinct()->pluck('foundation_E')->toArray();
        $payroll_statement = WorkData::select('payroll_statement')->distinct()->pluck('payroll_statement')->toArray();
        $contract_type = WorkData::select('contract_type')->distinct()->pluck('contract_type')->toArray();

        $employee = new Employee();
        $workData = new WorkData();
        $totals = new ReceivablesLoans();
        $banks = Bank::all();

        $bank_employee = new BanksEmployees();


        return view('dashboard.employees.create', compact('employee','workData','totals','banks','bank_employee',"advance_payment_rate","advance_payment_permanent","advance_payment_non_permanent","advance_payment_riyadh","areas","working_status","nature_work","type_appointment","field_action","matrimonial_status","scientific_qualification","state_effectiveness","association","workplace","section","dependence","establishment","foundation_E","payroll_statement","contract_type"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequset $request)
    {
        $this->authorize('create', Employee::class);
        $employee = Employee::create($request->all());
        $request->merge([
            'employee_id' => $employee->id,
            'default' => 1
        ]);
        WorkData::create($request->all());


        ReceivablesLoans::create($request->all());


        if($request->account_number != '' && $request->account_number != null){
            BanksEmployees::create($request->all());
        }

        // الراتب المحدد
        if($request->type_appointment == 'يومي'){
            SpecificSalary::updateOrCreate([
                'employee_id'=> $employee->id,
                'month' => '0000-00',
                ],[
                'number_of_days' => $request->number_of_days,
                'today_price' => $request->today_price,
                'salary' => $request->specific_salary
            ]);
        }
        if(in_array($request->type_appointment,['خاص','مؤقت','فصلي','رياض'])){
            SpecificSalary::updateOrCreate([
                'employee_id'=> $employee->id,
                'month' => '0000-00',
                ],[
                'salary' => $request->specific_salary
            ]);
        }
        return redirect()->route('employees.index')->with('success', 'تم اضافة الموظف الجديد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Employee $employee)
    {
        if ($request->showModel == true) {
            $employee = Employee::with(['workData'])->find($employee->id);
            return $employee;
        }
        // return redirect()->route('employees.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeRequset $request,Employee $employee)
    {
        $this->authorize('edit', Employee::class);
        $advance_payment_rate = Constant::where('type_constant','advance_payment_rate')->first('value')->value;
        $advance_payment_permanent = Constant::where('type_constant','advance_payment_permanent')->first('value')->value;
        $advance_payment_non_permanent = Constant::where('type_constant','advance_payment_non_permanent')->first('value')->value;
        $advance_payment_riyadh = Constant::where('type_constant','advance_payment_riyadh')->first('value')->value;
        $areas = Employee::select('area')->distinct()->pluck('area')->toArray();
        $working_status = WorkData::select('working_status')->distinct()->pluck('working_status')->toArray();
        $nature_work = WorkData::select('nature_work')->distinct()->pluck('nature_work')->toArray();
        $type_appointment = WorkData::select('type_appointment')->distinct()->pluck('type_appointment')->toArray();
        $field_action = WorkData::select('field_action')->distinct()->pluck('field_action')->toArray();
        $matrimonial_status = Employee::select('matrimonial_status')->distinct()->pluck('matrimonial_status')->toArray();
        $scientific_qualification = Employee::select('scientific_qualification')->distinct()->pluck('scientific_qualification')->toArray();
        $state_effectiveness = WorkData::select('state_effectiveness')->distinct()->pluck('state_effectiveness')->toArray();
        $association =  WorkData::select('association')->distinct()->pluck('association')->toArray();
        $workplace = WorkData::select('workplace')->distinct()->pluck('workplace')->toArray();
        $section = WorkData::select('section')->distinct()->pluck('section')->toArray();
        $dependence = WorkData::select('dependence')->distinct()->pluck('dependence')->toArray();
        $establishment = WorkData::select('establishment')->distinct()->pluck('establishment')->toArray();
        $foundation_E = WorkData::select('foundation_E')->distinct()->pluck('foundation_E')->toArray();
        $payroll_statement = WorkData::select('payroll_statement')->distinct()->pluck('payroll_statement')->toArray();
        $contract_type = WorkData::select('contract_type')->distinct()->pluck('contract_type')->toArray();



        $USD = Currency::where('code', 'USD')->first()->value;
        $month = Carbon::now()->format('Y') . '-01';
        $to_month = Carbon::now()->format('Y') . '-12';

        $salaries = Salary::where('employee_id', $employee->id)
                    ->whereBetween('month', [$month, $to_month])
                    ->get();


        $btn_label = "تعديل";
        $workData = WorkData::where('employee_id', $employee->id)->first();
        if ($workData == null) {
            $workData = new WorkData();
        }
        $totals = ReceivablesLoans::where('employee_id', $employee->id)->first();
        if ($totals == null) {
            $totals = new ReceivablesLoans();
        }
        $banks = Bank::all();

        $bank_employee = BanksEmployees::where('employee_id', $employee->id)->where('default', 1)->first();
        if ($bank_employee == null) {
            $bank_employee = BanksEmployees::where('employee_id', $employee->id)->first();
        }
        if ($bank_employee == null) {
            $bank_employee = new BanksEmployees();
        }


        return view('dashboard.employees.edit', compact('employee','workData','totals','banks','bank_employee','salaries','USD','btn_label',"advance_payment_rate","advance_payment_permanent","advance_payment_non_permanent","advance_payment_riyadh","areas","working_status","nature_work","type_appointment","field_action","matrimonial_status","scientific_qualification","state_effectiveness","association","workplace","section","dependence","establishment","foundation_E","payroll_statement",'contract_type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequset $request, Employee $employee)
    {
        $this->authorize('edit', Employee::class);
        // $request->validate([
        //     'employee_id' => [
        //         'required',
        //         'string',
        //         "unique:employees,employee_id,$request->employee_id,employee_id"
        //     ]
        // ],[
        //     'unique' => ' هذا الحقل (:attribute) مكرر يرجى التحقق'
        // ]);

        $employee->update($request->all());


        $request->merge([
            'employee_id' => $employee->id,
            'default' => 1
        ]);

        WorkData::updateOrCreate([
            'employee_id' => $employee->id
        ], $request->all());

            ReceivablesLoans::updateOrCreate([
                'employee_id' => $employee->id
            ], $request->all());

        if($request->account_number != '' && $request->account_number != null){

            BanksEmployees::updateOrCreate([
                'employee_id' => $employee->id
            ], $request->all());
        }
        // الراتب المحدد
        if($request->type_appointment == 'يومي'){
            SpecificSalary::updateOrCreate([
                'employee_id'=> $employee->id,
                'month' => '0000-00',
                ],[
                'number_of_days' => $request->number_of_days,
                'today_price' => $request->today_price,
                'salary' => $request->specific_salary
            ]);
        }
        if(in_array($request->type_appointment,['خاص','مؤقت','فصلي','رياض'])){
            SpecificSalary::updateOrCreate([
                'employee_id'=> $employee->id,
                'month' => '0000-00',
                ],[
                'salary' => $request->specific_salary
            ]);
        }
        $salary = Salary::where('employee_id',$employee->id)->where('month',Carbon::now()->format('Y-m'))->first();
        if($salary != null){
            AddSalaryEmployee::addSalary($employee);
        }
        return redirect()->route('employees.index')->with('success', 'تم تحديث بيانات الموظف المختار');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeRequset $request,Employee $employee)
    {
        $this->authorize('delete', Employee::class);
        $employee->delete();
        return redirect()->route('employees.index')->with('danger', 'تم حذف بيانات الموظف المحدد');
    }


    // getEmployeeId for tables related to employees
    public function getEmployee(Request $request)
    {
        $employee_search_id = $request->get('employeeId');
        $employee_search_name = $request->get('employeeName');
        $employees = new Employee();
        if($employee_search_id != ""){
            $employees = $employees->where('employee_id','LIKE',"{$employee_search_id}%");
        }
        if($employee_search_name != ""){
            $valueS = str_replace('*', '%', $employee_search_name);
            $employees = $employees->where('name','LIKE',"%{$valueS}%");
        }


        return $employees->get();
    }

    // filterEmployee function
    public function filterEmployee(Request $request)
    {
        $filedsEmpolyees = [
            'name',
            'employee_id',
            'gender',
            'matrimonial_status',
            'scientific_qualification',
            'area',
        ];
        $filedsWork = [
            'working_status',
            'type_appointment',
            'field_action',
            'dual_function',
            'state_effectiveness',
            'nature_work',
            'association',
            'workplace',
            'section',
            'dependence',
            'establishment',
            'payroll_statement'
        ];

        $employees = new Employee();
        foreach($filedsEmpolyees as $filed){
            $valInput = $request->post($filed);
            if($valInput != null || $valInput != ""){
                if($filed == 'name'){
                    $valueS = str_replace('*', '%', $valInput);
                    $employees = $employees->where('name','LIKE',"%{$valueS}%");
                }else{
                    $employees = Employee::where($filed,'LIKE',"{$valInput}%");
                }
            }
        }
        foreach($filedsWork as $filed){
            $valInput = $request->post($filed);
            if($valInput != null || $valInput != ""){
                $employees = $employees->whereHas('workData', function($query) use ($filed, $valInput) {
                    $query->where($filed,'LIKE',"{$valInput}%");
                });
            }
        }
        return $employees->get();
    }

    // Execl
    public function import(Request $request)
    {
        $this->authorize('import', Employee::class);
        $file = $request->file('fileUplode');
        if($file == null){
            return redirect()->back()->with('error', 'لم يتم رفع الملف بشكل صحيح');
        }

        Excel::import(new EmployeesImport, $file);

        return redirect()->route('employees.index')->with('success', 'تم رفع الملف');
    }
    public function export(Request $request)
    {
        $this->authorize('export', Employee::class);
        if($request->has('filter')){
            parse_str($request->data, $data);
            $filedsEmpolyees = [
                'name',
                'employee_id',
                'gender',
                'matrimonial_status',
                'scientific_qualification',
                'area',
            ];
            $filedsWork = [
                'working_status',
                'type_appointment',
                'field_action',
                'dual_function',
                'state_effectiveness',
                'nature_work',
                'association',
                'workplace',
                'section',
                'dependence',
                'establishment',
                'payroll_statement'
            ];
            $employees = Employee::query();
            foreach($filedsEmpolyees as $filed){
                $valInput = $data[$filed];
                if($valInput != ""){
                    $employees = Employee::where($filed,'LIKE',"%{$valInput}%");
                }
            }
            foreach($filedsWork as $filed){
                $valInput = $data[$filed];
                if($valInput != ""){
                    $employees = $employees->whereHas('workData', function($query) use ($filed, $valInput) {
                        $query->where($filed,'LIKE',"%{$valInput}%");
                    });
                }
            }
        }
        $time = Carbon::now();
        $headings = [
            'رقم الموظف',
            'اسم الموظف',
            'رقم الهوية',
            'تاريخ الميلاد',
            'العمر',
            'الجنس',
            'الحالة الزوجية',
            'عدد الزوجات',
            'عدد الأولاد',
            'عدد أولاد الجامعة',
            'المؤهل العلمي',
            'التخصص',
            'الجامعة',
            'المنطقة',
            'العنوان',
            'الإيميل',
            'رقم الهاتف',
            'العلاوة',
            'الدرجة',
            'نسبة علاوة درجة',
            'فئة الراتب',
            'تاريخ العمل',
            'تاريخ التثبيت',
            'تاريخ التقاعد',
            'حالة الدوام',
            'نوع التعين',
            'مجال العمل',
            'مزدوج وظيفة',
            'حالة الفعالية',
            'سنوات الخدمة',
            'طبيعة العمل',
            'الجمعية',
            'مكان العمل',
            'القسم',
            'التبعية',
            'المنشأة',
            'المؤسسة',
            'بيان الراتب',
            'نوع العقد',
            'عدد أيام العمل',
        ];
        $employees = $employees
                        ->join('work_data', 'work_data.employee_id', '=', 'employees.id')
                        ->select(
                            'employees.id',
                            'employees.name',
                            'employees.employee_id',
                            'employees.date_of_birth',
                            'employees.age',
                            'employees.gender',
                            'employees.matrimonial_status',
                            'employees.number_wives',
                            'employees.number_children',
                            'employees.number_university_children',
                            'employees.scientific_qualification',
                            'employees.specialization',
                            'employees.university',
                            'employees.area',
                            'employees.address',
                            'employees.email',
                            'employees.phone_number',
                            'work_data.allowance',
                            'work_data.grade',
                            'work_data.grade_allowance_ratio',
                            'work_data.salary_category',
                            'work_data.working_date',
                            'work_data.date_installation',
                            'work_data.date_retirement',
                            'work_data.working_status',
                            'work_data.type_appointment',
                            'work_data.field_action',
                            'work_data.dual_function',
                            'work_data.state_effectiveness',
                            'work_data.years_service',
                            'work_data.nature_work',
                            'work_data.association',
                            'work_data.workplace',
                            'work_data.section',
                            'work_data.dependence',
                            'work_data.establishment',
                            'work_data.foundation_E',
                            'work_data.payroll_statement',
                            'work_data.contract_type',
                            'work_data.number_working_days',
                        )
                        ->get();


        $filename = 'سجلات الموظفين' . $time .'.xlsx';
        return Excel::download(new ModelExport($employees,$headings), $filename);
    }
    // PDF Export
    public function viewPDF(Request $request)
    {
        if($request->has('filter')){
            parse_str( $request->data, $data);
            $filedsEmpolyees = [
                'name',
                'employee_id',
                'gender',
                'matrimonial_status',
                'scientific_qualification',
                'area',
            ];
            $filedsWork = [
                'working_status',
                'type_appointment',
                'field_action',
                'dual_function',
                'state_effectiveness',
                'nature_work',
                'association',
                'workplace',
                'section',
                'dependence',
                'establishment',
                'payroll_statement'
            ];
            $employees = new Employee();
            foreach($filedsEmpolyees as $filed){
                $valInput = $data[$filed];
                if($valInput != ""){
                    $employees = Employee::where($filed,'LIKE',"%{$valInput}%");
                }
            }
            foreach($filedsWork as $filed){
                $valInput = $data[$filed];
                if($valInput != ""){
                    $employees = $employees->whereHas('workData', function($query) use ($filed, $valInput) {
                        $query->where($filed,'LIKE',"%{$valInput}%");
                    });
                }
            }
            session()->put('employees', $employees->get());
            return "filter Done";
        }
        $this->authorize('export', Employee::class);
        $pdf = PDF::loadView('dashboard.pdf.employees',['employees' =>  session('employees')]);
        session()->remove('employees');
        return $pdf->stream();
    }
}
