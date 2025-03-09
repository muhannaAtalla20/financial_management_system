<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/funFixedView.css') }}">
    @endpush
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول الموظفين</h2>
                    <p class="card-text">هنا يتم عرض بيانات الموظفين الشخصية كاملة.</p>
                    <span  class="btn btn-primary ">عدد الموظفين : {{ $employees->count() }}</span>
                </div>
                <div class="col-auto">
                    @can('create', 'App\\Models\Employee')
                        <a class="btn btn-success" href="{{ route('employees.create') }}">
                            <i class="fe fe-plus"></i>
                        </a>
                    @endcan
                    <button class="btn btn-warning" id="filter-btn" title="التصفية">
                        <i class="fe fe-filter"></i>
                    </button>
                    @can('export', 'App\\Models\Employee')
                        <a class="btn btn-info" href="{{ route('employees.exportExcel') }}" title="تحميل excel">
                            <i class="fe fe-download"></i>Excel
                        </a>
                    @endcan
                    @can('export', 'App\\Models\Employee')
                        <form action="{{ route('employees.view_pdf') }}" id="view_pdf" method="post" class="d-inline"
                            target="_blank">
                            @csrf
                            <button onclick="sendData()" type="button" class="btn btn-primary" title="تحميل pdf">
                                <i class="fe fe-printer"></i>PDF
                            </button>
                        </form>
                        <script>
                            function sendData() {
                                var data = $('#filter-form').serialize();
                                $.ajax({
                                    url: "{{ route('employees.view_pdf') }}",
                                    type: "POST",
                                    data: {
                                        data: data,
                                        filter: true,
                                        _token: "{{ csrf_token() }}",
                                    },
                                    success: function(response) {
                                        $('#view_pdf').submit();
                                        console.log(response);
                                    },
                                    error: function(response) {
                                        console.log(response);
                                    }
                                });
                            }
                        </script>
                    @endcan
                    <form id="filter-form">
                        <div class="form-group col-md-12">
                            <x-form.input class="employee_filter" name="name" placeholder="أدخل الاسم"
                                label="اسم الموظف" />
                        </div>
                    <button style="display: none;" id="openModalShow" data-toggle="modal" data-target="#ModalShow">
                        Launch demo modal
                    </button>
                </div>
            </div>
            <div class="row" id="filter-div" style="display: none;">
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="employee_id" placeholder="أدخل رقم الهوية"
                        label="رقم الهوية" maxlength="9" />
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="area" placeholder="أدخل المنطقة" label="المنظقة"
                        list="areas_list" />
                    <datalist id="areas_list">
                        @foreach ($areas as $area)
                            <option value="{{ $area }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="matrimonial_status"
                        placeholder="أدخل الحالة الزوجية" label="الحالة الزوجية" list="matrimonial_status_list" />
                    <datalist id="matrimonial_status_list">
                        @foreach ($matrimonial_status as $matrimonial_status)
                            <option value="{{ $matrimonial_status }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="scientific_qualification"
                        placeholder="أدخل المؤهل العلمي" label="المؤهل العلمي"
                        list="scientific_qualification_list" />
                    <datalist id="scientific_qualification_list">
                        @foreach ($scientific_qualification as $scientific_qualification)
                            <option value="{{ $scientific_qualification }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="gender" placeholder="أدخل الجنس" label="الجنس"
                        list="gender_list" />
                    <datalist id="gender_list">
                        <option value="ذكر">
                        <option value="انثى">
                    </datalist>
                </div>
                {{-- بيانات العمل --}}
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="working_status" placeholder="أدخل حالة الدوام"
                        label="حالة الدوام" list="working_status_list" />
                    <datalist id="working_status_list">
                        @foreach ($working_status as $working_status)
                            <option value="{{ $working_status }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="type_appointment" placeholder="أدخل نوع التعين"
                        label="نوع التعين" list="type_appointment_list" />
                    <datalist id="type_appointment_list">
                        @foreach ($type_appointment as $type_appointment)
                            <option value="{{ $type_appointment }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="field_action" placeholder="أدخل مجال العمل"
                        label="مجال العمل" list="field_action_list" />
                    <datalist id="field_action_list">
                        @foreach ($field_action as $field_action)
                            <option value="{{ $field_action }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="dual_function" placeholder="أدخل الحالة"
                        label="مزدوج الوظيفة" list="dual_function_list" />
                    <datalist id="dual_function_list">
                        <option value="غير موظف">
                        <option value="موظف">
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="state_effectiveness"
                        placeholder="أدخل حالة الفعالية" label="حالة الفعالية" list="state_effectiveness_list" />
                    <datalist id="state_effectiveness_list">
                        @foreach ($state_effectiveness as $state_effectiveness)
                            <option value="{{ $state_effectiveness }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="nature_work" placeholder="أدخل طبيعة العمل"
                        label="طبيعة العمل" list="nature_work_list" />
                    <datalist id="nature_work_list">
                        @foreach ($nature_work as $nature_work)
                            <option value="{{ $nature_work }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="association" placeholder="أدخل الجمعية"
                        label="الجمعية" list="association_list" />
                    <datalist id="association_list">
                        @foreach ($association as $association)
                            <option value="{{ $association }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="workplace" placeholder="أدخل مكان العمل"
                        label="مكان العمل" list="workplace_list" />
                    <datalist id="workplace_list">
                        @foreach ($workplace as $workplace)
                            <option value="{{ $workplace }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="section" placeholder="أدخل القسم" label="القسم"
                        list="section_list" />
                    <datalist id="section_list">
                        @foreach ($section as $section)
                            <option value="{{ $section }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="dependence" placeholder="أدخل التبعية"
                        label="التبعية" list="dependence_list" />
                    <datalist id="dependence_list">
                        @foreach ($dependence as $dependence)
                            <option value="{{ $dependence }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="establishment" placeholder="أدخل المنشأة"
                        label="المنشأة" list="establishment_list" />
                    <datalist id="establishment_list">
                        @foreach ($establishment as $establishment)
                            <option value="{{ $establishment }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group col-md-3">
                    <x-form.input class="employee_filter" name="payroll_statement" placeholder="أدخل بيان الراتب"
                        label="بيان الراتب" list="payroll_statement_list" />
                    <datalist id="payroll_statement_list">
                        @foreach ($payroll_statement as $payroll_statement)
                            <option value="{{ $payroll_statement }}">
                        @endforeach
                    </datalist>
                </div>
            </div>
            </form>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body p-0">
                            <style>
                                td,th{
                                    color: #000 !important;
                                    padding: 4px 12px !important;
                                }
                            </style>
                            <!-- table -->
                            <table class="table table-bordered table-hover" id="dataTable-1" style="display: table;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>رقم الهوية</th>
                                        <th>نوع التعين</th>
                                        <th>الجمعية</th>
                                        <th>مكان العمل</th>
                                        <th>مجال العمل</th>
                                        <th>عدد <br> أيام <br> العمل</th>
                                        <th>الحالة الزوجية</th>
                                        <th>العلاوة</th>
                                        <th>الدرجة</th>
                                        <th>الحالة</th>
                                        <th>العمر</th>
                                        <th>رقم الهاتف</th>
                                        <th>المنطقة</th>
                                        <th>المؤهل العلمي</th>
                                        <th>الحدث</th>
                                    </tr>
                                </thead>
                                <tbody id="table_employees">
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $employee->name }}</td>
                                            <td>{{ $employee->employee_id }}</td>
                                            <td>{{ $employee->workData->type_appointment }}</td>
                                            <td>{{ $employee->workData->association }}</td>
                                            <td>{{ $employee->workData->workplace }}</td>
                                            <td>{{ $employee->workData->field_action }}</td>
                                            <td>{{ $employee->workData->number_working_days }}</td>
                                            <td>{{ $employee->matrimonial_status }}</td>
                                            <td>{{ $employee->workData->allowance }}</td>
                                            <td>{{ $employee->workData->grade }}</td>
                                            <td>{{ $employee->workData->state_effectiveness }}</td>
                                            <td>{{ $employee->age }}</td>
                                            <td>{{ $employee->phone_number }}</td>
                                            <td>{{ $employee->area }}</td>
                                            <td>{{ $employee->scientific_qualification }}</td>
                                            <td><button class="btn btn-sm dropdown-toggle more-horizontal"
                                                    type="button" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    {{-- <button class="dropdown-item showEmployee"
                                                        data-id="{{ $employee->id }}"
                                                        style="margin: 0.5rem -0.75rem; text-align: right;">عرض</button> --}}
                                                    @can('edit', 'App\\Models\Employee')
                                                        <a class="dropdown-item"
                                                            style="margin: 0.5rem -0.75rem; text-align: right;"
                                                            href="{{ route('employees.edit', $employee->id) }}">تعديل</a>
                                                    @endcan
                                                    @can('delete', 'App\\Models\Employee')
                                                        <form action="{{ route('employees.destroy', $employee->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="dropdown-item"
                                                                style="margin: 0.5rem -0.75rem; text-align: right;"
                                                                href="#">حذف</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div id="links_pages">
                                {{-- {{ $employees->links() }} --}}
                            </div>
                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
    @push('scripts')
        <script src="{{ asset('assets/js/ajax.min.js') }}"></script>
        <script>
            const csrf_token = "{{ csrf_token() }}";
            const app_link = "{{config('app.url')}}";
        </script>
        <script src="{{ asset('js/getShowEmployee.js') }}"></script>
        <script src="{{ asset('js/filterEmployees.js') }}"></script>
    @endpush
</x-front-layout>
