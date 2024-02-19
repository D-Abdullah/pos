@extends('layouts.app')

@section('title', "الاحصائيات")

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/statistics.css') }}">
@endsection

@section('content')
    <h2 class="mt-5 mb-5">الاحصائيات</h2>
    <!-- start of body -->
    <section class="d-flex gap-4">
        <div class="earningsReports rounded-3 shadow-sm w-50 p-4">
            <div class="info d-flex justify-content-between align-items-center">
                <div class="right">
                    <h4 class="text-color">تقارير الارباح</h4>
                    <p class="text-color">نظرة عامة على الأرباح الأسبوعية</p>
                </div>
                <div class="left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                         fill="none">
                        <circle cx="10.9997" cy="10.9999" r="0.916667" stroke="#4B465C" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="10.9997" cy="10.9999" r="0.916667" stroke="white" stroke-opacity="0.5"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="10.9997" cy="17.4167" r="0.916667" stroke="#4B465C" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="10.9997" cy="17.4167" r="0.916667" stroke="white" stroke-opacity="0.5"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <ellipse cx="10.9997" cy="4.58341" rx="0.916667" ry="0.916667" stroke="#4B465C"
                                 stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <ellipse cx="10.9997" cy="4.58341" rx="0.916667" ry="0.916667" stroke="white"
                                 stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            <div class="chart d-flex justify-content-between align-items-center mb-3">
                <div class="right">
                    <h2>EGP 455</h2>
                    <p>لقد أبلغت هذا الأسبوع مقارنة بالأسبوع الماضي</p>
                </div>
                <div class="left w-50">
                    <div>
                        <iframe src="./test.html" frameborder="0"></iframe>
                        <!-- <canvas id="myChart"></canvas> -->
                    </div>
                </div>
            </div>
            <div class="deta d-flex justify-content-between gap-4">
                <div class="box">
                    <div class="info d-flex align-items-center">
                        <img src="{{ asset('Assets/imgs/dollar.png') }}" alt="">
                        <span class="fw-bold fs-5 me-2">العائد</span>
                    </div>
                    <span class="d-block mb-3 mt-3 fs-4">EGP 445</span>
                    <div class="prog position-relative">
                        <span class="position-absolute" id="value" style="width: 70%; height: 100%;"></span>
                    </div>
                </div>
                <div class="box">
                    <div class="info d-flex align-items-center">
                        <img src="{{ asset('Assets/imgs/paypal.png') }}" alt="">
                        <span class="fw-bold fs-5 me-2">المصروف</span>
                    </div>
                    <span class="d-block mb-3 mt-3 fs-4">EGP 445</span>
                    <div class="prog position-relative">
                        <span class="position-absolute" id="value" style="width: 70%; height: 100%;"></span>
                    </div>
                </div>
                <div class="box">
                    <div class="info d-flex align-items-center">
                        <img src="{{ asset('Assets/imgs/profit.png') }}" alt="">
                        <span class="fw-bold fs-5 me-2">الربح</span>
                    </div>
                    <span class="d-block mb-3 mt-3 fs-4">EGP 445</span>
                    <div class="prog position-relative">
                        <span class="position-absolute" id="value" style="width: 70%; height: 100%;"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="workTarget rounded-3 shadow-sm w-50 p-4">
            <div class="info d-flex justify-content-between align-items-center">
                <div class="right">
                    <h4 class="text-color">تارجت العمل</h4>
                    <p class="text-color">باقي 7 ايام علي انتهاء التارجت</p>
                </div>
                <div class="left">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                         fill="none">
                        <circle cx="10.9997" cy="10.9999" r="0.916667" stroke="#4B465C" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="10.9997" cy="10.9999" r="0.916667" stroke="white" stroke-opacity="0.5"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="10.9997" cy="17.4167" r="0.916667" stroke="#4B465C" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="10.9997" cy="17.4167" r="0.916667" stroke="white" stroke-opacity="0.5"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <ellipse cx="10.9997" cy="4.58341" rx="0.916667" ry="0.916667" stroke="#4B465C"
                                 stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <ellipse cx="10.9997" cy="4.58341" rx="0.916667" ry="0.916667" stroke="white"
                                 stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>
    <section>

    </section>
    <!-- end of body -->

@endsection

@section('script')

    <script src="{{ asset('Assets/JS files/statistics.js') }}"></script>
    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['خ', 'ارب', 'ث', 'اث', 'ح', 'س'],
                datasets: [{
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 0
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

@endsection
