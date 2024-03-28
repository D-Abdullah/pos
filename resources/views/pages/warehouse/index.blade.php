@extends('layouts.app')

@section('title', ' المستودع')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/warehouse.css') }}">
@endsection
{{-- First One Style --}}
<style>
    .select-btn,
    li {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .select-btn {
        padding: 10px 20px;
        gap: 10px;
        border-radius: 5px;
        justify-content: space-between;
        border: 1px solid #eee;
        min-width: 160px;
    }

    .select-btn i {
        font-size: 14px;
        transition: transform 0.3s linear;
    }

    .wrapper.active .select-btn i {
        transform: rotate(-180deg);
    }

    .content {
        display: none;
        padding: 20px;
        margin-top: 15px;
        background: #fff;
        border-radius: 5px;
        border: 1px solid #eee;
        position: fixed;
    }

    .wrapper.active .content {
        display: block;
    }

    .content .search {
        position: relative;
    }

    .search input {
        height: 50px;
        width: 100%;
        outline: none;
        font-size: 17px;
        border-radius: 5px;
        padding: 0 20px 0 43px;
        border: 1px solid #B3B3B3;
    }

    .search input:focus {
        padding-left: 42px;
        border: 2px solid #4285f4;
    }

    .search input::placeholder {
        color: #bfbfbf;
    }

    .content .options {
        margin-top: 10px;
        max-height: 250px;
        overflow-y: auto;
        padding-right: 7px;
    }

    .options::-webkit-scrollbar {
        width: 7px;
    }

    .options::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 25px;
    }

    .options::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 25px;
    }

    .options::-webkit-scrollbar-thumb:hover {
        background: #b3b3b3;
    }

    .options li {
        padding: 5px 13px;
    }

    .options li:hover,
    li.selected {
        border-radius: 5px;
        background: #f2f2f2;
    }
</style>
{{-- Second One Style --}}

<style>
    .select-btn,
    li {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .select-btn-add {
        padding: 10px 20px;
        gap: 10px;
        border-radius: 5px;
        justify-content: space-between;
        border: 1px solid #eee;
        min-width: 160px;
    }

    .select-btn i {
        font-size: 14px;
        transition: transform 0.3s linear;
    }

    .dropdown.active .select-btn i {
        transform: rotate(-180deg);
    }

    .content {
        display: none;
        padding: 20px;
        margin-top: 15px;
        background: #fff;
        border-radius: 5px;
        border: 1px solid #eee;
        position: fixed;
    }

    .dropdown.active .content {
        display: block;
    }

    .content .search {
        position: relative;
    }

    .search input {
        height: 50px;
        width: 100%;
        outline: none;
        font-size: 17px;
        border-radius: 5px;
        padding: 0 20px 0 43px;
        border: 1px solid #B3B3B3;
    }

    .search input:focus {
        padding-left: 42px;
        border: 2px solid #4285f4;
    }

    .search input::placeholder {
        color: #bfbfbf;
    }

    .content .options {
        margin-top: 10px;
        max-height: 250px;
        overflow-y: auto;
        padding-right: 7px;
    }

    .options::-webkit-scrollbar {
        width: 7px;
    }

    .options::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 25px;
    }

    .options::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 25px;
    }

    .options::-webkit-scrollbar-thumb:hover {
        background: #b3b3b3;
    }

    .options li {
        padding: 5px 13px;
    }

    .options li:hover,
    li.selected {
        border-radius: 5px;
        background: #f2f2f2;
    }
