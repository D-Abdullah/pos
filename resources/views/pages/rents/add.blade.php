<div class="popup-add popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <form action="{{ route('rent.add') }}" method="post" id="add-cate" enctype="multipart/form-data">
        @csrf
        <h2 class= "text-center mt-4
        mb-4 opacity-75">اضافة ايجار جديد</h2>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="name">الاسم</label>
                <input type="text" name="name" id="name" placeholder="اسم" class="category-input">
            </div>
            <div>
                <label class="d-block mb-1" for="sale-rent">السعر</label>
                <input type="number" step="0.1" name="rent_price" id="sale-rent" placeholder="السعر"
                    class="category-input">
            </div>
        </div>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="gmail">الكميه</label>
                <input type="number" name="quantity" id="gmail" placeholder="الكمية" class="category-input">
            </div>
        </div>
        <div class="">
            <label for="supplierAdd" class="d-block">اختر المورد</label>
            <select class="js-example-basic-single add" name="supplier_id" id="supplierAdd">
                <option value="" disabled selected>اختر
                    المورد
                </option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="d-block" for="image">اضافه صوره للمنتج</label>
            <input name="image" id="image" type="file" accept="image/*" />
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
