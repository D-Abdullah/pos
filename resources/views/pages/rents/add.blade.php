<div class="popup-add popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <form action="{{ route('rent.add') }}" method="post" id="add-cate">
        @csrf
        <h2 class= "text-center mt-4
        mb-4 opacity-75">اضافة ايجار جديد</h2>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="name">الاسم</label>
                <input type="text" name="name" id="name" placeholder="اسم" class="category-input">
            </div>
            <div>
                <label class="d-block mb-1" for="sale-rent">سعر الايجار الوحده الواحده</label>
                <input type="number" step="0.1" name="rent_price" id="sale-rent" placeholder="سعر الايجار"
                    class="category-input">
            </div>
        </div>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="user-name">سعر البيع الوحده الواحده</label>
                <input type="number" step="0.1" name="sale_price" id="user-name" placeholder="سعر البيع"
                    class="category-input">
            </div>
            <div>
                <label class="d-block mb-1" for="gmail">الكميه</label>
                <input type="number" name="quantity" id="gmail" placeholder="الكمية" class="category-input">
            </div>
        </div>
        {{-- <div class="form-check form-switch d-flex align-items-center  ms-2 me-2">
            <input name="is_active" value="1" class="form-check-input ms-3" checked type="checkbox" role="switch"
                id="flexSwitchCheckDefault-90">
            <label for="flexSwitchCheckDefault-90">تفعيل</label>
        </div> --}}
        <div id="invalidAdd" class="invalid invalidAdd my-3"></div>

        <button class="main-btn mt-3">اضافه</button>
    </form>
</div>
