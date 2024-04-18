@extends('layouts.app')

@section('title', 'تعديل بيانات حفله')

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

        .invalid {
            color: red;
            font-size: 12px;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <!-- end of frame-5 (header) -->
    <h2 class="mb-2 mt-5">تعديل حفله جديده</h2>
    <!-- start of body -->

    <div class="w-100 d-flex justify-content-end mt-5 mb-5" id="addNewProduct">
        <form id="add-from" action="{{ route('party.update', $party->id) }}" method="post" class="w-100">
            @csrf
            @method('PUT')
            <div class="components">
                <div class="parent gap-3 mb-3 d-flex">

                    <div>
                        <label for="client" class="d-block">اختر العميل</label>
                        <select class="js-example-basic-single add" name="client_id" id="client">
                            <option value="" {{ old('client') ? 'disabled hidden' : 'selected disabled hidden' }}>
                                اختر العميل
                            </option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ $party->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="d-block mb-1" for="party-name">اسم الحفله</label>
                        <input type="text" name="name" value="{{ $party->name }}" id="party-name"
                            placeholder="اسم الحفله">
                    </div>
                    <div>
                        <label class="d-block mb-1" for="party-date">تاريخ الحفله</label>
                        <input type="date" name="date" value="{{ $party->date }}" class="deposit-date form-control"
                            placeholder="التاريخ">
                    </div>

                    {{-- <div class="select-form">
                        <label class="mb-1">الحاله</label>
                        <select name="status" id="" class="rounded-3 p-1">
                            <option selected hidden disabled>اختر الحاله</option>
                            @foreach ($status as $s)
                                <option value="{{ $s['value'] }}" {{ old('status') == $s['value'] ? 'selected' : '' }}>
                                    {{ $s['name'] }}</option>
                            @endforeach
                        </select>
                    </div> --}}


                    <div>
                        <label for="state" class="d-block">الحاله </label>
                        <select class="js-example-basic-single status" name="status" id="state">
                            <option selected hidden disabled>
                                الحاله
                            </option>
                            @foreach ($status as $s)
                                <option value="{{ $s['value'] }}" {{ $party->status == $s['value'] ? 'selected' : '' }}>
                                    {{ $s['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="parent d-flex mb-4">
                    <div>
                        <label class="d-block mb-1" for="party-address">عنوان الحفله</label>
                        <textarea class="w-100" name="address" id="" cols="30" rows="4" placeholder="عنوان الحفله">{{ $party->address }}</textarea>
                    </div>
                </div>
                {{-- <div class="elements">
                    <div id="addDepositsContainer">
                        <div class="f-row d-flex gap-4 align-items-end deposit-section">
                            <div>
                                <label class="d-block mb-1" for="deposit-amount">المبلغ</label>
                                <input type="text" name="deposits[0][cost]" class="deposit-amount form-control"
                                    placeholder="المبلغ" value="{{ old('deposits.0.cost') }}">
                            </div>
                            <div>
                                <label class="d-block mb-1" for="deposit-date">التاريخ</label>
                                <input type="date" name="deposits[0][date]" class="deposit-date form-control"
                                    placeholder="التاريخ" value="{{ old('deposits.0.date') }}">
                            </div>
                            <button type="button" class="remove-btn p-3" hidden disabled><i
                                    class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>

                    <button type="button" class="main-btn p-2 ps-3 pe-3 specialBtn m-0 mt-2 mb-2" id="addElement">
                        <svg class="pointer" xmlns="http://www.w3.org/2000/svg" width="26" height="27"
                            viewBox="0 0 26 27" fill="none">
                            <path d="M13 5.52753V20.6942" stroke="#fff" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M13 5.52753V20.6942" stroke="white" stroke-opacity="0.2" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5.41663 13.1108H20.5833" stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M5.41663 13.1108H20.5833" stroke="white" stroke-opacity="0.2" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div> --}}
            </div>
            <div id="invalidAdd" class="invalid invalidAdd my-3"></div>
            <button class="submit main-btn p-3 w-100 mt-4 fs-5" type="submit">تعديل</button>
        @endsection
    </form>
</div>


@section('script')
    <script src="{{ asset('Assets/JS files/add-concert.js') }}"></script>
    {{-- For JQuery --}}
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single.add').select2();
        });

        $(document).ready(function() {
            $('.js-example-basic-single.status').select2();
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
                addMessage.textContent = `الحقول التالية مطلوبة: ${emptyFields.join(', ')}`;
                // Optionally, you can focus on the first empty field
                addInputs[0].focus();
            }
        });
    </script>

@endsection
