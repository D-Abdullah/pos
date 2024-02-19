<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | {{config('app.name')}}</title>

    <link rel="shortcut icon" href="{{ asset('Assets/imgs/vuexy-logo.png') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('Assets/imgs/vuexy-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('Assets/Normalize file/Normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Bootsrap files/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Bootsrap files/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Css files/Golobal.css') }}">
    <link rel="stylesheet" href="{{ asset('Assets/Css files/login.css') }}">
</head>
<body>
<div class="page d-flex">
    <div class="up w-100 h-100 d-flex align-items-center">
        <div class="right-side"></div>
        <div class="left-side d-flex justify-content-center align-items-center">
            <div class="parent p-2 ps-4 pe-4">
                <div class="logo mb-4 d-flex align-items-center">
                    <img src="{{ asset('Assets/imgs/vuexy-logo.png') }}" alt="">
                    <span class="fs-3 fw-bold me-3 opacity-75">{{config('app.name')}}</span>
                </div>
                <div class="mb-2">
                    <h1 class="fw-bold fs-2">اهلا بعودتك</h1>
                    <p>من فضلك املئ تلك البيانات</p>
                </div>
                <form id="form" action="{{ route('loginAction') }}" method="POST">
                    @csrf
                    @include('components.alerts.danger')
                    @include('components.alerts.success')
                    @include('components.alerts.warning')
                    <div class="username input-control mb-3 d-flex flex-column">
                        <label class="mb-1" for="user">البريد الالكتروني</label>
                        <input type="text" value="{{old('email')}}" id="user" placeholder="افلت حسابك" name="email" autocomplete="false" autofocus aria-autocomplete="false">
                        <div class="error"></div>
                    </div>
                    <div class="password input-control d-flex mb-3 flex-column">
                        <label class="mb-1" for="pass">الرقم السري</label>
                        <input type="password" id="pass" placeholder="اكتب الرقم" name="password" autocomplete="false" aria-autocomplete="false">
                        <div class="error"></div>
                    </div>
                    <div class="form-check-1 mb-3">
                        <input class="form-check-input" type="checkbox" value="1" name="remember" id="checkbox">
                        <label class="form-check-label me-2" for="checkbox">احفظ بياناتي</label>
                    </div>
                </form>
                <button class="rounded-3 text-light" disabled id="login">تسجيل الدخول</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('Assets/JS files/login.js') }}"></script>
</body>
</html>
