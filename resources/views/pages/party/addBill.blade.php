@extends('layouts.app')

@section('title', 'اضافه فاتوره حفله جديده')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/add-concert.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .dateInp,
        .search-input,
        .search-div {
            max-width: 180px;
            min-width: 180px;
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
            min-width: 160px !important;
            min-width: 100% !important;

        }

        #totalPrice {
            width: fit-content;
            background: transparent !important;
            color: black !important;
            margin-right: auto;
        }

        #table tbody {
            margin-top: 30px;
            margin-bottom: 30px;
        }
    </style>
    <style>
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dot-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 100px;
            height: 50px;
        }

        .dot {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: #3498db;
            animation: bounce 0.5s infinite alternate;
        }

        .dot:nth-child(2) {
            animation-delay: 0.1s;
        }

        .dot:nth-child(3) {
            animation-delay: 0.2s;
        }

        @keyframes bounce {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-20px);
            }
        }
    </style>
@endsection

@section('content')
    <!-- start of body -->
    <h2 class="mb-2 mt-5">اضافه الفاتوره للحفله "{{ $party->name }}"</h2>

    <div class="mt-5 mb-5 special">
        <button class="secound-btn active-btn total-product mb-2 tabs" style="padding: 15px; width: 170px;"
            data-goto="product">منتجاتنا</button>
        <button class="me-2 secound-btn element-found mb-2 tabs" style="padding: 15px; width: 170px;"
            data-goto="rent">ايجار</button>
        <button class="secound-btn element-not-found mb-2 open-modal" style="padding: 15px; width: 170px;"
            data-type="custom" data-id="" data-action="add">مخصص</button>
    </div>

    <table id="table" class="table w-100 mb-4 border">

        <thead class="head">
            <tr>
                <th class="text-center">الصوره</th>
                <th class="text-center">العنصر من</th>
                <th class="text-center">الاسم</th>
                <th class="text-center">الكميه</th>
                <th class="text-center">سعر الوحده</th>
                <th class="text-center">السعر الاجمالي</th>
                <th class="text-center">النوع</th>
                <th class="text-center">الحاله</th>
                <th class="text-center">سبب الهلاك</th>

                <th class="text-center">
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
                        <circle cx="12" cy="12.1108" r="3" stroke="white" stroke-opacity="0.2" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </th>
            </tr>
        </thead>
        <tbody id="dataTableBody">
            <tr id="emptyDataTable">
                <td colspan="10" class="text-center p-4">
                    لا توجد بيانات
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="font-weight: bold;font-size: 20px;text-align: center;">
                    الاجمالي: <b style="font-size: larger; color: #080" id="totalPriceCell">0</b> جنيه</td>
                <td colspan="6">
                    <form action="{{ route('party.addBillStore', $id) }}" method="post" id="requestBillForm">
                        @csrf
                        <button id="payButton" class="submit main-btn p-3 ps-4 pe-4 w-100" style="cursor: no-drop;" disabled
                            type="submit">تأكيد معلومات
                            الفاتوره</button>
                    </form>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="part show gap-4 mb-4" id="product">
        <div class="products ps-2 pe-2 mb-5">
            <div class="info p-2 mb-1 d-flex gap-4 align-items-center justify-content-center">
                <div class="w-50">
                    <input type="search" name="search" id="productFilterWithName" placeholder="بحث بإسم المنتج">
                </div>
                <div class="w-50">
                    <select class="js-example-basic-single product" id="productFilterWithDepartment">
                        <option disabled selected value="">
                            بحث بالقسم
                        </option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="up p-2 d-flex overflow-auto justify-content-center" id="productData">
                <div class="loading-spinner">
                    <div class="dot-container">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="part gap-4 mb-4" id="rent">
        <div class="products ps-2 pe-2 mb-5">
            <div class="info p-2 mb-1 d-flex gap-4 align-items-center justify-content-center">
                <div class="w-100">
                    <input type="search" name="search" id="rentFilterWithName" placeholder="بحث بإسم المنتج">
                </div>
            </div>


            <div class="up p-2 d-flex overflow-auto justify-content-center" id="rentData">
                <div class="loading-spinner">
                    <div class="dot-container">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="popup-add popup close shadow-sm rounded-3 overflow-auto" id="popupModal">
        <img class="position-absolute normal-dismiss" src="{{ asset('Assets/imgs/Close.png') }}" id="dismiss"
            alt="">
        <h2 class="text-center mt-4 mb-4 opacity-75" id="modalTitle"></h2>
        <div class="justify-content-around align-items-center" style="display:none" id="infoContainer">
            <div>
                <p class="mb-0" id="modalInfoName"><b>اسم: </b> <span></span></p>
                <p class="mb-0" id="modalInfoDepartment"><b>قسم: </b> <span></span></p>
                <p class="mb-0" id="modalInfoPrice"><b>سعر: </b> <span></span> جنيه</p>
                <p class="mb-0" id="modalInfoQuantity"><b>كميه: </b> <span></span></p>
            </div>
            <img id="modalInfoImage" src="" alt="" width="200" height="150"
                style="border-radius: 20px; object-fit: cover">
        </div>
        <div id="modalFormElement">
            <input type="hidden" id="productId">
            <input type="hidden" id="rentId">
            <input type="hidden" id="from">
            <input type="hidden" id="partyId" value="{{ $id }}">

            <div class="modalInputsContainers" id="nameContainer" style="display: none">
                <label class="d-block mb-1" for="name">الاسم</label>
                <input type="text" id="name" placeholder="ضع اسم">
            </div>

            <div class="modalInputsContainers" id="totalPriceContainer" style="display: none">
                <label class="d-block mb-1" for="totalPrice">التكلفه</label>
                <input type="number" step="0.1" id="totalPrice" placeholder="ضع التكلفه ">
            </div>

            <div class="modalInputsContainers" id="quantityContainer" style="display: none">
                <label class="d-block mb-1" for="quantity">الكميه</label>
                <input type="number" id="quantity" placeholder="ضع الكميه المطلوبه">
            </div>

            <div class="modalInputsContainers" id="unitPriceContainer" style="display: none">
                <label class="d-block mb-1" for="unitPrice">التكلفه</label>
                <input type="number" step="0.1" id="unitPrice" placeholder="ضع التكلفه">
            </div>

            <div class="modalInputsContainers" id="typeInputContainer" style="display: none">
                <label class="d-block mb-1" for="typeInput">النوع</label>
                <select class="js-example-basic-single type" id="typeInput">
                    <option value="" disabled selected>اختر النوع</option>
                    <option value="rent">ايجار</option>
                    <option value="sale">بيع</option>
                    <option value="eol">هالك</option>
                </select>
            </div>

            <div class="modalInputsContainers" id="eolReasonContainer" style="display: none">
                <label class="d-block" for="eolReason">سبب الهلاك</label>
                <textarea id="eolReason" cols="30" rows="10" placeholder="ضع سبب الهلاك"></textarea>
            </div>

            <div class="form-check-2 form-check-checkbox modalInputsContainers" id="statusContainer"
                style="display: none">
                <input class="form-check-input" type="checkbox" value="1" id="statusInput" checked>
                <label class="form-check-label" for="statusInput">جاهز</label>
            </div>
            <div class="w-100 text-center" style="display: none" id="validationContainer">
                <small class="text-danger alert alert-danger fw-bold text-center"
                    style="margin: 20px auto 0 auto;
            display: inline-block;
            width: 90%;"></small>

            </div>

            <button class="main-btn" type="button" id="modalSubmitBtn" style="margin: 20px auto"></button>
        </div>
    </div>
    <!-- end of popup  ourProduct-->

    <div class="overlay-alfa position-absolute none w-100 h-100"></div>
@endsection

@section('script')
    {{-- For JQuery --}}
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" defer src="{{ asset('Assets/JS files/addBill.js') }}"></script>
@endsection
