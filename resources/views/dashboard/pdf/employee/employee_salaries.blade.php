<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>كشف الرواتب لموظف المعين</title>
    <style>
        body {
            font-family: 'XBRiyaz', sans-serif;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }
    </style>
    <style>
        table.blueTable {
            width: 100%;
            text-align: right;
            border-collapse: collapse;
        }

        table.blueTable td,
        table.blueTable th {
            border: 1px solid #AAAAAA;
            padding: 5px 9px;
            white-space: nowrap;
        }

        table.blueTable tbody td {
            font-size: 13px;
            color: #000000;
        }

        table.blueTable tr:nth-child(even) {
            background: #F5F5F5;
        }

        table.blueTable thead {
            background: #D3D3D3;
            background: -moz-linear-gradient(top, #dedede 0%, #d7d7d7 66%, #D3D3D3 100%);
            background: -webkit-linear-gradient(top, #dedede 0%, #d7d7d7 66%, #D3D3D3 100%);
            background: linear-gradient(to bottom, #dedede 0%, #d7d7d7 66%, #D3D3D3 100%);
            border-bottom: 2px solid #444444;
        }

        table.blueTable thead th {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }

        table.blueTable tfoot {
            font-size: 14px;
            font-weight: bold;
            color: #FFFFFF;
            background: #EEEEEE;
            background: -moz-linear-gradient(top, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            background: -webkit-linear-gradient(top, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            background: linear-gradient(to bottom, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            border-top: 2px solid #444444;
        }

        table.blueTable tfoot td {
            font-size: 14px;
        }

        table.blueTable tfoot .links {
            text-align: right;
        }

        table.blueTable tfoot .links a {
            display: inline-block;
            background: #1C6EA4;
            color: #FFFFFF;
            padding: 2px 8px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    @php
        $filedsEmpolyees = [
            'gender',
            'matrimonial_status',
            'scientific_qualification',
            'area',
            'working_status',
            'type_appointment',
            'field_action',
            'dual_function',
            'state_effectiveness',
            'nature_work',
            'association',
            'workplace',
            'section',
            'dependence',
            'establishment',
            'payroll_statement'
        ];
    @endphp
    <htmlpageheader name="page-header">

    </htmlpageheader>

    <div>
        <div>
            <p>
                <span>قسم المالية</span> /
                <span>كشف حساب لموظف</span>
            </p>
        </div>
        <div align="center"  style="color: #000;border:0; width: 100%;">
            <div align="center" style="font-size: 25px; font-weight: bold">كشف الرواتب للموظف : {{ $employee->name }}</div>
            <span>من شهر {{ $month }} الي الشهر {{ $to_month }}</span>
        </div>
    </div>
    <div lang="ar">
        <table class="blueTable">
            <thead>
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
            <tfoot>
                <tr>
                    <td>00</td>
                    <td>المجموع</td>
                    <td>{{$salariesTotalArray['secondary_salary']}}</td>
                    <td>{{$salariesTotalArray['allowance_boys']}}</td>
                    <td>{{$salariesTotalArray['nature_work_increase']}}</td>
                    <td>{{$salariesTotalArray['administrative_allowance']}}</td>
                    <td>{{$salariesTotalArray['scientific_qualification_allowance']}}</td>
                    <td>{{$salariesTotalArray['transport']}}</td>
                    <td>{{$salariesTotalArray['extra_allowance']}}</td>
                    <td>{{$salariesTotalArray['salary_allowance']}}</td>
                    <td>{{$salariesTotalArray['ex_addition']}}</td>
                    <td>{{$salariesTotalArray['mobile_allowance']}}</td>
                    <td>{{$salariesTotalArray['termination_service']}}</td>
                    <td>{{$salariesTotalArray['gross_salary']}}</td>
                    <td>{{$salariesTotalArray['health_insurance']}}</td>
                    <td>{{$salariesTotalArray['z_Income']}}</td>
                    <td>{{$salariesTotalArray['savings_rate']}}</td>
                    <td>{{$salariesTotalArray['association_loan']}}</td>
                    <td>{{$salariesTotalArray['savings_loan'] * $USD}}</td>
                    <td>{{$salariesTotalArray['shekel_loan']}}</td>
                    <td>{{$salariesTotalArray['late_receivables']}}</td>
                    <td>{{$salariesTotalArray['total_discounts']}}</td>
                    <td>{{$salariesTotalArray['net_salary']}}</td>
                </tr>
                <tr>
                    <td colspan="13">سعر الدولار : {{$USD}}</td>
                    <td colspan="2" style="text-align: left;">إجمالي : {{intval($salariesTotalArray['gross_salary'] / $USD)}} $</td>
                    <td colspan="7"></td>
                    <td colspan="2" style="text-align: left;">إجمالي : {{intval($salariesTotalArray['net_salary']  / $USD)}} $</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <htmlpagefooter name="page-footer">
        <table width="100%" style="vertical-align: bottom; color: #000000;  margin: 1em">
            <tr>
                <td width="33%">{DATE j-m-Y}</td>
                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                @auth
                    <td width="33%" style="text-align: left;">{{ Auth::user()->name }}</td>
                @else
                    <td width="33%" style="text-align: left;">اسم المستخدم</td>
                @endauth
            </tr>
        </table>
    </htmlpagefooter>

</body>

</html>
