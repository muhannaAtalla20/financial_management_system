<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    @push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.css')}}">
    @endpush
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول التعديلات</h2>
                    <p class="card-text">هنا يتم عرض البيانات المدخلة الشهرية لكل موظف والتي تستخدم في الرواتب</p>
                </div>
                <div class="col-auto">
                    @can('create', 'App\\Models\FixedEntries')
                    <a class="btn btn-success  mb-2" href="{{ route('fixed_entries.create') }}">
                        <i class="fe fe-plus"></i>
                    </a>
                    @endcan
                    @can('edit', 'App\\Models\FixedEntries')
                    <a class="btn btn-info mb-2" href="{{ route('fixed_entries.viewForm') }}">
                        <i class="fe fe-edit-3"></i> واجهة التعديلات
                    </a>
                    @endcan
                    <div class="form-group col-6 d-inline">
                        <input type="month" id="monthInputSearch" name="month" value="{{$monthNow}}" class="form-control">
                    </div>
                    <button style="display: none;" id="openModalShow" data-toggle="modal" data-target="#getShowFixed">
                        Launch demo modal
                    </button>
                </div>
            </div>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <table class="table table-bordered  table-hover datatables"  id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>علاوة إدارية</th>
                                        <th>علاوة مؤهل علمي</th>
                                        <th>مواصلات</th>
                                        <th>بدل إضافي</th>
                                        <th>علاوة اغراض راتب</th>
                                        <th>إضافة بأثر رجعي</th>
                                        <th>علاوة جوال</th>
                                        <th>تأمين صحي</th>
                                        <th>ف.أوريدو</th>
                                        <th>قرض جمعية </th>
                                        <th>رسوم دراسية</th>
                                        <th>تبرعات</th>
                                    </tr>
                                </thead>
                                <tbody id="fixed_entries_table">
                                    @foreach ($fixed_entries as $fixed_entrie)
                                    <tr class="fixed_select" data-id="{{$fixed_entrie->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$fixed_entrie->employee->name}}</td>
                                        <td>{{$fixed_entrie->administrative_allowance}}</td>
                                        <td>{{$fixed_entrie->scientific_qualification_allowance}}</td>
                                        <td>{{$fixed_entrie->transport}}</td>
                                        <td>{{$fixed_entrie->extra_allowance}}</td>
                                        <td>{{$fixed_entrie->salary_allowance}}</td>
                                        <td>{{$fixed_entrie->ex_addition}}</td>
                                        <td>{{$fixed_entrie->mobile_allowance}}</td>
                                        <td>{{$fixed_entrie->health_insurance}}</td>
                                        <td>{{$fixed_entrie->f_Oredo}}</td>
                                        <td>{{$fixed_entrie->association_loan}}</td>
                                        <td>{{$fixed_entrie->tuition_fees}}</td>
                                        <td>{{$fixed_entrie->voluntary_contributions}}</td>
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
    <div class="modal fade modal-right modal-slide" id="getShowFixed" tabindex="-1" role="dialog" aria-labelledby="getShowFixedTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="height: auto; min-width: 35%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="getShowFixedLongTitle"> عرض الإدخالات الثابتة </h5>
                <div class="form-group col-4">
                    <input type="month" id="monthModalSearch" name="month" value="{{$monthNow}}" class="form-control">
                </div>
            </div>
            <div class="modal-body" id="showFixed">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
        <script>
            $('#dataTable-1').DataTable(
            {
                autoWidth: true,
                "lengthMenu": [
                [10, 20, 100, -1],
                [10, 20, 100, "جميع"]
                ]
            });
        </script>
        <script src="{{ asset('assets/js/ajax.min.js') }}"></script>
        <script>
            const csrf_token = "{{ csrf_token() }}";
            const app_link = "{{config('app.url')}}";
        </script>
        <script src="{{ asset('js/getShowFixed.js') }}"></script>
        <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    @endpush
</x-front-layout>
