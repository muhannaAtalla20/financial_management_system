
<h2 class="h3">البيانات الشخصية</h2>
<div class="row">
    <div class="form-group p-3 col-3">
        <x-form.input label="إسم الموظف" :value="$employee->name"  name="name" placeholder="أحمد محمد ...." required/>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input label="رقم الهوية" minlength="9" maxlength="9" :value="$employee->employee_id"  name="employee_id" placeholder="400000000" required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="date" label="تاريخ الميلاد" :value="$employee->date_of_birth"  name="date_of_birth" required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" label="العمر" :value="$employee->age"  name="age" readonly  />
    </div>
    <div class="form-group p-3 col-3">
        <label for="gender">الجنس</label>
        <select class="custom-select" id="gender" name="gender" required >
            <option value="ذكر">ذكر</option>
            <option value="انثى">انثى</option>
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input name="matrimonial_status" placeholder="أدخل الحالة الزوجية" :value="$employee->matrimonial_status" label="الحالة الزوجية" list="matrimonial_status_list" required />
        <datalist id="matrimonial_status_list">
            @foreach ($matrimonial_status as $matrimonial_status)
                <option value="{{ $matrimonial_status }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" label="عدد الزوجات" min="0" value="{{$employee->number_wives ?? 0}}"  name="number_wives" placeholder="0" required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" label="عدد الأولاد"  min="0" value="{{$employee->number_children ?? 0}}"  name="number_children" placeholder="0" required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" label="عدد الأولاد في الجامعة"  min="0" value="{{$employee->number_university_children ?? 0}}"  name="number_university_children" placeholder="0" required />
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="scientific_qualification" placeholder="أدخل المؤهل العلمي" :value="$employee->scientific_qualification" label="المؤهل العلمي" list="scientific_qualification_list" required />
        <datalist id="scientific_qualification_list">
            @foreach ($scientific_qualification as $scientific_qualification)
                <option value="{{ $scientific_qualification }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="text" label="التخصص" :value="$employee->specialization"  name="specialization" placeholder="محاسبة...." />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="text" label="الجامعة" :value="$employee->university"  name="university" placeholder="الأزهر...." />
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="area" placeholder="أدخل المنطقة" :value="$employee->area" label="المنظقة" list="areas_list" required />
        <datalist id="areas_list">
            @foreach ($areas as $area)
                <option value="{{ $area }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="text" label="العنوان بالتفصيل" :value="$employee->address"  name="address" placeholder="دير البلح - شارع يافا - حي البشارة - مستشفى يافا"/>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="email" label="الإيميل" :value="$employee->email"  name="email" placeholder="email@example.com" />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="text" label="رقم الهاتف" :value="$employee->phone_number"  name="phone_number" placeholder="(734) 767-4418" />
    </div>

</div>

