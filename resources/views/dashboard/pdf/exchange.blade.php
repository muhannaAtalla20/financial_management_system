<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title> صرف للموظفين</title>
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
            width: 50%;
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

        table.blueTable tbody tr:nth-child(even) {
            background: #F5F5F5;
        }

        table.blueTable thead {
            background: #b8b8b8;
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
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card-header {
            font-size: 1.25rem;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .card-body {
            font-size: 1rem;
            color: #333;
            text-align: center; /* يضمن أن المحتوى يكون في المنتصف */
        }
        .card-body table {
            width: 50%;
            margin: 0 auto; /* توسيط الجدول أفقياً */
            border-collapse: collapse;
        }
        .card-body table, .card-body th, .card-body td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .card-body td {
            text-align: center;
        }
        .card-footer {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 15px;
            font-size: 0.875rem;
            text-align: right;
            color: #777;
        }
    </style>
    <style>
        .header-container {
            overflow: hidden; /* لضمان أن يتم التحكم في العناصر العائمة بشكل صحيح */
            padding: 5px 0;
        }
        .header-container p {
            float: right; /* وضع النص على اليمين */
            margin: 0;
            font-size: 16px; /* ضبط حجم النص حسب الحاجة */
        }
    </style>

</head>

<body>
    <htmlpageheader name="page-header">


    </htmlpageheader>
    <table width="100%" style="vertical-align: bottom; color: #000000; margin:0; font-size: 14px">
        <tr>
            <td width="50%" style=" vertical-align: top;">
                <p style="display: inline; margin: 0">
                    <span>قسم المالية</span> /
                    <span>كشف الصرف للموظف</span>
                </p>
            </td>
            <td width="50%" dir="ltr">
                <div style="display: inline;">
                    @if($exchange->employee->workData->association)
                        @if ($exchange->employee->workData->association == "المدينة")
                        <img src="{{ public_path('assets/images/logos/city_architecture.jpg') }}" style="max-width: 50px; float: left; margin: 5px;" alt="">
                        @elseif ($exchange->employee->workData->association == "حطين")
                        <img src="{{ public_path('assets/images/logos/hetten.png') }}" style="max-width: 50px; float: left; margin: 5px;" alt="">
                        @elseif ($exchange->employee->workData->association == "الكويتي")
                        <img src="{{ public_path('assets/images/logos/Kuwaiti.jpg') }}" style="max-width: 50px; float: left; margin: 5px;" alt="">
                        @elseif ($exchange->employee->workData->association == "يتيم")
                        <img src="{{ public_path('assets/images/logos/orphan.jpg') }}" style="max-width: 50px; float: left; margin: 5px;" alt="">
                        @elseif ($exchange->employee->workData->association == "صلاح")
                        <img src="{{ public_path('assets/images/logos/salah.png') }}" style="max-width: 50px; float: left; margin: 0 5px;" alt="">
                        @endif
                    @endif
                </div>
            </td>
        </tr>
    </table>
    <div style="margin-top: 10px;">
        <div align="center"  style="color: #000;border:0; width: 100%;">
            <div align="center" style="font-size: 25px; font-weight: bold">الموظف : {{ $exchange->employee->name }}</div>
            {{-- <span>من شهر {{ $month }} الي الشهر {{ $to_month }}</span> --}}
        </div>
    </div>
    @php
        // dd('here');
    @endphp
    <div lang="ar" style="margin-top: 25px;">
        <div class="card">
            <div class="card-header" align="center">
                نوع الصرف :
                {{ $exchange->exchange_type == 'receivables_discount' ? 'من المستحقات ش' : '' }}
                {{ $exchange->exchange_type == 'savings_discount' ? 'من الإدخارات $' : '' }}
                {{ $exchange->exchange_type == 'association_loan' ? 'قرض جمعية 	ش' : '' }}
                {{ $exchange->exchange_type == 'savings_loan' ? 'قرض إدخار $' : '' }}
                {{ $exchange->exchange_type == 'shekel_loan' ? 'قرض لجنة  ش' : '' }}
                {{ $exchange->exchange_type == 'reward' ? 'مكافأة مالية' : '' }}
            </div>
            <div class="card-body" >
                <table class="blueTable">
                    @php
                        $total = $exchange->employee->totals;
                    @endphp
                    <tbody>
                        @if ($exchange->exchange_type != 'reward')
                        <tr>
                            <th style="background: #dddddd;">الرصيد السابق</th>
                            <td>
                                @if ($exchange->exchange_type == 'receivables_discount')
                                    {{ floatval($total->total_receivables) + floatval($exchange->receivables_discount) }}
                                @elseif( $exchange->exchange_type == 'savings_discount')
                                    {{ floatval($total->total_savings) + floatval($exchange->savings_discount) }}
                                @elseif( $exchange->exchange_type == 'association_loan')
                                    {{ floatval($total->total_association_loan) - floatval($exchange->association_loan) }}
                                @elseif( $exchange->exchange_type == 'savings_loan')
                                    {{ floatval($total->total_savings_loan) - floatval($exchange->savings_loan) }}
                                @elseif( $exchange->exchange_type == 'shekel_loan')
                                    {{ floatval($total->total_shekel_loan) - floatval($exchange->shekel_loan) }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <th  style="background: #dddddd;">قيمة الصرف</th>
                            <td>
                                @if ($exchange->exchange_type == 'receivables_discount')
                                    {{ $exchange->receivables_discount }}
                                @elseif( $exchange->exchange_type == 'savings_discount')
                                    {{ $exchange->savings_discount }}
                                @elseif( $exchange->exchange_type == 'association_loan')
                                    {{ $exchange->association_loan }}
                                @elseif( $exchange->exchange_type == 'savings_loan')
                                    {{ $exchange->savings_loan }}
                                @elseif( $exchange->exchange_type == 'shekel_loan')
                                    {{ $exchange->shekel_loan }}
                                @elseif( $exchange->exchange_type == 'reward')
                                    {{ $exchange->reward }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th  style="background: #dddddd;">تاريخ الصرف</th>
                            <td>{{ $exchange->discount_date }}</td>
                        </tr>
                        @if ($exchange->exchange_type != 'reward')
                        <tr>
                            <th  style="background: #dddddd;">الرصيد الحالي</th>
                            <td>
                                @if ($exchange->exchange_type == 'receivables_discount')
                                    {{ number_format($total->total_receivables,2) }}
                                @elseif( $exchange->exchange_type == 'savings_discount')
                                    {{ number_format($total->total_savings,2) }}
                                @elseif( $exchange->exchange_type == 'association_loan')
                                    {{ number_format($total->total_association_loan,2) }}
                                @elseif( $exchange->exchange_type == 'savings_loan')
                                    {{ number_format($total->total_savings_loan,2) }}
                                @elseif( $exchange->exchange_type == 'shekel_loan')
                                    {{ number_format($total->total_shekel_loan,2) }}
                                @endif
                            </td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>
            <div class="card-footer" style="color: black;">
                سبب الصرف : {{ $exchange->notes }}
            </div>
        </div>
    </div>
    <table width="100%" style="vertical-align: bottom; color: #000000; margin:20px 1em 50px; font-size: 14px">
        <tr>
            <td width="50%">توقيع الموظف</td>
            <td width="50%" align="center">الإعتماد</td>
        </tr>
    </table>
    <table width="100%" style="vertical-align: bottom; color: #000000;  margin: 1em">
        <tr>
            <td width="33%">{{Carbon\Carbon::now()->format('Y-m-d')}}</td>
            <td width="33%" align="center"></td>
            @auth
                <td width="33%" style="text-align: left;">{{ Auth::user()->name }}</td>
            @else
                <td width="33%" style="text-align: left;">اسم المستخدم</td>
            @endauth
        </tr>
    </table>
    <htmlpagefooter name="page-footer">

    </htmlpagefooter>

</body>

</html>
