<div class="row">
    <div class="form-group p-3 col-12">
        <x-form.input label="الاسم" :value="$role->name"  name="name" placeholder="إضافة العنصر ..." required autofocus/>
    </div>
    <div class="form-group p-3 col-12">
        <x-form.input label="الرمز" :value="$role->ability"  name="ability" placeholder="item.create" required/>
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