</style>
@section('content')

                <!-- start of main-container -->
                <div class="main-container pt-4 d-flex flex-column overflow-hidden">

                    <!-- start of buttons -->
                    <div class="mt-5 mb-5 special ">
                        <button class="p-2 ps-4 pe-4 secound-btn active-btn mb-2" data-count="one">
                            <img class="dark" src="./Assets/imgs/box.png" alt="">
                            <img class="light" src="./Assets/imgs/box-light.png" alt="">
                            اجمالي المخزن
                        </button>
                        <button class="p-2 ps-4 pe-4 ms-2 me-2 secound-btn mb-2" data-count="two">
                            <img class="dark" src="./Assets/imgs/file-check.png" alt="">
                            <img class="light" src="./Assets/imgs/file-check-light.png" alt="">
                            عناصر المتاحه
                        </button>
                        <button class="p-2 ps-4 pe-4 secound-btn mb-2" data-count="three">
                            <img class="dark" src="./Assets/imgs/file-import.png" alt="">
                            <img class="light" src="./Assets/imgs/file-import-light.png" alt="">
                            عناصر في الحفلات
                        </button>
                    </div>
                    <!-- end of buttons -->

                    <!-- end of frame-5 (header) -->
                    <h2 class="mb-5">المخزن</h2>
                    <!-- start of body -->

                    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto one" id="one">

                        <div class="features shadow-sm p-4 d-flex justify-content-between align-items-center">



                            <div class="component-left me-3 gap-4 d-flex align-items-center">

                                <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                                    <button onclick="dropdown('valueRelease', 'listRelease')">
                                        <span class="fw-bold opacity-50 valueDropdown" id="valueRelease">اصدار</span>
                                        <img src="./Assets/imgs/chevron-down.png" alt="">
                                    </button>
                                    <div class="options none">
                                        <ul id="listRelease">
                                            <li>PDF</li>
                                            <li>EXCEL</li>
                                            <li>PRINT</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <table class="w-100 mb-4 border">

                            <thead class="head">
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th>الفئه</th>
                                    <th>الكميه</th>
                                    {{-- <th>الحاله</th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            viewBox="0 0 24 25" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                                                stroke="#4B465C" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                                                stroke="white" stroke-opacity="0.2" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="12" cy="12.1108" r="3" stroke="#4B465C"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="12" cy="12.1108" r="3" stroke="white"
                                                stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </th> --}}
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>150</td>
                                    {{-- <td><span class="live">نشط</span></td>
                                    <td>
                                        <div class="edit d-flex align-items-center justify-content-center">
                                            <img src="./Assets/imgs/edit-circle.png" alt="" id="edit">
                                            <div class="form-check form-switch ms-2 me-2">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckDefault">
                                            </div>
                                            <img src="./Assets/imgs/trash (1).png" alt="" id="trash">
                                        </div>
                                    </td> --}}
                                </tr>
                                <tr>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>150</td>
                                    {{-- <td><span class="died">غير نشط</span></td>
                                    <td>
                                        <div class="edit d-flex align-items-center justify-content-center">
                                            <img src="./Assets/imgs/edit-circle.png" alt="" id="edit">
                                            <div class="form-check form-switch ms-2 me-2">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckDefault">
                                            </div>
                                            <img src="./Assets/imgs/trash (1).png" alt="" id="trash">
                                        </div>
                                    </td> --}}
                                </tr>
                            </tbody>


                        </table>

                        <div class="table-control d-flex justify-content-between align-items-center">
                            <div class="buttons">
                                <button class="p-2 rounded-3">التالي</button>
                                <span class="number-pages main-btn text-light ms-1 me-1">1</span>
                                <button class="p-2 rounded-3">السابق</button>
                            </div>
                            <div class="info-table opacity-50">
                                <p>عرض <span>1</span> الي <span>10</span> من <span>1</span> مدخلات</p>
                            </div>
                        </div>

                    </section>

                    {{-- <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto none two" id="two">

                        <div class="features shadow-sm p-4 d-flex justify-content-between align-items-center">
                            <div class="component-right gap-4 d-flex align-items-center">

                                <div class="add-button">
                                    <button class="text-light main-btn"> اضافه عنصر</button>
                                </div>

                                <div class="search-input">
                                    <input type="search" placeholder="بحث" id="search">
                                </div>

                                <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                                    <button onclick="dropdown('valueStatus', 'listStatus')">
                                        <span class="fw-bold opacity-50 valueDropdown" id="valueStatus">الفئة</span>
                                        <img src="./Assets/imgs/chevron-down.png" alt="">
                                    </button>
                                    <div class="options none">
                                        <ul id="listStatus">
                                            <li class="p-0" id="search">
                                                <input class="search" type="search" placeholder="بحث">
                                            </li>
                                            <li class="active">الفئة</li>
                                            <li>فئة 1</li>
                                            <li>فئه 2</li>
                                        </ul>
                                    </div>
                                </div>

                                <button class="main-btn" id="form">تأكيد</button>

                            </div>

                            <div class="component-left me-3 gap-4 d-flex align-items-center">

                                <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                                    <button onclick="dropdown('valueRelease', 'listRelease')">
                                        <span class="fw-bold opacity-50 valueDropdown" id="valueRelease">اصدار</span>
                                        <img src="./Assets/imgs/chevron-down.png" alt="">
                                    </button>
                                    <div class="options none">
                                        <ul id="listRelease">
                                            <li>PDF</li>
                                            <li>ECXEL</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <table class="w-100 mb-4 border">

                            <thead class="head">
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th>الفئه</th>
                                    <th>الكميه</th>
                                    <th>الحاله</th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            viewBox="0 0 24 25" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                                                stroke="#4B465C" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                                                stroke="white" stroke-opacity="0.2" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="12" cy="12.1108" r="3" stroke="#4B465C"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="12" cy="12.1108" r="3" stroke="white"
                                                stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>150</td>
                                    <td><span class="live">نشط</span></td>
                                    <td>
                                        <div class="edit d-flex align-items-center justify-content-center">
                                            <img src="./Assets/imgs/edit-circle.png" alt="" id="edit">
                                            <div class="form-check form-switch ms-2 me-2">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckDefault">
                                            </div>
                                            <img src="./Assets/imgs/trash (1).png" alt="" id="trash">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>150</td>
                                    <td><span class="died">غير نشط</span></td>
                                    <td>
                                        <div class="edit d-flex align-items-center justify-content-center">
                                            <img src="./Assets/imgs/edit-circle.png" alt="" id="edit">
                                            <div class="form-check form-switch ms-2 me-2">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckDefault">
                                            </div>
                                            <img src="./Assets/imgs/trash (1).png" alt="" id="trash">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>


                        </table>

                        <div class="table-control d-flex justify-content-between align-items-center">
                            <div class="buttons">
                                <button class="p-2 rounded-3">التالي</button>
                                <span class="number-pages main-btn text-light ms-1 me-1">1</span>
                                <button class="p-2 rounded-3">السابق</button>
                            </div>
                            <div class="info-table opacity-50">
                                <p>عرض <span>1</span> الي <span>10</span> من <span>1</span> مدخلات</p>
                            </div>
                        </div>

                    </section>

                    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto none three" id="three">

                        <div class="features shadow-sm p-4 d-flex justify-content-between align-items-center">

                            <div class="component-right gap-4 d-flex align-items-center">

                                <div class="add-button">
                                    <button class="text-light main-btn"> اضافه عنصر</button>
                                </div>

                                <div class="search-input">
                                    <input type="search" placeholder="بحث" id="search">
                                </div>

                                <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                                    <button onclick="dropdown('valueStatus', 'listStatus')">
                                        <span class="fw-bold opacity-50 valueDropdown" id="valueStatus">الفئة</span>
                                        <img src="./Assets/imgs/chevron-down.png" alt="">
                                    </button>
                                    <div class="options none">
                                        <ul id="listStatus">
                                            <li class="p-0" id="search">
                                                <input class="search" type="search" placeholder="بحث">
                                            </li>
                                            <li class="active">الفئة</li>
                                            <li>فئة 1</li>
                                            <li>فئه 2</li>
                                        </ul>
                                    </div>
                                </div>

                                <button class="main-btn" id="form">تأكيد</button>

                            </div>

                            <div class="component-left me-3 gap-4 d-flex align-items-center">

                                <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                                    <button onclick="dropdown('valueRelease', 'listRelease')">
                                        <span class="fw-bold opacity-50 valueDropdown" id="valueRelease">اصدار</span>
                                        <img src="./Assets/imgs/chevron-down.png" alt="">
                                    </button>
                                    <div class="options none">
                                        <ul id="listRelease">
                                            <li>PDF</li>
                                            <li>ECXEL</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <table class="w-100 mb-4 border">

                            <thead class="head">
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th>الفئه</th>
                                    <th>الكميه</th>
                                    <th>الحاله</th>
                                    <th>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                            viewBox="0 0 24 25" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                                                stroke="#4B465C" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                                                stroke="white" stroke-opacity="0.2" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="12" cy="12.1108" r="3" stroke="#4B465C"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="12" cy="12.1108" r="3" stroke="white"
                                                stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>150</td>
                                    <td><span class="live">نشط</span></td>
                                    <td>
                                        <div class="edit d-flex align-items-center justify-content-center">
                                            <img src="./Assets/imgs/edit-circle.png" alt="" id="edit">
                                            <div class="form-check form-switch ms-2 me-2">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckDefault">
                                            </div>
                                            <img src="./Assets/imgs/trash (1).png" alt="" id="trash">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>150</td>
                                    <td><span class="died">غير نشط</span></td>
                                    <td>
                                        <div class="edit d-flex align-items-center justify-content-center">
                                            <img src="./Assets/imgs/edit-circle.png" alt="" id="edit">
                                            <div class="form-check form-switch ms-2 me-2">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckDefault">
                                            </div>
                                            <img src="./Assets/imgs/trash (1).png" alt="" id="trash">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>


                        </table>

                        <div class="table-control d-flex justify-content-between align-items-center">
                            <div class="buttons">
                                <button class="p-2 rounded-3">التالي</button>
                                <span class="number-pages main-btn text-light ms-1 me-1">1</span>
                                <button class="p-2 rounded-3">السابق</button>
                            </div>
                            <div class="info-table opacity-50">
                                <p>عرض <span>1</span> الي <span>10</span> من <span>1</span> مدخلات</p>
                            </div>
                        </div>

                    </section> --}}

                    <!-- end of body -->



                </div>
                <!-- end of main-container -->