<h2 class="h3">بيانات العمل</h2>
<div class="row">
    <div class="form-group p-3 col-md-3">
        <label for="type_appointment">أدخل نوع التعين (العقد)</label>
        <select class="custom-select" id="type_appointment" name="type_appointment" required>
            <option value="" disabled @selected($workData->type_appointment == null)>عرض القيم المتوفرة</option>
            <option value="مثبت" @selected($workData->type_appointment == 'مثبت')>مثبت</option>
            <option value="نسبة" @selected($workData->type_appointment == 'نسبة')>نسبة</option>
            <option value="خاص" @selected($workData->type_appointment == 'خاص')>خاص</option>
            <option value="رياض" @selected($workData->type_appointment == 'رياض')>رياض</option>
            <option value="فصلي" @selected($workData->type_appointment == 'فصلي')>فصلي</option>
            <option value="يومي" @selected($workData->type_appointment == 'يومي')>يومي</option>
            <option value="مؤقت" @selected($workData->type_appointment == 'مؤقت')>مؤقت</option>
        </select>
    </div>

    {{-- حقول خاصة بالموظف الثابت --}}
    <div class="row" id="proven" @if($workData->type_appointment == 'مثبت') style="display: flex; margin: 0; " @else style="display: none" @endif>
        <div class="form-group p-3 col-3">
            <x-form.input type="number" label="درجة العلاوة من السلم" min="0" max="40" :value="$workData->allowance" name="allowance" placeholder="0" />
        </div>
        <div class="form-group p-3 col-3">
            <label for="grade">الدرجة في سلم الرواتب</label>
            <select class="custom-select" id="grade" name="grade" required>
                <option value="" disabled>عرض القيم المتوفرة</option>
                <option value="10" @selected($workData->grade == 10)>10</option>
                <option value="9" @selected($workData->grade == 9)>9</option>
                <option value="8" @selected($workData->grade == 8)>8</option>
                <option value="7" @selected($workData->grade == 7)>7</option>
                <option value="6" @selected($workData->grade == 6)>6</option>
                <option value="5" @selected($workData->grade == 5)>5</option>
                <option value="4" @selected($workData->grade == 4)>4</option>
                <option value="3" @selected($workData->grade == 3)>3</option>
                <option value="2" @selected($workData->grade == 2)>2</option>
                <option value="1" @selected($workData->grade == 1)>1</option>
                <option value="C" @selected($workData->grade == "C")>C</option>
                <option value="B" @selected($workData->grade == "B")>B</option>
                <option value="A" @selected($workData->grade == "A")>A</option>
            </select>
        </div>
        <div class="form-group p-3 col-3">
            <x-form.input type="number" label="نسبة علاوة درجة" step="0.01" :value="$workData->grade_allowance_ratio" name="grade_allowance_ratio" placeholder="0.55" />
        </div>
        <div class="form-group p-3 col-3">
            <x-form.input type="number" label="نسبة علاوة طبيعة العمل" :value="$workData->percentage_allowance" name="percentage_allowance" placeholder="10.."/>
        </div>
        <div class="form-group p-3 col-3">
            <label for="salary_category">فئة الراتب</label>
            <select class="custom-select" id="salary_category" name="salary_category">
                <option >عرض القيم المتوفرة</option>
                <option value="1"  @selected($workData->salary_category == 1)>الأولى</option>
                <option value="2"  @selected($workData->salary_category == 2)>الثانية</option>
                <option value="3"  @selected($workData->salary_category == 3)>الثالثة</option>
                <option value="4"  @selected($workData->salary_category == 4)>الرابعة</option>
                <option value="5"  @selected($workData->salary_category == 5)>الخامسة</option>
            </select>
        </div>
        <div class="form-group p-3 col-3">
            <label for="installation_new">هل هو مثبت جديد</label>
            <select class="custom-select" id="installation_new" name="installation_new">
                <option value="null">عرض القيم المتوفرة</option>
                <option value="مثبت جديد"  @selected($workData->installation_new == 'مثبت جديد')>مثبت جديد (العلاوة * 10)</option>
                <option value="مثبت جديد2"  @selected($workData->installation_new == 'مثبت جديد2')>مثبت جديد (العلاوة * 20)</option>
            </select>
        </div>
    </div>

    <div id="notProven" class="form-group p-3 col-3" @if($workData->type_appointment != 'مثبت' && $workData->type_appointment != 'نسبة' && $workData->type_appointment != null) style="display: block; margin: 0; " @else style="display: none" @endif>
        <x-form.input type="number" label="الراتب المحدد" min="0" :value="$employee->specificSalaries()->where('month', '0000-00')->first()->salary ?? 0" name="specific_salary" placeholder="0" />
    </div>

    <div class="row col-md-9" id="daily" @if($workData->type_appointment == 'يومي') style="display: flex; margin: 0; " @else style="display: none" @endif>
        <div class="form-group p-3 col-4">
            <x-form.input type="number" label="عدد الأيام" class="daily_fields" min="0" data-name="number_of_days"  :value="$employee->specificSalaries()->where('month', '0000-00')->first()->number_of_days ?? 0" name="number_of_days" placeholder="0" />
        </div>
        <div class="form-group p-3 col-4">
            <x-form.input type="number" label="سعر اليوم" class="daily_fields" min="0" data-name="today_price" :value="$employee->specificSalaries()->where('month', '0000-00')->first()->today_price ?? 0" name="today_price" placeholder="0" />
        </div>
        <div class="form-group p-3 col-4">
            <x-form.input type="number" label="الراتب المحدد" class="daily_fields" :value="$employee->specificSalaries()->where('month', '0000-00')->first()->salary ?? 0" name="specificSalary" placeholder="0" readonly />
        </div>
    </div>


    <div class="form-group p-3 col-3">
        <x-form.input type="date" label="تاريخ العمل" :value="$workData->working_date"  name="working_date" required />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="date" label="تاريخ التثبيت" :value="$workData->date_installation"  name="date_installation" />
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" label="سنوات الخدمة" :value="$workData->years_service" name="years_service" placeholder="0" readonly  />
    </div>

    <div class="form-group p-3 col-3">
        <x-form.input type="date" label="تاريخ التقاعد" :value="$workData->date_retirement" name="date_retirement" readonly />
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="working_status" placeholder="أدخل حالة الدوام" :value="$workData->working_status" label="حالة الدوام" list="working_status_list" required />
        <datalist id="working_status_list">
            @foreach ($working_status as $working_status)
                <option value="{{ $working_status }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input label="عدد الأيام العمل"  :value="$employee->number_working_days" name="number_working_days" />
        <datalist id="number_working_days">
            <option value="جزئي">
            <option value="يومي">
        </datalist>
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="contract_type" placeholder="أدخل نوع العقد" :value="$workData->contract_type" label="نوع العقد" list="contract_type_list" />
        <datalist id="contract_type_list">
            @foreach ($contract_type as $contract_type)
                <option value="{{ $contract_type }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-3">
        <label for="dual_function">مزدوج الوظيفة</label>
        <select class="custom-select" id="dual_function" name="dual_function" required >
            <option value="غير موظف" @selected($workData->dual_function == "غير موظف" || $workData->dual_function == null)>غير موظف</option>
            <option value="موظف" @selected($workData->dual_function == "موظف")>موظف</option>
        </select>
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="field_action" placeholder="أدخل مجال العمل" :value="$workData->field_action" label="مجال العمل" list="field_action_list" required />
        <datalist id="field_action_list">
            @foreach ($field_action as $field_action)
                <option value="{{ $field_action }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="state_effectiveness" placeholder="أدخل حالة الفعالية" :value="$workData->state_effectiveness" label="حالة الفعالية" list="state_effectiveness_list" required />
        <datalist id="state_effectiveness_list">
            @foreach ($state_effectiveness as $state_effectiveness)
                <option value="{{ $state_effectiveness }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="nature_work" placeholder="أدخل طبيعة العمل" :value="$workData->nature_work" label="طبيعة العمل" list="nature_work_list" required />
        <datalist id="nature_work_list">
            @foreach ($nature_work as $nature_work)
                <option value="{{ $nature_work }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="association" placeholder="أدخل الجمعية" :value="$workData->association" label="الجمعية" list="association_list" required />
        <datalist id="association_list">
            @foreach ($association as $association)
                <option value="{{ $association }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="workplace" placeholder="أدخل مكان العمل" :value="$workData->workplace" label="مكان العمل" list="workplace_list" required />
        <datalist id="workplace_list">
            @foreach ($workplace as $workplace)
                <option value="{{ $workplace }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="section" placeholder="أدخل القسم" :value="$workData->section" label="القسم" list="section_list" required />
        <datalist id="section_list">
            @foreach ($section as $section)
                <option value="{{ $section }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="dependence" placeholder="أدخل التبعية" :value="$workData->dependence" label="التبعية" list="dependence_list" required />
        <datalist id="dependence_list">
            @foreach ($dependence as $dependence)
                <option value="{{ $dependence }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="establishment" placeholder="أدخل المنشأة" :value="$workData->establishment" label="المنشأة" list="establishment_list" required />
        <datalist id="establishment_list">
            @foreach ($establishment as $establishment)
                <option value="{{ $establishment }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="foundation_E" placeholder="أدخل المؤسسة بالإنجليزي" :value="$workData->foundation_E" label="المؤسسة بالإنجليزي" list="foundation_E_list" required />
        <datalist id="foundation_E_list">
            @foreach ($foundation_E as $foundation_E)
                <option value="{{ $foundation_E }}">
            @endforeach
        </datalist>
    </div>
    <div class="form-group p-3 col-md-3">
        <x-form.input name="payroll_statement" placeholder="أدخل بيان الراتب" :value="$workData->payroll_statement" label="بيان الراتب" list="payroll_statement_list" required />
        <datalist id="payroll_statement_list">
            @foreach ($payroll_statement as $payroll_statement)
                <option value="{{ $payroll_statement }}">
            @endforeach
        </datalist>
    </div>

