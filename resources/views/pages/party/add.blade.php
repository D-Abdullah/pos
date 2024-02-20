@extends('layouts.app')

@section('title', 'اضافه حفله جديده')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/add-concert.css') }}">
@endsection

@section('content')
    <!-- end of frame-5 (header) -->
    <h2 class="mb-2 mt-5">اضافه حفله جديده</h2>
    <!-- start of body -->
    <div class="components">
        <div class="parent gap-3 mb-4 d-flex">
            <div class="select-form">
                <label>العميل</label>
                <div class="select-btn w-100 mt-1 select position-relative rounded-3 d-flex align-items-center">
                    <button class="w-100 d-flex justify-content-between" onclick="dropdown('valueStatus', 'listStatus')">
                        <span class="fw-bold opacity-50 valueDropdown" id="valueStatus"></span>
                        <img src="./Assets/imgs/chevron-down.png" alt="">
                    </button>
                    <div class="options none">
                        <ul id="listStatus">
                            <li class="p-0" id="search">
                                <input class="search" type="search" placeholder="بحث">
                            </li>
                            <li>مصطفي</li>
                            <li>فكري</li>
                            <li>محمد</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div>
                <label class="d-block mb-1" for="party-name">اسم الحفله</label>
                <input type="text" name="text" id="party-name" placeholder="">
            </div>
            <div>
                <label class="d-block mb-1" for="party-date">تاريخ الحفله</label>
                <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                    <button class="w-100 d-flex justify-content-between"
                        onclick="dropdown('valueDateAddLast', 'listDateAddLast')">
                        <span class="fw-bold opacity-50 valueDropdown" id="valueDateAddLast">التاريخ</span>
                        <img src="./Assets/imgs/calendar-stats.png" alt="">
                    </button>
                    <div class="options none">
                        <ul id="listDateAddLast">
                            <li class="p-0" id="search">
                                <input class="date" type="date" placeholder="بحث">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="select-form">
                <label>الحاله</label>
                <div class="select-btn w-100 mt-1 select position-relative rounded-3 d-flex align-items-center">
                    <button class="w-100 d-flex justify-content-between"
                        onclick="dropdown('valueStatusSix', 'listStatusSix')">
                        <span class="fw-bold opacity-50 valueDropdown" id="valueStatusSix"></span>
                        <img src="./Assets/imgs/chevron-down.png" alt="">
                    </button>
                    <div class="options none">
                        <ul id="listStatusSix">
                            <li class="p-0" id="search">
                                <input class="search" type="search" placeholder="بحث">
                            </li>
                            <li>الحاله 1</li>
                            <li>الحاله 2</li>
                            <li>الحاله 3</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="parent d-flex mb-4">
            <div>
                <label class="d-block mb-1" for="party-address">عنوان الحفله</label>
                <textarea class="w-100" name="textarea" id="" cols="30" rows="4"></textarea>
            </div>
        </div>
        <div class="buttons gap-3 mb-3 d-flex align-items-center">
            <svg class="pointer" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 49 49"
                fill="none">
                <rect x="0.203125" y="0.0437012" width="48" height="48" rx="8" fill="#7367F0" />
                <path d="M24.2031 10.0437V38.0437" stroke="white" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M10.2031 24.0437H38.2031" stroke="white" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>
        <div class="elements">
            <div class="parent gap-3 d-flex  align-items-end" id="element">
                <div>
                    <label class="d-block mb-1" for="party-name">مبلغ التقسيط</label>
                    <input type="text" name="text" id="party-name" placeholder="">
                </div>
                <div>
                    <div>
                        <label class="d-block mb-1" for="party-name">تاريخ السداد</label>
                        <input type="date" name="dark" id="date" placeholder="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 d-flex justify-content-end mt-5 mb-5" id="addNewProduct">
        <form action="{{ route('party.addStore') }}" method="post">
            @csrf
            <button class="submit main-btn p-3 ps-4 pe-4" type="submit">اضافه</button>
        </form>
    </div>

@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/add-concert.js') }}"></script>
@endsection
