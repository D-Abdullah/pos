<div class="popup-add popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <form method="post" action="{{ route('eol.add') }}">
        @csrf
        <h2 class="text-center mt-4 mb-4 opacity-75">اضافة هالك</h2>
        <div class="f-row d-flex gap-4">
            {{-- <div>
            @foreach ($products as $product)
            <label class="d-block mb-1" for="product-name">اسم المنتج</label>
            <input type="text" name="product_id" @if ($eol->product_id == $product->id) inputed @endif
            id="product-name-{{$product->id}}" placeholder="اسم المنتج">
            @endforeach
        </div> --}}
            <div class="select-form">
                <label for="product">المنتج</label>
                <select class="form-control form-select" id="product" name="product_id">
                    <option selected hidden disabled>اختر المنتج</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="d-block mb-1" for="category">الكميه</label>
                <input type="number" name="quantity" id="category" placeholder="الكمية">
            </div>
        </div>
        <div>
            <span class="d-block mb-1">سبب الهالك</span>
            <textarea name="reason" id="textarea" cols="30" rows="10" placeholder="سبب الهالك"></textarea>
        </div>
        <button class="main-btn">اضافه</button>
    </form>
</div>
