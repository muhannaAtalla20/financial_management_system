<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول سلم الرواتب الأساسي</h2>
                    <p class="card-text">هنا يتم عرض جدول سلم الرواتب المعتمد عليه</p>
                </div>
                <div class="col-auto">
                    @can('create', 'App\\Models\SalaryScale')
                    <a type="button" class="btn btn-success text-white" data-toggle="modal" data-target="#createItem">
                        <i class="fe fe-plus f-16"></i>
                    </a>
                    @endcan
                    @can('edit', 'App\\Models\SalaryScale')
                    <a type="button" class="btn btn-info text-white" data-toggle="modal" data-target="#editItem">
                        <i class="fe fe-edit f-16"></i>
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
                            <table class="table table-bordered  table-hover">
                                <thead>
                                    <tr>
                                        <th>العلاوة</th>
                                        <th>10</th>
                                        <th>9</th>
                                        <th>8</th>
                                        <th>7</th>
                                        <th>6</th>
                                        <th>5</th>
                                        <th>4</th>
                                        <th>3</th>
                                        <th>2</th>
                                        <th>1</th>
                                        <th>C</th>
                                        <th>B</th>
                                        <th>A</th>
                                        <th>النسبة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($salary_scales as $salary_scale)
                                    <tr class="increase_select" data-id="{{$salary_scale->id}}">
                                        <td>{{$salary_scale->id}}</td>
                                        <td>{{$salary_scale[10]}}</td>
                                        <td>{{$salary_scale[9]}}</td>
                                        <td>{{$salary_scale[8]}}</td>
                                        <td>{{$salary_scale[7]}}</td>
                                        <td>{{$salary_scale[6]}}</td>
                                        <td>{{$salary_scale[5]}}</td>
                                        <td>{{$salary_scale[4]}}</td>
                                        <td>{{$salary_scale[3]}}</td>
                                        <td>{{$salary_scale[2]}}</td>
                                        <td>{{$salary_scale[1]}}</td>
                                        <td>{{$salary_scale->C}}</td>
                                        <td>{{$salary_scale->B}}</td>
                                        <td>{{$salary_scale->A}}</td>
                                        <td>{{$salary_scale->percentage}}</td>
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
    @can('create', 'App\\Models\SalaryScale')
    <div class="modal fade" id="createItem" tabindex="-1" role="dialog" aria-labelledby="createItemLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createItemLabel">إنشاء نسبة جديدة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('salary_scales.store')}}" method="post" class="col-12">
                        @csrf
                        <div class="row">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">10</span>
                                </div>
                                <input type="number" id="10" name="10" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">9</span>
                                </div>
                                <input type="number" id="9" name="9" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">8</span>
                                </div>
                                <input type="number" id="8" name="8" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">7</span>
                                </div>
                                <input type="number" id="7" name="7" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">6</span>
                                </div>
                                <input type="number" id="6" name="6" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">5</span>
                                </div>
                                <input type="number" id="5" name="5" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">4</span>
                                </div>
                                <input type="number" id="4" name="4" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">3</span>
                                </div>
                                <input type="number" id="3" name="3" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">2</span>
                                </div>
                                <input type="number" id="2" name="2" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">1</span>
                                </div>
                                <input type="number" id="1" name="1" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">C</span>
                                </div>
                                <input type="number" id="C" name="C" class="form-control" placeholder="250" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">B</span>
                                </div>
                                <input type="number" id="B" name="B" class="form-control" placeholder="250" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">A</span>
                                </div>
                                <input type="number" id="A" name="A" class="form-control" placeholder="250" required>
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    إنشاء
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan
    @can('edit', 'App\\Models\SalaryScale')
    <div class="modal fade" id="editItem" tabindex="-1" role="dialog" aria-labelledby="editItemLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemLabel">تعديل النسبة الحالية</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('salary_scales.update',$salary_scales_basic->id)}}" method="post" class="col-12">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">10</span>
                                </div>
                                <input type="number" id="10" name="10" value="{{$salary_scales_basic[10]}}" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">9</span>
                                </div>
                                <input type="number" id="9" name="9" value="{{$salary_scales_basic[9]}}" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">8</span>
                                </div>
                                <input type="number" id="8" name="8" value="{{$salary_scales_basic[8]}}" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">7</span>
                                </div>
                                <input type="number" id="7" name="7" value="{{$salary_scales_basic[7]}}" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">6</span>
                                </div>
                                <input type="number" id="6" name="6" value="{{$salary_scales_basic[6]}}" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">5</span>
                                </div>
                                <input type="number" id="5" name="5" value="{{$salary_scales_basic[5]}}" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">4</span>
                                </div>
                                <input type="number" id="4" name="4" value="{{$salary_scales_basic[4]}}" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">3</span>
                                </div>
                                <input type="number" id="3" name="3" value="{{$salary_scales_basic[3]}}" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">2</span>
                                </div>
                                <input type="number" id="2" name="2" value="{{$salary_scales_basic[2]}}" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">1</span>
                                </div>
                                <input type="number" id="1" name="1" value="{{$salary_scales_basic[1]}}" class="form-control" min="0" placeholder="250." required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">C</span>
                                </div>
                                <input type="number" id="C" name="C" value="{{$salary_scales_basic['C']}}" class="form-control" placeholder="250" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">B</span>
                                </div>
                                <input type="number" id="B" name="B" value="{{$salary_scales_basic['B']}}" class="form-control" placeholder="250" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">A</span>
                                </div>
                                <input type="number" id="A" name="A" value="{{$salary_scales_basic['A']}}" class="form-control" placeholder="250" required>
                            </div>
                        </div>
                        <div class="row align-items-center mb-2">
                            <div class="col">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    تعديل
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endcan

    @push('scripts')
    <script src="{{asset('assets/js/ajax.min.js')}}"></script>
    <script>
        const csrf_token = "{{csrf_token()}}";
        const app_link = "{{config('app.url')}}";
    </script>
    <script src="{{asset('js/getShowSalaryScales.js')}}"></script>
@endpush
</x-front-layout>

