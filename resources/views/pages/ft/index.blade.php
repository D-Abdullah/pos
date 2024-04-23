@extends('layouts.app')

@section('title', 'المعاملات الماليه')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/customers.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .invalid {
            color: red;
            font-size: 12px;
            text-align: center;
        }

        .dateInp,
        .search-input,
        .search-div {
            max-width: 180px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 0;
            outline: none;
            border: 1px solid #ddd;
            height: 30px !important;

        }

        .select2-container--default .select2-selection--single {
            height: 45px !important;
            border: 1px solid #ddd;
        }

        .select2-container[dir="rtl"] .select2-selection--single .select2-selection__rendered {
            padding-top: 7px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 0px !important;
            top: 50% !important;
        }

        .select2-container {
            width: 280px !important;
        }

        .js-example-basic-single.add.type {
            width: 100% !important
        }

        .js-example-basic-single.add.type~.select2-container {
            width: 100% !important
        }

        .js-example-basic-single.add.party~.select2-container {
            width: 100% !important
        }

        .js-example-basic-single.add.from~.select2-container {
            width: 100% !important
        }

        .js-example-basic-single.add.employee~.select2-container {
            width: 100% !important
        }

        .js-example-basic-single.add.safe~.select2-container {
            width: 100% !important
        }

        .js-example-basic-single.edit.type {
            width: 100% !important
        }

        .js-example-basic-single.edit.type~.select2-container {
            width: 100% !important
        }

        .js-example-basic-single.edit.party~.select2-container {
            width: 100% !important
        }

        .js-example-basic-single.edit.from~.select2-container {
            width: 100% !important
        }

        .js-example-basic-single.edit.employee~.select2-container {
            width: 100% !important
        }

        .js-example-basic-single.edit.safe~.select2-container {
            width: 100% !important
        }

        input[type="date"] {
            width: 280px !important
        }
    </style>

@endsection

