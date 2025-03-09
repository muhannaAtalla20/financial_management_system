<x-front-layout classC="shadow p-3 mb-5 bg-white rounded">
    @push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{ asset('css/funFixedView.css') }}">
    @endpush
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول الإجماليات</h2>
                    <p class="card-text">هنا يتم عرض جدول الإجماليات</p>
                    <span class="btn btn-primary "> عدد الإجماليات للموظفين : {{$totals->count()}}</span>
                </div>
                <div class="col-auto">
                    @can('create', 'App\\Models\ReceivablesLoans')
                    <a type="button" class="btn btn-success" data-toggle="modal" data-target="#createItem">
                        <i class="fe fe-plus"></i>
                    </a>
                    @endcan
                    <button style="display: none;" id="openModalShow" data-toggle="modal" data-target="#editItem">
                        Launch demo modal
                    </button>
                </div>
            </div>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <style>
                                thead
                                {
                                    background: #383848;
                                }
                                th
                                {
                                    /* color: #1E1E1E !important; */
                                    padding: 12px 33px !important;
                                }
                                td{
                                    padding: 3px 15px !important;
                                    text-align: center;
                                    /* color: #1E1E1E !important; */
                                }
                            </style>
                            <!-- table -->
                            <table class="table table-bordered  table-hover datatables"  id="dataTable-1"  style="display: table;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-left">الموظف</th>
                                        <th>إجمالي المستحقات</th>
                                        <th>إجمالي الإدخارات $</th>
                                        <th>إجمالي قرض الجمعية</th>
                                        <th>إجمالي قرض الإدخار $</th>
                                        <th>إجمالي قرض اللجنة (الشيكل)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($totals as $total)
                                    <tr class="total_select" data-id="{{$total->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td  class="text-left">{{$total->employee->name}}</td>
                                        <td>{{$total->total_receivables_view}}</td>
                                        <td>{{$total->total_savings_view}}</td>
                                        <td>{{$total->total_association_loan_view}}</td>
                                        <td>{{$total->total_savings_loan_view}}</td>
                                        <td>{{$total->total_shekel_loan_view}}</td>
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
    {{-- create model --}}
    @can('create', 'App\\Models\ReceivablesLoans')
    <div class="modal fade" id="createItem" tabindex="-2" role="dialog" aria-labelledby="createItemLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createItemLabel">إنشاء إجماليات جديدة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('totals.store')}}" method="post" class="col-12">
                        @csrf
                        <div class="form-group p-1 col-6">
                            <label for="gender">رقم الموظف</label>
                            <div class="input-group mb-3">
                                <x-form.input name="employee_id" placeholder="0" readonly required />
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchEmployee" >
                                        <i class="fe fe-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group p-3 col-4">
                                <x-form.input type="number" min="0" value="0"  label="إجمالي المستحقات" name="total_receivables" placeholder="5000...." />
                            </div>
                            <div class="form-group p-3 col-4">
                                <x-form.input type="number" min="0" value="0"  label="إجمالي الإدخارات" name="total_savings" placeholder="5000...." />
                            </div>
                            <div class="form-group p-3 col-4">
                                <x-form.input type="number" min="0"  value="0" label="إجمالي قرض الجمعية" name="total_association_loan" placeholder="5000...." />
                            </div>
                            <div class="form-group p-3 col-4">
                                <x-form.input type="number" min="0"  value="0" label="إجمالي قرض الإدخار" name="total_savings_loan" placeholder="5000...." />
                            </div>
                            <div class="form-group p-3 col-4">
                                <x-form.input type="number" min="0"  value="0" label="إجمالي قرض اللجنة (الشيكل)" name="total_shekel_loan" placeholder="5000...." />
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    {{$btn_label ?? "أضف"}}
                                </button>
                            </div>
                        </div>
                    </form>
                    @can('import','App\\\Models\Employee')
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <strong>إستيراد ملف إكسيل</strong>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('totals.importExcel') }}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <label for="images" class="drop-container" id="dropcontainer">
                                        <span class="drop-title">إسقاط الملف هنا</span>
                                        or
                                        <input type="file" name="fileUplode" id="fileUplode" accept=".xlsx, .xls, .csv, .xml , .xlsm" required>
                                    </label>
                                    <button type="submit" class="btn btn-primary">ارسال</button>
                                </form>
                                <p class="text-muted font-weight-bold h6">لتحميل نموذج الإدخال <a
                                        href="{{ asset('files/style_totals.xlsx') }}" download="نموذج الإدخال"
                                        target="_blank">إضغط هنا</a></p>
                            </div> <!-- .card-body -->
                        </div> <!-- .card -->
                    </div> <!-- .col -->
                    @endcan
                </div>
            </div>
        </div>
    </div>
    @endcan
    @can('edit','App\\Models\ReceivablesLoans')
    <div class="modal fade" id="editItem" tabindex="-3" role="dialog" aria-labelledby="editItemLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemLabel">تعديل الإجماليات </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body " id="showtotal">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    @endcan
    <div class="modal fade" id="searchEmployee" tabindex="-5" role="dialog" aria-labelledby="searchEmployeeLabel" aria-hidden="true">
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
        <script src="{{asset('assets/js/ajax.min.js')}}"></script>
        <script>
            const csrf_token = "{{csrf_token()}}";
            const app_link = "{{config('app.url')}}";
        </script>
        @can('create', 'App\\Models\ReceivablesLoans')
            <script src="{{ asset('js/getEmployee.js') }}"></script>
        @endcan
        @can('edit','App\\Models\ReceivablesLoans')
            <script src="{{asset('js/getShowTotals.js')}}"></script>
        @endcan
        <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
        <script>
            $('#dataTable-1').DataTable(
            {
                autoWidth: true,
                "lengthMenu": [
                [-1],
                ["جميع"]
                ]
            });
        </script>
    @endpush
</x-front-layout>
