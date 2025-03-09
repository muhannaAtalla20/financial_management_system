<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row align-items-center mb-2">
        <div class="col">
            <h2 class="mb-2 page-title">إضافة إدخالات جديدة</h2>
        </div>
    </div>
    <div class="row">
        <form action="{{ route('fixed_entries.store') }}" method="post" class="col-12">
            @csrf
            @php
                $fields = [
                    'administrative_allowance' => 'العلاوة الإدارية',
                    'scientific_qualification_allowance' => 'العلاوة المؤهل العلمي',
                    'transport' => 'المواصلات',
                    'extra_allowance' => 'بدل إضافي',
                    'salary_allowance' => 'علاوة أغراض راتب',
                    'ex_addition' => 'اضافة بأثر رجعي',
                    'mobile_allowance' => 'علاوة جوال',
                    'health_insurance' => 'تامين صحي',
                    'f_Oredo' => 'ف. اوريدو',
                    'tuition_fees' => 'رسوم دراسية',
                    'voluntary_contributions' => 'تبرعات',
                    'paradise_discount' => 'خصم اللجنة',
                    'other_discounts' => 'خصومات أخرى',
                    'proportion_voluntary' => ' التبرعات للحركة',
                    'savings_rate' => 'ادخار5%',
                ];
                $fieldsLoan=[
                    'association_loan' => 'قرض الجمعية',
                    'savings_loan' => 'قرض ادخار بالدولار',
                    'shekel_loan' => 'قرض اللجنة (الشيكل)',
                ]
            @endphp
            <div class="row">
                <div class="form-group p-3 col-3">
                    <label for="gender">رقم الموظف</label>
                    <div class="input-group mb-3">
                        <x-form.input name="employee_id" placeholder="0" readonly required />
                        @if (!isset($btn_label))
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#searchEmployee">
                                    <i class="fe fe-search"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <label id="employee_name"></label>
                </div>
                @foreach ($fields as $name => $label)
                    <div class="form-group p-3 col-3">
                        <label for="{{ $name }}">{{ $label }}</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" id="{{ $name }}" type="button"
                                    data-toggle="modal" data-target="#open_{{ $name }}">
                                    <i class="fe fe-maximize"></i>
                                </button>
                            </div>
                            <input value="0" type="text" class="form-control" placeholder="" aria-label=""
                                aria-describedby="basic-addon1">
                        </div>
                    </div>
                @endforeach
                @foreach ($fieldsLoan as $name => $label)
                <div class="form-group p-3 col-3">
                    <label for="{{ $name }}">{{ $label }}</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" id="{{ $name }}" type="button"
                                data-toggle="modal" data-target="#open_{{ $name }}">
                                <i class="fe fe-maximize"></i>
                            </button>
                        </div>
                        <input value="0" type="text" class="form-control" placeholder="" aria-label=""
                            aria-describedby="basic-addon1">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row align-items-center mb-2">
                <div class="col">
                </div>
                <div class="col-auto">
                    <a href="{{ route('fixed_entries.index') }}" class="btn btn-primary">
                        {{ $btn_label ?? 'أنتهيت' }}
                    </a>
                </div>
            </div>

            {{-- Models --}}
            @foreach ($fields as $name => $label)
                <div class="modal fade" id="open_{{ $name }}" tabindex="-1" role="dialog"
                    aria-labelledby="open_{{ $name }}Label" aria-hidden="true">
                    <div class="modal-dialog  modal-dialog-centered" role="document" style="max-width: 75%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="open_{{ $name }}Label">تحديد {{ $label }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('fixed_entries.store') }}" method="post">
                                    @csrf
                                    <div class="row mt-3">
                                        <div class="form-group col-md-3">
                                            <h3 class="ml-2">تحديد ثابت لكل شهر</h3>
                                            <x-form.input name="{{ $name }}_months" type="number"
                                                placeholder="0" />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <h3 class="ml-3">تحديد لكل شهر</h3>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">يناير</th>
                                                    <th scope="col">فبراير</th>
                                                    <th scope="col">مارس</th>
                                                    <th scope="col">أبريل</th>
                                                    <th scope="col">مايو</th>
                                                    <th scope="col">يونيو</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-1" name="{{ $name }}_month-1" class="form-control" placeholder="0."  @disabled($month > 1)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-2" name="{{ $name }}_month-2" class="form-control" placeholder="0." @disabled($month > 2)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-3" name="{{ $name }}_month-3" class="form-control" placeholder="0." @disabled($month > 3)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-4" name="{{ $name }}_month-4" class="form-control" placeholder="0." @disabled($month > 4)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-5" name="{{ $name }}_month-5" class="form-control" placeholder="0." @disabled($month > 5)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-6" name="{{ $name }}_month-6" class="form-control" placeholder="0." @disabled($month > 6)>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">يوليو</th>
                                                    <th scope="col">أغسطس</th>
                                                    <th scope="col">سبتمبر</th>
                                                    <th scope="col">أكتوبر</th>
                                                    <th scope="col">نوفمبر</th>
                                                    <th scope="col">ديسمبر</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-7" name="{{ $name }}_month-7" class="form-control" placeholder="0."   @disabled($month > 7)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-8" name="{{ $name }}_month-8" class="form-control" placeholder="0."  @disabled($month > 8)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-9" name="{{ $name }}_month-9" class="form-control" placeholder="0." @disabled($month > 9)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-10" name="{{ $name }}_month-10" class="form-control" placeholder="0."  @disabled($month > 10)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-11" name="{{ $name }}_month-11" class="form-control" placeholder="0." @disabled($month > 11)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-12" name="{{ $name }}_month-12" class="form-control" placeholder="0."  @disabled($month > 12)>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-status="create" id="{{ $name }}_form"
                                            class="btn btn-primary">إنشاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach ($fieldsLoan as $name => $label)
                <div class="modal fade" id="open_{{$name}}" tabindex="-1" role="dialog"
                    aria-labelledby="open_{{$name}}Label" aria-hidden="true">
                    <div class="modal-dialog  modal-dialog-centered" role="document" style="max-width: 75%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="open_{{$name}}Label">تحديد {{$label}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('fixed_entries.store') }}" method="post">
                                    @csrf
                                    <div class="row mt-3 align-items-center">
                                        <span>يصرف الإجمالي على كل شهر </span>
                                        <div class="form-group col-md-3 m-0">
                                            <x-form.input name="{{$name}}_months" type="number"
                                                class="d-inline {{$name}}_fields" placeholder="200..." />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <h3 class="ml-3">تحديد لكل شهر</h3>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">يناير</th>
                                                    <th scope="col">فبراير</th>
                                                    <th scope="col">مارس</th>
                                                    <th scope="col">أبريل</th>
                                                    <th scope="col">مايو</th>
                                                    <th scope="col">يونيو</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-1"
                                                            name="{{ $name }}_month-1"
                                                            class="form-control {{$name}}_fields_month"
                                                            placeholder="0." @disabled($month > 1)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-2"
                                                            name="{{ $name }}_month-2"
                                                            class="form-control {{$name}}_fields_month"
                                                            placeholder="0." @disabled($month > 2)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-3"
                                                            name="{{ $name }}_month-3"
                                                            class="form-control {{$name}}_fields_month"
                                                            placeholder="0." @disabled($month > 3)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-4"
                                                            name="{{ $name }}_month-4"
                                                            class="form-control {{$name}}_fields_month"
                                                            placeholder="0." @disabled($month > 4)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-5"
                                                            name="{{ $name }}_month-5"
                                                            class="form-control {{$name}}_fields_month"
                                                            placeholder="0." @disabled($month > 5)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-6"
                                                            name="{{ $name }}_month-6"
                                                            class="form-control {{$name}}_fields_month"
                                                            placeholder="0." @disabled($month > 6)>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">يوليو</th>
                                                    <th scope="col">أغسطس</th>
                                                    <th scope="col">سبتمبر</th>
                                                    <th scope="col">أكتوبر</th>
                                                    <th scope="col">نوفمبر</th>
                                                    <th scope="col">ديسمبر</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-7"
                                                            name="{{ $name }}_month-7"
                                                            class="form-control {{$name}}_fields_month"
                                                            placeholder="0." @disabled($month > 7)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-8"
                                                            name="{{ $name }}_month-8"
                                                            class="form-control {{$name}}_fields_month"
                                                            placeholder="0." @disabled($month > 8)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-9"
                                                            name="{{ $name }}_month-9"
                                                            class="form-control {{$name}}_fields_month"
                                                            placeholder="0." @disabled($month > 9)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-10"
                                                            name="{{ $name }}_month-10"
                                                            class="form-control {{$name}}_fields_month"
                                                            placeholder="0." @disabled($month > 10)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-11"
                                                            name="{{ $name }}_month-11"
                                                            class="form-control {{$name}}_fields_month"
                                                            placeholder="0." @disabled($month > 11)>
                                                    </td>
                                                    <td>
                                                        <input value="0" type="number" id="{{ $name }}_month-12"
                                                            name="{{ $name }}_month-12"
                                                            class="form-control {{$name}}_fields_month"
                                                            placeholder="0." @disabled($month > 12)>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="row mt-3 align-items-center">
                                        <span>المبلغ الإجمالي القديم</span>
                                        <span id="total_{{$name}}_old">
                                            @if ($name == 'association_loan')
                                                {{ intval($total_association_loan_old) }}
                                            @elseif ($name == 'savings_loan')
                                                {{ intval($total_savings_loan_old) }}
                                            @elseif ($name == 'shekel_loan')
                                                {{ intval($total_shekel_loan_old) }}
                                            @endif
                                        </span>
                                        <span>المبلغ الإجمالي المتبقي</span>
                                        <div class="form-group col-md-3 m-0">
                                            <x-form.input name="total_{{$name}}" type="number" class="d-inline"
                                                placeholder="00...." />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-status="create" id="{{ $name }}_form"
                                            class="btn btn-primary"  >إنشاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </form>
    </div>


    {{-- إختيار الموظف --}}
    <div class="modal fade" id="searchEmployee" tabindex="-1" role="dialog" aria-labelledby="searchEmployeeLabel"
        aria-hidden="true">
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
                                <x-form.input name="employee_id_search" label="رقم الهوية" type="number"
                                    class="employee_fields_search" placeholder="إملا رقم هوية الموظف" />
                            </div>
                            <div class="form-group col-md-6">
                                <x-form.input name="employee_name_search" label="إسم الموظف" type="text"
                                    class="employee_fields_search" placeholder="إملا إسم الموظف" />
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
            const csrf_token = "{{ csrf_token() }}";
            const app_link = "{{config('app.url')}}";
        </script>
        <script src="{{ asset('js/getEmployee.js') }}"></script>
        <script src="{{ asset('js/sendEmployeeData.js') }}"></script>
    @endpush
</x-front-layout>
