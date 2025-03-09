<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول البنوك</h2>
                    <p class="card-text">هنا يتم عرض بيانات البنوك المتعامل معها.</p>
                </div>
                <div class="col-auto">
                    @can('create', 'App\\Models\Bank')
                    <a class="btn btn-success" href="{{route('banks.create')}}">
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
                            <!-- table -->
                            <table class="table  table-bordered  table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>مكان الفرع</th>
                                        <th>رقم الفرع</th>
                                        <th>الحدث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($banks as $bank)
                                    <tr>
                                        <td>{{$bank->id}}</td>
                                        <td>{{$bank->name}}</td>
                                        <td>{{$bank->branch}}</td>
                                        <td>{{$bank->branch_number}}</td>
                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @can('edit', 'App\\Models\Bank')
                                                <a class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="{{route('banks.edit',$bank->id)}}">تعديل</a>
                                                @endcan
                                                @can('delete', 'App\\Models\Bank')
                                                <form action="{{route('banks.destroy',$bank->id)}}" method="post">
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
                            <div>
                                {{$banks->links()}}
                            </div>
                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
</x-front-layout>
