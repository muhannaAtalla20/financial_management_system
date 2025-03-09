<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">سلة المحذوفات الخاصة بالموظفين</h2>
                    <p class="card-text">هنا يتم عرض بيانات الموظفين الشخصية المحذوفة.</p>
                </div>
            </div>
            <div class="row my-4">
                <!-- Small table -->
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <!-- table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>رقم الهوية</th>
                                        <th>العمر</th>
                                        <th>الحالة الزوجية</th>
                                        <th>رقم الهاتف</th>
                                        <th>المنطقة</th>
                                        <th>المؤهل العلمي</th>
                                        <th>فئة الراتب</th>
                                        <th>الحدث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($salaries as $salary )
                                    <tr>
                                        <td>{{$salary->id}}</td>
                                        <td>{{$salary->name}}</td>
                                        <td>{{$salary->employee_id}}</td>
                                        <td>{{$salary->age}}</td>
                                        <td>{{$salary->matrimonial_status}}</td>
                                        <td>{{$salary->phone_number}}</td>
                                        <td>{{$salary->area}}</td>
                                        <td>{{$salary->scientific_qualification}}</td>
                                        <td>{{$salary->salary_category}}</td>
                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <form action="{{route('salaries.restore',$salary->id)}}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="id" value="{{$salary->id}}">
                                                    <button type="submit" class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="#">إستعادة الموظف</button>
                                                </form>
                                                <form action="{{route('salaries.forceDelete',$salary->id)}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="#">حذف نهائي</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                {{$salaries->links()}}
                            </div>
                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
</x-front-layout>
