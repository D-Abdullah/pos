@extends('layouts.app')

@section('title', 'العملاء')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/customers.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .invalid {
            color: red;
            font-size: 12px;
            text-align: center;
        }
    </style>
    <style>
        #startDate {
            max-width: 220px !important;
        }

        .remove-btn {
            background-color: #ff6767;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .dolar-icon {

            width: 15px;
        }

        .check-btn {
            background-color: #15d057;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }


        .dollar-btn {
            background: #7367f0;
            color: white;
            border-radius: 4px;
            padding: 10px;
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
            width: 160px !important;
        }

        select {
            height: 45px;
            width: 165px;
        }
    </style>

@endsection

@section('content')

    <h2 class="mt-5 mb-5">العملاء</h2>

    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto">

        <div class="features shadow-sm p-4 d-flex justify-content-between align-items-end">

            <div class="component-right d-flex align-items-end">

                <div class="add-button">
                    <button class="text-light main-btn ms-4"> اضافه عميل</button>
                </div>

                <form action="{{ url()->current() }}" method="GET" class="mb-0 gap-4 d-flex align-items-end">
                    <div>
                        <label>بحث بالاسم</label>

                        <input type="search" name="name" value="{{ request('name') }}" placeholder="بحث بالاسم"
                            id="search">
                    </div>

                    <div>
                        <label>بحث برقم الهاتف</label>
                        <input type="search" name="phone" value="{{ request('phone') }}" placeholder="بحث رقم الهاتف"
                            id="searchPhone">
                    </div>

                    <div>
                        <label for="startDate">من تاريخ:</label>
                        <input type="date" id="startDate" name="date_from" value="{{ request('date_from') }}">
                    </div>

                    <!-- Filter by Date To -->
                    <div>
                        <label for="date_to">إلى تاريخ:</label>
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
                    <th>اسم العميل</th>
                    <th>رقم الهاتف</th>
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
                @if (count($clients) === 0)
                    <tr>
                        <td colspan="5" class="text-center">
                            لا توجد بيانات
                        </td>
                    </tr>
                @endif

                @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>
                            <div class="up">
                                {{--                                        <img src="{{asset('Assets/imgs/Avatar-4.png')}}" alt=""> --}}
                                <span class="fw-bold">{{ $client->added_by }}</span>
                            </div>
                        </td>
                        <td> {{ $client->updated_at->format('Y/m/d') }}</td>

                        <td>
                            <div class="edit d-flex align-items-center justify-content-center">
                                <img src="{{ asset('Assets/imgs/edit-circle.png') }}" data-id="{{ $client->id }}"
                                    id="edit">

                                <img class="ms-2 me-2" src="{{ asset('Assets/imgs/trash (1).png') }}"
                                    data-id="{{ $client->id }}" alt="" id="trash">

                                <img class="ms-2 me-2 dolar-icon" src="{{ asset('Assets/imgs/dolar.svg') }}"
                                    data-action="{{ $client->deposits->count() > 0 ? 'edit' : 'add' }}" data-pt="both"
                                    data-id="{{ $client->id }}" alt="" id="dolar">
                            </div>
                        </td>
                        <td class="p-0">
                            <div
                                class="popup-edit  id-{{ $client->id }} popup close shadow-sm rounded-3 position-fixed">
                                <form id="edit-cate" method="post" action="{{ route('client.update', $client->id) }}">
                                    @csrf
                                    @method('put')
                                    <img class="position-absolute normal-dismiss"
                                        src="{{ asset('Assets/imgs/Close.png') }}" alt="">
                                    <h2 class="text-center mt-4 mb-4 opacity-75">تعديل: {{ $client->name }} </h2>
                                    <div class="f-row d-flex gap-4">
                                        <div>
                                            <label class="d-block mb-1" for="customer-name">اسم العميل</label>
                                            <input class="category-input" type="text" name="name"
                                                id="customer-name" value="{{ $client->name }}"
                                                placeholder="اسم العميل
">
                                        </div>
                                        <div>
                                            <label class="d-block mb-1" for="phone">رقم الهاتف</label>
                                            <input class="category-input" type="number" minlength="11" name="phone"
                                                id="phone" value="{{ $client->phone }}" placeholder="رقم العميل
">
                                        </div>
                                    </div>
                                    {{-- <div class="form-check form-switch d-flex align-items-center  ms-2 me-2">
                                        <input class="form-check-input ms-3"
                                            @if ($client->is_active) checked @endif type="checkbox"
                                            role="switch" id="flexSwitchCheckDefault-99" name="is_active"
                                            value="1">
                                        <label for="flexSwitchCheckDefault-95">تفعيل</label>
                                    </div> --}}
                                    <div id="invalidEdit" class="invalid invalidEdit my-3"></div>
                                    <button class="main-btn my-3">تحديث</button>
                                </form>
                            </div>

                            <div class="popup-delete popup close shadow-sm rounded-3 position-fixed">
                                <img class="position-absolute normal-dismiss" src="{{ asset('Assets/imgs/Close.png') }}"
                                    alt="">
                                <h3 class="fs-5 fw-bold mb-3">حذف العميل</h3>
                                <p>هل تريد الحذف متاكد !!</p>
                                <div class="buttons mt-5 d-flex">
                                    <button onclick="fnDelete('{{ $client->id }}')" class="agree rounded-2">نعم
                                        أريد</button>
                                    <button class="disagree me-3 text-light rounded-2 main-btn">لا أريد</button>
                                </div>
                            </div>


                            <div
                                class="popup-dolar id-{{ $client->id }} popup close shadow-sm rounded-3 position-fixed overflow-auto">
                                <img class="position-absolute normal-dismiss" src="{{ asset('Assets/imgs/Close.png') }}"
                                    id="dismiss" alt="">
                                <h3 class="mt-3">كشف حساب العميل {{ $client->name }}</h3>
                                <div class="dolar-container p-5 d-flex flex-column">
                                    <div
                                        class="dolar-info d-flex flex-column justify-content-center  align-items-start gap-3">
                                        <p> <span class="fw-bold"> التكلفة الإجمالية المطلوبة :</span>
                                            <span>{{ number_format($client->total_required, 0, ',', ',') }} جنيه</span>
                                        </p>
                                        <p> <span class="fw-bold">التكلفة الإجمالية المدفوعة :</span>
                                            <span>{{ number_format($client->total_paid, 0, ',', ',') }} جنيه</span>
                                        </p>
                                        <p> <span class="fw-bold">إجمالي تكلفة المستحقات المتبقيه:</span>
                                            <span>{{ number_format($client->total_receivables, 0, ',', ',') }}
                                                جنيه</span>
                                        </p>

                                    </div>
                                    @if ($client->total_receivables > 0)
                                        <form id="dolar-form" action="{{ route('client.deposits', $client->id) }}"
                                            method="post">
                                            @csrf
                                            @method('PATCH')
                                            <div class="buttons mt-5 d-flex justify-content-center">
                                                <div class="elements w-100">

                                                    <div class="d-flex justify-content-start" id="addElementContainerBtn">
                                                        <button type="button"
                                                            class="addElement  id-{{ $client->id }} main-btn p-2 ps-3 pe-3 specialBtn m-0 mt-2 mb-2"
                                                            id="addElement">
                                                            <svg class="pointer" xmlns="http://www.w3.org/2000/svg"
                                                                width="26" height="27" viewBox="0 0 26 27"
                                                                fill="none">
                                                                <path d="M13 5.52753V20.6942" stroke="#fff"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path d="M13 5.52753V20.6942" stroke="white"
                                                                    stroke-opacity="0.2" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path d="M5.41663 13.1108H20.5833" stroke="#fff"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                                <path d="M5.41663 13.1108H20.5833" stroke="white"
                                                                    stroke-opacity="0.2" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <div id="addDepositsContainer"
                                                        class="addDepositsContainer id-{{ $client->id }}">
                                                        @foreach ($client->deposits as $i => $deposit)
                                                            <div
                                                                class="f-row d-flex gap-4 align-items-end deposit-section id-{{ $client->id }}">
                                                                <div>
                                                                    <label class="d-block mb-1"
                                                                        for="deposit-amount">المبلغ</label>
                                                                    <input type="hidden" class="deleteThis"
                                                                        name="deposits[{{ $i }}][cost]"
                                                                        value="{{ $deposit->cost }}">
                                                                    <input type="text" disabled
                                                                        name="deposits[{{ $i }}][cost]"
                                                                        class="deposit-amount category-input form-control"
                                                                        value="{{ $deposit->cost }}" placeholder="المبلغ"
                                                                        required>
                                                                    <input type="hidden" class="deleteThis"
                                                                        name="deposits[{{ $i }}][id]"
                                                                        class="input-id" value="{{ $deposit->id }}">
                                                                </div>
                                                                <div>
                                                                    <label class="d-block mb-1"
                                                                        for="deposit-date">التاريخ</label>
                                                                    <input type="hidden" class="deleteThis"
                                                                        name="deposits[{{ $i }}][date]"
                                                                        value="{{ $deposit->date }}">
                                                                    <input type="date" disabled
                                                                        name="deposits[{{ $i }}][date]"
                                                                        class="deposit-date category-input form-control"
                                                                        value="{{ $deposit->date }}"
                                                                        placeholder="التاريخ" required>
                                                                </div>
                                                                <div class="">
                                                                    <label class="d-block">الى</label>
                                                                    <select class="js-example-basic-single from" disabled
                                                                        name="deposits[0][from]">
                                                                        <option value="safe"
                                                                            {{ $deposit->from == 'safe' ? 'selected' : '' }}>
                                                                            الخزنه</option>
                                                                        <option value="custody"
                                                                            {{ $deposit->from == 'custody' ? 'selected' : '' }}>
                                                                            عهده موظف</option>
                                                                    </select>
                                                                </div>

                                                                <div class="custodyContainer"
                                                                    style="{{ $deposit->from == 'custody' ? '' : 'display: none' }}">
                                                                    <label class="d-block">اسم
                                                                        الموظف</label>
                                                                    <select class="js-example-basic-single employee"
                                                                        disabled name="deposits[0][employee_id]">

                                                                        @foreach ($employees as $employee)
                                                                            <option value="{{ $employee->id }}"
                                                                                {{ $deposit->employee_id == $employee->id ? 'selected' : '' }}>
                                                                                {{ $employee->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="safeContainer"
                                                                    style="{{ $deposit->from == 'safe' ? '' : 'display: none' }}">
                                                                    <label class="d-block">اسم
                                                                        الخزنه</label>
                                                                    <select class="js-example-basic-single safe" disabled
                                                                        name="deposits[0][safe_id]">

                                                                        @foreach ($safes as $safe)
                                                                            <option value="{{ $safe->id }}"
                                                                                {{ $deposit->safe_id == $safe->id ? 'selected' : '' }}>
                                                                                {{ $safe->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                {{-- ---------------------------------------------------------------------------- --}}
                                                                <button type="button" class="remove-btn p-3" hidden
                                                                    disabled><i class="fa-solid fa-trash"></i></button>

                                                                <button type="button" class="check-btn p-3 "
                                                                    {{ $deposit->is_paid ? 'hidden' : '' }}>
                                                                    <i class="fa-solid fa-check"></i>
                                                                </button>
                                                                <input class="is-paid" type="hidden"
                                                                    value="{{ $deposit->is_paid }}"
                                                                    name="deposits[{{ $i }}][is_paid]">
                                                            </div>
                                                        @endforeach
                                                        <div class="f-row d-flex gap-4 align-items-end deposit-section id-{{ $client->id }}"
                                                            id="initialDepositMultiSection">
                                                            <div>
                                                                <label class="d-block mb-1"
                                                                    for="deposit-amount">المبلغ</label>
                                                                <input type="text" name="deposits[0][cost]"
                                                                    class="deposit-amount category-input form-control"
                                                                    placeholder="المبلغ" required>
                                                            </div>
                                                            <div>
                                                                <label class="d-block mb-1"
                                                                    for="deposit-date">التاريخ</label>
                                                                <input type="date" name="deposits[0][date]"
                                                                    class="deposit-date category-input form-control"
                                                                    placeholder="التاريخ" required>
                                                            </div>
                                                            {{-- ---------------------------------------------------------------------------- --}}
                                                            <div class="">
                                                                <label class="d-block">
                                                                    الى</label>
                                                                <select class="js-example-basic-single from" required
                                                                    name="deposits[0][from]">
                                                                    <option selected disabled hidden> الى
                                                                    </option>
                                                                    <option value="safe">الخزنه</option>
                                                                    <option value="custody">عهده موظف</option>
                                                                </select>
                                                            </div>

                                                            <div class="custodyContainer" style="display: none">
                                                                <label class="d-block">اسم
                                                                    الموظف</label>
                                                                <select class="js-example-basic-single employee"
                                                                    name="deposits[0][employee_id]">
                                                                    <option value="" selected disabled hidden>اختر
                                                                        الموظف
                                                                    </option>
                                                                    @foreach ($employees as $employee)
                                                                        <option value="{{ $employee->id }}">
                                                                            {{ $employee->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="safeContainer" style="display: none">
                                                                <label class="d-block">اسم
                                                                    الخزنه</label>
                                                                <select class="js-example-basic-single safe"
                                                                    name="deposits[0][safe_id]">
                                                                    <option value="" selected disabled hidden>اختر
                                                                        الخزنه
                                                                    </option>
                                                                    @foreach ($safes as $safe)
                                                                        <option value="{{ $safe->id }}">
                                                                            {{ $safe->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            {{-- ---------------------------------------------------------------------------- --}}

                                                            <button type="button" class="remove-btn p-3" hidden
                                                                disabled><i class="fa-solid fa-trash"></i></button>

                                                            <button type="button" class="check-btn p-3 ">
                                                                <i class="fa-solid fa-check"></i>
                                                            </button>
                                                            <input class="is-paid" type="hidden" value="0"
                                                                name="deposits[0][is_paid]">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div id="invalidDolar" class="invalid invalidDolar my-3">
                                            </div>
                                            @if ($client->total_receivables > 0)
                                                <button class="dollar-btn w-100" type="submit"
                                                    id="modalSubmitBtnDollar">
                                                    تـأكيد
                                                </button>
                                            @endif
                                        </form>
                                    @else
                                        <h3 class="text-danger mt-3">لا يوجد مستحقات </h3>
                                    @endif
                                </div>

                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="table-control d-flex justify-content-between align-items-center">
            <div class="buttons-div">
                @if ($clients->currentPage() != 1)
                    <a href="{{ $clients->previousPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">السابق</a>
                @endif

                @for ($i = max(1, $clients->currentPage() - 2); $i <= min($clients->lastPage(), $clients->currentPage() + 2); $i++)
                    <a href="{{ $clients->url($i) }}"
                        class="number-pages text-light ms-1 me-1 main-btn {{ $i == $clients->currentPage() ? 'bg-primary' : '' }}">{{ $i }}</a>
                @endfor

                @if ($clients->currentPage() != $clients->lastPage())
                    <a href="{{ $clients->nextPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">التالي</a>
                @endif
            </div>

            <div class="info-table opacity-50">
                <p>عرض <span>{{ $clients->firstItem() }}</span> إلى <span>{{ $clients->lastItem() }}</span>
                    من
                    <span>{{ $clients->total() }}</span> مدخلات
                </p>
            </div>
        </div>



    </section>

    @include('pages.clients.add')


    <div class="overlay position-fixed none w-100 h-100"></div>
    <div class="overlay-alfa position-fixed none w-100 h-100"></div>

@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/customers.js') }}"></script>


    {{-- For Exel --}}
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    {{-- For PDF --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
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
            form.setAttribute('action', `{{ url('client') }}/${id}`);
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
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            //init modal open
            function openModal(modal) {
                modal.removeClass('close');
                $('body').addClass('overflow-hidden');
                $('.overlay-alfa').removeClass('none');
            }

            //init close modal
            function closeModal(modal) {
                modal.addClass('close');
                $('body').removeClass('overflow-hidden');
                $('.overlay-alfa').addClass('none');
            }

            //modals actions
            $('.dolar-icon').click(function() {
                let id = $(this).data('id');
                let action = $(this).data('action');
                let pt = $(this).data('pt');
                let modal = $(`.popup-dolar.id-${id}`);
                let addContainer = modal.find('#addElementContainerBtn');
                let addElement = modal.find('#addElement');
                let addDepositsContainer = modal.find('#addDepositsContainer');
                let removeElement = addDepositsContainer.find('.remove-btn');
                let checkElement = addDepositsContainer.find('.check-btn');
                let formBtn = modal.find('#modalSubmitBtnDollar');
                let fromSelect = modal.find('.js-example-basic-single.from');

                fromSelect.on('change', function() {
                    let from = fromSelect.val();
                    let custody = $(this).parent().parent().find('.custodyContainer');
                    let safe = $(this).parent().parent().find('.safeContainer');
                    if (from == 'safe') {
                        custody.hide(0);
                        safe.show(300);
                    } else if (from == 'custody') {
                        safe.hide(0);
                        custody.show(300);
                    }
                })
                if (pt == 'cash') {
                    addContainer.removeClass('d-flex');
                    addContainer.hide();
                    addDepositsContainer.find('.is-paid').val('1');
                    addDepositsContainer.find('.check-btn').hide();
                    addDepositsContainer.find('.remove-btn').hide();
                    formBtn.text('دفع تكلفه المورد')
                } else {
                    formBtn.text('اضافه الدفعات')
                    addElement.click(function() {
                        let newDepositSection = addDepositsContainer.find('.deposit-section')
                            .last().clone(true);
                        var I = addDepositsContainer.children().not('input').length;
                        newDepositSection.find('.check-btn').removeAttr('hidden');
                        newDepositSection.find('.remove-btn').removeAttr('hidden');
                        newDepositSection.find('.check-btn').removeAttr('disabled');
                        newDepositSection.find('.remove-btn').removeAttr('disabled');
                        newDepositSection.find('.check-btn').fadeIn(300);
                        newDepositSection.find('.custodyContainer').hide(0);
                        newDepositSection.find('.safeContainer').hide(0);
                        newDepositSection.find('input, select').each(function() {
                            if ($(this).is('select')) {
                                if ($(this).hasClass('employee') || $(this).hasClass(
                                        'safe')) {
                                    $(this).parent().hide(0);

                                    if ($(this).hasClass('employee')) {
                                        let opt = `
                                        <option value="" selected disabled hidden> اختر الموظف
                                        </option>`;
                                        $(this).prepend(opt);
                                    }
                                    if ($(this).hasClass('safe')) {
                                        let opt = `
                                        <option value="" selected disabled hidden> اختر الخزنه
                                        </option>`;
                                        $(this).prepend(opt);
                                    }

                                } else if ($(this).hasClass('from')) {
                                    let opt = `
                                        <option value="" selected disabled hidden> الى
                                        </option>`;
                                    $(this).prepend(opt);
                                }
                                $(this).val('').trigger("change");
                            }
                            let name = $(this).attr('name');
                            if (name != undefined) {
                                if ($(this).hasClass('deleteThis')) {
                                    $(this).remove();
                                }
                                console.log(name);
                                let index = name.match(/\[(\d+)\]/);
                                if (index != undefined) {
                                    let finalName = name.replace(/(\d)+/, I);
                                    $(this).attr('name', finalName);
                                    $(this).val('');
                                    $(this).removeAttr('disabled');
                                    if ($(this).hasClass('is-paid')) {
                                        $(this).val('0');
                                    }
                                    if ($(this).hasClass('input-id')) {
                                        $(this).remove();
                                    }
                                }
                            }
                        });
                        newDepositSection.find('.remove-btn').removeAttr('disabled');
                        newDepositSection.hide().appendTo(addDepositsContainer).slideDown(
                            300);
                        let fromSelectNew = newDepositSection.find(
                            '.js-example-basic-single.from');

                        fromSelectNew.on('change', function() {
                            let from = fromSelectNew.val();
                            let custody = newDepositSection.find(
                                '.custodyContainer');
                            let safe = newDepositSection
                                .find(
                                    '.safeContainer');
                            if (from == 'safe') {
                                custody.hide(0);
                                safe.show(300);
                            } else if (from == 'custody') {
                                safe.hide(0);
                                custody.show(300);
                            }
                        })

                    });
                    removeElement.click(function() {
                        if (addDepositsContainer.children().length > 1) {
                            $(this).parent().slideUp(300, function() {
                                $(this).remove();
                            });
                        }
                    });
                    checkElement.click(function() {
                        new Swal({
                                title: "هل انت متأكد؟",
                                text: "سوف تتم عملية الدفع بالفعل ولا يمكن التراجع عنها",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "تأكيد الدفع",
                                cancelButtonText: "الغاء",
                                dangerMode: true,
                            })
                            .then((willDelete) => {
                                if (willDelete.isConfirmed) {
                                    $(this).parent().find('.is-paid').val('1');
                                    $(this).fadeOut(300);
                                }
                            });
                    });
                }

                if (action == 'edit') {
                    formBtn.text('تـأكيد')
                    addDepositsContainer.find('#initialDepositMultiSection').remove();
                    // addElement.click();
                }
                // open this modal
                openModal(modal);

                // listen on dismiss modal
                $(".popup img#dismiss").click(function() {
                    if (!$(this).parent().hasClass("none")) {
                        closeModal(modal);
                    }
                });

                $(".overlay-alfa").on("click", function(e) {
                    if ($(e.target).hasClass("overlay-alfa")) {
                        closeModal(modal);
                    }
                });
            });
        });
    </script>



@endsection
