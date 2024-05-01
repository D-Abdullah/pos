<style>
    .invalid {
        color: red;
        font-size: 12px;
        text-align: center;
    }
</style>

<div class="popup-add popup pb-5 close shadow-sm rounded-3 position-fixed ">
    <img class="position-absolute normal-dismiss" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <form id="add-purchase" action="{{ route('purchase.add') }}" method="post" id="purchaseForm">
        @csrf
        <h2 class="text-center mt-4 mb-4 opacity-75">انشاء عملية شراء</h2>

        <div class="f-row d-flex gap-4">
            <div class="dds add">
                <label class="d-block" for="date_to">اختر المورد</label>
                <select class="js-example-basic-single supplier add" name="supplier_id" aria-placeholder="اختر المورد">
                    <option value="" {{ old('supplier_id') ? 'disabled hidden' : 'selected disabled hidden' }}>
                        اختر المورد
                    </option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="dds add">
                <label class="d-block" for="date_to">اختر المنتج</label>
                <select class="js-example-basic-single product add" name="product_id" aria-placeholder="اختر المنتج">
                    <option value="" {{ old('product_id') ? 'disabled hidden' : 'selected disabled hidden' }}>
                        اختر المنتج
                    </option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="dds add party">
            <label class="d-block">اختر الحفله (اختياري)</label>
            <select class="js-example-basic-single party add" name="party_id" aria-placeholder="اختر الحفله">
                <option value="" {{ old('party_id') ? 'disabled hidden' : 'selected disabled hidden' }}>
                    اختر الحفله
                </option>
                @foreach ($parties as $party)
                    <option value="{{ $party->id }}" {{ old('party_id') == $party->id ? 'selected' : '' }}>
                        {{ $party->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="purchase-date">تاريخ الشراء</label>
                <input type="date" name="date" id="purchase-date"
                    class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }} category-input"
                    value="{{ old('date') }} category-input" placeholder="تاريخ الشراء">
                @if ($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
            </div>

            <div>
                <label class="d-block mb-1" for="purchase-quantity">الكمية</label>
                <input type="number" name="quantity" id="purchase-quantity"
                    class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }} category-input"
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
                <input type="text" name="unit_price" id="purchase-total-price"
                    class="form-control {{ $errors->has('total_price') ? 'is-invalid' : '' }} category-input"
                    value="{{ old('total_price') }}" placeholder="السعر الوحده">
                @if ($errors->has('total_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_price') }}
                    </div>
                @endif
            </div>
        </div>

        <div id="invalidAdd" class="invalid invalidAdd my-3"></div>
        <button class="main-btn mt-3" type="submit" id="formSubmitBtn">انشاء عملية الشراء</button>

    </form>

</div>
