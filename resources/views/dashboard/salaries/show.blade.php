<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">راتب الموظف : {{$salary->employee->name}}  </h2>
                    <p class="h4 card-text" style="font-size: 1rem">لشهر : {{$salary->month}}</p>
                </div>
                <div class="col-auto">
                    {{-- <a class="btn btn-success" href="{{route('salaries.create')}}">
                        <i class="fe fe-plus"></i>
                    </a>
                    <form action="{{route('salaries.view_pdf')}}" method="post" class="d-inline" target="_blank">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fe fe-printer"></i>
                        </button>
                    </form> --}}
                </div>
            </div>
            <div class="row my-4 justify-content-center text-center">
                <!-- Small table -->
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th  class="text-center">الاسم</th>
                                        <th  class="text-center">القيمة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $salaryKeys = [
                                            'نوع العقد',
                                            'الجمعية',
                                            'مكان العمل',
                                            'زوجة',
                                            'عدد الأولاد',
                                            'عدد الأولاد الجامعة',
                                            'العلاوة',
                                            'الدرجة',
                                            'نسبة العلاوة',
                                            'علاوة درجة',
                                            'الراتب الأولي',
                                            'نسبة علاوة درجة',
                                            'الحالة',
                                            'الراتب  الأساسي',
                                            'علاوة الأولاد',
                                            'علاوة طبيعة العمل',
                                            'نهاية الخدمة',
                                            'ض. دخل',
                                            'مستحقات متأخرة',
                                            'إجمالي الخصومات',
                                            'صافي الراتب',
                                            'المبلغ بالحروف',
                                            'بيان الراتب',
                                            'إسم البنك - الفرع',
                                            'رقم الحساب',
                                            // 'إعفاء مقيم',
                                            // 'مبلغ الضريبة السنوي',
                                            // 'الضريبة',
                                            // 'الإعفاءات',
                                            // 'مبلغ الضريبة ش',
                                        ];
                                        $salaryValues = [
                                            $salary->employee->workData->type_appointment,
                                            $salary->employee->workData->association,
                                            $salary->employee->workData->workplace,
                                            $salary->employee->number_wives,
                                            $salary->employee->number_children,
                                            $salary->employee->number_university_children,
                                            $salary->employee->workData->allowance,
                                            $salary->employee->workData->grade,
                                            $salary->percentage_allowance,
                                            $salary->grade_Allowance,
                                            $salary->initial_salary,
                                            $salary->employee->workData->grade_allowance_ratio,
                                            $salary->employee->workData->state_effectiveness,
                                            $salary->secondary_salary,
                                            $salary->allowance_boys,
                                            $salary->nature_work_increase,
                                            $salary->termination_service,
                                            $salary->z_Income,
                                            $salary->late_receivables,
                                            $salary->total_discounts,
                                            $salary->net_salary,
                                            $salary->amount_letters,
                                            $salary->employee->workData->payroll_statement,
                                            $salary->bank .  " - " . $salary->branch_number,
                                            $salary->account_number,
                                            // $salary->resident_exemption,
                                            // $salary->annual_taxable_amount,
                                            // $salary->tax,
                                            // $salary->exemptions,
                                            // $salary->amount_tax,
                                        ];
                                    @endphp
                                    @foreach($salaryKeys as $key => $value)
                                    <tr>
                                        <td>{{$value}}</td>
                                        <td>{{ $salaryValues[$key] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
</x-front-layout>