@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/warehouse.js') }}"></script>



    {{-- For Drobdown input --}}
    <script>
        const wrapper = document.querySelector(".wrapper"),
            selectBtn = wrapper.querySelector(".select-btn"),
            searchInp = wrapper.querySelector("input"),
            options = wrapper.querySelector(".options");

        let countries = ["Afghanistan", "Algeria", "Argentina"];

        function addCountry(selectedCountry) {
            options.innerHTML = "";
            countries.forEach(country => {
                let isSelected = country == selectedCountry ? "selected" : "";
                let li = `<li onclick="updateName(this)" class="${isSelected}">${country}</li>`;
                options.insertAdjacentHTML("beforeend", li);
            });
        }
        addCountry();

        function updateName(selectedLi) {
            searchInp.value = "";
            addCountry(selectedLi.innerText);
            wrapper.classList.remove("active");
            selectBtn.firstElementChild.innerText = selectedLi.innerText;
        }

        searchInp.addEventListener("keyup", () => {
            let arr = [];
            let searchWord = searchInp.value.toLowerCase();
            arr = countries.filter(data => {
                return data.toLowerCase().startsWith(searchWord);
            }).map(data => {
                let isSelected = data == selectBtn.firstElementChild.innerText ? "selected" : "";
                return `<li onclick="updateName(this)" class="${isSelected}">${data}</li>`;
            }).join("");
            options.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! not found</p>`;
        });

        selectBtn.addEventListener("click", () => wrapper.classList.toggle("active"));
    </script>
    {{-- Second One Script --}}
    <script>
        const wrapperAdd = document.querySelector(".dropdown"),
            selectBtnAdd = wrapperAdd.querySelector(".select-btn-add"),
            searchInpAdd = wrapperAdd.querySelector("input"),
            optionsAdd = wrapperAdd.querySelector(".options");

        let parts = ["part 1", "part 3", "part 2"];

        function addCate(selectedPart) {
            optionsAdd.innerHTML = "";
            parts.forEach(category => {
                let isSelectedAdd = category == selectedPart ? "selected" : "";
                let li = `<li onclick="update(this)" class="${isSelectedAdd}">${category}</li>`;
                optionsAdd.insertAdjacentHTML("beforeend", li);
            });
        }
        addCate();

        function update(selectedli) {
            searchInpAdd.value = "";
            addCate(selectedli.innerText);
            wrapperAdd.classList.remove("active");
            selectBtnAdd.firstElementChild.innerText = selectedli.innerText;
        }

        searchInpAdd.addEventListener("keyup", () => {
            let arr = [];
            let searchWord = searchInpAdd.value.toLowerCase();
            arr = parts.filter(onePart => {
                return onePart.toLowerCase().startsWith(searchWord);
            }).map(onePart => {
                let isSelectedAdd = onePart == selectBtnAdd.firstElementChild.innerText ? "selected" : "";
                return `<li onclick="update(this)" class="${isSelectedAdd}">${onePart}</li>`;
            }).join("");
            optionsAdd.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! not found</p>`;
        });

        selectBtnAdd.addEventListener("click", () => wrapperAdd.classList.toggle("active"));
    </script>


@endsection
