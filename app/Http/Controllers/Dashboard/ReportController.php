<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\EmployeesDataExport;
use App\Exports\ModelExport;
use App\Http\Controllers\Controller;
use App\Models\BanksEmployees;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\FixedEntries;
use App\Models\ReceivablesLoans;
use App\Models\Salary;
use App\Models\WorkData;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use App\Models\Bank;
use App\Models\Exchange;
use Illuminate\Support\Facades\DB;
use App\Models\LogRecord;

class ReportController extends Controller
{

    use AuthorizesRequests;
    protected $monthNameAr;

    public function __construct(){
        // مصفوفة لأسماء الأشهر باللغة العربية
        $this->monthNameAr = [
            '01' => 'يناير',
            '02' => 'فبراير',
            '03' => 'مارس',
            '04' => 'أبريل',
            '05' => 'مايو',
            '06' => 'يونيو',
            '07' => 'يوليو',
            '08' => 'أغسطس',
            '09' => 'سبتمبر',
            '10' => 'أكتوبر',
            '11' => 'نوفمبر',
            '12' => 'ديسمبر'
        ];
    }

    public function filterEmployees($data){
        $employees = Employee::query();
        if(isset($data["scientific_qualification"])){
            $employees = $employees->whereIn("scientific_qualification",$data["scientific_qualification"]);
        }
        if(isset($data["area"])){
            $employees = $employees->whereIn("area",$data["area"]);
        }
        if(isset($data["gender"])){
            foreach($data["gender"] as $gender){
                $employees = $employees->whereIn("gender",$gender);
            }
        }
        if(isset($data["matrimonial_status"])){
            foreach($data["matrimonial_status"] as $matrimonial_status){
                $employees = $employees->whereIn("matrimonial_status",$matrimonial_status);
            }
        }
        if(isset($data["working_status"])){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->whereIn('working_status',$data["working_status"]);
            });
        }
        if(isset($data["type_appointment"])){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->whereIn('type_appointment',$data["type_appointment"]);
            });
        }
        if(isset($data["field_action"])){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->whereIn("field_action",$data["field_action"]);
            });
        }
        if(isset($data["dual_function"])){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->whereIn('dual_function',$data["dual_function"]);
            });
        }
        if(isset($data["state_effectiveness"])){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->whereIn('state_effectiveness',$data["state_effectiveness"]);
            });
        }
        if(isset($data["nature_work"])){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->whereIn('nature_work',$data["nature_work"]);
            });
        }
        if(isset($data["association"])){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->whereIn('association',$data["association"]);
            });
        }
        if(isset($data["workplace"])){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->whereIn('workplace',$data["workplace"]);
            });
        }
        if(isset($data["section"])){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->whereIn('section',$data["section"]);
            });
        }
        if(isset($data["dependence"])){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->whereIn('dependence',$data["dependence"]);
            });
        }
        if(isset($data["establishment"])){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->whereIn('establishment',$data["establishment"]);
            });
        }
        if(isset($data["payroll_statement"])){
            $employees = $employees->whereHas('workData', function($query) use ($data) {
                $query->whereIn('payroll_statement',$data["payroll_statement"]);
            });
        }
        return $employees;
    }

    public function index(){
        $this->authorize('report.view');
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
        $banksId = BanksEmployees::select('bank_id')->distinct()->pluck('bank_id')->toArray();
        $banks = Bank::select('name')->distinct()->pluck('name')->toArray();
        $month = Carbon::now()->format('Y-m');

        return view('dashboard.report',compact("areas","working_status","nature_work","type_appointment","field_action","matrimonial_status","scientific_qualification","state_effectiveness","association","workplace","section","dependence","establishment","payroll_statement",'month','banks'));
    }


    public function export(Request $request){
        $time = Carbon::now();
        $employees = $this->filterEmployees($request->all())->get();
        if($request->employee_id != null){
            $employees = Employee::where('id',$request->employee_id)->get();
        }
        if($request->report_type == 'employees'){
            if($request->export_type == 'view'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.employees',['employees' =>  $employees,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->stream();
            }
            if($request->export_type == 'export_pdf'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.employees',['employees' =>  $employees,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->download('سجلات الموظفين' . $time .'.pdf');
            }
            if($request->export_type == 'export_excel'){
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
                $employees = $this->filterEmployees($request->all())
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
        }
        // الرواتب
        if($request->report_type == 'salaries'){
            $USD = Currency::where('code', 'USD')->first()->value;
            $month = $request->month ?? Carbon::now()->format('Y-m');

            $employees = $this->filterEmployees($request->all())->get();
            $salaries = Salary::whereIn('employee_id', $employees->pluck('id'))
                ->where('month', $month)
                ->get();

            // دوال الموجوع اخر سطر في التقرير
            $salariesTotal = collect($salaries)->map(function ($salary) use ($month) {
                $fixedEntries = $salary->employee->fixedEntries->where('month',$month)->first();
                return [
                    "secondary_salary" => $salary->secondary_salary ?? '0',
                    'allowance_boys' => $salary->allowance_boys ?? '0',
                    'nature_work_increase' => $salary->nature_work_increase ?? '0',
                    'administrative_allowance' => $fixedEntries->administrative_allowance ?? '0',
                    'scientific_qualification_allowance' => $fixedEntries->scientific_qualification_allowance ?? '0',
                    'transport' => $fixedEntries->transport ?? '0',
                    'extra_allowance' => $fixedEntries->extra_allowance ?? '0',
                    'salary_allowance' => $fixedEntries->salary_allowance ?? '0',
                    'ex_addition' => $fixedEntries->ex_addition ?? '0',
                    'mobile_allowance' => $fixedEntries->mobile_allowance ?? '0',
                    'termination_service' => $salary->termination_service ?? '0',
                    "gross_salary" => $salary->gross_salary?? 0,
                    'health_insurance' => $fixedEntries->health_insurance ?? '0',
                    'z_Income' => $salary->z_Income ?? '0',
                    'savings_rate' => $fixedEntries->savings_rate ?? '0',
                    'association_loan' => $fixedEntries->association_loan ?? '0',
                    'savings_loan' => $fixedEntries->savings_loan ?? '0',
                    'shekel_loan' => $fixedEntries->shekel_loan ?? '0',
                    'late_receivables' => $salary->late_receivables ?? '0',
                    'total_discounts' => $salary->total_discounts ?? '0',
                    'net_salary' => $salary->net_salary ?? '0',
                ];
            });
            $salariesTotalArray = [
                'secondary_salary' => collect($salariesTotal->pluck('secondary_salary')->toArray())->sum(),
                'allowance_boys' => collect($salariesTotal->pluck('allowance_boys')->toArray())->sum(),
                'nature_work_increase' => collect($salariesTotal->pluck('nature_work_increase')->toArray())->sum(),
                'administrative_allowance' => collect($salariesTotal->pluck('administrative_allowance')->toArray())->sum(),
                'scientific_qualification_allowance' => collect($salariesTotal->pluck('scientific_qualification_allowance')->toArray())->sum(),
                'transport' => collect($salariesTotal->pluck('transport')->toArray())->sum(),
                'extra_allowance' => collect($salariesTotal->pluck('extra_allowance')->toArray())->sum(),
                'salary_allowance' => collect($salariesTotal->pluck('salary_allowance')->toArray())->sum(),
                'ex_addition' => collect($salariesTotal->pluck('ex_addition')->toArray())->sum(),
                'mobile_allowance' => collect($salariesTotal->pluck('mobile_allowance')->toArray())->sum(),
                'termination_service' => collect($salariesTotal->pluck('termination_service')->toArray())->sum(),
                'gross_salary' => collect($salariesTotal->pluck('gross_salary')->toArray())->sum(),
                'health_insurance' => collect($salariesTotal->pluck('health_insurance')->toArray())->sum(),
                'z_Income' => collect($salariesTotal->pluck('z_Income')->toArray())->sum(),
                'savings_rate' => collect($salariesTotal->pluck('savings_rate')->toArray())->sum(),
                'association_loan' => collect($salariesTotal->pluck('association_loan')->toArray())->sum(),
                'savings_loan' => collect($salariesTotal->pluck('savings_loan')->toArray())->sum(),
                'shekel_loan' => collect($salariesTotal->pluck('shekel_loan')->toArray())->sum(),
                'late_receivables' => collect($salariesTotal->pluck('late_receivables')->toArray())->sum(),
                'total_discounts' => collect($salariesTotal->pluck('total_discounts')->toArray())->sum(),
                'net_salary' => collect($salariesTotal->pluck('net_salary')->toArray())->sum(),
            ];

            if($request->export_type == 'view'){
                $pdf = PDF::loadView('dashboard.pdf.salaries',['salaries' =>  $salaries,'salariesTotalArray' => $salariesTotalArray,'month' => $request->month,'USD' => $USD,'filter' => $request->all()],[],
                [
                    'mode' => 'utf-8',
                    'format' => 'A4-L',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->stream();
            }
            if($request->export_type == 'export_pdf'){
                $pdf = PDF::loadView('dashboard.pdf.salaries',['salaries' =>  $salaries,'salariesTotalArray' => $salariesTotalArray,'month' => $request->month,'USD' => $USD,'filter' => $request->all()],[],
                [
                    'mode' => 'utf-8',
                    'format' => 'A4-L',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->download('سجلات رواتب الموظفين' . $time .'.pdf');
            }
            if($request->export_type == 'export_excel'){
                $headings = [
                    'الاسم',
                    'الشهر',
                    'مكان العمل',
                    'نوع التعين',
                    'الراتب الاساسي',
                    'علاوة الأولاد',
                    'علاوة طبيعة العمل',
                    'علاوة إدارية',
                    'علاوة مؤهل علمي',
                    'المواصلات',
                    'بدل إضافي +-',
                    'علاوة أغراض راتب',
                    'إضافة بأثر رجعي',
                    'علاوة جوال',
                    'نهاية الخدمة',
                    'إجمالي الراتب',
                    'تأمين صحي',
                    'ض.دخل',
                    'إدخار 5%',
                    'قرض الجمعية',
                    'قرض الإدخار',
                    'قرض شيكل',
                    'مستحقات متأخرة',
                    'إجمالي الخصومات',
                    'صافي الراتب'
                ];

                $salaries = Salary::whereIn('salaries.employee_id', $employees->pluck('id'))
                                ->where('salaries.month', $month)
                                ->join('employees', 'salaries.employee_id', '=', 'employees.id')
                                ->join('work_data as workData', 'employees.id', '=', 'workData.employee_id')
                                ->leftJoin('fixed_entries as fixedEntries', function ($join) use ($month) {
                                    $join->on('employees.id', '=', 'fixedEntries.employee_id')
                                        ->where('fixedEntries.month', $month);
                                })
                                ->select(
                                    'employees.name',
                                    'salaries.month',
                                    'workData.workplace',
                                    'workData.type_appointment',
                                    'salaries.secondary_salary',
                                    'salaries.allowance_boys',
                                    'salaries.nature_work_increase',
                                    DB::raw('COALESCE(fixedEntries.administrative_allowance, 0) as administrative_allowance'),
                                    DB::raw('COALESCE(fixedEntries.scientific_qualification_allowance, 0) as scientific_qualification_allowance'),
                                    DB::raw('COALESCE(fixedEntries.transport, 0) as transport'),
                                    DB::raw('COALESCE(fixedEntries.extra_allowance, 0) as extra_allowance'),
                                    DB::raw('COALESCE(fixedEntries.salary_allowance, 0) as salary_allowance'),
                                    DB::raw('COALESCE(fixedEntries.ex_addition, 0) as ex_addition'),
                                    DB::raw('COALESCE(fixedEntries.mobile_allowance, 0) as mobile_allowance'),
                                    'salaries.termination_service',
                                    'salaries.gross_salary',
                                    DB::raw('COALESCE(fixedEntries.health_insurance, 0) as health_insurance'),
                                    'salaries.z_Income',
                                    DB::raw('COALESCE(fixedEntries.savings_rate, 0) as savings_rate'),
                                    DB::raw('COALESCE(fixedEntries.association_loan, 0) as association_loan'),
                                    DB::raw('COALESCE(fixedEntries.savings_loan, 0) as savings_loan'),
                                    DB::raw('COALESCE(fixedEntries.shekel_loan, 0) as shekel_loan'),
                                    'salaries.late_receivables',
                                    'salaries.total_discounts',
                                    'salaries.net_salary'
                                )
                                ->orderBy('employees.name', 'asc')
                                ->get();

                $filename = 'سجلات رواتب الموظفين' . $time .'.xlsx';
                return Excel::download(new ModelExport($salaries,$headings), $filename);
            }
        }

        // حسابات الموظفين في البنوك
        if($request->report_type == 'accounts'){
            $accounts = BanksEmployees::whereIn('employee_id', $employees->pluck('id'))->get();
            // معاينة pdf
            if($request->export_type == 'view'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.accounts',['accounts' =>  $accounts,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->stream();
            }
            // تحميل الملف المصدر
            if($request->export_type == 'export_pdf'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.accounts',['accounts' =>  $accounts,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->download('سجلات حسابات الموظفين في البنوك' . $time .'.pdf');
            }
            if($request->export_type == 'export_excel'){
                $headings = [
                    'اسم الموظف',
                    'اسم البنك',
                    'الفرع',
                    'رقم الفرع',
                    'رقم الحساب',
                    'أساسي؟',
                ];
                $accounts = BanksEmployees::whereIn('banks_employees.employee_id', $employees->pluck('id'))
                            ->join('employees', 'banks_employees.employee_id', '=', 'employees.id')
                            ->join('banks', 'banks_employees.bank_id', '=', 'banks.id')
                            ->select('employees.name as employee_name','banks.name as bank_name','banks.branch as branch_name','banks.branch_number as branch_number','banks_employees.account_number','banks_employees.default')
                            ->get();


                $filename = 'كشف حسابات الموظفين_' . $time .'.xlsx';
                return Excel::download(new ModelExport($accounts,$headings), $filename);
            }
        }

        // سجلات لمستحقات وقروض الموظفين
        if($request->report_type == 'employees_totals'){
            $totals = ReceivablesLoans::whereIn('employee_id', $employees->pluck('id'))->get();
            // دوال الموجوع اخر سطر في التقرير
            $totalsFooter = collect($totals)->map(function ($total)  {
                return [
                    'total_receivables' => $total->total_receivables ?? '0',
                    'total_savings' => $total->total_savings ?? '0',
                    'total_association_loan' => $total->total_association_loan ?? '0',
                    'total_shekel_loan' => $total->total_shekel_loan ?? '0',
                    'total_savings_loan' => $total->total_savings_loan ?? '0',
                ];
            });
            $totalsFooterArray = [
                'total_receivables' => number_format(collect($totalsFooter->pluck('total_receivables')->toArray())->sum(), 2, '.', ','),
                'total_savings' => number_format(collect($totalsFooter->pluck('total_savings')->toArray())->sum(), 2, '.', ','),
                'total_association_loan' => number_format(collect($totalsFooter->pluck('total_association_loan')->toArray())->sum(), 2, '.', ','),
                'total_shekel_loan' => number_format(collect($totalsFooter->pluck('total_shekel_loan')->toArray())->sum(), 2, '.', ','),
                'total_savings_loan' => number_format(collect($totalsFooter->pluck('total_savings_loan')->toArray())->sum(), 2, '.', ','),
            ];
            // معاينة pdf
            if($request->export_type == 'view'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.totals',['totals' =>  $totals,'filter' => $request->all(),'totalsFooterArray' => $totalsFooterArray],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->stream();
            }
            // تحميل الملف المصدر
            if($request->export_type == 'export_pdf'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.totals',['totals' =>  $totals,'filter' => $request->all(),'totalsFooterArray' => $totalsFooterArray],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->download('سجلات لمستحقات وقروض الموظفين' . $time .'.pdf');
            }
            if($request->export_type == 'export_excel'){
                $headings = [
                    'اسم الموظف',
                    'إجمالي المستحقات',
                    'إجمالي الإدخارات $',
                    'إجمالي قرض الجمعية',
                    'إجمالي قرض الإدخار$',
                    'إجمالي قرض اللجنة (الشيكل)',
                ];
                $totals = ReceivablesLoans::whereIn('totals.employee_id', $employees->pluck('id'))
                            ->join('employees', 'totals.employee_id', '=', 'employees.id')
                            ->select('employees.name as employee_name','totals.total_receivables','totals.total_savings','totals.total_association_loan','totals.total_shekel_loan','totals.total_savings_loan')
                            ->get();

                $filename = 'كشف المستحقات والقروض_' . $time .'.xlsx';
                return Excel::download(new ModelExport($totals,$headings), $filename);
            }
        }

        // التعديلات للموظفين
        if($request->report_type == 'employees_fixed'){
            $month = $request->month ?? Carbon::now()->format('Y-m');
            $fixed_entries = FixedEntries::whereIn('employee_id', $employees->pluck('id'))
                ->where('month', $month)
                ->get();

            // دوال الموجوع اخر سطر في التقرير
            $fixedEntriesTotals = collect($fixed_entries)->map(function ($fixedEntry)  {
                return [
                    'administrative_allowance' => $fixedEntry->administrative_allowance ?? '0',
                    'scientific_qualification_allowance'=> $fixedEntry->scientific_qualification_allowance ??'0',
                    'transport'=> $fixedEntry->transport ?? '0',
                    'extra_allowance'=> $fixedEntry->extra_allowance ?? '0',
                    'salary_allowance'=> $fixedEntry->salary_allowance ?? '0',
                    'ex_addition'=> $fixedEntry->ex_addition ?? '0',
                    'mobile_allowance'=> $fixedEntry->mobile_allowance ?? '0',
                    'health_insurance'=> $fixedEntry->health_insurance ?? '0',
                    'f_Oredo'=> $fixedEntry->f_Oredo ?? '0',
                    'association_loan'=> $fixedEntry->association_loan ?? '0',
                    'tuition_fees'=> $fixedEntry->tuition_fees ?? '0',
                    'voluntary_contributions'=> $fixedEntry->voluntary_contributions ?? '0',
                    'savings_loan'=> $fixedEntry->savings_loan ?? '0',
                    'shekel_loan'=> $fixedEntry->shekel_loan ?? '0',
                    'paradise_discount'=> $fixedEntry->paradise_discount ?? '0',
                    'other_discounts'=> $fixedEntry->other_discounts ?? '0',
                    'proportion_voluntary'=> $fixedEntry->proportion_voluntary ?? '0',
                    'savings_rate'=> $fixedEntry->savings_rate ?? '0',
                ];
            });
            $fixedEntriesTotalsArray = [
                'administrative_allowance' => number_format(collect($fixedEntriesTotals->pluck('administrative_allowance')->toArray())->sum(), 2, '.', ','),
                'scientific_qualification_allowance'=> number_format(collect($fixedEntriesTotals->pluck('scientific_qualification_allowance')->toArray())->sum(), 2, '.', ','),
                'transport'=> number_format(collect($fixedEntriesTotals->pluck('transport')->toArray())->sum(), 2, '.', ','),
                'extra_allowance'=> number_format(collect($fixedEntriesTotals->pluck('extra_allowance')->toArray())->sum(), 2, '.', ','),
                'salary_allowance'=> number_format(collect($fixedEntriesTotals->pluck('salary_allowance')->toArray())->sum(), 2, '.', ','),
                'ex_addition'=> number_format(collect($fixedEntriesTotals->pluck('ex_addition')->toArray())->sum(), 2, '.', ','),
                'mobile_allowance'=> number_format(collect($fixedEntriesTotals->pluck('mobile_allowance')->toArray())->sum(), 2, '.', ','),
                'health_insurance'=> number_format(collect($fixedEntriesTotals->pluck('health_insurance')->toArray())->sum(), 2, '.', ','),
                'f_Oredo'=> number_format(collect($fixedEntriesTotals->pluck('f_Oredo')->toArray())->sum(), 2, '.', ','),
                'association_loan'=> number_format(collect($fixedEntriesTotals->pluck('association_loan')->toArray())->sum(), 2, '.', ','),
                'tuition_fees'=> number_format(collect($fixedEntriesTotals->pluck('tuition_fees')->toArray())->sum(), 2, '.', ','),
                'voluntary_contributions'=> number_format(collect($fixedEntriesTotals->pluck('voluntary_contributions')->toArray())->sum(), 2, '.', ','),
                'savings_loan'=> number_format(collect($fixedEntriesTotals->pluck('savings_loan')->toArray())->sum(), 2, '.', ','),
                'shekel_loan'=> number_format(collect($fixedEntriesTotals->pluck('shekel_loan')->toArray())->sum(), 2, '.', ','),
                'paradise_discount'=> number_format(collect($fixedEntriesTotals->pluck('paradise_discount')->toArray())->sum(), 2, '.', ','),
                'other_discounts'=> number_format(collect($fixedEntriesTotals->pluck('other_discounts')->toArray())->sum(), 2, '.', ','),
                'proportion_voluntary'=> number_format(collect($fixedEntriesTotals->pluck('proportion_voluntary')->toArray())->sum(), 2, '.', ','),
                'savings_rate'=> number_format(collect($fixedEntriesTotals->pluck('savings_rate')->toArray())->sum(), 2, '.', ','),
            ];
            // معاينة pdf
            if($request->export_type == 'view'){
                $pdf = PDF::loadView('dashboard.pdf.fixed_entries',['fixed_entries' =>  $fixed_entries,'filter' => $request->all(),'month' => $month,'fixedEntriesTotalsArray' => $fixedEntriesTotalsArray],[],[
                    'mode' => 'utf-8',
                    'format' => 'A4-L',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->stream();
            }

            // تحميل الملف المصدر
            if($request->export_type == 'export_pdf'){
                $pdf = PDF::loadView('dashboard.pdf.fixed_entries',['fixed_entries' =>  $fixed_entries,'filter' => $request->all(),'month' => $month,'fixedEntriesTotalsArray' => $fixedEntriesTotalsArray],[],[
                    'mode' => 'utf-8',
                    'format' => 'A4-L',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->download('سجلات التعديلات_' . $time .'.pdf');
            }
            if($request->export_type == 'export_excel'){
                $headings = [
                    'اسم الموظف',
                    'الشهر',
                    'علاوة إدارية',
                    'علاوة مؤهل علمي',
                    'مواصلات',
                    'بدل إضافي',
                    'علاوة اغراض راتب',
                    'إضافة بأثر رجعي',
                    'علاوة جوال',
                    'تأمين صحي',
                    'فاتورة وطنية',
                    'قرض الجمعية',
                    'رسوم دراسية',
                    'تبرعات',
                    'قرض إدخار',
                    'قرض شيكل',
                    'خصم اللجنة',
                    'خصومات أخرى',
                    'تبرعات الحركة',
                    'إدخار 5%',
                ];

                $fixed_entries = FixedEntries::whereIn('fixed_entries.employee_id', $employees->pluck('id'))
                            ->where('fixed_entries.month', $month)
                            ->join('employees', 'fixed_entries.employee_id', '=', 'employees.id')
                            ->select('employees.name as employee_name','fixed_entries.month','fixed_entries.administrative_allowance','fixed_entries.scientific_qualification_allowance','fixed_entries.transport','fixed_entries.extra_allowance','fixed_entries.salary_allowance','fixed_entries.ex_addition','fixed_entries.mobile_allowance','fixed_entries.health_insurance','fixed_entries.f_Oredo','fixed_entries.association_loan','fixed_entries.tuition_fees','fixed_entries.voluntary_contributions','fixed_entries.savings_loan','fixed_entries.shekel_loan','fixed_entries.paradise_discount','fixed_entries.other_discounts','fixed_entries.proportion_voluntary','fixed_entries.savings_rate')
                            ->get();
                $filename = 'كشف التعديلات_' . $time .'.xlsx';
                return Excel::download(new ModelExport($fixed_entries,$headings), $filename);
            }
        }

        // كشف البنك
        if($request->report_type == 'bank'){
            $USD = Currency::where('code', 'USD')->first()->value ?? null;
            $month = $request->month ?? Carbon::now()->format('Y-m');

            $monthName = $this->monthNameAr[Carbon::parse($month)->format('m')];
            $salaries = Salary::whereIn('employee_id', $employees->pluck('id'))
                    ->where('month', $month);
                    if($request->bank != null){
                        $salaries = $salaries->where('bank', $request->bank);
                    }
            $salaries = $salaries->get();

            // دوال الموجوع اخر سطر في التقرير
            $salariesTotal = collect($salaries)->map(function ($salary) use ($month) {
                $fixedEntries = $salary->employee->fixedEntries->where('month',$month)->first();
                return [
                    'net_salary' => $salary->net_salary ?? '0',
                ];
            });
            $salariesTotalArray = [
                'net_salary' => collect($salariesTotal->pluck('net_salary')->toArray())->sum(),
            ];

            // معاينة pdf
            if($request->export_type == 'view'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.bank',['salaries' =>  $salaries,'salariesTotalArray' => $salariesTotalArray,'month' => $month,'monthName' => $monthName,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->stream();
            }
            // تحميل الملف المصدر
            if($request->export_type == 'export_pdf'){
                $margin_top = 3;
                if($request->association != ""){
                    $margin_top = 50;
                }
                if($request->association == "الكويتي" || $request->association == "يتيم"){
                    $margin_top = 35;
                }
                $pdf = PDF::loadView('dashboard.pdf.bank',['salaries' =>  $salaries,'salariesTotalArray' => $salariesTotalArray,'month' => $month,'monthName' => $monthName,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->download('كشف الصرف_' . $time .'.pdf');
            }

            if($request->export_type == 'export_excel'){
                if ($request->exchange_type == 'cash') {
                    $headings = [
                        'مكان العمل',
                        'رقم الهوية',
                        'السكن',
                        'الاسم',
                        'صافي الراتب',
                        'التوقيع'
                    ];

                    $salaries = Salary::whereIn('salaries.employee_id', $employees->pluck('id'))
                                ->where('salaries.month', $month)
                                ->join('employees', 'salaries.employee_id', '=', 'employees.id')
                                ->join('work_data', 'salaries.employee_id', '=', 'work_data.employee_id')
                                ->select('work_data.workplace as employee_workplace','employees.employee_id as employee_id','employees.area as employee_area','employees.name as employee_name','salaries.net_salary')
                                ->get();
                }
                if ($request->exchange_type == 'bank') {
                    $headings = [
                        'مكان العمل',
                        'البنك',
                        'رقم الهوية',
                        'السكن',
                        'الاسم',
                        'رقم الحساب',
                        'رقم الفرع',
                        'صافي الراتب',
                        'التوقيع'
                    ];

                    $salaries = Salary::whereIn('salaries.employee_id', $employees->pluck('id'))
                                ->where('salaries.month', $month)
                                ->join('employees', 'salaries.employee_id', '=', 'employees.id')
                                ->join('work_data', 'salaries.employee_id', '=', 'work_data.employee_id')
                                ->select('work_data.workplace as employee_workplace','salaries.bank','employees.employee_id as employee_id','employees.area as employee_area','employees.name as employee_name','salaries.account_number','salaries.branch_number','salaries.net_salary')
                                ->get();
                }


                $filename = 'كشف الصرف_' . $time .'.xlsx';
                return Excel::download(new ModelExport($salaries,$headings), $filename);
            }
        }

        // التخصيصات
        if($request->report_type == 'customization'){
            $USD = Currency::where('code', 'USD')->first()->value ?? null;
            $month = $request->month ?? Carbon::now()->format('Y-m');

            $workplaces = Workdata::select('association', 'field_action', 'workplace');
            if(isset($request->association)){
                $workplaces = $workplaces->whereIn('association', $request->association);
            }
            if(isset($request->field_action)){
                $workplaces =  $workplaces->whereIn('field_action', $request->field_action);
            }
            if(isset($request->workplace)){
                $workplaces = $workplaces->whereIn('workplace', $request->workplace);
            }

            $workplaces = $workplaces->orderBy('association')
                ->orderBy('field_action')
                ->orderBy('workplace')
                ->distinct()
                ->get();

            $salaries = Salary::whereIn('salaries.employee_id', $employees->pluck('id'))
                                ->where('salaries.month', $month)
                                ->join('employees', 'salaries.employee_id', '=', 'employees.id')
                                ->join('work_data', 'salaries.employee_id', '=', 'work_data.employee_id')
                                ->select('salaries.*','employees.*','work_data.*')
                                ->get();

            // دوال الموجوع اخر سطر في التقرير
            $salariesTotal = collect($salaries)->map(function ($salary) use ($month) {
                $fixedEntries = $salary->employee->fixedEntries->where('month',$month)->first();
                return [
                    "secondary_salary" => $salary->secondary_salary ?? '0',
                    'allowance_boys' => $salary->allowance_boys ?? '0',
                    'nature_work_increase' => $salary->nature_work_increase ?? '0',
                    'administrative_allowance' => $fixedEntries->administrative_allowance ?? '0',
                    'scientific_qualification_allowance' => $fixedEntries->scientific_qualification_allowance ?? '0',
                    'transport' => $fixedEntries->transport ?? '0',
                    'extra_allowance' => $fixedEntries->extra_allowance ?? '0',
                    'salary_allowance' => $fixedEntries->salary_allowance ?? '0',
                    'ex_addition' => $fixedEntries->ex_addition ?? '0',
                    'mobile_allowance' => $fixedEntries->mobile_allowance ?? '0',
                    'termination_service' => $salary->termination_service ?? '0',
                    "gross_salary" => $salary->gross_salary?? 0,
                    'health_insurance' => $fixedEntries->health_insurance ?? '0',
                    'z_Income' => $salary->z_Income ?? '0',
                    'savings_rate' => $fixedEntries->savings_rate ?? '0',
                    'association_loan' => $fixedEntries->association_loan ?? '0',
                    'savings_loan' => $fixedEntries->savings_loan ?? '0',
                    'shekel_loan' => $fixedEntries->shekel_loan ?? '0',
                    'late_receivables' => $salary->late_receivables ?? '0',
                    'total_discounts' => $salary->total_discounts ?? '0',
                    'net_salary' => $salary->net_salary ?? '0',
                ];
            });
            $salariesTotalArray = [
                'secondary_salary' => collect($salariesTotal->pluck('secondary_salary')->toArray())->sum(),
                'allowance_boys' => collect($salariesTotal->pluck('allowance_boys')->toArray())->sum(),
                'nature_work_increase' => collect($salariesTotal->pluck('nature_work_increase')->toArray())->sum(),
                'administrative_allowance' => collect($salariesTotal->pluck('administrative_allowance')->toArray())->sum(),
                'scientific_qualification_allowance' => collect($salariesTotal->pluck('scientific_qualification_allowance')->toArray())->sum(),
                'transport' => collect($salariesTotal->pluck('transport')->toArray())->sum(),
                'extra_allowance' => collect($salariesTotal->pluck('extra_allowance')->toArray())->sum(),
                'salary_allowance' => collect($salariesTotal->pluck('salary_allowance')->toArray())->sum(),
                'ex_addition' => collect($salariesTotal->pluck('ex_addition')->toArray())->sum(),
                'mobile_allowance' => collect($salariesTotal->pluck('mobile_allowance')->toArray())->sum(),
                'termination_service' => collect($salariesTotal->pluck('termination_service')->toArray())->sum(),
                'gross_salary' => collect($salariesTotal->pluck('gross_salary')->toArray())->sum(),
                'health_insurance' => collect($salariesTotal->pluck('health_insurance')->toArray())->sum(),
                'z_Income' => collect($salariesTotal->pluck('z_Income')->toArray())->sum(),
                'savings_rate' => collect($salariesTotal->pluck('savings_rate')->toArray())->sum(),
                'association_loan' => collect($salariesTotal->pluck('association_loan')->toArray())->sum(),
                'savings_loan' => collect($salariesTotal->pluck('savings_loan')->toArray())->sum(),
                'shekel_loan' => collect($salariesTotal->pluck('shekel_loan')->toArray())->sum(),
                'late_receivables' => collect($salariesTotal->pluck('late_receivables')->toArray())->sum(),
                'total_discounts' => collect($salariesTotal->pluck('total_discounts')->toArray())->sum(),
                'net_salary' => collect($salariesTotal->pluck('net_salary')->toArray())->sum(),
            ];

            $margin_top = 3;
            if($request->association != ""){
                $margin_top = 50;
            }
            if($request->association == "الكويتي" || $request->association == "يتيم"){
                $margin_top = 35;
            }
            if($request->export_type == 'view'){
                $pdf = PDF::loadView('dashboard.pdf.customization',['salaries' =>  $salaries,'salariesTotalArray' => $salariesTotalArray,'workplaces' => $workplaces,'month' => $request->month,'USD' => $USD,'filter' => $request->all()],[],
                [
                    'mode' => 'utf-8',
                    'default_font' => 'Arial',
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10
                ]);
                return $pdf->stream();
            }
        }




        // كشف حساب للموظف
        if($request->report_type == 'employee_accounts'){
            $USD = Currency::where('code', 'USD')->first()->value ?? null;
            $month = $request->month ?? Carbon::now()->format('Y-m');
            $to_month = $request->to_month ?? Carbon::now()->format('Y-m');
            $monthName = $this->monthNameAr[Carbon::parse($month)->format('m')];

            $salaries = Salary::whereIn('employee_id', $employees->pluck('id'))
                        ->whereBetween('month', [$month, $to_month])
                        ->get();


            // دوال الموجوع اخر سطر في التقرير
            $salariesTotal = collect($salaries)->map(function ($salary) use ($month) {
                return [
                    'net_salary' => $salary->net_salary ?? '0',
                ];
            });
            $salariesTotalArray = [
                'net_salary' => collect($salariesTotal->pluck('net_salary')->toArray())->sum(),
            ];

            $months = Salary::whereIn('employee_id', $employees->pluck('id'))
                ->whereBetween('month', [$month, $to_month])
                ->distinct()
                ->pluck('month');

            $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endOfMonth = Carbon::createFromFormat('Y-m', $to_month)->endOfMonth();

            $exchanges = Exchange::whereIn('employee_id', $employees->pluck('id'))
                                ->whereBetween('discount_date', [$startOfMonth, $endOfMonth])
                                ->get();
            // معاينة pdf
            if($request->export_type == 'view' || $request->export_type == 'export_excel'){
                $margin_top = 3;
                $pdf = PDF::loadView('dashboard.pdf.employee.employee_accounts',['employee' =>  $employees->first(),'salaries' =>  $salaries,'salariesTotalArray' => $salariesTotalArray,'exchanges' => $exchanges,'month' => $month,'to_month' => $to_month,'months' => $months,'monthName' => $monthName,'USD' => $USD,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10,
                ]);
                return $pdf->stream();
            }
            // تحميل الملف المصدر
            if($request->export_type == 'export_pdf'){
                $margin_top = 3;
                $pdf = PDF::loadView('dashboard.pdf.employee.employee_accounts',['employee' =>  $employees->first(),'salaries' =>  $salaries,'salariesTotalArray' => $salariesTotalArray,'exchanges' => $exchanges,'month' => $month,'to_month' => $to_month,'months' => $months,'monthName' => $monthName,'USD' => $USD,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10,
                ]);
                return $pdf->download('كشف حساب للموظف' . ' - ' . $employees->first()->name  . ' - ' .  $time .'.pdf');
            }
        }
        // كشف رواتب للموظف
        if($request->report_type == 'employee_salaries'){
            $USD = Currency::where('code', 'USD')->first()->value ?? null;
            $month = $request->month ?? Carbon::now()->format('Y-m');
            $to_month = $request->to_month ?? Carbon::now()->format('Y-m');
            $monthName = $this->monthNameAr[Carbon::parse($month)->format('m')];

            $salaries = Salary::whereIn('employee_id', $employees->pluck('id'))
                        ->whereBetween('month', [$month, $to_month])
                        ->get();

            // دوال الموجوع اخر سطر في التقرير
            $salariesTotal = collect($salaries)->map(function ($salary) use ($month) {
                $fixedEntries = $salary->employee->fixedEntries->where('month',$salary->month)->first();
                return [
                    "secondary_salary" => $salary->secondary_salary ?? '0',
                    'allowance_boys' => $salary->allowance_boys ?? '0',
                    'nature_work_increase' => $salary->nature_work_increase ?? '0',
                    'administrative_allowance' => $fixedEntries->administrative_allowance ?? '0',
                    'scientific_qualification_allowance' => $fixedEntries->scientific_qualification_allowance ?? '0',
                    'transport' => $fixedEntries->transport ?? '0',
                    'extra_allowance' => $fixedEntries->extra_allowance ?? '0',
                    'salary_allowance' => $fixedEntries->salary_allowance ?? '0',
                    'ex_addition' => $fixedEntries->ex_addition ?? '0',
                    'mobile_allowance' => $fixedEntries->mobile_allowance ?? '0',
                    'termination_service' => $salary->termination_service ?? '0',
                    "gross_salary" => $salary->gross_salary?? 0,
                    'health_insurance' => $fixedEntries->health_insurance ?? '0',
                    'z_Income' => $salary->z_Income ?? '0',
                    'savings_rate' => $fixedEntries->savings_rate ?? '0',
                    'association_loan' => $fixedEntries->association_loan ?? '0',
                    'savings_loan' => $fixedEntries->savings_loan ?? '0',
                    'shekel_loan' => $fixedEntries->shekel_loan ?? '0',
                    'late_receivables' => $salary->late_receivables ?? '0',
                    'total_discounts' => $salary->total_discounts ?? '0',
                    'net_salary' => $salary->net_salary ?? '0',
                ];
            });
            $salariesTotalArray = [
                'secondary_salary' => collect($salariesTotal->pluck('secondary_salary')->toArray())->sum(),
                'allowance_boys' => collect($salariesTotal->pluck('allowance_boys')->toArray())->sum(),
                'nature_work_increase' => collect($salariesTotal->pluck('nature_work_increase')->toArray())->sum(),
                'administrative_allowance' => collect($salariesTotal->pluck('administrative_allowance')->toArray())->sum(),
                'scientific_qualification_allowance' => collect($salariesTotal->pluck('scientific_qualification_allowance')->toArray())->sum(),
                'transport' => collect($salariesTotal->pluck('transport')->toArray())->sum(),
                'extra_allowance' => collect($salariesTotal->pluck('extra_allowance')->toArray())->sum(),
                'salary_allowance' => collect($salariesTotal->pluck('salary_allowance')->toArray())->sum(),
                'ex_addition' => collect($salariesTotal->pluck('ex_addition')->toArray())->sum(),
                'mobile_allowance' => collect($salariesTotal->pluck('mobile_allowance')->toArray())->sum(),
                'termination_service' => collect($salariesTotal->pluck('termination_service')->toArray())->sum(),
                'gross_salary' => collect($salariesTotal->pluck('gross_salary')->toArray())->sum(),
                'health_insurance' => collect($salariesTotal->pluck('health_insurance')->toArray())->sum(),
                'z_Income' => collect($salariesTotal->pluck('z_Income')->toArray())->sum(),
                'savings_rate' => collect($salariesTotal->pluck('savings_rate')->toArray())->sum(),
                'association_loan' => collect($salariesTotal->pluck('association_loan')->toArray())->sum(),
                'savings_loan' => collect($salariesTotal->pluck('savings_loan')->toArray())->sum(),
                'shekel_loan' => collect($salariesTotal->pluck('shekel_loan')->toArray())->sum(),
                'late_receivables' => collect($salariesTotal->pluck('late_receivables')->toArray())->sum(),
                'total_discounts' => collect($salariesTotal->pluck('total_discounts')->toArray())->sum(),
                'net_salary' => collect($salariesTotal->pluck('net_salary')->toArray())->sum(),
            ];


            $months = Salary::whereIn('employee_id', $employees->pluck('id'))
                ->whereBetween('month', [$month, $to_month])
                ->distinct()
                ->pluck('month');

            $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endOfMonth = Carbon::createFromFormat('Y-m', $to_month)->endOfMonth();

            // معاينة pdf
            if($request->export_type == 'view' || $request->export_type == 'export_excel'){
                $margin_top = 3;
                $pdf = PDF::loadView('dashboard.pdf.employee.employee_salaries',['employee' =>  $employees->first(),'salaries' =>  $salaries,'salariesTotalArray' => $salariesTotalArray,'month' => $month,'to_month' => $to_month,'months' => $months,'monthName' => $monthName,'USD' => $USD,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10,
                    'mode' => 'utf-8',
                    'format' => 'A4-L',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->stream();
            }
            // تحميل الملف المصدر
            if($request->export_type == 'export_pdf'){
                $margin_top = 3;
                $pdf = PDF::loadView('dashboard.pdf.employee.employee_accounts',['employee' =>  $employees->first(),'salaries' =>  $salaries,'salariesTotalArray' => $salariesTotalArray,'month' => $month,'to_month' => $to_month,'months' => $months,'monthName' => $monthName,'USD' => $USD,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10,
                    'mode' => 'utf-8',
                    'format' => 'A4-L',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->download('كشف رواتب للموظف' . ' - ' . $employees->first()->name  . ' - ' . $time .'.pdf');
            }
        }
        // كشف مستحقات الموظف
        if($request->report_type == 'employee_receivables_savings'){

            $USD = Currency::where('code', 'USD')->first()->value ?? null;
            $month = $request->month ?? Carbon::now()->format('Y-m');
            $to_month = $request->to_month ?? Carbon::now()->format('Y-m');
            $monthName = $this->monthNameAr[Carbon::parse($month)->format('m')];

            $salaries = Salary::whereIn('employee_id', $employees->pluck('id'))
                        ->whereBetween('month', [$month, $to_month])
                        ->get();

            $months = Salary::whereIn('employee_id', $employees->pluck('id'))
                ->whereBetween('month', [$month, $to_month])
                ->distinct()
                ->pluck('month');

            $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endOfMonth = Carbon::createFromFormat('Y-m', $to_month)->endOfMonth();


            $exchanges = Exchange::whereIn('employee_id', $employees->pluck('id'))
                                ->whereBetween('discount_date', [$startOfMonth, $endOfMonth])
                                ->get();

            // معاينة pdf
            if($request->export_type == 'view' || $request->export_type == 'export_excel'){
                $margin_top = 3;
                $pdf = PDF::loadView('dashboard.pdf.employee.employee_receivables_savings',['employee' =>  $employees->first(),'salaries' =>  $salaries,'exchanges' => $exchanges,'month' => $month,'to_month' => $to_month,'months' => $months,'monthName' => $monthName,'USD' => $USD,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10,
                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->stream();
            }
            // تحميل الملف المصدر
            if($request->export_type == 'export_pdf'){
                $margin_top = 3;
                $pdf = PDF::loadView('dashboard.pdf.employee.employee_receivables_savings',['employee' =>  $employees->first(),'salaries' =>  $salaries,'exchanges' => $exchanges,'month' => $month,'to_month' => $to_month,'months' => $months,'monthName' => $monthName,'USD' => $USD,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10,
                    'mode' => 'utf-8',
                    'format' => 'A5-L',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->download('كشف المستحقات للموظف' . ' - ' . $employees->first()->name  . ' - ' . $time .'.pdf');
            }
        }

        // كشف القروض الموظف
        if($request->report_type == 'employee_loans'){

            $USD = Currency::where('code', 'USD')->first()->value ?? null;
            $month = $request->month ?? Carbon::now()->format('Y-m');
            $to_month = $request->to_month ?? Carbon::now()->format('Y-m');
            $monthName = $this->monthNameAr[Carbon::parse($month)->format('m')];

            $salaries = Salary::whereIn('employee_id', $employees->pluck('id'))
                        ->whereBetween('month', [$month, $to_month])
                        ->get();

            $months = Salary::whereIn('employee_id', $employees->pluck('id'))
                ->whereBetween('month', [$month, $to_month])
                ->distinct()
                ->pluck('month');

            $startOfMonth = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endOfMonth = Carbon::createFromFormat('Y-m', $to_month)->endOfMonth();


            $exchanges = Exchange::whereIn('employee_id', $employees->pluck('id'))
                                ->whereBetween('discount_date', [$startOfMonth, $endOfMonth])
                                ->get();

            // معاينة pdf
            if($request->export_type == 'view' || $request->export_type == 'export_excel'){
                $margin_top = 3;
                $pdf = PDF::loadView('dashboard.pdf.employee.employee_loans',['employee' =>  $employees->first(),'salaries' =>  $salaries,'exchanges' => $exchanges,'month' => $month,'to_month' => $to_month,'months' => $months,'monthName' => $monthName,'USD' => $USD,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10,
                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->stream();
            }

            // تحميل الملف المصدر
            if($request->export_type == 'export_pdf'){
                $margin_top = 3;
                $pdf = PDF::loadView('dashboard.pdf.employee.employee_loans',['employee' =>  $employees->first(),'salaries' =>  $salaries,'exchanges' => $exchanges,'month' => $month,'to_month' => $to_month,'months' => $months,'monthName' => $monthName,'USD' => $USD,'filter' => $request->all()],[],[
                    'margin_left' => 3,
                    'margin_right' => 3,
                    'margin_top' => $margin_top,
                    'margin_bottom' => 10,
                    'mode' => 'utf-8',
                    'format' => 'A5-L',
                    'default_font_size' => 12,
                    'default_font' => 'Arial',
                ]);
                return $pdf->download('كشف المستحقات للموظف' . ' - ' . $employees->first()->name  . ' - ' . $time .'.pdf');
            }
        }


    }

}
