<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankRequest;
use App\Models\Bank;
use App\Models\BanksEmployees;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class BankController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Bank::class);
        $banks = Bank::paginate(10);
        return view('dashboard.banks.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Bank::class);
        $bank = new Bank();
        return view('dashboard.banks.create', compact('bank'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankRequest $request)
    {
        $this->authorize('create', Bank::class);
        Bank::create($request->all());
        return redirect()->route('banks.index')->with('success', 'تم إضافة بنك جديد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        $this->authorize('view', Bank::class);
        return redirect()->route('banks.edit',$bank->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankRequest $request,Bank $bank)
    {
        $this->authorize('edit', Bank::class);
        $btn_label = "تعديل";
        return view('dashboard.banks.edit', compact('bank','btn_label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankRequest $request, Bank $bank)
    {
        $this->authorize('edit', Bank::class);
        $bank->update($request->all());
        return redirect()->route('banks.index')->with('success', 'تم تعديل بيانات البنك');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankRequest $request,Bank $bank)
    {
        $this->authorize('delete', Bank::class);
        $bank->delete();
        return redirect()->route('banks.index')->with('success', 'تم حذف البنك');
    }
}
