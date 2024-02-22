@extends('layouts.app')

@section('title', 'اضافه حفله جديده')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/add-concert.css') }}">
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
    <!-- end of frame-5 (header) -->
    <h2 class="mb-2 mt-5">اضافه حفله جديده</h2>
    <!-- start of body -->

    <div class="w-100 d-flex justify-content-end mt-5 mb-5" id="addNewProduct">
        <form action="{{ route('party.addStore') }}" method="post" class="w-100">
            @csrf
            <div class="components">
                <div class="parent gap-3 mb-3 d-flex">
                    <div class="select-form">
                        <label class="mb-1">العميل</label>
                        <select name="client_id" id="" class="rounded-3 p-1">
                            <option selected hidden disabled>اختر العميل</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="d-block mb-1" for="party-name">اسم الحفله</label>
                        <input type="text" name="name" value="{{ old('name') }}" id="party-name" placeholder="">
                    </div>
                    <div>
                        <label class="d-block mb-1" for="party-date">تاريخ الحفله</label>
                        <input type="date" name="date" value="{{ old('date') }}" class="deposit-date form-control"
                            placeholder="التاريخ">
                    </div>
                    <div class="select-form">
                        <label class="mb-1">الحاله</label>
                        <select name="status" id="" class="rounded-3 p-1">
                            <option selected hidden disabled>اختر الحاله</option>
                            @foreach ($status as $s)
                                <option value="{{ $s['value'] }}" {{ old('status') == $s['value'] ? 'selected' : '' }}>
                                    {{ $s['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="parent d-flex mb-4">
                    <div>
                        <label class="d-block mb-1" for="party-address">عنوان الحفله</label>
                        <textarea class="w-100" name="address" id="" cols="30" rows="4">{{ old('address') }}</textarea>
                    </div>
                </div>
                <div class="elements">
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
                </div>
            </div>
            <button class="submit main-btn p-3 w-100 mt-4 fs-5" type="submit">اضافه</button>
        @endsection
    </form>
</div>


@section('script')
    <script src="{{ asset('Assets/JS files/add-concert.js') }}"></script>

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
