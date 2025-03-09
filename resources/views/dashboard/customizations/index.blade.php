<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    @push('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{ asset('css/funFixedView.css') }}">
    @endpush
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول التخصيصات</h2>
                    <p class="card-text">هنا يتم عرض التخصيص للمعادلات الموجودة في الراتب</p>
                </div>
                <div class="col-auto">
                    @can('create', 'App\\Models\Customization')
                    <a class="btn btn-success" href="{{route('customizations.create')}}">
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
                                    /* color: #1E1E1E !important; */
                                }
                            </style>
                            <!-- table -->
                            <table class="table table-bordered table-hover datatables" id="dataTable-1"   style="display: table;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الموظف</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customizations as $customization)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$customization->employee->name}}</td>
                                        <td>
                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @can('edit', 'App\\Models\Customization')
                                                <a class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="{{route('customizations.edit',$customization->id)}}">تعديل</a>
                                                @endcan
                                                @can('delete', 'App\\Models\Customization')
                                                <form action="{{route('customizations.destroy',$customization->id)}}" method="post">
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
            [10, 20, 100, -1],
            [10, 20, 100, "جميع"]
            ]
        });
    </script>
    @endpush
</x-front-layout>
