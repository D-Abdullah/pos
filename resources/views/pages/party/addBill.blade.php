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
                    <div class="box open-modal" data-type="items" data-id="{{ $product->id }}">
                        <div class="info-box p-3">
                            <span class="d-block fs-5"><b>اسم المنتج:</b> {{ $product->name }}</span>
                            <span class="d-block fs-5"><b>القسم:</b> {{ $product->department->name }}</span>
                            <span class="fs-5"><b>الكميه المتاحه:</b> {{ $product->quantity }}</span>
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
                    <div class="box open-modal" data-type="rent" data-id="{{ $rent->id }}">
                        <div class="info-box p-3">
                            <div class="d-block fs-5"><b>اسم المنتج:</b> {{ $rent->name }}</div>
                            <div class="fs-5"><b>السعر:</b> {{ $rent->sale_price }} جنيه</div>
                            <div class="fs-5"><b>الكميه:</b> {{ $rent->quantity }}</div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <div class="carts rounded-3 d-flex flex-column justify-content-between">
        <div class="elements">
            <div class="info d-flex gap-3 justify-content-between">
                <span>الاسم</span>
                <span>الكميه</span>
                <span>سعر الوحده</span>
                <span>اجمالي السعر</span>
                <span>النوع</span>
                <span>الحاله</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 25" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                        stroke="#4B465C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                        stroke="white" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <circle cx="12" cy="12.1108" r="3" stroke="#4B465C" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <circle cx="12" cy="12.1108" r="3" stroke="white" stroke-opacity="0.2" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="total active-btn mt-2" id="totalPrice">اجمالي السعر 900</div>
        </div>
    </div>


    <div class="popup-add popup close shadow-sm rounded-3 position-absolute overflow-auto" id="popupModal">
        <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" id="dismiss" alt="">
        <h2 class="text-center mt-4 mb-4 opacity-75" id="modalTitle"></h2>
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
            <textarea name="textarea" id="eolReason" cols="30" rows="10" placeholder="ضع سبب الهلاك"></textarea>
        </div>

        <div class="form-check-2 form-check-checkbox modalInputsContainers" id="statusContainer" style="display: none">
            <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault20" checked>
            <label class="form-check-label" for="flexCheckDefault20" id="status">جاهز</label>
        </div>

        <button class="main-btn" id="modalSubmitBtn"></button>
    </div>
    <!-- end of popup  ourProduct-->

    <div class="overlay-alfa position-absolute none w-100 h-100"></div>

    <div class="w-100 d-flex justify-content-end mt-5 mb-5">
        <form action="{{ route('party.addBillStore', $id) }}" method="post">
            @csrf
            <button class="submit main-btn p-3 ps-4 pe-4" type="submit">اضافه</button>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/add-concert.js') }}"></script>
    {{-- For JQuery --}}
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
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
                modal.find('#statusContainer input#name').val('');
                modal.find('#statusContainer input#name').prop('checked', true);

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
                modal.find('#unitPriceContainer').show();
            }

            //init rent inputs
            function rentInputs(modal, id) {
                modal.find('#rentId').val(id);
            }

            //init product and rents inputs
            function productAndRentInputs(modal) {
                modal.find('#quantityContainer').show();
                modal.find('#typeInputContainer').show();
                modal.find('#statusContainer').show();
            }

            //init custom inputs
            function customInputs(modal) {
                modal.find('#nameContainer').show();
                modal.find('#totalPriceContainer').show();
            }


            //modals actions
            $('.open-modal').click(function() {
                let type = $(this).data('type');
                let id = $(this).data('id');
                let action = $(this).data('action');
                let modal = $('#popupModal');
                let title = modal.find('#modalTitle');
                let formBtn = modal.find('#modalSubmitBtn');

                // status checkbox change inner text
                modal.find('.form-check-2 input').on("change", function() {
                    let $parent = $(this).parent();
                    let $lable = $parent.find('label#status');
                    $parent.toggleClass("notReady");

                    if ($parent.hasClass("notReady")) {
                        $lable.text("قيد التحضير");
                        $(this).val(0);
                    } else {
                        $lable.text("جاهز");
                        $(this).val(1);
                    }
                });

                //eol reason toggle
                modal.find('#typeInputContainer select#typeInput').on('change', function() {
                    if ($(this).val() == 'eol') {
                        modal.find('#eolReasonContainer').show();
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
