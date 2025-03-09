<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryScaleRequest;
use App\Models\SalaryScale;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SalaryScaleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view', SalaryScale::class);
        $salary_scales = SalaryScale::get();
        $salary_scales_basic = SalaryScale::find(0);
        if($salary_scales_basic == null){
            $salary_scales_basic = new SalaryScale();
            $salary_scales_basic->id = 0;
        }
        return view('dashboard.salary_scales', compact('salary_scales','salary_scales_basic'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(SalaryScaleRequest $request)
    {
        $this->authorize('create', SalaryScale::class);

        DB::beginTransaction();
        try{
            $request->merge([
                'id' => 0,
                'percentage' => round(($request[10] / $request[10]),5),
            ]);
            SalaryScale::create($request->all());
            SalaryScale::create([
                'id' => 1,
                '10' => $D10 =  round(($request[10]+(($request[10]*0.0125)*1)), 2),
                '9' =>  $D9 = round(($request[9]+(($request[9]*0.0125)*1)), 2),
                '8' =>  $D8 = round(($request[8]+(($request[8]*0.0125)*1)), 2),
                '7' =>  $D7 = round(($request[7]+(($request[7]*0.0125)*1)), 2),
                '6' =>  $D6 = round(($request[6]+(($request[6]*0.0125)*1)), 2),
                '5' =>  $D5 = round(($request[5]+(($request[5]*0.0125)*1)), 2),
                '4' => $D4 = round(($request[4]+(($request[4]*0.0125)*1)), 2),
                '3' => $D3 = round(($request[3]+(($request[3]*0.0125)*1)), 2),
                '2' => $D2 = round(($request[2]+(($request[2]*0.0125)*1)), 2),
                '1' => $D1 = round(($request[1]+(($request[1]*0.0125)*1)), 2),
                'C' => $DC = round(($request["C"]+(($request["C"]*0.0125)*1)), 2),
                'B' => $DB = round(($request["B"]+(($request["B"]*0.0125)*1)), 2),
                'A' => $DA = round(($request["A"]+(($request["A"]*0.0125)*1)), 2),
                'percentage' => round(($D10/$request[10]),5),
            ]);
            for ($i = 2; $i <= 40; $i++) {
                SalaryScale::create([
                    'id' => $i,
                    '10' => $D10 =  round(($request[10]+(($D10*0.0125)*$i)), 2),
                    '9' =>  $D9 = round(($request[9]+(($D9*0.0125)*$i)), 2),
                    '8' =>  $D8 = round(($request[8]+(($D8*0.0125)*$i)), 2),
                    '7' =>  $D7 = round(($request[7]+(($D7*0.0125)*$i)), 2),
                    '6' =>  $D6 = round(($request[6]+(($D6*0.0125)*$i)), 2),
                    '5' =>  $D5 = round(($request[5]+(($D5*0.0125)*$i)), 2),
                    '4' => $D4 = round(($request[4]+(($D4*0.0125)*$i)), 2),
                    '3' => $D3 = round(($request[3]+(($D3*0.0125)*$i)), 2),
                    '2' => $D2 = round(($request[2]+(($D2*0.0125)*$i)), 2),
                    '1' => $D1 = round(($request[1]+(($D1*0.0125)*$i)), 2),
                    'C' => $DC = round(($request["C"]+(($DC*0.0125)*$i)), 2),
                    'B' => $DB = round(($request["B"]+(($DB*0.0125)*$i)), 2),
                    'A' => $DA = round(($request["A"]+(($DA*0.0125)*$i)), 2),
                    'percentage' => round(($D10/$request[10]),5),
                ]);
            };
            DB::commit();
            return redirect()->route('salary_scales.index')->with('success', 'تم إضافة سلم الرواتب');
        }catch(Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('danger', 'هنالك خطأ في الإضافة يرجى المراجعة');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalaryScaleRequest $request, SalaryScale $salaryScale)
    {
        $this->authorize('edit', SalaryScale::class);

        DB::beginTransaction();
        try{
            $salaryScale = SalaryScale::findOrFail(0);
            $salaryScale->update($request->all());

            SalaryScale::findOrFail(1)->update([
                'id' => 1,
                '10' => $D10 =  round(($request[10]+(($request[10]*0.0125)*1)), 2),
                '9' =>  $D9 = round(($request[9]+(($request[9]*0.0125)*1)), 2),
                '8' =>  $D8 = round(($request[8]+(($request[8]*0.0125)*1)), 2),
                '7' =>  $D7 = round(($request[7]+(($request[7]*0.0125)*1)), 2),
                '6' =>  $D6 = round(($request[6]+(($request[6]*0.0125)*1)), 2),
                '5' =>  $D5 = round(($request[5]+(($request[5]*0.0125)*1)), 2),
                '4' => $D4 = round(($request[4]+(($request[4]*0.0125)*1)), 2),
                '3' => $D3 = round(($request[3]+(($request[3]*0.0125)*1)), 2),
                '2' => $D2 = round(($request[2]+(($request[2]*0.0125)*1)), 2),
                '1' => $D1 = round(($request[1]+(($request[1]*0.0125)*1)), 2),
                'C' => $DC = round(($request["C"]+(($request["C"]*0.0125)*1)), 2),
                'B' => $DB = round(($request["B"]+(($request["B"]*0.0125)*1)), 2),
                'A' => $DA = round(($request["A"]+(($request["A"]*0.0125)*1)), 2),
                'percentage' => round(($D10/$request[10]),5),
            ]);
            for ($i = 2; $i <= 40; $i++) {
                SalaryScale::findOrFail($i)->update([
                    'id' => $i,
                    '10' => $D10 =  round(($request[10]+(($D10*0.0125)*$i)), 2),
                    '9' =>  $D9 = round(($request[9]+(($D9*0.0125)*$i)), 2),
                    '8' =>  $D8 = round(($request[8]+(($D8*0.0125)*$i)), 2),
                    '7' =>  $D7 = round(($request[7]+(($D7*0.0125)*$i)), 2),
                    '6' =>  $D6 = round(($request[6]+(($D6*0.0125)*$i)), 2),
                    '5' =>  $D5 = round(($request[5]+(($D5*0.0125)*$i)), 2),
                    '4' => $D4 = round(($request[4]+(($D4*0.0125)*$i)), 2),
                    '3' => $D3 = round(($request[3]+(($D3*0.0125)*$i)), 2),
                    '2' => $D2 = round(($request[2]+(($D2*0.0125)*$i)), 2),
                    '1' => $D1 = round(($request[1]+(($D1*0.0125)*$i)), 2),
                    'C' => $DC = round(($request["C"]+(($DC*0.0125)*$i)), 2),
                    'B' => $DB = round(($request["B"]+(($DB*0.0125)*$i)), 2),
                    'A' => $DA = round(($request["A"]+(($DA*0.0125)*$i)), 2),
                    'percentage' => round(($D10/$request[10]),5),
                ]);
            };
            DB::commit();
            return redirect()->route('salary_scales.index')->with('success', 'تم إضافة سلم الرواتب');
        }catch(Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('danger', 'هنالك خطأ في العملية يرجى المراجعة للمهندس');
        }
    }
}
