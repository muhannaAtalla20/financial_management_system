@push('styles')
<style>
    #user-roles{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-auto-rows: minmax(auto, auto);
        gap: 10px 45px;
    }
</style>
@endpush
<div class="row">
    <div class="form-group p-3 col-4">
        <x-form.input label="الاسم" :value="$user->name"  name="name" placeholder="محمد ...." required autofocus/>
    </div>
    <div class="form-group p-3 col-4">
        <x-form.input label="اسم المستخدم" :value="$user->username"  name="username" placeholder="username" required/>
    </div>
    <div class="form-group p-3 col-4">
        <x-form.input type="email" label="البريد الالكتروني" :value="$user->email"  name="email" placeholder="example@gmail.com"/>
    </div>
    <div class="form-group p-3 col-4">
        @if (isset($btn_label))
        <x-form.input type="password" label="كلمة المرور" name="password" placeholder="****"  />
        @else
        <x-form.input type="password" label="كلمة المرور" name="password" placeholder="****" required />
        @endif
    </div>

    @if (!isset($btn_label))
    <div class="form-group p-3 col-4">
        <x-form.input type="password" label="تأكيد كلمة المرور"  name="confirm_password" placeholder="****" required/>
    </div>
    @endif

</div>
<div class="row ml-3">
    <fieldset id="user-roles" class="col-12">
        <legend>الصلاحيات</legend>
        @foreach (app('abilities') as $abilities_name => $ability_array)
            <div class="mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row flex-column align-items-start pl-2 pr-2">
                            <legend>{{$ability_array['name']}}</legend>
                            @foreach ($ability_array as $ability_name => $ability)
                                @if ($ability_name != 'name')
                                <div class="custom-control custom-checkbox" style="margin-right: 0;">
                                    <input class="custom-control-input" type="checkbox" name="abilities[]" id="ability-{{$abilities_name . '.' . $ability_name}}" value="{{$abilities_name . '.' . $ability_name}}" @checked(in_array($abilities_name . '.' . $ability_name, $user->roles()->pluck('role_name')->toArray())) >
                                    <label class="custom-control-label" for="ability-{{$abilities_name . '.' . $ability_name}}">
                                        {{$ability}}
                                    </label>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    </fieldset>
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
