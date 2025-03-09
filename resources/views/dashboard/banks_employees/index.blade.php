<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    @push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{ asset('css/funFixedView.css') }}">
    @endpush
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول حسابات الموظفين</h2>
                    <p class="card-text">هنا يتم عرض بيانات حسابات الموظفين في البنوك.</p>
                </div>
                <div class="col-auto">
                    @can('create', 'App\\Models\BankEmployee')
                    <a class="btn btn-success" href="{{route('banks_employees.create')}}">
                        <i class="fe fe-plus"></i>
                    </a>
                    @endcan
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
                                    background: #383848 !important;
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
                            <table class="table  table-bordered  table-hover datatables" id="dataTable-1" style="display: table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الموظف</th>
                                        <th>البنك - الفرع</th>
                                        <th>رقم الحساب</th>
                                        <th>؟الأساسي</th>
                                        <th>الحدث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($banks_employees as $bank_employee)
                                    <tr>
                                        <td>{{$bank_employee->id}}</td>
                                        <td>{{$bank_employee->employee->name}}</td>
                                        <td>{{$bank_employee->bank->name . " - " . $bank_employee->bank->branch}}</td>
                                        <td>{{$bank_employee->account_number}}</td>
                                        @if ($bank_employee->default == 1)
                                            <td>الأساسي</td>
                                        @else
                                            <td>---</td>
                                        @endif
                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @can('edit', 'App\\Models\BankEmployee')
                                                <a class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="{{route('banks_employees.edit',$bank_employee->id)}}">تعديل</a>
                                                @endcan
                                                @can('delete', 'App\\Models\BankEmployee')
                                                <form action="{{route('banks_employees.destroy',$bank_employee->id)}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="#">حذف</button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
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
    @push('scripts')
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
