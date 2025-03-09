<?php

use App\Http\Controllers\Dashboard\AccreditationController;
use App\Http\Controllers\Dashboard\BankController;
use App\Http\Controllers\Dashboard\BanksEmployeesController;
use App\Http\Controllers\Dashboard\ConstantController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\CustomizationController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\ExchangeController;
use App\Http\Controllers\Dashboard\FixedEntriesController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\SalaryController;
use App\Http\Controllers\Dashboard\SalaryScaleController;
use App\Http\Controllers\Dashboard\TotalController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:web'],
    // 'prefix' => 'dashboard',
    // 'namespace' => 'Dashboard',
    // 'as' => 'dashboard.'
], function () {
    // outhers fields
    Route::get('/employees/getEmployee', [EmployeeController::class,'getEmployee'])->name('employees.getEmployee');
    Route::post('/employees/filterEmployee', [EmployeeController::class,'filterEmployee'])->name('employees.filterEmployee');
    Route::post('/employees/filterEmployee', [EmployeeController::class,'filterEmployee'])->name('employees.filterEmployee');

    Route::post('/fixed_entries/getFixedEntriesData', [FixedEntriesController::class,'getFixedEntriesData'])->name('fixed_entries.getFixedEntriesData');
    Route::post('/fixed_entries/getModalForm', [FixedEntriesController::class,'getModalForm'])->name('fixed_entries.getModalForm');
    Route::post('/fixed_entries/getModalFormLoan', [FixedEntriesController::class,'getModalFormLoan'])->name('fixed_entries.getModalFormLoan');
    Route::get('/fixed_entries/viewForm', [FixedEntriesController::class,'viewForm'])->name('fixed_entries.viewForm');

    Route::post('/exchanges/printPdf', [ExchangeController::class,'printPdf'])->name('exchanges.printPdf');
    Route::post('/exchanges/getTotals', [ExchangeController::class,'getTotals'])->name('exchanges.getTotals');


    Route::post('/salaries/createAllSalaries', [SalaryController::class,'createAllSalaries'])->name('salaries.createAllSalaries');
    Route::post('/salaries/deleteAllSalaries', [SalaryController::class,'deleteAllSalaries'])->name('salaries.deleteAllSalaries');
    Route::post('/salaries/getSalariesMonth', [SalaryController::class, 'getSalariesMonth'])->name('salaries.getSalariesMonth');



    // soft delete for salaries
    Route::get('/salaries/trashed', [SalaryController::class,'trashed'])->name('salaries.trashed');
    Route::put('/salaries/{salary}/restore', [SalaryController::class,'restore'])->name('salaries.restore');
    Route::delete('/salaries/{salary}/forceDelete', [SalaryController::class,'forceDelete'])->name('salaries.forceDelete');


    // Excel
    Route::post('employees/importExcel', [EmployeeController::class,'import'])->name('employees.importExcel');
    Route::get('employees/exportExcel', [EmployeeController::class,'export'])->name('employees.exportExcel');
    Route::post('banks_employees/importExcel', [BanksEmployeesController::class,'import'])->name('banks_employees.importExcel');
    Route::get('banks_employees/exportExcel', [BanksEmployeesController::class,'export'])->name('banks_employees.exportExcel');
    Route::post('totals/importExcel', [TotalController::class,'import'])->name('totals.importExcel');
    Route::get('totals/exportExcel', [TotalController::class,'export'])->name('totals.exportExcel');

    // PDF Export
    Route::post('employees/view_pdf', [EmployeeController::class, 'viewPDF'])->name('employees.view_pdf');
    Route::post('salaries/view_pdf', [SalaryController::class, 'viewPDF'])->name('salaries.view_pdf');

    // sections seystem
    Route::get('/constants', [ConstantController::class,'index'])->name('constants.index');
    Route::post('/constants', [ConstantController::class,'store'])->name('constants.store');
    Route::delete('/constants/destroy', [ConstantController::class,'destroy'])->name('constants.destroy');


    // Report
    Route::get('/report', [ReportController::class,'index'])->name('report.index');
    Route::post('/report/export', [ReportController::class,'export'])->name('report.export');

    // stores
    Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
    Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');
    Route::get('/stores/{id}', [StoreController::class, 'getStoreDetails'])->name('stores.show');
    Route::post('/stores/{store}/categories', [StoreController::class, 'addCategory'])->name('stores.addCategory');
    Route::post('/stores/{store}/donations', [StoreController::class, 'addDonation'])->name('stores.addDonation');
    Route::get('/stores/{id}/inventory', [StoreController::class, 'getStoreInventorySummary'])->name('stores.inventory');
    Route::put('/donations/{id}', [StoreController::class, 'updateDonation'])->name('donations.update');
    Route::delete('/donations/{id}', [StoreController::class, 'deleteDonation'])->name('donations.delete');

    // specific_salaries
    require __DIR__ . "/specific_salaries.php";

    Route::resources([
        'currencies' => CurrencyController::class,
        'employees' => EmployeeController::class,
        'banks' => BankController::class,
        'banks_employees' => BanksEmployeesController::class,
        'fixed_entries' => FixedEntriesController::class,
        'salary_scales' => SalaryScaleController::class,
        'totals' => TotalController::class,
        'salaries' => SalaryController::class,
        'users' => UserController::class,
        'exchanges' => ExchangeController::class,
        'customizations' => CustomizationController::class,
        'accreditations' => AccreditationController::class,
        // 'roles' => RoleController::class,
    ]);
});

