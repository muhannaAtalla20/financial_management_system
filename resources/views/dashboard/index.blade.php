<x-front-layout>
    @push('styles')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
    <div class="row align-items-center mb-2">
        <div class="col">
            @auth
                <h2 class="h5 page-title">مرحبا : {{ auth()->user()->name }}</h2>
            @endauth
        </div>
        <div class="col-auto">
            <form class="form-inline">
                <div class="form-group d-none d-lg-inline">
                    <label for="reportrange" class="sr-only">Date Ranges</label>
                    <div id="reportrange" class="px-2 py-2 text-muted">
                        <span class="small"></span>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-sm"><span
                            class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
                    <button type="button" class="btn btn-sm mr-2"><span
                            class="fe fe-filter fe-16 text-muted"></span></button>
                </div>
            </form>
        </div>
    </div>

    <h2>تقارير</h2>
    <div class="row justify-content-between">
        <div class="col-md-3">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <span class="h2 mb-0">{{ $countEmployees }}</span>
                            <p class="small text-muted mb-0">عدد الموظفين</p>
                            <span class="badge badge-pill badge-warning">إجمالي</span>
                        </div>
                        <div class="col-auto">
                            <span class="fe fe-32 fe-users text-muted mb-0"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mt-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <span class="h2 mb-0">{{ number_format($net_salary, 2) }}</span>
                            <p class="small text-muted mb-0">صافي راتب شهر : {{ $monthDownload }}</p>
                            <span class="badge badge-pill badge-warning">إجمالي</span>
                        </div>
                        <div class="col-auto">
                            <span class="fe fe-32 fe-dollar-sign text-muted mb-0"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="shadow p-3 mb-5 bg-white rounded col-md-6">
            <h3 class="h5">تصنيف الموظفين حسب المناطق</h3>
            {!! $chartEmployeesArea->render() !!}
        </div>
        <div class="shadow p-3 mb-5 bg-white rounded col-md-4">
            <h3 class="h5">تصنيف الموظفين حسب المؤهلات العلمية</h3>
            {!! $chartEmployeesScientificQualification->render() !!}
        </div> --}}
        <div class="shadow p-3 mb-5 bg-white rounded col-md-6">
            <h3 class="h5">تصنيف الموظفين حسب التعين</h3>
            {!! $chartLineTypeAppointment->render() !!}
        </div>
        <div class="col-md-6 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">تقرير المناطق لشهر : {{ $monthDownload }}</h5>
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المنطقة</th>
                                <th>عدد الموظفين</th>
                                <th>إجمالي الراتب</th>
                                <th>صافي الراتب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workplaces as $workplace)
                                @php
                                    $employees = App\Models\Employee::query()->whereHas('workData', function($query) use ($workplace) {
                                        $query->where('workplace',$workplace);
                                    })->get();
                                    $salaries = \App\Models\Salary::whereIn('employee_id', $employees->pluck('id'))
                                        ->where('salaries.month', $monthDownload)
                                        ->select('salaries.net_salary', 'salaries.gross_salary')
                                        ->get();

                                    $gross_salary = $salaries->sum('gross_salary');
                                    $net_salary = $salaries->sum('net_salary');
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $workplace }}</td>
                                    <td>{{ App\Models\WorkData::where('workplace', $workplace)->count() }}</td>
                                    <td>{{ number_format($gross_salary, 2) }}</td>
                                    <td>{{ number_format($net_salary, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                @php
                                    $salaries = \App\Models\Salary::where('salaries.month', $monthDownload)
                                        ->select('salaries.net_salary', 'salaries.gross_salary')
                                        ->get();
                                    $gross_salary = $salaries->sum('gross_salary');
                                    $net_salary = $salaries->sum('net_salary');
                                @endphp
                                <td>{{ 00 }}</td>
                                <td>المجموع</td>
                                <td>{{ $countEmployees }}</td>
                                <td>{{ number_format($gross_salary, 2) }}</td>
                                <td>{{ number_format($net_salary, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div> <!-- Bordered table -->

    </div>
    <h2>أدوات البرنامج</h2>
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card shadow  text-white">
                <div class="card-body">
                    @can('admins.backup')
                        <a href="{{ route('backup') }}" class="text-center nav-link">
                            <div class="squircle bg-success justify-content-center">
                                <i class="fe fe-download fe-32 align-self-center text-white"></i>
                            </div>
                            <p class="text-secondary">أخذ نسخة إحتياطية من القاعدة</p>
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>


</x-front-layout>
