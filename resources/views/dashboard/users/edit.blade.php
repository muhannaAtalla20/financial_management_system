<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row align-items-center mb-2">
        <div class="col">
            <h2 class="mb-2 page-title">تعديل بيانات المستخدم  : {{$user->name}}</h2>
        </div>
    </div>
    <div class="row">
        <form action="{{route('users.update',$user->id)}}" method="post" class="col-12">
            @csrf
            @method('put')
            @include("dashboard.users._form")
        </form>
    </div>

</x-front-layout>
