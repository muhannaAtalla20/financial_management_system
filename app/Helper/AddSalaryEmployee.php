<?php

namespace App\Helper;

use Alkoumi\LaravelArabicNumbers\Numbers;
use App\Models\Bank;
use App\Models\Constant;
use App\Models\Currency;
use App\Models\FixedEntries;
use App\Models\LogRecord;
use App\Models\ReceivablesLoans;
use App\Models\Salary;
use App\Models\SalaryScale;
use App\Models\SpecificSalary;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AddSalaryEmployee{

    public function __construct()
    {
        //
    }

    public static function addSalary($employee,$month = null)
    {
        // قيم ثابتة تجلب من الخارج
        if($month == null){
            $month = Carbon::now()->format('Y-m');
        }
        $state_effectiveness = Constant::where('type_constant','state_effectiveness')->get()? Constant::where('type_constant','state_effectiveness')->get()->pluck('value')->toArray()  : [];

        $USD = Currency::where('code','USD')->first('value')->value ?? 3.5;


        // موظف غير فعال ام لا
        if(!in_array($employee->workData->state_effectiveness,$state_effectiveness)){
            LogRecord::create([
                'type' => 'errorSalary',
                'related_id' => "employee_$employee->id",
                'description' => 'الموظف : ' . $employee->name . ' . موظف غير فعال',
            ]);
            return;
        }
        // مزدوج الوظيفة
        $dual_function = $employee->workData->dual_function;
        if($dual_function == "غير موظف"){
            $dual_function = null;
        }


        // مبلغ السلفة من حالة الدوام
        $working_status = $employee->workData->working_status;
        if($working_status == "مداوم" || $working_status == "نعم"){
            $advance_payment = Constant::where('type_constant','advance_payment_permanent')->first('value')->value;
            if($employee->workData->type_appointment == 'يومي'){
                $advance_payment = Constant::where('type_constant','advance_payment_rate')->first('value')->value;
            }
        }elseif($working_status == "غير مداوم" || $working_status == "لا"){
            $advance_payment = Constant::where('type_constant','advance_payment_non_permanent')->first('value')->value;
            if($employee->workData->type_appointment == 'يومي'){
                $advance_payment = Constant::where('type_constant','advance_payment_rate')->first('value')->value;
            }
        }elseif($working_status == "رياض"){
            $advance_payment = Constant::where('type_constant','advance_payment_riyadh')->first('value')->value;
        }elseif($working_status == "نسبة"){
            $advance_payment = Constant::where('type_constant','advance_payment_rate')->first('value')->value;
        }else{
            $advance_payment = 0;
        }


        //  البنك المتعامل معه
        if($employee->banks->first() != null){
            foreach ($employee->banks as $bank) {
                $account_default = $bank->accounts->where('employee_id',$employee->id)->where('default',1)->first();
                if($account_default == null){
                    $account_default = $bank->accounts->where('employee_id',$employee->id)->first();
                }
            }
            $bank = Bank::find($account_default->bank_id)->first()->name;
            $branch_number = Bank::find($account_default->bank_id)->first()->branch_number;
            $account_number = $account_default->account_number;
        }
        if($employee->banks->first() == null){
            $bank = '';
            $branch_number = '';
            $account_number = '';
        }
        if($employee->workData->type_appointment == 'مثبت'){
            // مثبتين
            // الحسابات
            $percentage_allowance = ($employee->workData->percentage_allowance != null) ? $employee->workData->percentage_allowance : 100; //نسبة علاوة من طبيعة العمل
            $initial_salary = SalaryScale::where('id',$employee->workData->allowance)->first()->{$employee->workData->grade}; // الراتب الأولي
            if($employee->workData->contract_type == 'صحة' && $employee->workData->type_appointment == 'مثبت'){
                if($employee->scientific_qualification == 'بكالوريوس'){
                    $initial_salary = 900;
                }
                if($employee->scientific_qualification == 'دبلوم'){
                    $initial_salary = 800;
                }
                if($employee->scientific_qualification == 'ثانوية عامة'){
                    $initial_salary = 700;
                }
            }
            $grade_allowance_ratio = $employee->workData->grade_allowance_ratio; // نسبة علاوة درجة
            if($grade_allowance_ratio != 0){
                $grade_Allowance = number_format($initial_salary * $grade_allowance_ratio,0); // علاوة درجة
            }else{
                $grade_Allowance = 0;
            }
            if($employee->workData->installation_new == 'مثبت جديد'){
                $grade_Allowance = $employee->workData->allowance * 10;
            }
            if($employee->workData->installation_new == 'مثبت جديد2'){
                $grade_Allowance = $employee->workData->allowance * 20;
            }

            if($employee->customizations->isNotEmpty() != null){
                if($employee->customizations->first()->grade_Allowance != ''){
                    $grade_Allowance = $employee->customizations->first()->grade_Allowance;
                }
            }

            $secondary_salary = $initial_salary + $grade_Allowance; // الراتب الثانوي
            // الإضافات الثابتة
            if($employee->workData->type_appointment == 'مثبت' && $employee->matrimonial_status == "متزوج"){
                $allowance_boys = (($employee->number_children * 20) + 60);
            }elseif($employee->workData->type_appointment == 'مثبت' && ($employee->matrimonial_status == "متزوج - موظفة حكومة" || $employee->matrimonial_status == "ارملة")){
                $allowance_boys = ($employee->number_children * 20);
            }else{
                $allowance_boys = 0;
            }
            if($employee->workData->section == 'الصحة'){
                $allowance_boys = $allowance_boys / 2;
            }
            if($employee->customizations->isNotEmpty() != null){
                if($employee->customizations->first()->allowance_boys_1 != ''){
                    $allowance_boys = (($employee->number_children * ($employee->customizations->first()->allowance_boys_1 ?? 20)) + ($employee->customizations->first()->allowance_boys_2 ?? 0));
                }
            }

            $nature_work_increase = floatval(($percentage_allowance*0.01) * $secondary_salary); // علاوة طبيعة العمل
        }else{
            if($employee->workData->type_appointment == 'نسبة'){
                $initial_salary = SpecificSalary::where('employee_id',$employee->id)->where('month',$month)->first();
                $secondary_salary = $initial_salary;
            }else{
                $initial_salary = SpecificSalary::where('employee_id',$employee->id)->where('month','0000-00')->first();
                $secondary_salary = $initial_salary;
            }
            if($secondary_salary == null || $secondary_salary->salary == 0){
                LogRecord::create([
                    'type' => 'errorSalary',
                    'related_id' => "employee_$employee->id",
                    'description' => 'الموظف : ' . $employee->name . ' . لم يتم تحديد الراتب له',
                ]);
                return;
            }else{
                $percentage_allowance = 0;
                $grade_Allowance = 0;
                $allowance_boys = 0;
                $nature_work_increase =  0; // علاوة طبيعة العمل
                $initial_salary = $secondary_salary->salary;
                $secondary_salary = $initial_salary;
            }
        }

        // المدخلات الثابتة
        $fixedEntries = $employee->fixedEntries->where('month',$month)->first();

        $administrative_allowance = ($fixedEntries != null) ? $fixedEntries->administrative_allowance : 0;
        $scientific_qualification_allowance = ($fixedEntries != null) ? $fixedEntries->scientific_qualification_allowance : 0;
        $transport = ($fixedEntries != null) ? $fixedEntries->transport : 0;
        $extra_allowance = ($fixedEntries != null) ?  $fixedEntries->extra_allowance : 0;
        $salary_allowance = ($fixedEntries != null) ? $fixedEntries->salary_allowance : 0;
        $ex_addition = ($fixedEntries != null) ? $fixedEntries->ex_addition : 0;
        $mobile_allowance = ($fixedEntries != null) ? $fixedEntries->mobile_allowance : 0;


        // نسبة نهاية الخدمة
        $termination_service_rate = Constant::where('type_constant','termination_service')->first('value') ? (Constant::where('type_constant','termination_service')->first('value')->value / 100) : 0.1;

        // نهاية الخدمة

        $termination_service = $dual_function == null ?  number_format(($secondary_salary+$nature_work_increase+$administrative_allowance)*$termination_service_rate,2) : 0;
        if($employee->workData->type_appointment == 'نسبة' || $dual_function == "موظف"){
            $termination_service = 0;
        }
        if($employee->customizations->isNotEmpty() != null){
            if($employee->customizations->first()->termination_service != ''){
                $termination_service = number_format(($secondary_salary+$nature_work_increase+$administrative_allowance)*($employee->customizations->first()->termination_service ?? $termination_service_rate),2) ?? 0;
            }
        }
        if($employee->workData->state_effectiveness == "شهيد"){
            $termination_service = 0;
        }


        $total_additions = ($allowance_boys + $nature_work_increase + $administrative_allowance + $scientific_qualification_allowance + $transport + $extra_allowance + $salary_allowance + $ex_addition + $mobile_allowance +$termination_service);

        // الخصومات
        $health_insurance = ($fixedEntries != null) ? $fixedEntries->health_insurance : 0;
        $f_Oredo = $fixedEntries != null ? $fixedEntries->f_Oredo : 0;
        $association_loan = $fixedEntries != null ? $fixedEntries->association_loan : 0;
        $tuition_fees = $fixedEntries != null ? $fixedEntries->tuition_fees : 0;
        $voluntary_contributions = $fixedEntries != null ? $fixedEntries->voluntary_contributions : 0;
        $savings_loan = $fixedEntries != null ? ($fixedEntries->savings_loan * $USD)  : 0;
        $shekel_loan = $fixedEntries != null ? $fixedEntries->shekel_loan : 0;
        $paradise_discount = $fixedEntries != null ? $fixedEntries->paradise_discount : 0;
        $other_discounts = $fixedEntries != null ? $fixedEntries->other_discounts : 0;
        $proportion_voluntary = $fixedEntries != null ? $fixedEntries->proportion_voluntary : 0;
        $savings_rate = $fixedEntries != null ? $fixedEntries->savings_rate : 0;


        // إضافات للمبلغ الضريبية العملة شيكل
        $amount_tax = $working_status == "مداوم" || $working_status == "نعم"  ? ($secondary_salary + $nature_work_increase - $termination_service - $health_insurance - $savings_rate - $voluntary_contributions) / $USD : 0; // المبلغ الضريبي

        $exemptions = ($dual_function == null) ? ((3000 + ($employee->matrimonial_status == "متزوج"? 500 : 0) + ($employee->matrimonial_status == "متزوج - موظفة وكالة"? $employee->number_children *500 : 0) +  ($employee->matrimonial_status == "متزوج - موظفة حكومة"? $employee->number_children *500 : 0) + ($employee->number_university_children * 12)) / 12) : 0; // الاعفاءات

        $tax = ($amount_tax -$exemptions < 0) ? 0 : ($amount_tax - $exemptions); // الضريبة

        $resident_exemption = ($dual_function != null) ? 0 : 3000; // إعفاء مقيم

        $annual_taxable_amount = $tax * 12 ; // مبلغ الضريبة الخاضع السنوي بالدولار

        // ضريبة الدخل
        if($annual_taxable_amount<=10000){
            $z_Income = $annual_taxable_amount*0.08;
        }elseif($annual_taxable_amount<=16000){
            $z_Income = 800+(($annual_taxable_amount-10000)*0.12);
        }elseif($annual_taxable_amount>16000){
            $z_Income = 800+720+(($annual_taxable_amount-16000)*0.16);
        }else{
            $z_Income = 0;
        }
        $z_Income = ($z_Income / 12) * $USD;

        // تم إيقاف الضريبة لفترة الحرب
        $z_Income = 0;

        $total_discounts = ($termination_service + $health_insurance + $f_Oredo + $association_loan + $tuition_fees + $voluntary_contributions + $savings_loan + $shekel_loan + $paradise_discount + $other_discounts + $proportion_voluntary + $savings_rate + $z_Income);

        // إجمالي الراتب
        $gross_salary = ($secondary_salary + $total_additions) - $total_discounts;

        $late_receivables = ($gross_salary >= $advance_payment) ? $gross_salary - $advance_payment : 0; // مستحقات متأخرة
        if($employee->workData->type_appointment == 'نسبة'){
            $late_receivables = 0;
        }

        $net_salary = $gross_salary - $late_receivables;

        $amount_letters = Numbers::TafqeetMoney($net_salary,'ILS'); // المبلغ بالنص

        // قرض الإدخار
        $savings_loan = $fixedEntries != null ? $fixedEntries->savings_loan : 0;

        // إجمالي الراتب الاخير الخاص ببرنامج الإكسيل فقط للعرض
        $gross_salary = $secondary_salary +$allowance_boys + $nature_work_increase + $administrative_allowance+ $scientific_qualification_allowance+ $transport + $extra_allowance+ $salary_allowance + $ex_addition + $mobile_allowance+ $termination_service;



        // الراتب الشهري للموظفين الغير مداومين
        if($employee->workData->working_status == 'لا'){
            $advance_payment = Constant::where('type_constant','advance_payment_non_permanent')->first('value')->value;
            $salary_allowance = ($fixedEntries != null) ? $fixedEntries->salary_allowance : 0;

            if($secondary_salary < $advance_payment  ){
                $initial_salary = $initial_salary;
                $secondary_salary = $secondary_salary;
                $gross_salary = $secondary_salary + $salary_allowance;
                $net_salary = $gross_salary;
            }else{
                $initial_salary = $advance_payment;
                $secondary_salary = $advance_payment;
                $gross_salary = $advance_payment + $salary_allowance;
                $net_salary = $gross_salary;
            }
            $amount_letters = Numbers::TafqeetMoney($net_salary,'ILS');
            // حقول مصفرة
            $percentage_allowance = 0;
            $grade_Allowance = 0;
            $allowance_boys = 0;
            $nature_work_increase = 0;
            $termination_service = 0;
            $z_Income = 0;
            $late_receivables = 0;
            $total_discounts = 0;
            $bank = 0;
            $branch_number = 0;
            $account_number = 0;
            $resident_exemption = 0;
            $annual_taxable_amount = 0;
            $tax = 0;
            $exemptions = 0;
            $amount_tax = 0;
            $savings_loan = 0;
            $shekel_loan = 0;
            $association_loan = 0;
            $savings_rate = 0;

            // تصفير الخصم في التعديلات
            $fixedEntries = FixedEntries::find($employee->fixedEntries->where('month',$month)->first() ? $employee->fixedEntries->where('month',$month)->first()->id : null);
            if($fixedEntries != null){
                $fixedEntries->update([
                    "administrative_allowance" => 0,
                    "scientific_qualification_allowance" => 0,
                    "transport" => 0,
                    "extra_allowance" => 0,
                    "ex_addition" => 0,
                    "mobile_allowance" => 0,
                    "health_insurance" => 0,
                    "f_Oredo" => 0,
                    "association_loan" => 0,
                    "tuition_fees" => 0,
                    "voluntary_contributions" => 0,
                    "savings_loan" => 0,
                    "shekel_loan" => 0,
                    "paradise_discount" => 0,
                    "other_discounts" => 0,
                    "proportion_voluntary" => 0,
                    "savings_rate" => 0,
                ]);
            }
        }

        DB::beginTransaction();
        try{
            $salaryOld = Salary::where('employee_id',$employee->id)->where('month',$month)->first();
            Salary::updateOrCreate([
                'employee_id' => $employee->id,
                'month' => ($month),
            ],[
                'percentage_allowance' => $percentage_allowance,
                'initial_salary' => $initial_salary,
                'grade_Allowance' => $grade_Allowance,
                'secondary_salary' => $secondary_salary,
                'allowance_boys' => $allowance_boys,
                'nature_work_increase' => $nature_work_increase,
                'termination_service' =>$termination_service,
                'z_Income' => $z_Income,
                'gross_salary' => $gross_salary,
                'late_receivables' => $late_receivables,
                'total_discounts' => $total_discounts + $late_receivables,
                'net_salary' => $net_salary,
                'amount_letters' => $amount_letters,
                'bank' => $bank,
                'branch_number' => $branch_number,
                'account_number' => $account_number,
                'resident_exemption' => $resident_exemption,
                'annual_taxable_amount' => $annual_taxable_amount, // مبلغ الضريبة الخاضع السنوي بالدولار
                'tax' => $tax,
                'exemptions' => $exemptions,
                'amount_tax' => $amount_tax,
                // حقول ثابتة للتحقق
                'savings_loan' => $savings_loan,
                'shekel_loan' => $shekel_loan,
                'association_loan' => $association_loan,
                'savings_rate' => $savings_rate,
            ]);

            if($salaryOld == null && $employee->workData->type_appointment != 'نسبة'){
                ReceivablesLoans::updateOrCreate([
                    'employee_id' => $employee->id,
                ],[
                    'total_savings_loan' => DB::raw('total_savings_loan - '.($savings_loan)),
                    'total_shekel_loan' => DB::raw('total_shekel_loan - '.($shekel_loan)),
                    'total_association_loan' => DB::raw('total_association_loan - '.($association_loan)),
                    'total_receivables' => DB::raw('total_receivables + '.($late_receivables)),
                    'total_savings' => DB::raw('total_savings + '.($savings_loan + (($savings_rate + $termination_service) / $USD ))),
                ]);
            }
            if($salaryOld != null && $employee->workData->type_appointment != 'نسبة'){
                if(floatval($salaryOld->savings_loan) != $savings_loan){
                    ReceivablesLoans::updateOrCreate([
                        'employee_id' => $employee->id,
                    ],[
                        'total_savings_loan' => DB::raw('total_savings_loan + '.($salaryOld->total_savings_loan) .'-' . ($savings_loan)),
                    ]);
                }
                if(floatval($salaryOld->shekel_loan) != $shekel_loan){
                    ReceivablesLoans::updateOrCreate([
                        'employee_id' => $employee->id,
                    ],[
                        'total_shekel_loan' => DB::raw('total_shekel_loan + '.($salaryOld->total_shekel_loan) .'-' . ($shekel_loan)),
                    ]);
                }
                if(floatval($salaryOld->association_loan) != $association_loan){
                    ReceivablesLoans::updateOrCreate([
                        'employee_id' => $employee->id,
                    ],[
                        'total_association_loan' => DB::raw('total_association_loan + '.($salaryOld->total_association_loan) .'-' . ($association_loan)),
                    ]);
                }
                if(number_format($salaryOld->late_receivables,0) != number_format($late_receivables,0)){
                    ReceivablesLoans::updateOrCreate([
                        'employee_id' => $employee->id,
                    ],[
                        'total_receivables' => DB::raw('total_receivables - '.($salaryOld->late_receivables) .'+' . ($late_receivables)),
                    ]);
                }
                if(floatval($salaryOld->savings_loan) != $savings_loan || floatval($salaryOld->savings_rate) != $savings_rate || floatval($salaryOld->termination_service) != $termination_service){
                    ReceivablesLoans::updateOrCreate([
                        'employee_id' => $employee->id,
                    ],[
                        'total_savings' => DB::raw('total_savings - '.($salaryOld->savings_loan + (($salaryOld->savings_rate + $salaryOld->termination_service) / $USD )) .'+' . ($savings_loan + (($savings_rate + $termination_service) / $USD ))),
                    ]);
                }
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('danger', 'حذث هنالك خطأ بالإدخال يرجى مراجعة المهندس');
        }
    }
}
