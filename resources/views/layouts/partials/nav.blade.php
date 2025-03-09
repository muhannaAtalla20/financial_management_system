<nav class="navbar navbar-expand-lg navbar-light bg-white flex-row border-bottom shadow">
    <div class="container-fluid">
        <a class="navbar-brand mx-lg-1 mr-0"  href="{{ route('home') }}">
            <img src="{{ asset('assets/images/') }}" style="max-width: 15%" alt="logo">
        </a>
        <button class="navbar-toggler mt-2 mr-auto toggle-sidebar text-muted">
            <i class="fe fe-menu navbar-toggler-icon"></i>
        </button>
        <div class="navbar-slide bg-white ml-lg-4" id="navbarSupportedContent">
            <a href="#" class="btn toggle-sidebar d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
                <i class="fe fe-x"><span class="sr-only"></span></i>
            </a>
            <ul class="navbar-nav mr-auto">
                @can('view','App\\Models\Employee')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{route('employees.index')}}">
                            <i class="fe fe-users fe-16"></i>
                            <span class="ml-3 item-text">الموظفين</span>
                        </a>
                    </li>
                @endcan
                @can('view','App\\Models\Salary')
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('salaries.index')}}">
                            <span class="ml-3 item-text">الرواتب</span>
                        </a>
                    </li>
                @endcan
                @can('report.view')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{route('report.index')}}">
                            <i class="fe fe-file fe-16"></i>
                            <span class="ml-3 item-text">التقارير</span>
                        </a>
                    </li>
                @endcan
                <li class="nav-item dropdown">
                    <a href="#" id="dashboardDropdown" class="dropdown-toggle nav-link" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ml-lg-2">المالية</span><span class="sr-only">(current)</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dashboardDropdown">
                        <a class="nav-link pl-lg-2" href="{{route('totals.index')}}"><span class="ml-1">المستحقات والقروض</span></a>
                        <a class="nav-link pl-lg-2" href="{{route('fixed_entries.index')}}"><span class="ml-1">التعديلات</span></a>
                        <a class="nav-link pl-lg-2" href="{{route('exchanges.index')}}"><span class="ml-1">الصرف</span></a>
                        <a class="nav-link pl-lg-2" href="{{route('customizations.index')}}"><span class="ml-1">التخصيص</span></a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" id="dashboardDropdown" class="dropdown-toggle nav-link" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ml-lg-2">الرواتب المحددة</span><span class="sr-only">(current)</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dashboardDropdown">
                        <a class="nav-link pl-lg-2" href="{{route('specific_salaries.index')}}"><span class="ml-1">الجميع</span></a>
                        <a class="nav-link pl-lg-2" href="{{route('specific_salaries.ratio')}}"><span class="ml-1">النسبة</span></a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" id="dashboardDropdown" class="dropdown-toggle nav-link" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ml-lg-2">البيانات</span><span class="sr-only">(current)</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dashboardDropdown">
                        <a class="nav-link pl-lg-2" href="{{route('banks.index')}}"><span class="ml-1">البنوك</span></a>
                        <a class="nav-link pl-lg-2" href="{{route('banks_employees.index')}}"><span class="ml-1">حسابات الموظفين</span></a>
                        <a class="nav-link pl-lg-2" href="{{route('salary_scales.index')}}"><span class="ml-1">سلم الرواتب</span></a>
                    </div>
                </li>
                <li class="nav-item dropdown more">
                    <a class="dropdown-toggle more-horizontal nav-link" href="#" id="moreDropdown"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ml-2 sr-only">More</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="moreDropdown">
                        <a class="nav-link pl-lg-2" href="{{route('users.index')}}"><span class="ml-1">المستخدمين</span></a>
                        <a class="nav-link pl-lg-2" href="{{route('constants.index')}}"><span class="ml-1">ثوابت النظام</span></a>
                        <a class="nav-link pl-lg-2" href="{{route('currencies.index')}}"><span class="ml-1">العملات</span></a>

                    </ul>
                </li>
            </ul>
        </div>
        {{-- <form class="form-inline ml-md-auto d-none d-lg-flex searchform text-muted">
            <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search"
                placeholder="Type something..." aria-label="Search">
        </form> --}}
        <ul class="navbar-nav d-flex flex-row">
            <li class="nav-item">
                <a class="nav-link text-muted my-2" href="./#" id="modeSwitcher" data-mode="light">
                    <i class="fe fe-sun fe-16"></i>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link text-muted my-2" href="./#" data-toggle="modal"
                    data-target=".modal-shortcut">
                    <i class="fe fe-grid fe-16"></i>
                </a>
            </li> --}}
            {{-- <li class="nav-item nav-notif">
                <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-notif">
                    <i class="fe fe-bell fe-16"></i>
                    <span class="dot dot-md bg-success"></span>
                </a>
            </li> --}}
            <li class="nav-item dropdown ml-lg-0">
                <a class="nav-link dropdown-toggle text-muted" href="#" id="navbarDropdownMenuLink"
                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="avatar avatar-sm mt-2">
                        <img src="{{ asset('assets/images/user.jpg') }}" alt="..." class="avatar-img rounded-circle">
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="#">الملف الشخصي</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pl-3" href="#">Activities</a>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="nav-link pl-3">تسجيل خروج</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
