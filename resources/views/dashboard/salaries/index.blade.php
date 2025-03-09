<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    @push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.css')}}">
    @endpush
    <div class="row justify-content-center">
        <div class="col-12">
            <livewire:TableSalaries :salaries="$salaries" :month="$monthDownload" :monthDownload="$monthDownload" :btn_download_salary="$btn_download_salary"  :btn_delete_salary="$btn_delete_salary" />
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
    <!-- Modal -->'
    @if (session()->has('danger'))
    <div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logModalLongTitle">أخطاء حدتث في معالجة الراتب</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(is_array(session('danger')))
                <ul class="list-group">
                    @foreach(session('danger') as $error)
                        <li class="list-group-item">{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>
    @endif
    @can('view','App\\Models\Accreditation')
    <div class="modal fade" id="AccreditationModal" tabindex="-1" role="dialog" aria-labelledby="AccreditationModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AccreditationModalLongTitle">اعتماد الأشهر</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">الشهر</th>
                            <th scope="col">معتمد</th>
                            <th scope="col">المستخدم المعتمد</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accreditations as $accreditation)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $accreditation->month }}</td>
                            <td>{{ ($accreditation->status == 1 ? 'معتمد' : 'غير معتمد') }}</td>
                            <td>{{ $accreditation->user->name }}</td>
                            <td>
                                <form action="{{ route('accreditations.destroy', $accreditation->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <form action="{{ route('accreditations.store') }}" method="post" class="col-12">
                    @csrf
                    <h3>تحديد شهر معين للإعتماد</h3>
                    <div class="row">
                        <div class="form-group col-6">
                            <input type="month" name="month" class="form-control" value="{{date('Y-m')}}">
                        </div>
                        <div class="form-group col-6">
                            <button type="submit" class="btn btn-primary">اعتماد</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    @endcan

    @push('scripts')
        {{-- <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script> --}}
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
        <script>
            // $(document).ready(function() {
            //     const csrf_token = "{{ csrf_token() }}";
            //     const app_link = "{{config('app.url')}}";
            //     $('#month').on('input', function() {
            //         $.ajax({
            //             url: app_link + "salaries/getSalariesMonth",
            //             method: "post",
            //             data: {
            //                 _token: csrf_token,
            //                 month: $(this).val(),
            //             },
            //             success: function (response) {
            //                 console.log(response.length);
            //                 $("#table_salaries").empty();
            //                 response.forEach((salary) => {
            //                     $("#table_salaries").append(
            //                         `<tr>
            //                             <td>${response.indexOf(salary) + 1}</td>
            //                             <td>`+ salary['employee']['name'] +`</td>
            //                             <td>`+ salary['month'] +`</td>
            //                             <td>`+ salary['initial_salary'] +`</td>
            //                             <td>`+ salary['grade_Allowance'] +`</td>
            //                             <td>`+ salary['secondary_salary'] +`</td>
            //                             <td>`+ salary['gross_salary'] +`</td>
            //                             <td>`+ salary['late_receivables'] +`</td>
            //                             <td>`+ salary['total_discounts'] +`</td>
            //                             <td>`+ salary['net_salary'] +`</td>
            //                             <td>`+ salary['bank'] +`</td>
            //                             <td>`+ salary['account_number'] +`</td>
            //                             <td>`+ salary['annual_taxable_amount'] +`</td>
            //                             <td>
            //                                 <button class="btn btn-sm dropdown-toggle more-horizontal"
            //                                     type="button" data-toggle="dropdown" aria-haspopup="true"
            //                                     aria-expanded="false">
            //                                     <span class="text-muted sr-only">Action</span>
            //                                 </button>
            //                                 <div class="dropdown-menu dropdown-menu-right">
            //                                     <a class="dropdown-item"
            //                                         style="margin: 0.5rem -0.75rem; text-align: right;"
            //                                         href="/salaries/`+ salary['id'] +`/">عرض</a>
            //                                     <form action="/salaries/`+ salary['id'] +`"
            //                                         method="post">
            //                                         <input type="hidden" name="_token" value="`+ csrf_token +`" autocomplete="off">
            //                                         <input type="hidden" name="_method" value="delete">
            //                                         <button type="submit" class="dropdown-item"
            //                                             style="margin: 0.5rem -0.75rem; text-align: right;"
            //                                             href="#">حذف</button>
            //                                     </form>
            //                                 </div>
            //                             </td>
            //                     </tr>`
            //                     );
            //                 });
            //                 if(response.length == 0){
            //                     $("#table_salaries").append(
            //                         '<tr><td colspan="14" class="text-center text-danger">لا يوجد بيانات لعرضها</td></tr>'
            //                     );
            //                 }
            //             },
            //             error: function (response) {
            //                 console.error(response);
            //             }
            //         });
            //     });
            // });
        </script>
    @endpush
</x-front-layout>
