<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>كشف القروض للموظف</title>
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
                <span>كشف القروض</span>
            </p>
        </div>
        <div align="center"  style="color: #000;border:0; width: 100%;">
            <div align="center" style="font-size: 25px; font-weight: bold">كشف  للموظف : {{ $employee->name }}</div>
            <span>من شهر {{ $month }} الي الشهر {{ $to_month }}</span>
        </div>
    </div>
    <div lang="ar" style="margin-top: 25px;">
        <table class="blueTable">
            <thead>
                <tr  style="background: #dddddd;">
                    <th>#</th>
                    <th>الشهر</th>
                    <th>البيان</th>
                    <th>قرض الجمعية</th>
                    <th>قرض الإدخار</th>
                    <th>قرض الشيكل</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = $employee->totals;
                    $fixedEntries = App\Models\FixedEntries::where('employee_id', $employee->id)->whereBetween('month', [$month, $to_month])->get();
                    $association_loan = $fixedEntries->sum('association_loan');
                    $savings_loan = $fixedEntries->sum('savings_loan');
                    $shekel_loan = $fixedEntries->sum('shekel_loan');
                @endphp
                <tr>
                    <td>00</td>
                    <td></td>
                    <td>الرصيد السابق</td>
                    <td>{{ floatval($total->total_association_loan) + floatval($association_loan) }}</td>
                    <td>{{ floatval($total->total_savings_loan) + floatval($savings_loan) }}</td>
                    <td>{{ floatval($total->total_shekel_loan) + floatval($shekel_loan) }}</td>
                </tr>
                @foreach($salaries as $salary)
                    @php
                        $fixedEntriesN = App\Models\FixedEntries::where('employee_id', $employee->id)->where('month', $salary->month)->first();
                    @endphp
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td style="white-space: nowrap;">{{$salary->month ?? ''}}</td>
                        <td></td>
                        <td>{{$fixedEntriesN->association_loan ?? ''}}</td>
                        <td>{{$fixedEntriesN->savings_loan ?? ''}}</td>
                        <td>{{$fixedEntriesN->shekel_loan ?? ''}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>00</td>
                    <td>---</td>
                    <td>الإجمالي (المتبقي)</td>
                    <td>{{ $total->total_association_loan }}</td>
                    <td>{{ $total->total_savings_loan }}</td>
                    <td>{{ $total->total_shekel_loan }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <table width="100%" style="vertical-align: bottom; color: #000000; margin:30px 1em 10px; font-size: 14px">
        <tr>
            <td width="50%">الختم</td>
            <td width="50%" align="center">التوقيع</td>
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
                    <td width="33%" style="text-align: left;">اسم المستخدم</td>
                @endauth
            </tr>
        </table>
    </htmlpagefooter>

</body>

</html>
