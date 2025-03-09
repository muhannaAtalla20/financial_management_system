<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankEmployeeRequest;
use App\Imports\BanksEmployeesImport;
use App\Models\Bank;
use App\Models\BanksEmployees;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BanksEmployeesController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', BanksEmployees::class);
        $banks_employees = BanksEmployees::with(['employee','bank'])->get();
        return view('dashboard.banks_employees.index', compact('banks_employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', BanksEmployees::class);
        $bank_employee = new BanksEmployees();
        $banks = Bank::get();
        $employees = Employee::get();
        return view('dashboard.banks_employees.create', compact('bank_employee','banks','employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankEmployeeRequest $request)
    {
        $this->authorize('create', BanksEmployees::class);
        $request->validate([
            'employee_id' =>'required|exists:employees,id',
            'bank_id' =>'required|exists:banks,id',
            'account_number' =>'required|min:9|max:9',
        ]);
        BanksEmployees::create($request->all());
        return redirect()->route('banks_employees.index')->with('success', 'تم إضافة حساب بنك جديد');
    }

    /**
     * Display the specified resource.
     */
    public function show(BanksEmployees $banksEmployees)
    {
        return redirect()->route('banks_employees.edit',$banksEmployees->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankEmployeeRequest $request, $id)
    {
        $this->authorize('edit', BanksEmployees::class);
        $bank_employee = BanksEmployees::with(['employee','bank'])->find($id);
        $banks = Bank::get();
        $employees = Employee::get();
        return view('dashboard.banks_employees.edit', compact('bank_employee','banks','employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankEmployeeRequest $request, $id)
    {
        $this->authorize('edit', BanksEmployees::class);
        $request->validate([
            'employee_id' =>'required|exists:employees,id',
            'bank_id' =>'required|exists:banks,id',
            'account_number' =>'required|min:9|max:9',
        ]);
        $banksEmployees = BanksEmployees::findOrFail($id);
        $banksEmployees->update($request->all());
        return redirect()->route('banks_employees.index')->with('success', 'تم تحديث حساب البنك');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankEmployeeRequest $request, $id)
    {
        $this->authorize('delete', BanksEmployees::class);
        $banksEmployees = BanksEmployees::findOrFail($id);
        $banksEmployees->delete();

        return redirect()->route('banks_employees.index')->with('success', 'تم حذف حساب البنك');
    }

    // Execl
    public function import(Request $request)
    {
        $this->authorize('import', Employee::class);
        $file = $request->file('fileUplode');
        if($file == null){
            return redirect()->back()->with('error', 'لم يتم رفع الملف بشكل صحيح');
        }
        Excel::import(new BanksEmployeesImport, $file);

        return redirect()->route('banks_employees.index')->with('success', 'تم رفع الملف');
    }
    public function export(Request $request)
    {
        // $this->authorize('export', Employee::class);
        // $time = Carbon::now();
        // $filename = 'سجلات الموظفين' . $time .'.xlsx';
        // return Excel::download(new EmployeesDataExport, $filename);
    }

}
