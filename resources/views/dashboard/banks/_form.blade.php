<div class="row">
    <div class="form-group p-3 col-3">
        <x-form.input label="إسم البنوك" :value="$bank->name"  name="name" placeholder="فلسطين ....." required/>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input label="مكان الفرع" :value="$bank->branch"  name="branch" placeholder="دير البلح ..." required/>
    </div>
    <div class="form-group p-3 col-3">
        <x-form.input type="number" min="0" label="رقم الفرع" :value="$bank->branch_number"  name="branch_number" placeholder="500." required/>
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
