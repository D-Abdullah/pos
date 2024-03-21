<div class="popup-add popup pb-5 close shadow-sm rounded-3 position-fixed overflow-y-auto">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <form action="{{ route('purchase.add') }}" method="post" id="purchaseForm">
        @csrf
        <h2 class="text-center mt-4 mb-4 opacity-75">انشاء عملية شراء</h2>

        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="purchase-supplier">اسم المورد</label>
                <select name="supplier_id" id="purchase-supplier"
                    class="form-control {{ $errors->has('supplier_id') ? 'is-invalid' : '' }}">
                    <option>اختر المورد</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('supplier_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('supplier_id') }}
                    </div>
                @endif
            </div>

            <div>
                <label class="d-block mb-1" for="purchase-product">اسم المنتج</label>
                <select name="product_id" id="purchase-product"
                    class="form-control {{ $errors->has('product_id') ? 'is-invalid' : '' }}">
                    <option value="">اختر المنتج</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('product_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product_id') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="purchase-date">تاريخ الشراء</label>
                <input type="date" name="date" id="purchase-date"
                    class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" value="{{ old('date') }}"
                    placeholder="تاريخ الشراء">
                @if ($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
            </div>

            <div>
                <label class="d-block mb-1" for="purchase-quantity">الكمية</label>
                <input type="number" name="quantity" id="purchase-quantity"
                    class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}"
                    value="{{ old('quantity') }}" placeholder="الكمية">
                @if ($errors->has('quantity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="purchase-total-price">سعر الوحده</label>
                <input type="text" name="total_price" id="purchase-total-price"
                    class="form-control {{ $errors->has('total_price') ? 'is-invalid' : '' }}"
                    value="{{ old('total_price') }}" placeholder="السعر الإجمالي">
                @if ($errors->has('total_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_price') }}
                    </div>
                @endif
            </div>
        </div>
        {{-- <input type="hidden" name="deposits" id="depositsInput"> --}}
        {{-- <div id="addDepositsContainer">
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
                <button type="button" class="remove-btn" hidden disabled><i class="fa-solid fa-trash"></i></button>
            </div>
        </div>

        <button type="button" class="main-btn p-2 ps-3 pe-3 specialBtn m-0 mt-2 mb-2" id="addElement">
            <svg class="pointer" xmlns="http://www.w3.org/2000/svg" width="26" height="27" viewBox="0 0 26 27"
                fill="none">
                <path d="M13 5.52753V20.6942" stroke="#fff" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M13 5.52753V20.6942" stroke="white" stroke-opacity="0.2" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" />
                <path d="M5.41663 13.1108H20.5833" stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M5.41663 13.1108H20.5833" stroke="white" stroke-opacity="0.2" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button> --}}

        <button class="main-btn mt-3" type="submit" id="formSubmitBtn">انشاء عملية الشراء</button>

    </form>

</div>
