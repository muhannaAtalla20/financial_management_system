@include('layouts.partials.head', ['title' => Config::get('app.name')])
@php
    // dd(auth()->guard());
@endphp
<div class="wrapper vh-100">
    <div class="row align-items-center h-100">
        <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="{{ route('login') }}" method="POST">
            @csrf
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/') }}" style="max-width: 100%; margin-bottom: 50px" alt="logo">
            </a>
            <h1 class="page-title mb-3">{{Config::get('app.name')}}</h1>
            <h3 class="h2 font-bold mb-3 text-muted">تسجيل الدخول</h3>
            <div class="form-group text-left">
                <x-form.input name="username" label="اسم المستخدم" placeholder="اسم المستخدم" class="form-control-lg" required autofocus />
            </div>
            <div class="form-group text-left">
                <label>Password</label>
                <div class="input-group  mb-3" id="show_hide_password">
                    <x-form.input type="password" name="password" placeholder="********"
                    class="form-control-lg" required />
                    <div class="input-group-append">
                        <a href="#" class="btn btn-primary d-flex align-items-center" style="font-size: 17px" type="button" id="button-addon2">
                            <i class="fe fe-eye-off" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">تسجيل</button>
            <p class="mt-5 mb-3 text-muted font-weight-bold h6">© تم الإنشاء بواسطة <a
                    href="https://saeyd-jamal.github.io/My_Portfolio/" target="_blank">م. محمد عسفة</a></p>
        </form>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fe-eye-off");
                    $('#show_hide_password i').removeClass("fe-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fe-eye-off");
                    $('#show_hide_password i').addClass("fe-eye");
                }
            });
        });
    </script>
@endpush
@include('layouts.partials.footer')
