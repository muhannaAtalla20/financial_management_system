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
        <div class="col" style="position: relative">
            <h1 class="mb-2 page-title">إنشاء موظف جديد</h1>
            <hr>
        </div>
    </div>
    <div class="row">
        <form action="{{ route('employees.store', $employee->id) }}" method="post" class="col-12 mt-3">
            @csrf
            @include('dashboard.employees._form')
        </form>
        @can('import','App\\Models\Employee')
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <strong>إستيراد ملف إكسيل</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('employees.importExcel') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <label for="images" class="drop-container" id="dropcontainer">
                            <span class="drop-title">إسقاط الملف هنا</span>
                            or
                            <input type="file" name="fileUplode" id="fileUplode" accept=".xlsx, .xls, .csv, .xml , .xlsm" required>
                        </label>
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </form>
                    <p class="text-muted font-weight-bold h6">لتحميل نموذج الإدخال <a
                            href="{{ asset('files/style_employees.xlsx') }}" download="نموذج الإدخال"
                            target="_blank">إضغط هنا</a></p>
                </div> <!-- .card-body -->
            </div> <!-- .card -->
        </div> <!-- .col -->
        @endcan
    </div>
</x-front-layout>
