<style>
    .invalid {
        color: red;
        font-size: 12px;
        text-align: center;
    }
</style>

<div class="popup-add popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <h2 class="text-center mt-4 mb-4 opacity-75">اضافة منتج جديد</h2>
    <form id="add-cate" method="post" action="{{ route('product.add') }}">
        @csrf
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="category-name">اسم المنتج</label>
                <input class="category-input" type="text" name="name" id="category-name" placeholder="اسم المنتج">
            </div>
            {{-- drobdown search --}}
            <div class="dropdown">
                <label class="d-block mb-1" for="category-name"> القسم</label>
                <div class="select-btn-add">
                    <span>اختر القسم</span>
                    <input id="add_input_id" type="hidden" value="" name="department_id">
                    <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">
                </div>
                <div class="content">
                    <div class="search">
                        <i class="uil uil-search"></i>
                        <input class="input" spellcheck="false" type="text" placeholder="بحث في الاقسام">
                    </div>
                    <ul class="options"></ul>
                </div>
            </div>
        </div>

        {{-- <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="buy-price">الكمية</label>
                <input type="number" name="quantity" id="buy-price" placeholder="ادخل الكميه المتاحه">
            </div>
        </div> --}}

        <div>
            <label class="d-block" for="textarea">وصف المنتج</label>
            <textarea class="category-input" name="description" id="textarea" cols="30" rows="10"
                placeholder=" وصف المنتج"></textarea>
        </div>

        {{-- <div class="form-check form-switch d-flex align-items-center  ms-2 me-2">
            <input value="1" name="is_active" class="form-check-input ms-3" checked type="checkbox" role="switch"
                   id="flexSwitchCheckDefault-90">
            <label for="flexSwitchCheckDefault-90">تفعيل</label>
        </div> --}}
        <div id="invalidAdd" class="invalid invalidAdd my-3"></div>
        <button class="main-btn mt-5">اضافه</button>
</div>
