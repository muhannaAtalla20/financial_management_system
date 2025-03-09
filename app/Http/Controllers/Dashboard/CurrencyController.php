<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use App\Models\Currency;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', Currency::class);
        $currencies = Currency::all();

        return view('dashboard.currencies', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CurrencyRequest $request)
    {
        $this->authorize('create', Currency::class);
        Currency::create($request->all());
        return redirect()->route('currencies.index')->with('success','تم إضافة عملة جديدة');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CurrencyRequest $request, Currency $currency)
    {
        $this->authorize('edit', Currency::class);
        $currency->update($request->all());
        return redirect()->route('currencies.index')->with('success','تم تحديث البيانات');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CurrencyRequest $request,Currency $currency)
    {
        $this->authorize('delete', Currency::class);
        $currency->delete();
        return redirect()->route('currencies.index')->with('success','تم حذف البيانات');
    }
}
