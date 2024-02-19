<div class="popup-add popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="{{asset ('Assets/imgs/Close.png')}}" alt="">
    <h2 class="text-center mt-4 mb-4 opacity-75">اضافة منتج جديد</h2>
    <form method="post" action="{{route('product.add')}}">
        @csrf
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="category-name">اسم المنتج</label>
                <input type="text" name="name" id="category-name" placeholder="اسم المنتج">
            </div>
            <div class="select-form">
                <label for="department">القسم</label>
                <select class="form-control form-select" id="department" name="department_id">
                    <option selected hidden disabled>اختر القسم</option>
                    @foreach($departments as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="buy-price">الكمية</label>
                <input type="number" name="quantity" id="buy-price" placeholder="ادخل الكميه المتاحه">
            </div>
        </div>
        <div>
            <label class="d-block" for="textarea">وصف المنتج</label>
            <textarea name="description" id="textarea" cols="30" rows="10" placeholder="ادخل وصف المنتج"></textarea>
        </div>
        <div class="form-check form-switch d-flex align-items-center  ms-2 me-2">
            <input value="1" name="is_active" class="form-check-input ms-3" checked type="checkbox" role="switch"
                   id="flexSwitchCheckDefault-90">
            <label for="flexSwitchCheckDefault-90">تفعيل</label>
        </div>
        <button class="main-btn">اضافه</button>
</div>
