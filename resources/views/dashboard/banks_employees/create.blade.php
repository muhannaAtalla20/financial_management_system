<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    @push('styles')
    <style>
        hr {
            position: absolute;
            top: 50px;
            right: 15px;
            width: 35%;
            height: 5px;
            border-radius: 10px;
            background: linear-gradient(to right, rgba(210, 255, 82, 1) 0%, rgba(40, 64, 18, 1) 100%);
            margin: 0;
        }

        .drop-container {
            position: relative;
            display: flex;
            gap: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 200px;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #555;
            color: #444;
            cursor: pointer;
            transition: background .2s ease-in-out, border .2s ease-in-out;
        }

        .drop-container:hover {
            background: #eee;
            border-color: #111;
        }

        .drop-container:hover .drop-title {
            color: #222;
        }

        .drop-title {
            color: #444;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            transition: color .2s ease-in-out;
        }
    </style>
@endpush
    <div class="row align-items-center mb-2">
        <div class="col">
            <h2 class="mb-2 page-title">إنشاء حساب بنك جديد</h2>
        </div>
    </div>
    <div class="row">
        <form action="{{route('banks_employees.store',$bank_employee->id)}}" method="post" class="col-12">
            @csrf
            @include("dashboard.banks_employees._form")
        </form>
        @can('import','App\\Models\BanksEmployees')
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong>إستيراد ملف إكسيل</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('banks_employees.importExcel') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <label for="images" class="drop-container" id="dropcontainer">
                            <span class="drop-title">إسقاط الملف هنا</span>
                            or
                            <input type="file" name="fileUplode" id="fileUplode" accept=".xlsx, .xls, .csv, .xml , .xlsm" required>
                        </label>
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </form>
                    <p class="text-muted font-weight-bold h6">لتحميل نموذج الإدخال <a
                            href="{{ asset('files/style_acconts_employees.xlsx') }}" download="نموذج الإدخال"
                            target="_blank">إضغط هنا</a></p>
                </div> <!-- .card-body -->
            </div> <!-- .card -->
        </div> <!-- .col -->
        @endcan

    </div>
    <div class="modal fade" id="searchEmployee" tabindex="-1" role="dialog" aria-labelledby="searchEmployeeLabel" aria-hidden="true">
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
        <script>
            const csrf_token = "{{csrf_token()}}";
            const app_link = "{{config('app.url')}}";
        </script>
        <script src="{{ asset('js/getEmployee.js') }}"></script>
    @endpush

</x-front-layout>
