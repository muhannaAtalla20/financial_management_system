<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>جدول التعديلات الثابتة للموظفين</title>
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
            'payroll_statement',
        ];
    @endphp
    <htmlpageheader name="page-header">
        <p>
            <span>قسم المالية</span> /
            <span>جدول التعديلات الثابتة للموظفين</span>
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
        <table class="blueTable" style="margin-top: 20px">
            <thead>
                <tr>
                    <td colspan="4" style="border:0;">
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
                    </td>
                    <td colspan="12" align="center" style="color: #000;border:0;">
                        <h1>جدول التعديلات الثابتة للموظفين لشهر : {{ $month }}</h1>
                    </td>
                    <td colspan="4" style="border:0;"></td>
                </tr>
                <tr  style="background: #dddddd;">
                    <th>#</th>
                    <th style="width: 150px">الاسم</th>
                    <th>علاوة <br> إدارية</th>
                    <th>علاوة <br>  مؤهل <br>  علمي</th>
                    <th>مواصلات</th>
                    <th>بدل <br>  إضافي</th>
                    <th>علاوة <br>  اغراض <br>  راتب</th>
                    <th>إضافة <br>  بأثر <br>  رجعي</th>
                    <th>علاوة <br>  جوال</th>
                    <th>تأمين <br>  صحي</th>
                    <th>ف.أوريدو</th>
                    <th>قرض <br>  جمعية </th>
                    <th>قرض <br>  الإدخار</th>
                    <th>قرض <br>  اللجنة</th>
                    <th>رسوم <br>  دراسية</th>
                    <th>تبرعات</th>
                    <th>خصم <br>  اللجنة</th>
                    <th>خصومات <br>  الإخرى</th>
                    <th>تبرعات <br>  للحركة</th>
                    <th>إدخار 5%</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fixed_entries as $fixed_entrie)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $fixed_entrie->employee->name }}</td>
                        <td>{{ $fixed_entrie->administrative_allowance }}</td>
                        <td>{{ $fixed_entrie->scientific_qualification_allowance }}</td>
                        <td>{{ $fixed_entrie->transport }}</td>
                        <td>{{ $fixed_entrie->extra_allowance }}</td>
                        <td>{{ $fixed_entrie->salary_allowance }}</td>
                        <td>{{ $fixed_entrie->ex_addition }}</td>
                        <td>{{ $fixed_entrie->mobile_allowance }}</td>
                        <td>{{ $fixed_entrie->health_insurance }}</td>
                        <td>{{ $fixed_entrie->f_Oredo }}</td>
                        <td>{{ $fixed_entrie->association_loan }}</td>
                        <td>{{ $fixed_entrie->savings_loan }}</td>
                        <td>{{ $fixed_entrie->shekel_loan }}</td>
                        <td>{{ $fixed_entrie->tuition_fees }}</td>
                        <td>{{ $fixed_entrie->voluntary_contributions }}</td>
                        <td>{{ $fixed_entrie->paradise_discount }}</td>
                        <td>{{ $fixed_entrie->other_discounts }}</td>
                        <td>{{ $fixed_entrie->proportion_voluntary }}</td>
                        <td>{{ $fixed_entrie->savings_rate }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr  style="background: #dddddd;">
                    <td>00</td>
                    <td>الإجمالي الكلي</td>
                    <td>{{ $fixedEntriesTotalsArray['administrative_allowance'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['scientific_qualification_allowance'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['transport'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['extra_allowance'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['salary_allowance'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['ex_addition'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['mobile_allowance'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['health_insurance'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['f_Oredo'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['association_loan'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['savings_loan'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['shekel_loan'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['tuition_fees'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['voluntary_contributions'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['paradise_discount'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['other_discounts'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['proportion_voluntary'] }}</td>
                    <td>{{ $fixedEntriesTotalsArray['savings_rate'] }}</td>
                </tr>
            </tfoot>
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
