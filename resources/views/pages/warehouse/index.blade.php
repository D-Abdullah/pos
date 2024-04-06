@extends('layouts.app')

@section('title', ' المستودع')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/warehouse.css') }}">
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

@endsection
@section('content')

    <!-- start of buttons -->
    <div class="mt-5 mb-5 special ">
        <a href="{{ url()->current() }}?type=all"
            class="btn border-0 p-2 ps-4 pe-4 secound-btn {{ request('type') == 'all' ? 'active-btn' : '' }} mb-2">
            @if (request('type') == 'all')
                <img class="light" src="{{ asset('Assets/imgs/box-light.png') }}" alt="">
            @else
                <img class="dark" src="{{ asset('Assets/imgs/box.png') }}">
            @endif
            اجمالي
        </a>
        <a href="{{ url()->current() }}?type=current"
            class="btn border-0 p-2 ps-4 pe-4 ms-2 me-2 secound-btn {{ request('type') == 'current' ? 'active-btn' : '' }} mb-2">
            @if (request('type') == 'current')
                <img class="light" src="{{ asset('Assets/imgs/file-check-light.png') }}" alt="">
            @else
                <img class="dark" src="{{ asset('Assets/imgs/file-check.png') }}" alt="">
            @endif
            الفعليه
        </a>
        <a href="{{ url()->current() }}?type=party"
            class="btn border-0 p-2 ps-4 pe-4 secound-btn {{ request('type') == 'party' ? 'active-btn' : '' }} mb-2">
            @if (request('type') == 'party')
                <img class="light" src="{{ asset('Assets/imgs/file-import-light.png') }}" alt="">
            @else
                <img class="dark" src="{{ asset('Assets/imgs/file-import.png') }}" alt="">
            @endif
            عهده
        </a>
    </div>
    <!-- end of buttons -->

    <h2 class="mb-5">المخزن</h2>


    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto">

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

        <table class="w-100 mb-4 border">
            <thead class="head">
                <tr>
                    <th>اسم المنتج</th>
                    <th>القسم</th>
                    <th>الكميه</th>
                </tr>
            </thead>

            <tbody>
                @if (count($wts) === 0)
                    <tr>
                        <td colspan="3" class="text-center">
                            لا توجد بيانات
                        </td>
                    </tr>
                @endif
                @foreach ($wts as $wt)
                    <tr>
                        <td>{{ $wt->name }}</td>
                        @if ($wt->department)
                            <td>{{ $wt->department->name }}</td>
                        @else
                            <td class="text-danger fw-bold">لم يتم التحديد</td>
                        @endif
                        <td>{{ $wt->quantity }}</td>
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

@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/warehouse.js') }}"></script>


@endsection
