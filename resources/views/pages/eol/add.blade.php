<style>
    .invalid {
        color: red;
        font-size: 12px;
        text-align: center;
    }
</style>

<div class="popup-add popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute normal-dismiss" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <form id="add-cate" method="post" action="{{ route('eol.add') }}">
        @csrf
        <h2 class="text-center mt-4 mb-4 opacity-75">اضافة هالك</h2>
        <div class="f-row d-flex gap-4">

            <div>
                <label class="d-block"> اختر المنتج</label>
                <select class="js-example-basic-single add" name="product_id" aria-placeholder="اختر المنتج">
                    <option value="" {{ request('product_id') ? 'disabled hidden' : 'selected disabled hidden' }}>
                        اختر المنتج
                    </option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}"
                            {{ request('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="d-block mb-1" for="category">الكميه</label>
                <input class="category-input" type="number" name="quantity" id="category" placeholder="الكمية">
            </div>
        </div>
        <div>
            <span class="d-block mb-1">سبب الهالك</span>
            <textarea class="category-input" name="reason" id="textarea" cols="30" rows="10" placeholder="سبب الهالك"></textarea>
        </div>

        <div id="invalidAdd" class="invalid invalidAdd my-3"></div>

        <button class="main-btn mt-5">اضافه</button>
    </form>
</div>
