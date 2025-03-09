<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row align-items-center mb-2">
        <div class="col">
            <h2 class="mb-2 page-title">تعديل حساب الموظف: {{$bank_employee->employee->name}}</h2>
        </div>
    </div>
    <div class="row">
        <form action="{{route('banks_employees.update',$bank_employee->id)}}" method="post" class="col-12">
            @csrf
            @method('put')
            @include("dashboard.banks_employees._form")
        </form>
    </div>

</x-front-layout>
