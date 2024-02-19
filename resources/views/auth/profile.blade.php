@extends('layouts.app')

@section('title', "الملف الشخصي")

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/personalAccount.css') }}">
@endsection

@section('content')

    <h2 class="mt-4 mb-4">الملف الشخصي</h2>
    <!-- start of body -->
    <section class="p-4 rounded-3 position-relative shadow-sm">
        <form action="{{ route('profile.update') }}" method="post">
            @method('put')
            @csrf
            <div class="f-row mb-2 d-flex gap-4">
                <div class="w-100">
                    <label class="d-block mb-1" for="first-name">الاسم الاول</label>
                    <input type="text" name="name" id="first-name" value="{{ old('name', auth()->user()->name) }}">
                    @error("name")
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="f-row d-flex gap-4">
                <div class="">
                    <label class="d-block mb-1" for="sale-buy">البريد الالكتروني</label>
                    <input type="text" name="email" id="sale-buy" value="{{ old('email', auth()->user()->email) }}">
                    @error("email")
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label class="d-block mb-1" for="phone-number">رقم الهاتف</label>
                    <input type="text" name="phone" id="phone-number" value="{{ old('phone', auth()->user()->phone) }}">
                    @error("phone")
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="buttons mt-4 d-flex justify-content-end align-items-center">
                <button class="main-btn p-2 ps-4 pe-4" type="submit">حفظ التغييرات</button>
            </div>
        </form>
    </section>

    <div class="passwords-main-div p-4 rounded-3 position-relative shadow-sm mt-3">
        <form action="{{ route('profile.password') }}" method="post">
            @method('put')
            @csrf
            <h2 class="mb-4 fs-4">كلمه المرور</h2>
            <div class="f-row mb-4">
                <div class="w-100">
                    <label class="d-block mb-1" for="first-name">كلمه السر الحاليه</label>
                    <input type="password" name="current_password" placeholder="كلمه المرور الحاليه">
                    @error("current_password")
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="f-row mb-4">
                <div class="">
                    <label class="d-block mb-1" for="sale-buy">كلمه المرور الجديده</label>
                    <input type="password" name="password" id="sale-buy" placeholder="كلمه المرور الجديده">
                    @error("password")
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="f-row mb-4">
                <div class="">
                    <label class="d-block mb-1" for="sale-buy">تاكيد كلمه المرور الجديده</label>
                    <input type="password" name="password_confirmation" id="sale-buy"
                           placeholder="تاكيد كلمه المرور الجديده">
                </div>
            </div>
            <div class="buttons mt-4 d-flex justify-content-end align-items-center">
                <button class="main-btn p-2 ps-4 pe-4" type="submit">حفظ التغييرات</button>
            </div>
        </form>
    </div>
    <!-- end of body -->

@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/personalAccount.js') }}"></script>
@endsection
