<div class="row">
    <div class="form-group p-3 col-4">
        <label for="gender">رقم الموظف</label>
        <div class="input-group mb-3">
            <x-form.input :value="$customization->employee_id" name="employee_id" placeholder="0" readonly  />
            <div class="input-group-append">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#searchEmployee">
                    <i class="fe fe-search"></i>
                </button>
            </div>
        </div>
        <div id="nameEmployee"></div>
    </div>

</div>
<div class="row">
    <h4>علاوة الدرجة</h4>
    <div class="form-group p-3 col-4">
        <x-form.input type="number" label="تخصيص علاوة درجة للموظف" :value="$customization->grade_Allowance"  name="grade_Allowance" placeholder="مبلغ معين" />
    </div>
</div>
<h4>علاوة الأولاد</h4>
<div class="row align-items-center ml-2 mr-2">
    <span>(عدد الأولاد X </span>
    <div class="form-group p-3 col-2">
        <x-form.input type="number" label="" value="{{$customization->allowance_boys_1}}"  name="allowance_boys_1" placeholder="" />
    </div>
    <span>)+</span>
    <div class="form-group p-3 col-2">
        <x-form.input type="number" label="" value="{{$customization->allowance_boys_2}}"  name="allowance_boys_2" placeholder="" />
    </div>
</div>
<h4>نهاية الخدمة</h4>
<div class="row align-items-center  ml-2 mr-2">
    <span>(الراتب الأساسي X </span>
    <span>زيادة طبيعة العمل X </span>
    <span>علاوة إدارية) X </span>
    <div class="form-group p-3 col-2">
        <x-form.input type="number" label="" :value="$customization->termination_service"  name="termination_service" placeholder="النسبة" />
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
