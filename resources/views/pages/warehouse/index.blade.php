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
