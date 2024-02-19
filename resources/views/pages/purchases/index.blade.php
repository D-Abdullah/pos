@extends('layouts.app')

@section('title', 'المشتريات')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/purchases.css') }}">

    <style>
        /* Style for the remove button */
        .remove-btn {
            background-color: #ff6767;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Style for the deposits container */
        #deposits-container {
            margin-top: 10px;
        }

        /* Style for the deposit section */
        .deposit-section {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')

    <h2 class="mt-5 mb-5">المشتريات</h2>
    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto">

        <div class="features shadow-sm p-4 d-flex justify-content-between align-items-center">

            <div class="component-right gap-4 d-flex align-items-center">

                @can('create purchase')
                    <div class="add-button">
                        <button class="text-light main-btn"> اضافه عمليه شراء</button>
                    </div>
                @endcan
                @can('read purchase')
                    <div class="search-input">
                        <input type="search" placeholder="بحث" id="search">
                    </div>

                    <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                        <button onclick="dropdown('valueStatus', 'listStatus')">
                            <span class="fw-bold opacity-50 valueDropdown" id="valueStatus">فلتر</span>
                            <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">
                        </button>
                        <div class="options none">
                            <ul id="listStatus">
                                <li class="p-0" id="search">
                                    <input class="search" type="search" placeholder="بحث">
                                </li>
                                <li class="active">الوظيفه</li>
                                <li>وظيفه 2</li>
                                <li>وظيفه 3</li>
                            </ul>
                        </div>
                    </div>

                    <button class="main-btn" id="form">تأكيد</button>
                @endcan
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
        @can('read purchase')
            <table class="w-100 mb-4 border">
                <thead class="head">
                    <tr>
                        <th>المنتج</th>
                        <th>المورد</th>
                        <th>الكميه</th>
                        <th>الاجمالي</th>
                        <th>بواسطه</th>
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
                    @foreach ($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->product->name }}</td>
                            <td>{{ $purchase->supplier->name }}</td>
                            <td>{{ $purchase->quantity }}</td>
                            <td>{{ $purchase->total_price }}</td>
                            <td>{{ $purchase->added_by }}</td>
                            <td>
                                <div class="edit d-flex align-items-center justify-content-center">
                                    @can('update purchase')
                                        <img src="{{ asset('Assets/imgs/edit-circle.png') }}" alt="" id="edit"
                                            data-id="{{ $purchase->id }}">
                                    @endcan
                                    @can('delete purchase')
                                        <img class="ms-2 me-2" src="{{ asset('Assets/imgs/trash (1).png') }}" alt=""
                                            id="trash">
                                    @endcan
                                </div>
                            </td>
                            </td>
                            @can('update purchase')
                                <div
                                    class="popup-edit id-{{ $purchase->id }} popup close shadow-sm rounded-3 position-fixed overflow-y-auto">
                                    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
                                    <form action="{{ route('purchase.update', $purchase->id) }}" method="post" id="purchaseForm">
                                        @csrf
                                        @method('put')
                                        <h2 class="text-center mt-4 mb-4 opacity-75">تحديث دفعات عملية شراء</h2>

                                        <h2><b>المتبقي:
                                                @php
                                                    $deposits = $purchase->deposits;
                                                    $dtc = 0;
                                                    for ($i = 0; $i < count($deposits); $i++) {
                                                        $dtc += $deposits[$i]['cost'];
                                                    }
                                                @endphp
                                                <span style="color: #7367F0">{{ $dtc }}</span>
                                            </b>
                                        </h2>

                                        <!-- Deposits Container -->
                                        <div id="addDepositsContainer">
                                            @foreach ($purchase->deposits as $index => $deposit)
                                                <div class="f-row d-flex gap-4 align-items-end deposit-section">
                                                    <div>
                                                        <label class="d-block mb-1" for="deposit-amount">المبلغ</label>
                                                        <input type="text" name="deposits[{{ $index }}][cost]"
                                                            class="deposit-amount form-control" placeholder="المبلغ"
                                                            value="{{ old('deposits.' . $index . '.cost', $deposit->cost) }}">
                                                    </div>
                                                    <div>
                                                        <label class="d-block mb-1" for="deposit-date">التاريخ</label>
                                                        <input type="date" name="deposits[{{ $index }}][date]"
                                                            class="deposit-date form-control" placeholder="التاريخ"
                                                            value="{{ old('deposits.' . $index . '.date', $deposit->date) }}">
                                                    </div>
                                                    <button type="button" class="remove-btn"
                                                        {{ $index == 0 ? 'hidden' : '' }}><i
                                                            class="fa-solid fa-trash"></i></button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <!-- Add Deposit Button -->

                                        <button type="button" class="main-btn p-2 ps-3 pe-3 specialBtn m-0 mt-2 mb-2"
                                            id="addElement">
                                            <svg class="pointer" xmlns="http://www.w3.org/2000/svg" width="26"
                                                height="27" viewBox="0 0 26 27" fill="none">
                                                <path d="M13 5.52753V20.6942" stroke="#fff" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M13 5.52753V20.6942" stroke="white" stroke-opacity="0.2"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M5.41663 13.1108H20.5833" stroke="#fff" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M5.41663 13.1108H20.5833" stroke="white" stroke-opacity="0.2"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>

                                        <!-- Submit Button -->
                                        <button class="main-btn mt-3" type="submit" id="formSubmitBtn">تحديث دفعات عملية
                                            الشراء</button>

                                    </form>
                                </div>
                            @endcan

                            @can('delete purchase')
                                <div class="popup-delete popup close shadow-sm rounded-3 position-fixed">
                                    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
                                    <h3 class="fs-5 fw-bold mb-3">حذف العنصر</h3>
                                    <p>هل تريد الحذف متاكد !!</p>
                                    <div class="buttons mt-5 d-flex">
                                        <button class="agree rounded-2">نعم أريد</button>
                                        <button class="disagree me-3 text-light rounded-2 main-btn">لا أريد</button>
                                    </div>
                                </div>
                            @endcan

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="table-control d-flex justify-content-between align-items-center">
                <div class="buttons-div">
                    @if ($purchases->currentPage() != 1)
                        <a href="{{ $purchases->previousPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">
                            السابق
                        </a>
                    @endif

                    @for ($i = max(1, $purchases->currentPage() - 2); $i <= min($purchases->lastPage(), $purchases->currentPage() + 2); $i++)
                        <a href="{{ $purchases->url($i) }}"
                            class="number-pages text-light ms-1 me-1 main-btn {{ $i == $purchases->currentPage() ? 'bg-primary' : '' }}">{{ $i }}</a>
                    @endfor

                    @if ($purchases->currentPage() != $purchases->lastPage())
                        <a href="{{ $purchases->nextPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">التالي</a>
                    @endif
                </div>

                <div class="info-table opacity-50">
                    <p>عرض <span>{{ $purchases->firstItem() }}</span> إلى <span>{{ $purchases->lastItem() }}</span>
                        من
                        <span>{{ $purchases->total() }}</span> مدخلات
                    </p>
                </div>
            </div>
        @endcan

    </section>

    @include('pages.purchases.add')

    <div class="overlay position-fixed none w-100 h-100"></div>

