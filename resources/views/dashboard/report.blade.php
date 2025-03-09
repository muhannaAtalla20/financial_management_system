<x-front-layout>
    @push('styles')
    <link rel="stylesheet" href="css/select2.css">
    @endpush
    <div class="row align-items-center mb-2">
        <div class="col">
            <h2 class="h5 page-title">إنتاج التقارير</h2>
        </div>
    </div>
    <div class="row justify-content-between">
        <form action="{{route('report.export')}}" method="post" class="col-12" target="_blank">
            @csrf
            <div class="row">
                <div class="form-group col-md-3">
                    <x-form.input type="month" :value="$month" name="month" label="الشهر المطلوب (الشهر الاول)" />
                </div>
                <div class="form-group col-md-3">
                    <x-form.input type="month"  name="to_month" label="الى شهر" />
                </div>
                <div class="form-group col-md-3">
                    <label for="area">المنظقة</label>
                    <select name="area[]" id="area" class="form-control select2-multi" multiple>
                        @foreach ($areas as $area)
                            <option value="{{ $area }}"> {{ $area }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="matrimonial_status">الحالة الزوجية</label>
                    <select name="matrimonial_status[]" id="matrimonial_status" class="form-control select2-multi" multiple >
                        @foreach ($matrimonial_status as $matrimonial_status)
                            <option value="{{ $matrimonial_status }}"> {{ $matrimonial_status }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="scientific_qualification">المؤهل العلمي</label>
                    <select name="scientific_qualification[]" id="scientific_qualification" class="form-control select2-multi" multiple >
                        @foreach ($scientific_qualification as $scientific_qualification)
                            <option value="{{ $scientific_qualification }}">{{ $scientific_qualification }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="gender">الجنس</label>
                    <select name="gender[]" id="gender" class="form-control select2-multi" multiple >
                        <option value="ذكر">ذكور</option>
                        <option value="انثى">إناث</option>
                    </select>
                </div>
                {{-- بيانات العمل --}}
                <div class="form-group col-md-3">
                    <label for="working_status">حالة الدوام</label>
                    <select name="working_status[]" id="working_status" class="form-control select2-multi" multiple >
                        @foreach ($working_status as $working_status)
                            <option value="{{ $working_status }}">{{ $working_status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="field_action">مجال العمل</label>
                    <select name="field_action[]" id="field_action" class="form-control select2-multi" multiple >
                        @foreach ($field_action as $field_action)
                            <option value="{{ $field_action }}">{{ $field_action }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="dual_function">مزدوج الوظيفة</label>
                    <select name="dual_function[]" id="dual_function"   class="form-control select2-multi" multiple >
                        <option value="غير موظف"> غير موظف</option>
                        <option value="موظف"> موظف</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="state_effectiveness">حالة الفعالية</label>
                    <select name="state_effectiveness[]" id="state_effectiveness" class="form-control select2-multi" multiple >
                        @foreach ($state_effectiveness as $state_effectiveness)
                            <option value="{{ $state_effectiveness }}">{{ $state_effectiveness }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="nature_work">طبيعة العمل</label>
                    <select name="nature_work[]" id="nature_work"   class="form-control select2-multi" multiple >
                        @foreach ($nature_work as $nature_work)
                            <option value="{{ $nature_work }}">{{ $nature_work }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="workplace">مكان العمل</label>
                    <select name="workplace[]" id="workplace"   class="form-control select2-multi" multiple >
                        @foreach ($workplace as $workplace)
                            <option value="{{ $workplace }}">{{ $workplace }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="section">القسم</label>
                    <select name="section[]" id="section"   class="form-control select2-multi" multiple >
                        @foreach ($section as $section)
                            <option value="{{ $section }}">{{ $section }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="type_appointment">نوع التعين</label>
                    <select name="type_appointment[]" id="type_appointment"   class="form-control select2-multi" multiple >
                        @foreach ($type_appointment as $type_appointment)
                            <option value="{{ $type_appointment }}">{{ $type_appointment }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="dependence">التبعية</label>
                    <select name="dependence[]" id="dependence"   class="form-control select2-multi" multiple >
                        @foreach ($dependence as $dependence)
                            <option value="{{ $dependence }}">{{ $dependence }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="establishment">المنشأة</label>
                    <select name="establishment[]" id="establishment"   class="form-control select2-multi" multiple >
                        @foreach ($establishment as $establishment)
                            <option value="{{ $establishment }}">{{ $establishment }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="payroll_statement">بيان الراتب</label>
                    <select name="payroll_statement[]" id="payroll_statement"   class="form-control select2-multi" multiple >
                        @foreach ($payroll_statement as $payroll_statement)
                            <option value="{{ $payroll_statement }}">{{ $payroll_statement }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="association">الجمعية</label>
                    <select name="association[]" id="association" class="form-control select2-multi" multiple >
                        @foreach ($association as $association)
                            <option value="{{ $association }}">{{ $association }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- إضافات --}}
                <div class="form-group col-md-3">
                    <label for="report_type">نوع الكشف</label>
                    <select class="custom-select" name="report_type" id="report_type" required>
                        <option  value="" disabled selected>حدد نوع الكشف</option>
                        <optgroup label="الكشوفات الأساسية">
                            <option value="employees">كشف موظفين</option>
                            <option value="salaries">كشف الرواتب</option>
                            <option value="accounts">كشف حسابات البنك</option>
                            <option value="employees_totals">كشف المستحقات والقروض</option>
                            <option value="employees_fixed">كشف التعديلات</option>
                            <option value="bank" >كشف الصرف</option>
                            <option value="customization">كشف التخصيصات</option>
                        </optgroup>
                        <optgroup label="كشوفات لموظف معين">
                            <option value="employee_accounts">كشف الحساب</option>
                            <option value="employee_salaries">كشف الرواتب للموظف</option>
                            <option value="employee_receivables_savings">كشف المستحقات والإدخارات</option>
                            <option value="employee_loans">كشف القروض</option>
                        </optgroup>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="export_type">طريقة التصدير</label>
                    <select class="custom-select" name="export_type" id="export_type">
                        <option selected="" value="view">معاينة</option>
                        <option value="export_pdf">PDF</option>
                        <option value="export_excel">Excel</option>
                    </select>
                </div>
                <div class="form-group p-3 col-4">
                    <label for="gender">إختيار موظف معين</label>
                    <div class="input-group mb-3">
                        <x-form.input name="employee_id" placeholder="0"/>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchEmployee">
                                <i class="fe fe-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="bankDiv" style="display: none;">
                <div class="form-group col-md-3">
                    <label for="exchange_type">نوع الصرف</label>
                    <select name="exchange_type" id="exchange_type" class="custom-select" >
                        <option value="cash" selected>نقدي</option>
                        <option value="bank">بنك</option>
                    </select>
                </div>
                <div class="form-group col-md-3" id="bank_select" style="display: none;">
                    <label for="bank">البنك</label>
                    <select name="bank" id="bank" class="custom-select" >
                        <option value="" selected>حدد البنك المراد</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank}}">{{ $bank }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="h5 page-title"></h2>
                </div>
                <div class="col-auto">
                    <button type="reset"  class="btn btn-danger">
                        مسح
                    </button>
                    <button type="submit"  class="btn btn-primary">
                        تصدير
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="searchEmployee" tabindex="-1" role="dialog" aria-labelledby="searchEmployeeLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchEmployeeLabel">البحث عن الموظفين</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="row mt-3">
                            <div class="form-group col-md-6">
                                <x-form.input name="employee_id_search" label="رقم الهوية" type="number" class="employee_fields_search"
                                    placeholder="إملا رقم هوية الموظف"  />
                            </div>
                            <div class="form-group col-md-6">
                                <x-form.input name="employee_name_search" label="إسم الموظف" type="text" class="employee_fields_search"
                                    placeholder="إملا إسم الموظف" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">رقم الموظف</th>
                                    <th scope="col">رقم الهوية</th>
                                    <th scope="col">الإسم</th>
                                    <th scope="col">تاريخ الميلاد</th>
                                </tr>
                            </thead>
                            <tbody id="table_employee">
                                <tr>
                                    <td colspan='4'>يرجى تعبئة البيانات</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        const csrf_token = "{{csrf_token()}}";
        const app_link = "{{config('app.url')}}";
    </script>
    <script src="{{asset('js/report.js')}}"></script>
    <script src="{{ asset('js/getEmployee.js') }}"></script>
    <script src='js/select2.min.js'></script>
    <script>
        $('.select2-multi').select2(
        {
          multiple: true,
          theme: 'bootstrap4',
        });
    </script>
    @endpush

</x-front-layout>
