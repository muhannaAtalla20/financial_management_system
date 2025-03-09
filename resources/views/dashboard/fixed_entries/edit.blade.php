<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <div class="row align-items-center mb-2">
        <div class="col">
            <h2 class="mb-2 page-title">تعديل  الإدخالات للموظف : {{$fixed_entrie['employee']->name}} لسنة : {{$year}}</h2>
        </div>
    </div>
    <div class="row">
        <form action="{{route('fixed_entries.update',$fixed_entrie['employee']->id)}}" method="post" class="col-12">
            @csrf
            @method('put')
            @include("dashboard.fixed_entries._form")
        </form>
    </div>
    @push('scripts')
    <script>
        const csrf_token = "{{csrf_token()}}";
        const app_link = "{{config('app.url')}}";
    </script>
    <script src="{{ asset('js/sendEmployeeData.js') }}"></script>
@endpush
</x-front-layout>
