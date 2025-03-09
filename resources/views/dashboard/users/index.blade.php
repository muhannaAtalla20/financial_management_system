<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row align-items-center mb-2">
                <div class="col">
                    <h2 class="mb-2 page-title">جدول المستخدمين</h2>
                    <p class="card-text">هنا يتم عرض بيانات المستخدمين ويمكنك التحكم في صلاحياتهم كاملة</p>
                </div>
                <div class="col-auto">
                    @can('create', 'App\\Models\User')
                    <a class="btn btn-success" href="{{route('users.create')}}">
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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>حالة النشاط</th>
                                        <th>الاسم</th>
                                        <th>اسم المستخدم</th>
                                        <th>البريد الالكتروني</th>
                                        <th>أخر موعد تواجد</th>
                                        <th>الحدث</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <style>
                                        #user-1{
                                            display: none;
                                        }
                                    </style>
                                    @foreach($users as $user)
                                    <tr  id="user-{{$user->id}}">
                                        <td>{{ $loop->iteration - 1 }}</td>
                                        @if ($user->last_activity >= now()->subMinutes(5))
                                            <td>
                                                <i class="fe fe-circle text-success bg-success rounded-circle"></i>
                                            </td>
                                        @else
                                            <td>
                                                <i class="fe fe-circle"></i>
                                            </td>
                                        @endif
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->last_activity}}</td>
                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted sr-only">Action</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                {{-- @can('view', 'App\\Models\User')
                                                <a class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                href="{{route('users.show',$user->id)}}">عرض</a>
                                                @endcan --}}
                                                @can('edit', 'App\\Models\User')
                                                <a class="dropdown-item" style="margin: 0.5rem -0.75rem; text-align: right;"
                                                    href="{{route('users.edit',$user->id)}}">تعديل</a>
                                                @endcan
                                                @can('delete', 'App\\Models\User')
                                                <form action="{{route('users.destroy',$user->id)}}" method="post">
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
                                {{$users->links()}}
                            </div>
                        </div>
                    </div>
                </div> <!-- simple table -->
            </div> <!-- end section -->
        </div> <!-- .col-12 -->
    </div> <!-- .row -->
</x-front-layout>