@section('content')

    <h2 class="mt-5 mb-5">المعاملات الماليه</h2>

    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto">

        <div class="features shadow-sm p-4 d-flex justify-content-between align-items-end">

            <div class="component-right d-flex align-items-end">

                <div class="add-button">
                    <button class="text-light main-btn ms-4"> اضافه معامله ماليه</button>
                </div>

                <form action="{{ url()->current() }}" method="GET" class="mb-0 gap-4 d-flex flex-wrap align-items-end">
                    <div>
                        <label for="filterType" class="d-block">نوع</label>
                        <select class="js-example-basic-single filter type" name="type" id="filterType">
                            <option value="" {{ request('type') ? 'disabled hidden' : 'selected disabled hidden' }}>
                                اختر نوع العمليه
                            </option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>
                                دخل
                            </option>
                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>
                                مصروف
                            </option>
                        </select>
                    </div>
                    <div>
                        <label for="filterParty" class="d-block">الحفله</label>
                        <select class="js-example-basic-single filter party" name="party" id="filterParty">
                            <option value="" {{ request('party') ? 'disabled hidden' : 'selected disabled hidden' }}>
                                اختر حفله
                            </option>
                            @foreach ($parties as $party)
                                <option value="{{ $party->id }}" {{ request('party') == $party->id ? 'selected' : '' }}>
                                    {{ $party->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="filterFTType" class="d-block">نوع المعامله الماليه</label>
                        <select class="js-example-basic-single filter FTType" name="FTType" id="filterFTType">
                            <option value="" {{ request('FTType') ? 'disabled hidden' : 'selected disabled hidden' }}>
                                اختر نوع المعامله الماليه
                            </option>
                            @foreach ($ftTypes as $ftt)
                                <option value="{{ $ftt->id }}" {{ request('FTType') == $ftt->id ? 'selected' : '' }}>
                                    {{ $ftt->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="filterFrom" class="d-block">من / الى</label>
                        <select class="js-example-basic-single filter from" name="from" id="filterFrom">
                            <option value="" {{ request('from') ? 'disabled hidden' : 'selected disabled hidden' }}>
                                من / الى</option>
                            <option value="safe" {{ request('from') == 'safe' ? 'selected' : '' }}>الخزنه</option>
                            <option value="custody" {{ request('from') == 'custody' ? 'selected' : '' }}>عهده موظف</option>
                        </select>
                    </div>
                    <div>
                        <label for="filterEmployee" class="d-block">الموظف</label>
                        <select class="js-example-basic-single filter employee" name="employee" id="filterEmployee">
                            <option value=""
                                {{ request('employee') ? 'disabled hidden' : 'selected disabled hidden' }}>اختر الموظف
                            </option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ request('employee') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="filterSafe" class="d-block">الخزنه</label>
                        <select class="js-example-basic-single filter safe" name="safe" id="filterSafe">
                            <option value="" {{ request('safe') ? 'disabled hidden' : 'selected disabled hidden' }}>
                                اختر الخزنه
                            </option>
                            @foreach ($safes as $safe)
                                <option value="{{ $safe->id }}" {{ request('safe') == $safe->id ? 'selected' : '' }}>
                                    {{ $safe->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="startDate" class="d-block">من تاريخ:</label>
                        <input type="date" id="startDate" name="date_from" value="{{ request('date_from') }}">
                    </div>

                    <!-- Filter by Date To -->
                    <div>
                        <label for="date_to" class="d-block">إلى تاريخ:</label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>

                    <button type="submit" class="main-btn" id="form">تأكيد</button>
                </form>


            </div>

            <div class="component-left me-3 gap-4 d-flex align-items-center">

                <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                    <button onclick="dropdown('valueRelease', 'listRelease')">
                        <span class="fw-bold opacity-50 valueDropdown" id="valueRelease">اصدار</span>
                        <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">
                    </button>
                    <div class="options none">
                        <ul id="listRelease">
                            <li id="pdf">PDF</li>
                            <li id="excel">EXCEL</li>
                            <li id="print">PRINT</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <table class="w-100 mb-4 border" id="table">

            <thead class="head">
                <tr>
                    <th>نوع</th>
                    <th>تكلفه</th>
                    <th>الحفله</th>
                    <th>نوع المعامله الماليه</th>
                    <th>من/الى</th>
                    <th>الموظف</th>
                    <th>الخزنه</th>
                    <th>بواسطه</th>
                    <th>التاريخ</th>
                    <th>
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 25"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                                stroke="#4B465C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                                stroke="white" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <circle cx="12" cy="12.1108" r="3" stroke="#4B465C" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="12" cy="12.1108" r="3" stroke="white" stroke-opacity="0.2"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </th>
                </tr>
            </thead>

            <tbody>
                @if (count($fts) === 0)
                    <tr>
                        <td colspan="10" class="text-center">
                            لا توجد بيانات
                        </td>
                    </tr>
                @endif

                @foreach ($fts as $ft)
                    <tr>
                        <td>
                            @php
                                $type = ['income' => 'دخل', 'expense' => 'مصروف'];
                            @endphp
                            <b
                                style="{{ $ft->type == 'income' ? 'color:#080' : 'color:#800' }}">{{ $type[$ft->type] }}</b>
                        </td>
                        <td>{{ $ft->amount }}</td>
                        <td>
                            @if ($ft->party)
                                <b>{{ $ft->party->name }}</b>
                            @else
                                <b style="color: #800">لم يتم التحديد</b>
                            @endif
                        </td>
                        <td>
                            {{ $ft->financial_transaction_type->name }}
                        </td>
                        <td>
                            @php
                                $from = ['custody' => 'عهده موظف', 'safe' => 'خزنه'];
                            @endphp
                            <b>{{ $from[$ft->from] }}</b>
                        </td>
                        <td>
                            @if ($ft->from == 'custody')
                                {{ $ft->employee->name }}
                            @else
                                ----
                            @endif
                        </td>
                        <td>
                            @if ($ft->from == 'safe')
                                {{ $ft->safe->name }}
                            @else
                                ----
                            @endif
                        </td>
                        <td>
                            <div class="up">
                                <span class="fw-bold">{{ $ft->added_by }}</span>
                            </div>
                        </td>
                        <td> {{ $ft->updated_at->format('Y/m/d') }}</td>

                        <td>
                            <div class="edit d-flex align-items-center justify-content-center">
                                <img src="{{ asset('Assets/imgs/edit-circle.png') }}" data-id="{{ $ft->id }}"
                                    id="edit">

                                <img class="ms-2 me-2" src="{{ asset('Assets/imgs/trash (1).png') }}"
                                    data-id="{{ $ft->id }}" alt="" id="trash">

                            </div>
                        </td>
                        <td class="p-0">
                            <div
                                class="popup-edit  id-{{ $ft->id }} popup close shadow-sm rounded-3 position-fixed overflow-y-auto overflow-x-hidden">
                                <form id="edit-cate" method="post" action="{{ route('ft.update', $ft->id) }}">
                                    @csrf
                                    @method('put')
                                    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}"
                                        alt="">
                                    <h2 class="text-center mt-4 mb-4 opacity-75">تعديل المعامله الماليه </h2>
                                    <div class="d-flex">
                                        <label class="d-block mb-1"><b>النوع: </b></label>
                                        <div class="text-center w-100 d-flex justify-content-around">
                                            <div>
                                                <input style="height: 20px!important; width: 20px!important"
                                                    class="category-input" type="radio" value="income" name="type"
                                                    id="incomeEdit" {{ $ft->type == 'income' ? 'checked' : '' }}>
                                                <label for="incomeEdit">
                                                    <b style="color: #080">دخل</b>
                                                </label>
                                            </div>
                                            <div>
                                                <input style="height: 20px!important; width: 20px!important"
                                                    class="category-input" type="radio" value="expense" name="type"
                                                    id="expenseEdit" {{ $ft->type == 'expense' ? 'checked' : '' }}>
                                                <label for="expenseEdit">
                                                    <b style="color: #f00">مصروف</b>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="f-row d-flex mt-2" style="text-align: right">
                                        <div>
                                            <label class="d-block mb-1" for="descriptionEdit">الوصف</label>
                                            <input dir="rtl" class="category-input" style="direction: rtl"
                                                type="text" name="description" id="descriptionEdit"
                                                placeholder="الوصف" value="{{ $ft->description }}">
                                        </div>
                                    </div>
                                    <div class="f-row d-flex mt-2" style="text-align: right">
                                        <div>
                                            <label class="d-block mb-1" for="amountEdit">القيمه</label>
                                            <input dir="rtl" class="category-input" style="direction: rtl"
                                                type="number" name="amount" id="amountEdit" placeholder="القيمه"
                                                value="{{ $ft->amount }}">
                                        </div>
                                    </div>
                                    <div class="f-row d-flex mt-2" style="text-align: right">
                                        <div>
                                            <div class="">
                                                <label class="d-block">نوع المعامله الماليه</label>
                                                <select class="js-example-basic-single edit type"
                                                    name="financial_transaction_type_id">
                                                    <option value="" disabled hidden>نوع المعامله الماليه
                                                    </option>
                                                    @foreach ($ftTypes as $fttype)
                                                        <option value="{{ $fttype->id }}"
                                                            {{ $fttype->id == $ft->financial_transaction_type_id ? 'selected' : '' }}>
                                                            {{ $fttype->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="f-row d-flex mt-2" style="text-align: right">
                                        <div>
                                            <div class="">
                                                <label class="d-block">من / الى</label>
                                                <select class="js-example-basic-single edit from" name="from"
                                                    onchange="changeFrom(this, '{{ $ft->id }}')">
                                                    <option disabled hidden>من / الى</option>
                                                    <option value="safe" {{ $ft->from == 'safe' ? 'selected' : '' }}>
                                                        الخزنه</option>
                                                    <option value="custody"
                                                        {{ $ft->from == 'custody' ? 'selected' : '' }}>عهده موظف</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="f-row d-flex" style="text-align: right">
                                        <div>
                                            <div class="" id="custodyContainerEdit"
                                                style="{{ $ft->from == 'custody' ? '' : 'display: none' }}">
                                                <label class="d-block">اسم الموظف</label>
                                                <select class="js-example-basic-single edit employee" name="employee_id">
                                                    <option value="" disabled hidden>اختر الموظف
                                                    </option>
                                                    @foreach ($employees as $employee)
                                                        <option value="{{ $employee->id }}"
                                                            {{ $employee->id == $ft->employee_id ? 'selected' : '' }}>
                                                            {{ $employee->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="f-row d-flex" style="text-align: right">
                                        <div>
                                            <div class="" id="safeContainerEdit"
                                                style="{{ $ft->from == 'safe' ? '' : 'display: none' }}">
                                                <label class="d-block">اسم الخزنه</label>
                                                <select class="js-example-basic-single edit safe" name="safe_id">
                                                    <option value="" disabled hidden>اختر الخزنه
                                                    </option>
                                                    @foreach ($safes as $safe)
                                                        <option value="{{ $safe->id }}"
                                                            {{ $safe->id == $ft->safe_id ? 'selected' : '' }}>
                                                            {{ $safe->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="f-row d-flex mt-2" style="text-align: right">
                                        <div>
                                            <div class="">
                                                <label class="d-block">الحفله (اختياري)</label>
                                                <select class="js-example-basic-single edit party" name="party_id">
                                                    <option value="" selected disabled hidden>الحفله (اختياري)
                                                    </option>
                                                    @foreach ($parties as $party)
                                                        <option value="{{ $party->id }}"
                                                            {{ $party->id == $ft->party_id ? 'selected' : '' }}>
                                                            {{ $party->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="invalidEdit" class="invalid invalidEdit my-3"></div>
                                    <button class="main-btn my-3">تحديث</button>
                                </form>
                            </div>

                        </td>
                        <div class="popup-delete popup close shadow-sm rounded-3 position-fixed">
                            <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
                            <h3 class="fs-5 fw-bold mb-3">حذف المعامله الماليه</h3>
                            <p>هل تريد الحذف متاكد !!</p>
                            <div class="buttons mt-5 d-flex">
                                <button onclick="fnDelete('{{ $ft->id }}')" class="agree rounded-2">نعم
                                    أريد</button>
                                <button class="disagree me-3 text-light rounded-2 main-btn">لا أريد</button>
                            </div>
                        </div>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="table-control d-flex justify-content-between align-items-center">
            <div class="buttons-div">
                @if ($fts->currentPage() != 1)
                    <a href="{{ $fts->previousPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">السابق</a>
                @endif

                @for ($i = max(1, $fts->currentPage() - 2); $i <= min($fts->lastPage(), $fts->currentPage() + 2); $i++)
                    <a href="{{ $fts->url($i) }}"
                        class="number-pages text-light ms-1 me-1 main-btn {{ $i == $fts->currentPage() ? 'bg-primary' : '' }}">{{ $i }}</a>
                @endfor

                @if ($fts->currentPage() != $fts->lastPage())
                    <a href="{{ $fts->nextPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">التالي</a>
                @endif
            </div>

            <div class="info-table opacity-50">
                <p>عرض <span>{{ $fts->firstItem() }}</span> إلى <span>{{ $fts->lastItem() }}</span>
                    من
                    <span>{{ $fts->total() }}</span> مدخلات
                </p>
            </div>
        </div>



    </section>

    @include('pages.ft.add')


    <div class="overlay position-fixed none w-100 h-100"></div>

@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/customers.js') }}"></script>


    {{-- For Exel --}}
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    {{-- For PDF --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
    </script>
    {{-- For JQuery --}}
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single.filter.type').select2();
            $('.js-example-basic-single.filter.party').select2();
            $('.js-example-basic-single.filter.FTType').select2();
            $('.js-example-basic-single.filter.from').select2();
            $('.js-example-basic-single.filter.employee').select2();
            $('.js-example-basic-single.filter.safe').select2();

            $('.js-example-basic-single.add.type').select2();
            $('.js-example-basic-single.add.party').select2();
            $('.js-example-basic-single.add.from').select2();
            $('.js-example-basic-single.add.employee').select2();
            $('.js-example-basic-single.add.safe').select2();

            $('.js-example-basic-single.edit.type').select2();
            $('.js-example-basic-single.edit.party').select2();
            $('.js-example-basic-single.edit.from').select2();
            $('.js-example-basic-single.edit.employee').select2();
            $('.js-example-basic-single.edit.safe').select2();
        });
    </script>

    <script>
        function printTable() {
            // Clone the table
            var myTable = document.getElementById("table").cloneNode(true);
            myTable.setAttribute('border', '1');
            myTable.setAttribute('cellpadding', '5');

            // Remove last column from the cloned table
            var rows = myTable.getElementsByTagName("tr");
            for (var i = 0; i < rows.length; i++) {
                var cols = rows[i].getElementsByTagName("td");
                if (cols.length > 0) {
                    rows[i].removeChild(cols[cols.length - 1]);
                }
            }

            // Open a new window for printing
            var printWindow = window.open('');
            printWindow.document.write('<html dir="rtl"><head><title>Table Contents</title>');

            // Print the Table CSS.
            // var table_style = document.getElementById("table_style").innerHTML;
            printWindow.document.write('<style type="text/css">');
            // printWindow.document.write(table_style);
            printWindow.document.write('.print-hidden{display:none;}')
            printWindow.document.write('#table{width:100%;}')
            printWindow.document.write('</style>');
            printWindow.document.write('</head>');

            // Print the cloned table
            printWindow.document.write('<body>');
            printWindow.document.write('<div id="dvContents">');
            printWindow.document.write(myTable.outerHTML);
            printWindow.document.write('</div>');
            printWindow.document.write('</body>');

            printWindow.document.write('</html>');
            printWindow.document.close();
            printWindow.print();
        }

        const print = document.getElementById("print");
        print.addEventListener('click', () => {
            printTable();
        });
        //End Print Table

        // Start PDF File
        function Export() {
            // Hide the last column of the table
            var table = document.getElementById('table');

            var lastColumnCells = table.querySelectorAll('td:last-child, th:last-child');
            lastColumnCells.forEach(function(cell) {
                cell.style.display = 'none';
            });

            // Apply text alignment style to <th> and <td> elements inside the table
            var tableCells = table.querySelectorAll('th, td');
            tableCells.forEach(function(cell) {
                cell.style.textAlign = "right";
            });

            // Render the modified table to canvas
            html2canvas(table, {
                onrendered: function(canvas) {
                    // Restore the visibility of the last column
                    lastColumnCells.forEach(function(cell) {
                        cell.style.display = '';
                    });

                    // Remove text alignment style from <th> and <td> elements inside the table
                    tableCells.forEach(function(cell) {
                        cell.style.textAlign = "";
                    });

                    // Convert canvas to base64 data URL
                    var data = canvas.toDataURL();

                    // Create PDF
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Table.pdf");
                }
            });
        }


        const pdfBtn = document.getElementById("pdf");
        pdfBtn.addEventListener('click', () => {
            Export()
        });
        // End PDF File

        // Start Exel Sheet
        function htmlTableToExcel(type) {
            var data = document.getElementById('table');


            // Remove last column
            var rows = data.getElementsByTagName('tr');
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName('td');
                if (cells.length > 0) {
                    rows[i].deleteCell(cells.length - 1);
                }
            }

            var excelFile = XLSX.utils.table_to_book(data, {
                sheet: "sheet1"
            });
            XLSX.write(excelFile, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            });
            XLSX.writeFile(excelFile, 'ExportedFile:HTMLTableToExcel.' + type);
        }

        const exelBtn = document.getElementById("excel");
        exelBtn.addEventListener('click', () => {
            htmlTableToExcel('xlsx')
        });
        // End Exel Sheet
    </script>

    {{-- Validation For Edit --}}
    <script>
        document.querySelectorAll("table #edit").forEach((edit) => {
            let id = edit.dataset.id;

            edit.addEventListener("click", () => {
                let popUp = document.querySelector(".popup-edit.id-" + id),
                    editForm = popUp.querySelector("#edit-cate"),
                    editInputs = editForm.querySelectorAll(".category-input"),
                    editMessage = editForm.querySelector("#invalidEdit");

                editForm.addEventListener('submit', (event) => {
                    editMessage.textContent = '';
                    let notValid = false;
                    for (let i = 0; i < editInputs.length; i++) {
                        if (editInputs[i].value.trim() === "") {
                            event.preventDefault();
                            const inputName = editInputs[i].getAttribute('placeholder');
                            editMessage.textContent = `الحقل ${inputName} مطلوب`;
                            editInputs[i].focus();
                            notValid = true;
                            if (notValid) {
                                break;
                            }

                        }
                    }
                });
            });
        });
    </script>

    {{-- Delete --}}
    <script>
        document.querySelectorAll("#trash").forEach((trash) => {
            let id = trash.dataset.id;

            trash.addEventListener("click", (e) => {
                document.querySelector("body").classList.add("overflow-hidden");

                document.querySelector(".overlay").classList.remove("none");

                document.querySelector(".popup-delete").classList.remove("close");

                document
                    .querySelector(".popup-delete .agree")
                    .addEventListener("click", () => {


                        fnDelete(id)

                        document
                            .querySelector("body")

                            .classList.remove("overflow-hidden");

                        document.querySelector(".overlay").classList.add("none");

                        document.querySelector(".popup-delete").classList.add("close");



                    });

                document
                    .querySelector(".popup-delete .disagree")
                    .addEventListener("click", () => {
                        document
                            .querySelector("body")
                            .classList.remove("overflow-hidden");

                        document.querySelector(".overlay").classList.add("none");

                        document.querySelector(".popup-delete").classList.add("close");
                    });
            });
        });


        function fnDelete(id) {
            // Get the form element
            var form = document.createElement('form');
            form.setAttribute('method', 'POST');
            form.setAttribute('action', `{{ url('financial-transaction') }}/${id}`);
            form.style.display = 'none';

            // Add CSRF token field
            var csrfTokenField = document.createElement('input');
            csrfTokenField.setAttribute('type', 'hidden');
            csrfTokenField.setAttribute('name', '_token');
            csrfTokenField.setAttribute('value', '{{ csrf_token() }}');
            form.appendChild(csrfTokenField);

            // Add method spoofing for DELETE request
            var methodField = document.createElement('input');
            methodField.setAttribute('type', 'hidden');
            methodField.setAttribute('name', '_method');
            methodField.setAttribute('value', 'DELETE');
            form.appendChild(methodField);

            // Append the form to the document body
            document.body.appendChild(form);

            // Submit the form
            form.submit();
        }
    </script>

    <script>
        $('select.js-example-basic-single.add.from#from').change(e => {
            let from = e.target.value;
            if (from == 'safe') {
                $('#safeContainer').show(300);
                $('#custodyContainer').hide(0);
            } else if (from == 'custody') {
                $('#custodyContainer').show(300);
                $('#safeContainer').hide(0);
            }
        })

        function changeFrom(e, id) {
            let safe = $(`.popup-edit.id-${id}`).find('#safeContainerEdit');
            let custody = $(`.popup-edit.id-${id}`).find('#custodyContainerEdit');

            if (e.value == 'safe') {
                safe.show(300);
                custody.hide(0);
            } else if (e.value == 'custody') {
                custody.show(300);
                safe.hide(0);
            }
        }
    </script>

@endsection
