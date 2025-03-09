<?php

use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\SpecificSalaryController;
use App\Models\Employee;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:web'],
    // 'prefix' => 'dashboard',
    // 'namespace' => 'Dashboard',
    // 'as' => 'dashboard.'
], function () {
    // الرئيسية
    Route::get('/specific_salaries/index', [SpecificSalaryController::class,'index'])->name('specific_salaries.index');

    // النسبة
    Route::get('/specific_salaries/ratio', [SpecificSalaryController::class,'ratio'])->name('specific_salaries.ratio');
    Route::post('/specific_salaries/ratioCreate', [SpecificSalaryController::class,'ratioCreate'])->name('specific_salaries.ratioCreate');
    Route::post('/specific_salaries/getRatio', [SpecificSalaryController::class,'getRatio'])->name('specific_salaries.getRatio');

    // خاص
    Route::post('/specific_salaries/privateCreate', [SpecificSalaryController::class,'privateCreate'])->name('specific_salaries.privateCreate');

    // رياض
    Route::post('/specific_salaries/riyadhCreate', [SpecificSalaryController::class,'riyadhCreate'])->name('specific_salaries.riyadhCreate');

    // فصلي
    Route::post('/specific_salaries/fasleCreate', [SpecificSalaryController::class,'fasleCreate'])->name('specific_salaries.fasleCreate');

    // المؤقت
    Route::post('/specific_salaries/interimCreate', [SpecificSalaryController::class,'interimCreate'])->name('specific_salaries.interimCreate');

    // اليومي
    Route::post('/specific_salaries/dailyCreate', [SpecificSalaryController::class,'dailyCreate'])->name('specific_salaries.dailyCreate');
});
