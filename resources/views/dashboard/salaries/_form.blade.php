<div class="row">
    <div class="form-group p-3 col-3">
        <label for="gender">رقم الموظف</label>
        <div class="input-group mb-3">
            <x-form.input :value="$salary->employee->id" name="employee_id" placeholder="0" readonly  />
            <div class="input-group-append">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchEmployee">
                    <i class="fe fe-search"></i>
                </button>
            </div>
        </div>
    </div>
    


</div>

<div class="form-group p-3 col-3">
    <x-form.input label="" :value="$salary->name"  name="name" placeholder="" required/>
</div>


<div class="row align-items-center mb-2">
    <div class="col">
        <h2 class="h5 page-title"></h2>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">
            {{$btn_label ?? "أضف"}}
        </button>
    </div>
</div>
@push('scripts')
    <script>
        $("input[name='date_of_birth']").on("input", function () {
            let thisYear = new Date().getFullYear();
            let date_of_birth = moment($("input[name='date_of_birth']").val()).format('YYYY');
            $("input[name='age']").val(thisYear - date_of_birth)
        });
    </script>
@endpush
