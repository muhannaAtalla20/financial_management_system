<?php

namespace App\Http\Controllers\Dashboard;

use App\Helper\AddSalaryEmployee;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryRequest;
use App\Models\Accreditation;
use App\Models\BanksEmployees;
use App\Models\Currency;
use App\Models\Employee;
use App\Models\LogRecord;
use App\Models\ReceivablesLoans;
use App\Models\Salary;
use Exception;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Log;

class SalaryController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Salary::class);
        $accreditations = Accreditation::get();
        $lastAccreditations = Accreditation::latest()->first();


        $month  = Carbon::now()->format('Y-m');
        $monthDownload = ($lastAccreditations  != null) ? Carbon::parse($lastAccreditations->month)->addMonth()->format('Y-m') : '2024-07' ;
        $USD = Currency::where('code', 'USD')->first()->value ?? null;
        $salaries = Salary::where('month', $monthDownload)->get();

        $btn_download_salary = null;
        $employess = Employee::all();
        foreach ($employess as $employee) {
            $salary = Salary::where('employee_id', $employee->id)->where('month', $monthDownload)->first();
            if($salary == null){
                $btn_download_salary = "active";
            }
        }
        $btn_delete_salary = $salaries->isNotEmpty() ? "active" : null;

        return view('dashboard.salaries.index', compact('salaries','btn_download_salary','btn_delete_salary','accreditations','USD','month','monthDownload'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SalaryRequest $request)
    {
        // $salary = new Salary();
        // $salary->employee = new Employee();
        // return view('dashboard.salaries.create',compact('salary'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalaryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Salary $salary)
    {
        return view('dashboard.salaries.show', compact('salary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalaryRequest $request, Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalaryRequest $request, Salary $salary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalaryRequest $request, $id)
    {
        $salary = Salary::findOrFail($id);
        $USD = Currency::where('code', 'USD')->first()->value;
        $fixedEntries = $salary->employee->fixedEntries->where('month', $salary->month)->first();
        // إجمالي الإدخارات (تم وضع معادلته سابقا لوجود مشكلة بالحسبة)
        $savings_loan = ($fixedEntries != null) ? $fixedEntries->savings_loan : 0;
        $savings_rate = ($fixedEntries != null) ? $fixedEntries->savings_rate : 0;
        $termination_service = $salary->termination_service ?? 0;

        $total_savings = $savings_loan + (($savings_rate + $termination_service) / $USD );

        ReceivablesLoans::updateOrCreate([
            'employee_id' => $salary->employee_id,
        ],[
            'total_receivables' => DB::raw('total_receivables - '. ($salary->late_receivables )),
            'total_savings' => DB::raw('total_savings - ' . $total_savings),
            'total_savings_loan' => DB::raw('total_savings_loan + '.$savings_loan),
            'total_shekel_loan' => DB::raw('total_shekel_loan + '.($fixedEntries->shekel_loan ?? 0)),
            'total_association_loan' => DB::raw('total_association_loan + '.($fixedEntries->association_loan ?? 0))
        ]);
        $salary->forceDelete();
        // $salary->delete();
        return redirect()->route('salaries.index')->with('success', 'تم الحذف بنجاح');
    }

    // soft delete
    // public function trashed()
    // {
    //     $banks_employees = Salary::onlyTrashed()->paginate(10);

    //     return view('dashboard.banks_employees.trashed', compact('banks_employees'));
    // }
    // public function restore(Request $request)
    // {
    //     $banksEmployee = Salary::onlyTrashed()->findOrFail($request->id);
    //     $banksEmployee->restore();
    //     return redirect()->route('banks_employees.index')->with('success', 'تم إرجاع العنصر مرة أخرى');
    // }
    // public function forceDelete(Request $request)
    // {
    //     $banksEmployees = Salary::onlyTrashed()->findOrFail($request->banks_employees);
    //     $banksEmployees->forceDelete();
    //     // Salary::onlyTrashed()->where('deleted_at', '<', Carbon::now()->subDays(30))->forceDelete();
    //     return redirect()->route('banks_employees.trashed')->with('danger', 'تم الحذف بشكل نهائي');
    // }


    // Create All Salaries
    public function createAllSalaries(Request $request){
        $this->authorize('create-all', Salary::class);
        DB::beginTransaction();
        try {

            // التجربة لموظف
            // $employee = Employee::findOrFail($request->employee_id);
            // $month = $request->month ?? Carbon::now()->format('Y-m');
            // AddSalaryEmployee::addSalary($employee,$month);

            $employees = Employee::get();
            $logRecords = [];
            $month = $request->month ?? Carbon::now()->format('Y-m');
            foreach ($employees as $employee) {
                try{
                    LogRecord::where('type', 'errorSalary')->where('related_id', "employee_$employee->id")->delete();
                    AddSalaryEmployee::addSalary($employee,$month);
                }catch(Exception $e){
                    LogRecord::create([
                        'type' => 'errorSalary',
                        'related_id' => "employee_$employee->id",
                        'description' => 'خطأ في معالجة راتب الموظف : ' . $employee->name . '. الخطأ: ' . $e->getMessage(),
                    ]);
                }
            }
            $logRecords = LogRecord::where('type', 'errorSalary')->get()->pluck('description')->toArray();
            // الحصول على بداية ونهاية الشهر السابق
            $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();
            $endOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth();

            // العثور على جميع السجلات التي تم إنشاؤها في الشهر السابق
            DB::table('log_records')
                        ->where('type', 'errorSalary')
                        ->whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])
                        ->delete();

            DB::commit();
        }catch (Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        return redirect()->route('salaries.index')->with('success', 'تم اضافة الراتب لجميع الموظفين للشهر الحالي')
                ->with('danger', $logRecords);
    }
    // Create All Salaries
    public function deleteAllSalaries(Request $request){
        $this->authorize('delete-all', Salary::class);
        DB::beginTransaction();
        try {
            $month = $request->month ?? Carbon::now()->format('Y-m');
            $salaries = Salary::where('month', $month)->get();
            foreach ($salaries as $salary) {
                try{
                    $USD = Currency::where('code', 'USD')->first()->value;
                    $fixedEntries = $salary->employee->fixedEntries->where('month', $salary->month)->first();
                    // إجمالي الإدخارات (تم وضع معادلته سابقا لوجود مشكلة بالحسبة)
                    $savings_loan = ($fixedEntries != null) ? $fixedEntries->savings_loan : 0;
                    $savings_rate = ($fixedEntries != null) ? $fixedEntries->savings_rate : 0;
                    $termination_service = $salary->termination_service ?? 0;

                    $total_savings = $savings_loan + (($savings_rate + $termination_service) / $USD );

                    ReceivablesLoans::updateOrCreate([
                        'employee_id' => $salary->employee_id,
                    ],[
                        'total_receivables' => DB::raw('total_receivables - '. ($salary->late_receivables )),
                        'total_savings' => DB::raw('total_savings - ' . $total_savings),
                        'total_savings_loan' => DB::raw('total_savings_loan + '.$savings_loan),
                        'total_shekel_loan' => DB::raw('total_shekel_loan + '.($fixedEntries->shekel_loan ?? 0)),
                        'total_association_loan' => DB::raw('total_association_loan + '.($fixedEntries->association_loan ?? 0))
                    ]);
                    $salary->forceDelete();
                    LogRecord::where('type', 'errorSalary')->where('related_id', "employee_$salary->employee_id")->delete();
                }catch (\Exception $exception){
                    DB::rollBack();
                    throw $exception;
                }
            }
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        return redirect()->route('home')->with('danger', 'تم حذف الراتب لجميع الموظفين للشهر الحالي');
    }

    public function getSalariesMonth(Request $request){
        $salaries = Salary::with('employee')->where('month', $request->month)->get();
        return $salaries;
    }
}
