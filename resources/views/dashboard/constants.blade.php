<x-front-layout classC="shadow p-3 mb-5 bg-white rounded ">
    <x-slot:breadcrumbs>
        <div class="row align-items-center">
            <div class="col">
                <h2 class="h5 page-title">ثوابت النظام</h2>
            </div>
        </div>
    </x-slot:breadcrumbs>
    <hr class="border border-danger border-2 opacity-50">


    {{-- btns collapse --}}
    <div>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#advance_payment" aria-expanded="false"
                aria-controls="advance_payment">
            مبلغ السلفة
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#state_effectiveness" aria-expanded="false"
                aria-controls="state_effectiveness">
            حالة الفعالية المجهزة
        </button>
        <button class="btn btn-info m-2"
                type="button" data-toggle="collapse"
                data-target="#termination_service" aria-expanded="false"
                aria-controls="termination_service">
            نسبة نهاية الخدمة
        </button>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>

    {{-- contents --}}
    <div class="collapse multi-collapse" id="advance_payment">
        <form action="{{ route('constants.store') }}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-6 d-flex align-items-end">
                    <label for="advance_payment_rate">مبلغ السلفة - نسبة</label>
                    <div class="col-8 input-group">
                        <x-form.input required type="number" :value="$advance_payment_rate" min="0" name="advance_payment_rate" placeholder="1000" class="d-inline" />
                        <div class="input-group-append">
                            <span class="input-group-text">₪</span>
                        </div>
                    </div>
                </div>
                <div class="form-group m-0 col-6 d-flex  align-items-end">
                    <label for="advance_payment_riyadh">مبلغ السلفة - رياض</label>
                    <div class="col-8 input-group">
                        <x-form.input required type="number" min="0" :value="$advance_payment_riyadh"  name="advance_payment_riyadh" placeholder="1000" class="d-inline" />
                        <div class="input-group-append">
                            <span class="input-group-text">₪</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-3">
                <div class="form-group m-0 col-6 d-flex align-items-end">
                    <label for="advance_payment_permanent">مبلغ السلفة - مداوم</label>
                    <div class="col-8 input-group">
                        <x-form.input required type="number" min="0" :value="$advance_payment_permanent"  name="advance_payment_permanent" placeholder="1000" class="d-inline" />
                        <div class="input-group-append">
                            <span class="input-group-text">₪</span>
                        </div>
                    </div>
                </div>
                <div class="form-group m-0 col-6 d-flex  align-items-end">
                    <label for="advance_payment_non_permanent">مبلغ السلفة - غير مداوم</label>
                    <div class="col-8 input-group">
                        <x-form.input required type="number" min="0" :value="$advance_payment_non_permanent"  name="advance_payment_non_permanent" placeholder="1000" class="d-inline" />
                        <div class="input-group-append">
                            <span class="input-group-text">₪</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row-reverse pr-3">
                <button class="btn btn-success" type="submit">
                    <i class="fe fe-check"></i>
                </button>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="state_effectiveness">
        <form action="{{ route('constants.store') }}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <label for="state_effectivenessEmployees">حالة الفعالية للموظفين</label>
                    <select class="custom-select" id="state_effectivenessEmployees" name="state_effectiveness">
                        <option selected>عرض القيم المتوفرة</option>
                        @foreach ($state_effectivenessEmployees as $state_effectivenes)
                            <option value="{{$state_effectivenes}}">{{$state_effectivenes}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-success" type="submit">
                        <i class="fe fe-check"></i>
                    </button>
                </div>
            </div>
        </form>
        <form action="{{ route('constants.destroy') }}" method="post">
            @csrf
            @method('delete')
            <div class="row p-3">
                <div class="form-group m-0 col-12 d-flex justify-content-between align-items-end">
                    <div class="input-group">
                        <label for="state_effectiveness">حالة الفعالية المحدد لها الراتب</label>
                        <select class="custom-select" id="state_effectiveness" name="state_effectiveness">
                            <option selected>عرض القيم المتوفرة</option>
                            @foreach ($state_effectiveness as $state_effectiveness)
                                <option value="{{$state_effectiveness['id']}}">{{$state_effectiveness['value']}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">
                            <button class="btn btn-danger" type="submit">
                                <i class="fe fe-delete fe-30"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
    <div class="collapse multi-collapse" id="termination_service">
        <form action="{{ route('constants.store') }}" method="post">
            @csrf
            <div class="row p-3">
                <div class="form-group m-0 col-6 d-flex align-items-end">
                    <label for="termination_service">نسبة نهاية الخدمة</label>
                    <div class="col-4 input-group">
                        <x-form.input required type="number" :value="$termination_service" min="0" name="termination_service" placeholder="1000" class="d-inline" />
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-end">
                <button class="btn btn-success" type="submit">
                    <i class="fe fe-check"></i>
                </button>
            </div>
        </form>
        <hr class="border border-danger border-2 opacity-50 w-100">
    </div>
</x-front-layout>
