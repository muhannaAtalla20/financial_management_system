customizations<div class="row">

    <div class="form-group p-3 col-4">
        <label for="gender">رقم الموظف</label>
        <div class="input-group mb-3">
            <x-form.input :value="$bank_employee->employee_id" name="employee_id" placeholder="0" readonly  />
            <div class="input-group-append">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchEmployee">
                    <i class="fe fe-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="form-group p-3 col-4">
        <label for="bank_id">البنك - الفرع</label>
        <select class="custom-select" id="bank_id" name="bank_id" required>
            <option @selected($bank_employee->bank_id == null)>عرض القيم المتوفرة</option>
            @foreach ($banks as $bank)
                <option value="{{$bank['id']}}" @selected($bank_employee->bank_id == $bank['id'])>{{$bank['name'] . " - " . $bank['branch'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group p-3 col-4">
        <x-form.input minlength="9" maxlength="9" label="رقم الحساب" :value="$bank_employee->account_number"  name="account_number" placeholder="4000000" required/>
    </div>
    <div class="form-group p-3 col-4">
        <label for="default">الإفتراضي</label>
        <select class="custom-select" id="default" name="default" required>
            <option  value="1" @selected($bank_employee->default == 1)>نعم</option>
            <option value="0" @selected($bank_employee->default == 0)>لا</option>
        </select>
    </div>
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
