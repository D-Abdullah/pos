@extends('layouts.app')

@section('title', 'اضافه حفله جديده')

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
            data-type="custom" data-id="">مخصص</button>
    </div>

    <div class="part show gap-4" id="product">
        <div class="products ps-2 pe-2">
            <div class="info p-2 mb-1 d-flex gap-4 align-items-center">
                <div class="w-50">
                    <input type="search" name="search" id="search-name" placeholder="بحث بإسم المنتج">
                </div>
                <div class="w-100">
                    <select class="js-example-basic-single product">
                        <option disabled selected value="">
                            بحث بالقسم
                        </option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="up p-2 d-flex overflow-auto">
                @foreach ($products as $product)
                    <div class="box open-modal" data-type="items" data-id="{{ $product->id }}"
                        data-saleprice="{{ $product->avg_price }}">
                        <img src="{{ asset($product->image) }}" alt="">
                        <div class="info-box p-3">
                            <span class="d-block fs-5"><b>اسم المنتج:</b> {{ $product->name }}</span>
                            <span class="d-block fs-5"><b>القسم:</b> {{ $product->department->name }}</span>
                            <span class="d-block fs-5"><b>الكميه المتاحه:</b> {{ $product->quantity }}</span>
                            <span class="d-block fs-5"><b>السعر:</b> {{ $product->avg_price }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="part gap-4" id="rent">
        <div class="products">
            <div class="info p-2 mb-1 d-flex gap-4 align-items-center">
                <div class="w-50">
                    <input type="search" name="search" id="search-name" placeholder="بحث بإسم المنتج">
                </div>
            </div>


            <div class="up p-2 d-flex overflow-auto">
                @foreach ($rents as $rent)
                    <div class="box open-modal" data-type="rent" data-id="{{ $rent->id }}"
                        data-saleprice="{{ $rent->sale_price }}">
                        <img src="{{ asset($rent->image) }}" alt="">
                        <div class="info-box p-3">
                            <div class="d-block fs-5"><b>اسم المنتج:</b> {{ $rent->name }}</div>
                            <div class="d-block fs-5"><b>السعر:</b> {{ $rent->sale_price }} جنيه</div>
                            <div class="d-block fs-5"><b>الكميه:</b> {{ $rent->quantity }}</div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <table id="table" class="table w-100 mb-4 border">

        <thead class="head">
            <tr>
                <th>من</th>
                <th>الاسم</th>
                <th>الكميه</th>
                <th>سعر الوحده</th>
                <th>السعر الاجمالي</th>
                <th>النوع</th>
                <th>الحاله</th>
                <th>المنتج</th>
                <th>المنتج (مستأجر)</th>
                <th>سبب الهلاك</th>

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
                        <circle cx="12" cy="12.1108" r="3" stroke="white" stroke-opacity="0.2" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </th>
            </tr>
        </thead>
        <tbody id="dataTableBody">
            <tr id="emptyDataTable">
                <td colspan="11" class="text-center">
                    لا توجد بيانات
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"></td>
                <td id="totalPriceCell">الاجمالي: 0</td>
                <td colspan="6">
                    <form action="{{ route('party.addBillStore', $id) }}" method="post" id="requestBillForm">
                        @csrf
                        <button id="payButton" class="submit main-btn p-3 ps-4 pe-4 w-100" type="submit">تأكيد معلومات
                            الفاتوره</button>
                    </form>
                </td>
            </tr>
        </tfoot>
    </table>


    <div class="popup-add popup close shadow-sm rounded-3 overflow-auto" id="popupModal">
        <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" id="dismiss" alt="">
        <h2 class="text-center mt-4 mb-4 opacity-75" id="modalTitle"></h2>
        <form action="#" id="modalFormElement">
            <input type="hidden" id="productId">
            <input type="hidden" id="rentId">
            <input type="hidden" id="from">
            <input type="hidden" id="partyId">


            <div class="modalInputsContainers" id="nameContainer" style="display: none">
                <label class="d-block mb-1" for="name">الاسم</label>
                <input type="text" id="name" placeholder="ضع اسم">
            </div>

            <div class="modalInputsContainers" id="totalPriceContainer" style="display: none">
                <label class="d-block mb-1" for="totalPrice">السعر الاجمالي</label>
                <input type="number" step="0.1" id="totalPrice" placeholder="ضع السعر الاجمالي">
            </div>

            <div class="modalInputsContainers" id="quantityContainer" style="display: none">
                <label class="d-block mb-1" for="quantity">الكميه</label>
                <input type="number" id="quantity" placeholder="ضع الكميه المطلوبه">
            </div>

            <div class="modalInputsContainers" id="unitPriceContainer" style="display: none">
                <label class="d-block mb-1" for="unitPrice">سعر الوحده</label>
                <input type="number" step="0.1" id="unitPrice" placeholder="ضع سعر الوحده">
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
                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault20" checked>
                <label class="form-check-label" for="flexCheckDefault20" id="status">جاهز</label>
            </div>

            <button class="main-btn" type="submit" id="modalSubmitBtn" style="margin: 20px auto"></button>
        </form>
    </div>
    <!-- end of popup  ourProduct-->

    <div class="overlay-alfa position-absolute none w-100 h-100"></div>
@endsection

@section('script')
    {{-- For JQuery --}}
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script defer>
        $(document).ready(function() {
            //init ddws
            $('.js-example-basic-single.product').select2({
                placeholder: 'ابحث بالقسم'
            });
            $('.js-example-basic-single.type').select2({
                placeholder: 'اختر النوع'
            });

            //tabs btns
            $(".tabs").on("click", function() {
                let $button = $(this);
                let goto = $(this).data("goto");

                $(".tabs").removeClass("active-btn");
                $button.addClass("active-btn");

                $(".part").hide().removeClass("show");

                $(`#${goto}`).css("display", "flex").addClass("show");
            });

            //init hide modal inputs
            function hideModalInputs(modal) {
                modal.find('.modalInputsContainers').hide();
            }

            //init modal reset
            function resetModalInputs(modal) {
                modal.find('input#productId').val('');
                modal.find('input#rentId').val('');
                modal.find('input#from').val('');
                modal.find('input#partyId').val('');

                modal.find('#nameContainer input#name').val('');
                modal.find('#totalPriceContainer input#totalPrice').val('');
                modal.find('#quantityContainer input#quantity').val('');
                modal.find('#unitPriceContainer input#unitPrice').val('');
                modal.find('#typeInputContainer select#typeInput').val('').trigger('change');
                modal.find('#typeInputContainer select#typeInput').val(modal.find(
                    '#typeInputContainer select#typeInput').prop('defaultSelected'));
                modal.find('#eolReasonContainer textarea#eolReason').val('');
                modal.find('#statusContainer').removeClass('notReady');
                modal.find('#statusContainer label#status').text('جاهز');
                modal.find('#statusContainer input#flexCheckDefault20').val('');
                modal.find('#statusContainer input#flexCheckDefault20').prop('checked', true);

                hideModalInputs(modal);
            }

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
                resetModalInputs(modal);
            }

            //init product inputs
            function productInputs(modal, id) {
                modal.find('#productId').val(id);
            }

            //init rent inputs
            function rentInputs(modal, id) {
                modal.find('#rentId').val(id);
            }

            //init product and rents inputs
            function productAndRentInputs(modal) {
                modal.find('#quantityContainer').show();
                modal.find('#quantityContainer').find('input#quantity').attr('required', true);
                modal.find('#typeInputContainer').show();
                modal.find('#typeInputContainer').find('select#typeInput').attr('required', true);
                modal.find('#statusContainer').show();
            }

            //init custom inputs
            function customInputs(modal) {
                modal.find('#nameContainer').show();
                modal.find('#nameContainer').find('input#name').attr('required', true);
                modal.find('#totalPriceContainer').show();
                modal.find('#totalPriceContainer').find('input#totalPrice').attr('required', true);
            }

            // calculate and update total price
            function updateTotalPrice(modal) {
                var totalPrice = 0;
                $('#dataTableBody tr:not(.type-eol)').each(function() {
                    var rowTotal = parseFloat($(this).find('td#totalPriceTableItem').text());
                    totalPrice += +rowTotal;
                });
                $('#totalPriceCell').text('الاجمالي: ' + totalPrice);
                closeModal(modal);
            }

            // get name of the product or the rent
            function getNameFromServer(id, type) {
                return $.ajax({
                    url: '/party/get-name/' + type + '/',
                    method: 'GET',
                    data: {
                        id: id
                    }
                });
            }

            // appent into table
            function addToTable(data, modal) {
                // Remove the empty data row if it exists
                $('#emptyDataTable').remove();

                // Create a new row with data
                var newRow = $('<tr>');
                if (data.type == 'eol') {
                    newRow.addClass("type-eol")
                }

                let from = data.from == 'items' ? "المنتجات" : (data.from == 'rent' ? "الايجارات" : "مخصص");
                let type = data.type == 'rent' ? "ايجار" : (data.type == 'sale') ? "بيع" : "هالك"
                let status = data.status ? "جاهز" : "غير جاهز"

                // Usage in your code
                let productPromise = null;
                let rentPromise = null;
                if (data.product_id !== "----") {
                    productPromise = getNameFromServer(data.product_id, 'product');
                }

                if (data.rent_id !== "----") {
                    rentPromise = getNameFromServer(data.rent_id, 'rent');
                }

                if (data.from == 'custom') {
                    // Append table data (td) elements with data values
                    newRow.append('<td>' + from + '</td>');
                    newRow.append('<td>' + data.name + '</td>');
                    newRow.append('<td>' + "----" + '</td>');
                    newRow.append('<td>' + "----" + '</td>');
                    newRow.append('<td id="totalPriceTableItem">' + data.total_price + '</td>');
                    newRow.append('<td>' + "----" + '</td>');
                    newRow.append('<td>' + status + '</td>');
                    newRow.append('<td>' + "----" + '</td>');
                    newRow.append('<td>' + "----" + '</td>');
                    newRow.append('<td>' + "----" + '</td>');
                    // Append hidden input fields for each item
                    $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                            '#dataTableBody tr')
                        .length +
                        '][from]" value="' + data.from + '">');
                    $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                            '#dataTableBody tr')
                        .length +
                        '][name]" value="' + data.name + '">');
                    $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                            '#dataTableBody tr')
                        .length +
                        '][quantity]" value="' + data.quantity + '">');
                    $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                            '#dataTableBody tr')
                        .length +
                        '][unit_price]" value="' + data.unit_price + '">');
                    $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                            '#dataTableBody tr')
                        .length +
                        '][total_price]" value="' + data.total_price + '">');
                    $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                            '#dataTableBody tr')
                        .length +
                        '][type]" value="' + data.type + '">');
                    $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                            '#dataTableBody tr')
                        .length +
                        '][status]" value="' + data.status + '">');
                    $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                            '#dataTableBody tr')
                        .length +
                        '][party_id]" value="' + data.party_id + '">');
                    $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                            '#dataTableBody tr')
                        .length +
                        '][product_id]" value="' + data.product_id + '">');
                    $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                            '#dataTableBody tr')
                        .length +
                        '][rent_id]" value="' + data.rent_id + '">');
                    $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                            '#dataTableBody tr')
                        .length +
                        '][eol_reason]" value="' + data.eol_reason + '">');
                    // Append the new row to the table body
                    $('#dataTableBody').append(newRow);

                    // Calculate and update total price
                    updateTotalPrice(modal);
                } else {
                    // Resolve promises and set names
                    $.when(productPromise, rentPromise).done(function(productResponse, rentResponse) {
                        let res, resPrice
                        if (productResponse) {
                            res = productResponse[0];
                            resPrice = res.avg_price
                        }
                        if (rentResponse) {
                            res = rentResponse[0];
                            resPrice = res.sale_price
                        }
                        // Append table data (td) elements with data values
                        newRow.append('<td>' + from + '</td>');
                        newRow.append('<td>' + data.name + '</td>');
                        newRow.append('<td>' + data.quantity + '</td>');
                        newRow.append('<td>' + resPrice + '</td>');
                        newRow.append('<td id="totalPriceTableItem">' + (resPrice * data.quantity) +
                            '</td>');
                        newRow.append('<td>' + type + '</td>');
                        newRow.append('<td>' + status + '</td>');
                        if (rentResponse) {
                            newRow.append('<td>' + "----" + '</td>');
                            newRow.append('<td>' + res.name + '</td>');
                        }
                        if (productResponse) {
                            newRow.append('<td>' + res.name + '</td>');
                            newRow.append('<td>' + "----" + '</td>');
                        }
                        newRow.append('<td>' + data.eol_reason + '</td>');


                        // Append hidden input fields for each item
                        $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                                '#dataTableBody tr')
                            .length +
                            '][from]" value="' + data.from + '">');
                        $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                                '#dataTableBody tr')
                            .length +
                            '][name]" value="' + data.name + '">');
                        $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                                '#dataTableBody tr')
                            .length +
                            '][quantity]" value="' + data.quantity + '">');
                        $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                                '#dataTableBody tr')
                            .length +
                            '][unit_price]" value="' + data.unit_price + '">');
                        $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                                '#dataTableBody tr')
                            .length +
                            '][total_price]" value="' + data.total_price + '">');
                        $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                                '#dataTableBody tr')
                            .length +
                            '][type]" value="' + data.type + '">');
                        $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                                '#dataTableBody tr')
                            .length +
                            '][status]" value="' + data.status + '">');
                        $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                                '#dataTableBody tr')
                            .length +
                            '][party_id]" value="' + data.party_id + '">');
                        $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                                '#dataTableBody tr')
                            .length +
                            '][product_id]" value="' + data.product_id + '">');
                        $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                                '#dataTableBody tr')
                            .length +
                            '][rent_id]" value="' + data.rent_id + '">');
                        $('#requestBillForm').append('<input type="hidden" name="bill[' + $(
                                '#dataTableBody tr')
                            .length +
                            '][eol_reason]" value="' + data.eol_reason + '">');
                        // Append the new row to the table body
                        $('#dataTableBody').append(newRow);

                        // Calculate and update total price
                        updateTotalPrice(modal);
                    });
                }
            }

            // validate modal
            function validateModal(salePrice, modal, type) {
                //data object for the request
                let data = {
                    from: modal.find('#from').val() ? modal.find('#from').val() : "----",
                    name: modal.find('#name').val() ? modal.find('#name').val() : "----",
                    quantity: modal.find('#quantity').val() ? +modal.find('#quantity').val() : "----",
                    unit_price: salePrice ? salePrice : "----",
                    type: modal.find('#typeInput').val() ? modal.find('#typeInput').val() : "----",
                    status: modal.find('#statusContainer input#flexCheckDefault20').prop('checked') ? "ready" :
                        "preparing",
                    party_id: modal.find('#partyId').val() ? +modal.find('#partyId').val() : "----",
                    product_id: modal.find('#productId').val() ? +modal.find('#productId').val() : "----",
                    rent_id: modal.find('#rentId').val() ? +modal.find('#rentId').val() : "----",
                    eol_reason: modal.find('#eolReason').val() ? modal.find('#eolReason').val() : "----",
                    total_price: 0,
                };

                if (data.from == 'items' || data.from == 'rent') {
                    let quantity = +modal.find('input#quantity').val();
                    if (!isNaN(quantity) && salePrice) {
                        data.total_price = quantity * salePrice;
                    }
                } else {
                    let totalPriceInput = modal.find('#totalPriceContainer input#totalPrice[required="required"]')
                        .val();
                    if (totalPriceInput) {
                        data.total_price = totalPriceInput;
                    }
                }
                console.log(data);
                addToTable(data, modal);
            }

            //modals actions
            $('.open-modal').click(function() {
                // debugger;
                let type = $(this).data('type');
                let id = $(this).data('id');
                let action = $(this).data('action');
                let salePrice = $(this).data('saleprice');
                let modal = $('#popupModal');
                let title = modal.find('#modalTitle');
                let modalForm = modal.find('#modalFormElement');
                let formBtn = modal.find('#modalSubmitBtn');

                //reset inputs required
                modal.find('.modalInputsContainers').each(function() {
                    $(this).find('input, select, textarea').attr('required', false);
                });

                // status checkbox change inner text
                modal.find('#statusContainer input#flexCheckDefault20').on("change", function() {
                    let $parent = $(this).parent();
                    let $lable = $parent.find('label#status');
                    if ($parent.hasClass("notReady")) {
                        $parent.removeClass("notReady");
                    } else {
                        $parent.addClass("notReady");
                    }
                    if ($parent.hasClass("notReady")) {
                        $lable.text("قيد التحضير");
                    } else {
                        $lable.text("جاهز");
                    }
                });

                //eol reason toggle
                modal.find('#typeInputContainer select#typeInput').on('change', function() {
                    if ($(this).val() == 'eol') {
                        modal.find('#eolReasonContainer').slideDown(300);
                    } else {
                        modal.find('#eolReasonContainer').slideUp(300);
                    }
                });

                // form button name
                if (!action) {
                    formBtn.text('اضافه الى الفاتوره')

                    //init default values
                    modal.find('#from').val(type);
                    modal.find('#partyId').val('{{ $id }}');

                    // modal inputs data debend on type
                    switch (type) {
                        case 'items':
                            title.text('اضافه عنصر من المخزن');
                            productInputs(modal, id);
                            break;
                        case 'rent':
                            title.text('اضافه عنصر من قايمه الإيجار');
                            rentInputs(modal, id);
                            break;
                        case 'custom':
                            title.text('اضافه عنصر مخصص');
                            customInputs(modal);
                            break;
                        default:
                            break;
                    }
                    if (type === 'items' || type === 'rent') {
                        productAndRentInputs(modal);
                    }
                } else if (action == 'edit') {
                    formBtn.text('تعديل الفاتوره')
                } else if (action == 'delete') {
                    formBtn.text('حذف الفاتوره')
                } else {
                    formBtn.text('حفظ التعديلات')
                }

                // open this modal
                openModal(modal);

                // stop modal form submit
                modalForm.submit(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                });
                // click event on submit btn for the modal form
                modalForm.find('button#modalSubmitBtn').click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    if (modalForm.find('[required="required"]').val() == "") {
                        return;
                    } else {
                        validateModal(salePrice, modal, type);
                    }
                });

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
