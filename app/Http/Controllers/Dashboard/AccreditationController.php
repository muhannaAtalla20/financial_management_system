<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use Illuminate\Http\Request;

class AccreditationController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'user_id' => auth()->user()->id,
            'status' => 1,
        ]);
        Accreditation::create($request->all());
        return redirect()->back()->with('success', 'تم إعتماد الشهر بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accreditation $accreditation)
    {
        $accreditation->delete();
        return redirect()->back()->with('danger', 'تم حذف إعتماد الشهر بنجاح');
    }
}