</div>


<h2 class="h3">حساب البنك الأساسي</h2>
<div class="row">
    <div class="form-group p-3 col-3">
        <label for="bank_id">البنك - الفرع</label>
        <select class="custom-select" id="bank_id" name="bank_id" required>
            <option @selected($bank_employee->bank_id == null)>عرض القيم المتوفرة</option>
            @foreach ($banks as $bank)
                <option value="{{$bank['id']}}" @selected($bank_employee->bank_id == $bank['id'])>{{$bank['name'] . " - " . $bank['branch'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input minlength="9" maxlength="9" label="رقم الحساب" :value="$bank_employee->account_number"  name="account_number" placeholder="4000000" required/>
    </div>
</div>
<h2 class="h3">قسم الإجماليات</h2>
<div class="row">
    <div class="form-group p-3 col-3">
        <x-form.input type="number" step="0.01" label="إجمالي المستحقات" :value="$totals->total_receivables" name="total_receivables" placeholder="المستحقات الخاصة به"/>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" step="0.01"  label="إجمالي الإدخارات" :value="$totals->total_savings" name="total_savings" placeholder="الإدخارات الخاصة به"/>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" step="0.01" min="0" label="قرض الجمعية" :value="$totals->total_association_loan" name="total_association_loan" placeholder=""/>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" step="0.01" min="0" label="قرض الإدخار $" :value="$totals->total_savings_loan" name="total_savings_loan" placeholder=""/>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" step="0.01" min="0" label="قرض اللجنة" :value="$totals->total_shekel_loan" name="total_shekel_loan" placeholder=""/>
    </div>
</div>


<div class="row align-items-center mb-2">
    <div class="col">
        <h2 class="h5 page-title"></h2>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">
            {{$btn_label ?? "أضف"}}
        </button>
    </div>
</div>
@push('scripts')
    <script>
        let number_of_days = 0;
        let today_price = 0;
        $('.daily_fields').on('input', function () {
            let name = $(this).data("name");
            if(name == 'number_of_days') {
                number_of_days = $(this).val();
            }
            if(name == 'today_price') {
                today_price = $(this).val();
            }
            let total = number_of_days * today_price;
            $("input[name='specificSalary']").val(total)
        });
    </script>

    <script>

        $("input[name='date_of_birth']").on("input", function () {
            let date_of_birth = $("input[name='date_of_birth']").val();
            let thisYear = new Date().getFullYear();
            let year_of_birth = moment(date_of_birth).format('YYYY');
            $("input[name='age']").val(thisYear - year_of_birth);
            let futureDate = moment(date_of_birth, "YYYY-MM-DD").add(60, "years").format("YYYY-MM-DD");
            $("input[name='date_retirement']").val(futureDate);
        });
        $("input[name='date_installation']").on("input", function () {
            let thisYear = new Date().getFullYear();
            let date_installation = moment($("input[name='date_installation']").val()).format('YYYY');
            $("input[name='years_service']").val(thisYear - date_installation)
        });
        const app_link = "{{config('app.url')}}";

    </script>
    <script src="{{asset('js/formEmployee.js')}}"></script>
@endpush
