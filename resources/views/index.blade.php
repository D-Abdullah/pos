@extends('layouts.app')

@section('title', 'الاحصائيات')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/statistics.css') }}">

    <style>
        .dropdown-target {
            position: relative;
        }

        .dropdown-target svg {
            cursor: pointer;
        }

        .dropdown-target ul {
            background-color: white;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 10;
            display: none;
        }

        .dropdown-target ul li {
            padding: 7px 30px;
            cursor: pointer;
        }

        .dropdown-target ul li:hover {
            background: #ddd;
        }

        .show-hide {

            display: block !important;
        }

        .open {
            opacity: 1 !important;
            top: 50% !important;
        }
    </style>
@endsection

@section('content')
    <h2 class="mt-5 mb-5">الاحصائيات</h2>
    <!-- start of body -->
    <div class="section firstSection d-flex gap-4 mb-4 overflow-scroll">

        <div class="earningsReports rounded-3 shadow-sm p-4">
            <div class="info d-flex justify-content-between align-items-center">
                <div class="right">
                    <h4 class="fw-medium fs-3">تقارير الارباح</h4>
                    <p class="text-color">نظرة عامة على الأرباح الأسبوعية</p>
                </div>
                {{-- <div class="left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                        fill="none">
                        <circle cx="10.9997" cy="10.9999" r="0.916667" stroke="#4B465C" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="10.9997" cy="10.9999" r="0.916667" stroke="white" stroke-opacity="0.5"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="10.9997" cy="17.4167" r="0.916667" stroke="#4B465C" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="10.9997" cy="17.4167" r="0.916667" stroke="white" stroke-opacity="0.5"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <ellipse cx="10.9997" cy="4.58341" rx="0.916667" ry="0.916667" stroke="#4B465C"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <ellipse cx="10.9997" cy="4.58341" rx="0.916667" ry="0.916667" stroke="white"
                            stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div> --}}
            </div>
            <div class="chart d-flex justify-content-between align-items-center mb-3">
                <div class="right">
                    <span class="fw-medium fs-1" id="comparingValue">455 EGP</span>
                    <p>لقد أبلغت هذا الأسبوع مقارنة بالأسبوع الماضي</p>
                </div>
                <div class="left w-50">
                    <canvas id="customChart"></canvas>
                </div>
            </div>
            <div class="deta d-flex justify-content-between gap-4">
                <div class="box">
                    <div class="info d-flex align-items-center">
                        <img src="./Assets/imgs/dollar.png" alt="">
                        <span class="fw-bold fs-5 me-2">العائد</span>
                    </div>
                    <span class="d-block mb-3 mt-3 fs-4">EGP 445</span>
                    <div class="prog position-relative">
                        <span class="position-absolute" id="value" style="width: 70%; height: 100%;"></span>
                    </div>
                </div>
                <div class="box">
                    <div class="info d-flex align-items-center">
                        <img src="./Assets/imgs/paypal.png" alt="">
                        <span class="fw-bold fs-5 me-2">المصروف</span>
                    </div>
                    <span class="d-block mb-3 mt-3 fs-4">EGP 445</span>
                    <div class="prog position-relative">
                        <span class="position-absolute" id="value" style="width: 20%; height: 100%;"></span>
                    </div>
                </div>
                <div class="box">
                    <div class="info d-flex align-items-center">
                        <img src="./Assets/imgs/profit.png" alt="">
                        <span class="fw-bold fs-5 me-2">الربح</span>
                    </div>
                    <span class="d-block mb-3 mt-3 fs-4">EGP 445</span>
                    <div class="prog position-relative">
                        <span class="position-absolute" id="value" style="width: 60%; height: 100%;"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="workTarget rounded-3 shadow-sm p-4">
            <div class="info mb-4 d-flex justify-content-between align-items-center">
                <div class="right">
                    <h4 class="text-color">تارجت العمل</h4>
                    <p class="text-color">باقي 7 ايام علي انتهاء التارجت</p>
                </div>
                <div class="left dropdown-target">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                        fill="none">
                        <circle cx="10.9997" cy="10.9999" r="0.916667" stroke="#4B465C" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="10.9997" cy="10.9999" r="0.916667" stroke="white" stroke-opacity="0.5"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="10.9997" cy="17.4167" r="0.916667" stroke="#4B465C" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="10.9997" cy="17.4167" r="0.916667" stroke="white" stroke-opacity="0.5"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <ellipse cx="10.9997" cy="4.58341" rx="0.916667" ry="0.916667" stroke="#4B465C"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <ellipse cx="10.9997" cy="4.58341" rx="0.916667" ry="0.916667" stroke="white"
                            stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <ul>
                        <li class="add">اضافه</li>
                        <li class="edit">تعديل</li>
                        <li class="delete">حذف</li>
                    </ul>

                    <div class="popup-add popup shadow-sm rounded-3 position-fixed close">
                        <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
                        <h2 class="text-center mt-4 mb-4 opacity-75">اضافة تارجيت جديدة</h2>
                        <form id="add-cate" method="post" action="">

                            <div>
                                <span class="d-block mb-1">اخر الموعد</span>
                                <input type="text" name="dead_time" class="dead_time" placeholder="اخر الموعد">
                            </div>
                            <div>
                                <span class="d-block">المبلغ</span>
                                <input type="text" name="cost" class="cost" placeholder="المبلغ">
                            </div>
                            <div id="invalidAdd" class="invalid my-3"></div>
                            <button class="main-btn mt-5" type="submit">اضافه التارجيت</button>
                        </form>
                    </div>

                    <div class="overlay position-absolute none w-100 h-100"></div>
                </div>
            </div>
            <div class="chart mb-5 d-flex align-items-center">
                <div class="right w-100 gap-3 d-flex flex-column">
                    <h1>مده</h1>
                    <span class="fs-5 opacity-50" id="date">من 1/30/2024 الي 1/2/2024</span>
                    <div class="d-flex align-items-center gap-3">
                        <img src="./Assets/imgs/profit.png" alt="">
                        <div class="d-flex flex-column">
                            <span class="fw-bold fs-5">دخل المبيعات</span>
                            <span class="fs-5 opacity-50">150 الف من 200 الف</span>
                        </div>
                    </div>
                    {{-- <div class="d-flex d-flex align-items-center gap-3">
                        <img src="./Assets/imgs/ticket.png" alt="">
                        <div class="d-flex flex-column"">
                            <span class="fw-bold fs-5">حفله جديدة</span>
                            <span class="fs-5 opacity-50">122 حفله من 150 حفله</span>
                        </div>
                    </div> --}}
                </div>
                <div class="left w-100 d-flex flex-column align-items-center gap-2 me-5">
                    <span class="fs-5 opacity-50">تقدم التارجت</span>
                    <span class="fw-medium fs-1" id="value">85%</span>
                    <div class="progress">
                        <span style="width: 75%;"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section mb-4">
        <div class="revenueReport p-5 rounded-3 shadow-sm d-flex justify-content-between">
            <div>
                <h4>تقرير الايرادات</h4>
                <canvas id="myChart2x"></canvas>
            </div>
            <div class="left d-flex gap-2 flex-column align-items-center justify-content-center">
                <span class="mb-5" id="year">2024</span>
                <span class="fw-medium fs-2" id="value"> EGP 25,825</span>
                <div class="fw-bold fs-3">الايراد الكلي: <span class="fs-5 opacity-50">56,800</span></div>
                <canvas id="myChart5"></canvas>
            </div>
            <!-- <div class="up d-flex gap-5">
                                                                                                                                                                                                                                                                            </div> -->
        </div>
    </div>

    <div class="section">
        <div class="revenueReport p-5 h-100 w-100 rounded-3 shadow-sm">
            <div>
                <h2>تقارير الارباح</h2>
                <span>نظرة عامة على الأرباح السنوية</span>
            </div>
            {{-- <div class="buttoms d-flex gap-4 mt-4 mb-4">
                <div class="d-flex gap-4">
                    <button class="active" data-chart="customChart3">
                        <img src="./Assets/imgs/sales.png" alt="">
                        مبيعات
                    </button>
                    <button data-chart="customChart4">
                        <img src="./Assets/imgs/current-dollar.png" alt="">
                        مصروف
                    </button>
                </div>
                <div class="d-flex gap-4">
                    <button data-chart="customChart5">
                        <img src="./Assets/imgs/current-dollar.png" alt="">
                        ربح
                    </button>
                    <button>
                        <img src="./Assets/imgs/Add.png" alt="">
                        اضافه
                    </button>
                </div>
            </div> --}}
            <canvas class="canvas" id="customChart3"></canvas>
            <canvas class="canvas none" id="customChart4"></canvas>
            <canvas class="canvas none" id="customChart5"></canvas>
        </div>
    </div>
    <!-- end of body -->

@endsection

@section('script')

    <script src="{{ asset('Assets/JS files/chart.js') }}"></script>
    <script src="{{ asset('Assets/JS files/statistics.js') }}"></script>
    <script src="{{ asset('Assets/JS files/global.js') }}"></script>


    {{-- open target --}}
    <script>
        const icon = document.querySelector(".dropdown-target svg");
        const menuTarget = document.querySelector(".dropdown-target ul");

        const targetPopup = document.querySelector(".dropdown-target popup");

        const openTarget = document.querySelector(".dropdown-target ul .add");
        const editTarget = document.querySelector(".dropdown-target ul .edit");

        icon.addEventListener("click", function() {
            menuTarget.classList.toggle("show-hide")
        });
    </script>
@endsection
