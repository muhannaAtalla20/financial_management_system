<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row align-items-center mb-2">
        <div class="col">
            <h2 class="h5 page-title">جدول العملات</h2>
            <p class="mb-3">يمكنك تعديل قيمة العملات</p>

        </div>
        <div class="col-auto">
            @can('create', 'App\\Models\Currency')
            <a class="btn btn-success" data-toggle="modal" data-target="#create">
                <i class="fe fe-plus"></i>
            </a>
            @endcan
        </div>
    </div>
    <div class="row">
        <!-- Small table -->
        <div class="col-md-12 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <!-- table -->
                    <table class="table table-bordered  table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>العملة</th>
                                <th>الرمز</th>
                                <th>القيمة</th>
                                <th>الحدث</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($currencies as $currency)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$currency->name}}</td>
                                <td>{{$currency->code}}</td>
                                <td class="text-muted">{{$currency->value}}</td>
                                <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted sr-only">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @can('edit', 'App\\\Models\Currency')
                                        <a class="dropdown-item" data-toggle="modal"
                                            data-target="#edit_{{$currency->id}}">تعديل</a>
                                        @endcan
                                        @can('delete', 'App\\\Models\Currency')
                                        <form action="{{route('currencies.destroy',$currency->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="dropdown-item">حذف</button>
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
        </div> <!-- customized table -->
    </div> <!-- end section -->
    @can('edit', 'App\\\Models\Currency')
    @foreach ($currencies as $currency)
    <div class="modal fade" id="edit_{{$currency->id}}" tabindex="-1" role="dialog" aria-labelledby="edit{{$currency->id}}Label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit{{$currency->id}}Label">تعديل عملة : {{$currency->name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('currencies.update',$currency->id)}}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <x-form.input required label="إسم العملة"  :value="$currency->name" min="0" name="name" placeholder="الدولار"/>
                        </div>
                        <div class="form-group">
                            <x-form.input required label="رمز العملة"  :value="$currency->code" min="0" name="code" placeholder="USD"/>
                        </div>
                        <div class="form-group">
                            <x-form.input required label="قيمة العملة" type="number" :value="$currency->value" step=".01" min="0" name="value" placeholder="3.80"/>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تعديل</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    @endforeach
    @endcan
    @can('create', 'App\\\Models\Currency')
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="createLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createLabel">إنشاء عملة جديدة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('currencies.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <x-form.input required label="إسم العملة"  min="0" name="name" placeholder="الدولار...."/>
                        </div>
                        <div class="form-group">
                            <x-form.input required label="رمز العملة"   min="0" name="code" placeholder="USD..."/>
                        </div>
                        <div class="form-group">
                            <x-form.input required label="قيمة العملة" type="number" step=".01" min="0" name="value" placeholder="3.80"/>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">أضف</button>
                </div>
            </form>

            </div>
        </div>
    </div>
    @endcan

</x-front-layout>