@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/purchases.js') }}"></script>

    <script>
        function addElement() {
            let depositsContainer = document.getElementById('addDepositsContainer');
            let newDepositSection = depositsContainer.querySelector('.deposit-section').cloneNode(true);
            var I = depositsContainer.childElementCount;
            newDepositSection.querySelectorAll('input').forEach(function(input) {
                input.value = '';
                let name = input.name;
                let index = name.match(/\d+/g);
                if (index == null) {
                    return;
                } else {
                    finalName = name.replace(/(\d)+/, I);
                }
                input.setAttribute('name', finalName);
            });

            newDepositSection.querySelector('.remove-btn').removeAttribute('disabled');
            newDepositSection.querySelector('.remove-btn').removeAttribute('hidden');

            depositsContainer.appendChild(newDepositSection);

            initRemoveButtons(); // Initialize remove buttons after adding a new section
        }

        function removeElement(button) {
            let depositsContainer = document.getElementById('addDepositsContainer');

            if (depositsContainer.childElementCount > 1) {
                depositsContainer.removeChild(button.parentNode);
            } else {
                button.setAttribute('disabled', 'disabled');
                button.setAttribute('hidden', 'hidden');
            }
        }

        function initRemoveButtons() {
            document.querySelectorAll('.remove-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    removeElement(button);
                });
            });
        }

        document.getElementById('addElement').addEventListener('click', addElement);

        // Initialize remove buttons on page load
        initRemoveButtons();
    </script>
@endsection
