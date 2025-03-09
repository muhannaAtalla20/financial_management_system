<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    @push('styles')
    <style>
        hr {
            position: absolute;
            top: 50px;
            right: 15px;
            width: 35%;
            height: 5px;
            border-radius: 10px;
            background: linear-gradient(to right, rgba(210, 255, 82, 1) 0%, rgba(40, 64, 18, 1) 100%);
            margin: 0;
        }

        .drop-container {
            position: relative;
            display: flex;
            gap: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 200px;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #555;
            color: #444;
            cursor: pointer;
            transition: background .2s ease-in-out, border .2s ease-in-out;
        }

        .drop-container:hover {
            background: #eee;
            border-color: #111;
        }

        .drop-container:hover .drop-title {
            color: #222;
        }

        .drop-title {
            color: #444;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            transition: color .2s ease-in-out;
        }
    </style>
@endpush
    <div class="row align-items-center mb-2">
        <div class="col">
            <h2 class="mb-2 page-title">تعديل بيانات الموظف : {{$employee->name}}</h2>
            <hr>
        </div>
    </div>
    <div class="row">
        <form action="{{route('employees.update',$employee->id)}}" method="post" class="col-12  mt-3">
            @csrf
            @method('PUT')
            @include("dashboard.employees._form")
            <h2 class="h3 mb-3">رواتب السنة الحالية</h2>
            <div class="container-fluid">
                <table class="table table-bordered table-hover">
                    <thead>
                        <style>
                            th {
                                text-align: center;
                                color: #000 !important;
                            }
                        </style>
                        <tr style="background: #dddddd;">
                            <th>#</th>
                            <th>الشهر</th>
                            <th>الراتب <br> الاساسي</th>
                            <th>علاوة <br> الأولاد</th>
                            <th>علاوة <br> طبيعة <br> العمل</th>
                            <th>علاوة <br> إدارية</th>
                            <th>علاوة <br> مؤهل <br> علمي</th>
                            <th>المواصلات</th>
                            <th>بدل <br> إضافي <br> +-</th>
                            <th>علاوة <br> أغراض <br> راتب</th>
                            <th>إضافة <br> بأثر <br> رجعي</th>
                            <th>علاوة <br> جوال</th>
                            <th>نهاية <br> الخدمة</th>
                            <th>إجمالي <br> الراتب</th>
                            <th>تأمين <br> صحي</th>
                            <th>ض.دخل</th>
                            <th>إدخار 5%</th>
                            <th>قرض <br> الجمعية</th>
                            <th>قرض <br> الإدخار</th>
                            <th>قرض <br> شيكل</th>
                            <th>مستحقات <br> متأخرة</th>
                            <th>إجمالي <br> الخصومات</th>
                            <th>صافي <br> الراتب</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salaries as $salary)
                            @php
                                $fixedEntries = App\Models\FixedEntries::where('employee_id',$salary->employee_id)->where('month',$salary->month)->first();
                                $fixedEntries = $fixedEntries ?? new App\Models\FixedEntries();
                                if($salary->employee->workData->working_status == 'لا'){
                                    $fixedEntries = new  App\Models\FixedEntries();
                                }
                            @endphp
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td style="white-space: nowrap;">{{$salary->month ?? ''}}</td>
                                <td>{{$salary->secondary_salary ?? ''}}</td>
                                <td>{{$salary->allowance_boys ?? ''}}</td>
                                <td>{{$salary->nature_work_increase ?? ''}}</td>
                                <td>{{$fixedEntries->administrative_allowance ?? ''}}</td>
                                <td>{{$fixedEntries->scientific_qualification_allowance ?? ''}}</td>
                                <td>{{$fixedEntries->transport ?? ''}}</td>
                                <td>{{$fixedEntries->extra_allowance ?? ''}}</td>
                                <td>{{$fixedEntries->salary_allowance ?? ''}}</td>
                                <td>{{$fixedEntries->ex_addition ?? ''}}</td>
                                <td>{{$fixedEntries->mobile_allowance ?? ''}}</td>
                                <td>{{$salary->termination_service ?? ''}}</td>
                                <td>{{$salary->gross_salary }}</td>
                                <td>{{$fixedEntries->health_insurance ?? ''}}</td>
                                <td>{{$salary->z_Income ?? ''}}</td>
                                <td>{{$fixedEntries->savings_rate ?? ''}}</td>
                                <td>{{$fixedEntries->association_loan ?? ''}}</td>
                                <td>{{$fixedEntries != null  ? $fixedEntries->savings_loan * $USD : ''}}</td>
                                <td>{{$fixedEntries->shekel_loan ?? ''}}</td>
                                <td>{{$salary->late_receivables ?? ''}}</td>
                                <td>{{$salary->total_discounts ?? ''}}</td>
                                <td style="color: #000; background: #dddddd; font-weight: bold;">{{$salary->net_salary ?? ''}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>

</x-front-layout>
