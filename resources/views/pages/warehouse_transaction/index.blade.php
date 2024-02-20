@extends('layouts.app')

@section('title', 'تحويلات المستودع')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/transaction.css') }}">
@endsection

@section('content')
    <h2 class="mt-5 mb-5">معاملات المستودع</h2>
    <!-- start of body -->
    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto">

        <div class="features shadow-sm p-4 d-flex justify-content-between align-items-center">
            <div class="component-right gap-4 d-flex align-items-center">
                <div class="search-input">
                    <input type="search" placeholder="بحث" id="search">
                </div>
                <button class="main-btn" id="form">تأكيد</button>
            </div>
            <div class="component-left me-3 gap-4 d-flex align-items-center">
                <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                    <button onclick="dropdown('valueRelease', 'listRelease')">
                        <span class="fw-bold opacity-50 valueDropdown" id="valueRelease">اصدار</span>
                        <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">
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
                    <th>الكميه</th>
                    <th>من</th>
                    <th>الي</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($wts as $wt)
                    <tr>
                        <td>{{ $wt->product_id }}</td>
                        <td>{{ $wt->quantity }}</td>
                        <td>{{ $wt->from }}</td>
                        <td>{{ $wt->to }}</td>
                    </tr>
                @endforeach

            </tbody>


        </table>

        <div class="table-control d-flex justify-content-between align-items-center">
            <div class="buttons-div">
                @if ($wts->currentPage() != 1)
                    <a href="{{ $wts->previousPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">السابق</a>
                @endif

                @for ($i = max(1, $wts->currentPage() - 2); $i <= min($wts->lastPage(), $wts->currentPage() + 2); $i++)
                    <a href="{{ $wts->url($i) }}"
                        class="number-pages text-light ms-1 me-1 main-btn {{ $i == $wts->currentPage() ? 'bg-primary' : '' }}">{{ $i }}</a>
                @endfor

                @if ($wts->currentPage() != $wts->lastPage())
                    <a href="{{ $wts->nextPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">التالي</a>
                @endif
            </div>

            <div class="info-table opacity-50">
                <p>عرض <span>{{ $wts->firstItem() }}</span> إلى <span>{{ $wts->lastItem() }}</span>
                    من
                    <span>{{ $wts->total() }}</span> مدخلات
                </p>
            </div>
        </div>

    </section>
    <!-- end of body -->

@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/transaction.js') }}"></script>
@endsection
