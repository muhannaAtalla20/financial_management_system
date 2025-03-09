<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>جدول رواتب الموظفين</title>
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
        table.blueTable th
        {
            border: 1px solid #AAAAAA;
            padding: 5px 9px;
        }

        table.blueTable tbody td {
            font-size: 18px;
            padding: 10px 9px;
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
            background: #EEEEEE;
            background: -moz-linear-gradient(top, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            background: -webkit-linear-gradient(top, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            background: linear-gradient(to bottom, #f2f2f2 0%, #efefef 66%, #EEEEEE 100%);
            border-top: 2px solid #444444;
        }

        table.blueTable tfoot td {
            font-size: 18px;
            padding: 10px 9px;
            color: #000000;
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
        <p>
            <span>قسم المالية</span> /
            <span>الرواتب الشهرية</span>
            @if (isset($filter))
                @foreach ($filedsEmpolyees as $name)
                    @if (isset($filter["$name"]))
                    /
                        @foreach ($filter["$name"] as $value)
                            <span> {{ $value }} / </span>
                        @endforeach
                    @endif
                @endforeach
            @endif
        </p>
    </htmlpageheader>

    <div lang="ar">
        <table class="blueTable">
            <thead>
                <tr>
                    <th colspan="7" style="border: 0;">
                        @if(!isset($filter["association"][1]) && isset($filter["association"][0]))
                            @if ($filter["association"][0] == "المدينة")
                                عمارة المدينة
                            @elseif ($filter["association"][0] == "حطين")
                                مزرعة حطين
                            @elseif ($filter["association"][0] == "الكويتي")
                                المركز الكويتي للأشعة التخصصية
                            @elseif ($filter["association"][0] == "يتيم")
                                جمعية دار اليتيم الفلسطيني
                            @elseif ($filter["association"][0] == "صلاح")
                                جميعة الصلاح الإسلامية
                            @endif
                        @endif
                    </th>
                    <th colspan="8" align="center" style="color: #000; border: 0;">
                        <h1>رواتب الموظفين لشهر : {{$month}}</h1>
                    </th>
                    <th colspan="9" style="border: 0;"></th>
                </tr>
                <tr style="background: #dddddd;">
                    <th>#</th>
                    <th>الاسم</th>
                    <th>مكان العمل</th>
                    <th>الراتب الاساسي</th>
                    <th>علاوة الأولاد</th>
                    <th>علاوة طبيعة العمل</th>
                    <th>علاوة إدارية</th>
                    <th>علاوة مؤهل علمي</th>
                    <th>المواصلات</th>
                    <th>بدل إضافي +-</th>
                    <th>علاوة أغراض راتب</th>
                    <th>إضافة بأثر رجعي</th>
                    <th>علاوة جوال</th>
                    <th>نهاية الخدمة</th>
                    <th>إجمالي الراتب</th>
                    <th>تأمين صحي</th>
                    <th>ض.دخل</th>
                    <th>إدخار 5%</th>
                    <th>قرض الجمعية</th>
                    <th>قرض الإدخار</th>
                    <th>قرض شيكل</th>
                    <th>مستحقات متأخرة</th>
                    <th>إجمالي الخصومات</th>
                    <th>صافي الراتب</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salaries as $salary)
                    @php
                        $fixedEntries = $salary->employee->fixedEntries->where('month',$month)->first();
                        if($salary->employee->workData->working_status == 'لا'){
                            $fixedEntries = new  App\Models\FixedEntries();
                        }
                    @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td style="white-space: nowrap;">{{$salary->employee->name ?? ''}}</td>
                        <td style="white-space: nowrap;">{{$salary->employee->workData->workplace ?? ''}}</td>
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
                    <td></td>
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
        <table width="100%" style="vertical-align: bottom; color: #000000; margin:30px 1em; font-size: 12px">
            <tr>
                <td width="33%">الختم</td>
                <td width="33%" align="center">التوقيع</td>
                <td width="33%" style="text-align: left; padding-left: 80px;">إعتماد</td>
            </tr>
        </table>

        <htmlpagefooter name="page-footer">
            <table width="100%" style="vertical-align: bottom; color: #000000;  margin: 1em">
                <tr>
                    <td width="33%">{DATE j-m-Y}</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    @auth
                        <td width="33%" style="text-align: left;">{{ Auth::user()->name }}</td>
                    @else
                        <td width="33%" style="text-align: left;"></td>
                    @endauth
                </tr>
            </table>
        </htmlpagefooter>
    </div>


</body>

</html>
