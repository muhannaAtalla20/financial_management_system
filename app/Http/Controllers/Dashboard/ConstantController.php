<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Constant;
use App\Models\WorkData;
use Illuminate\Http\Request;

class ConstantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advance_payment_rate = Constant::where('type_constant','advance_payment_rate')->first('value') ? Constant::where('type_constant','advance_payment_rate')->first('value')->value : 0;

        $advance_payment_permanent = Constant::where('type_constant','advance_payment_permanent')->first('value') ? Constant::where('type_constant','advance_payment_permanent')->first('value')->value : 0;

        $advance_payment_non_permanent = Constant::where('type_constant','advance_payment_non_permanent')->first('value') ? Constant::where('type_constant','advance_payment_non_permanent')->first('value')->value : 0;

        $advance_payment_riyadh = Constant::where('type_constant','advance_payment_riyadh')->first('value') ? Constant::where('type_constant','advance_payment_riyadh')->first('value')->value : 0;

        $state_effectivenessEmployees = WorkData::select('state_effectiveness')->distinct()->pluck('state_effectiveness')->toArray();

        $state_effectiveness = Constant::where('type_constant','state_effectiveness')->get()? Constant::where('type_constant','state_effectiveness')->get()->toArray()  : [];

        $termination_service = Constant::where('type_constant','termination_service')->first('value') ? Constant::where('type_constant','termination_service')->first('value')->value : 0;

        $constants = Constant::get();
        return view('dashboard.constants',compact('constants','advance_payment_rate', 'advance_payment_permanent', 'advance_payment_non_permanent', 'advance_payment_riyadh','state_effectivenessEmployees','state_effectiveness','termination_service'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->advance_payment_rate){
            Constant::updateOrCreate([
                'type_constant' => 'advance_payment_rate',
            ],[
                'value' => $request->advance_payment_rate,
            ]);
        }
        if($request->advance_payment_permanent){
            Constant::updateOrCreate([
                'type_constant' => 'advance_payment_permanent',
            ],[
                'value' => $request->advance_payment_permanent,
            ]);
        }
        if($request->advance_payment_non_permanent){
            Constant::updateOrCreate([
                'type_constant' => 'advance_payment_non_permanent',
            ],[
                'value' => $request->advance_payment_non_permanent,
            ]);
        }
        if($request->advance_payment_riyadh){
            Constant::updateOrCreate([
                'type_constant' => 'advance_payment_riyadh',
            ],[
                'value' => $request->advance_payment_riyadh,
            ]);
        }
        if($request->state_effectiveness){
            Constant::create([
                'type_constant' => 'state_effectiveness',
                'value' => $request->state_effectiveness,
            ]);
        }
        if($request->termination_service){
            Constant::updateOrCreate([
                'type_constant' => 'termination_service',
            ],[
                'value' => $request->termination_service,
            ]);
        }
        return redirect()->route('constants.index')->with('success','تم تحديث القيم');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if($request->state_effectiveness){
            Constant::findOrFail($request->state_effectiveness)->delete();
        }
        return redirect()->route('constants.index')->with('danger','تم حذف القيمة المحددة');
    }
}
