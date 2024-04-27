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
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 0;
            outline: none;
            border: 1px solid #ddd;
            height: 30px !important;

        }

        .select2-container--default .select2-selection--single {
            height: 49px !important;
            border: 1px solid #ddd;
        }

        .select2-container[dir="rtl"] .select2-selection--single .select2-selection__rendered {
            padding-top: 7px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 0px !important;
            top: 50% !important;
        }

        label {
            margin-bottom: 0.25rem;
        }
    </style>
    <style>
        /* Style for the remove button */
        .check-btn {
            background-color: #15d057;
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

        .invalid {
            color: red;
            font-size: 12px;
            text-align: center;
        }

        .js-example-basic-single.from~.select2-container {
            width: 190px !important
        }

        .js-example-basic-single.employee~.select2-container {
            width: 190px !important
        }

        .js-example-basic-single.safe~.select2-container {
            width: 190px !important
        }
    </style>
@endsection

@section('content')
    <!-- end of frame-5 (header) -->
    <h2 class="mb-2 mt-5">اضافه حفله جديده</h2>
    <!-- start of body -->

    <div class="w-100 d-flex justify-content-end mt-5 mb-5" id="addNewProduct">
        <form id="add-from" action="{{ route('party.addStore') }}" method="post" class="w-100">
            @csrf
            <div class="components">
                <div class="parent gap-3 mb-3 d-flex">

                    <div>
                        <label for="client" class="d-block">اختر العميل</label>
                        <select class="js-example-basic-single add" name="client_id" id="client">
                            <option value="" selected disabled hidden>
                                اختر العميل
                            </option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="d-block mb-1" for="party-name">اسم الحفله</label>
                        <input type="text" name="name" value="{{ old('name') }}" id="party-name"
                            placeholder="اسم الحفله">
                    </div>
                    <div>
                        <label class="d-block mb-1" for="party-date">تاريخ الحفله</label>
                        <input type="date" name="date" value="{{ old('date') }}" class="deposit-date form-control"
                            placeholder="التاريخ">
                    </div>
                    <input type="hidden" name="status" value="contracted">

                </div>
                <div class="parent d-flex mb-4">
                    <div>
                        <label class="d-block mb-1" for="party-address">عنوان الحفله</label>
                        <textarea class="w-100" name="address" id="" cols="30" rows="4" placeholder="عنوان الحفله">{{ old('address') }}</textarea>
                    </div>
                </div>
                <div class="elements">
                    <h3>الدفعه الأولى</h3>
                    {{-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ --}}
                    <div id="addDepositsContainer" class="addDepositsContainer">
                        <div class="f-row d-flex gap-4 align-items-end deposit-section" id="initialDepositMultiSection">
                            <div>
                                <label class="d-block mb-1" for="deposit-amount">المبلغ</label>
                                <input type="text" name="d_cost" class="deposit-amount category-input form-control"
                                    placeholder="المبلغ" value="{{ old('d_cost') }}">
                            </div>
                            <div>
                                <label class="d-block mb-1" for="deposit-date">التاريخ</label>
                                <input type="date" name="d_date" class="deposit-date category-input form-control"
                                    placeholder="التاريخ" value="{{ old('d_date') }}">
                            </div>
                            {{-- ---------------------------------------------------------------------------- --}}
                            <div class="">
                                <label class="d-block">
                                    من</label>
                                <select class="js-example-basic-single from" name="d_from" aria-placeholder="من">
                                    <option selected disabled hidden> من
                                    </option>
                                    <option value="safe" {{ old('d_from') == 'safe' ? 'selected' : '' }}>الخزنه</option>
                                    <option value="custody" {{ old('d_from') == 'custody' ? 'selected' : '' }}>عهده موظف
                                    </option>
                                </select>
                            </div>

                            <div class="custodyContainer" style="display: none">
                                <label class="d-block">اسم
                                    الموظف</label>
                                <select class="js-example-basic-single employee" name="d_employee_id">
                                    <option value="" selected disabled hidden>اختر
                                        الموظف
                                    </option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('d_employee_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="safeContainer" style="display: none">
                                <label class="d-block">اسم
                                    الخزنه</label>
                                <select class="js-example-basic-single safe" name="d_safe_id">
                                    <option value="" selected disabled hidden>اختر
                                        الخزنه
                                    </option>
                                    @foreach ($safes as $safe)
                                        <option value="{{ $safe->id }}"
                                            {{ old('d_safe_id') == $safe->id ? 'selected' : '' }}>
                                            {{ $safe->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- ---------------------------------------------------------------------------- --}}

                            <button type="button" class="check-btn p-3 ">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <input class="is-paid" type="hidden" value="0" name="d_is_paid">
                        </div>
                    </div>
                    {{-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ --}}
                </div>
            </div>
            <div id="invalidAdd" class="invalid invalidAdd my-3"></div>
            <button class="submit main-btn p-3 w-100 mt-4 fs-5" type="submit">اضافه</button>
        @endsection
    </form>
</div>


@section('script')
    <script src="{{ asset('Assets/JS files/add-concert.js') }}"></script>
    {{-- For JQuery --}}
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function() {
            $('.js-example-basic-single.add').select2();
            $('.js-example-basic-single.status').select2();
            $('.js-example-basic-single.from').select2();
            $('.js-example-basic-single.employee').select2();
            $('.js-example-basic-single.safe').select2();
            let checkElement = $('.check-btn');
            let fromSelect = $('.js-example-basic-single.from');
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
        });
    </script>



    {{-- Validation For Add --}}
    <script>
        const addForm = document.getElementById("add-from");
        const addInputs = addForm.querySelectorAll("input, select,textarea");
        const addMessage = document.getElementById("invalidAdd");

        addForm.addEventListener('submit', (event) => {
            addMessage.textContent = '';
            let emptyFields = [];

            for (let i = 0; i < addInputs.length; i++) {
                const input = addInputs[i];
                const inputType = input.getAttribute('type');
                const inputValue = input.value.trim();
                const inputName = input.getAttribute('placeholder') || input.getAttribute('aria-placeholder');
                if (!inputName) {
                    continue;
                }
                if (inputType === 'date' || inputType === 'number' || inputType === 'select-one') {
                    if (inputValue === "") {
                        emptyFields.push(inputName);
                    }
                } else {
                    if (inputValue === "") {
                        emptyFields.push(inputName);
                    }
                }
            }

            if (emptyFields.length > 0) {
                event.preventDefault();
                addMessage.textContent = `الحقل: ${emptyFields[0]} مطلوب`;
                // Optionally, you can focus on the first empty field
                addInputs[0].focus();
            }
        });
    </script>

@endsection
