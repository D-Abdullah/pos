<div class="popup-add popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <h2 class="text-center mt-4 mb-4 opacity-75">اضافة قسم جديدة</h2>
    <form method="post" action="{{ route('department.add') }}">
        @csrf
        <div>
            <span class="d-block mb-1">اسم الفئة</span>
            {{-- <input type="text" name="name" id="category-name" placeholder="اسم القسم" > --}}
            <input type="text" name="name" id="category-name" placeholder="اسم القسم" pattern="[a-zA-Z]{2,}"
                title="Please enter a valid name with at least 2 Latin alphabet letters" required>

        </div>
        {{-- <div>
            <span class="d-block">وصف الفئة</span>
            <textarea name="description" id="textarea" cols="30" rows="10" placeholder="وصف القسم"></textarea>
        </div>
        <div class="form-check d-block form-switch d-flex align-items-center  ms-2 me-2">
            <input class="form-check-input ms-3" checked type="checkbox" role="switch" id="flexSwitchCheckDefault-90"
                   name="is_active" value="1">
            <label for="flexSwitchCheckDefault-90">تفعيل</label>
        </div> --}}
        <button class="main-btn mt-5" type="submit">اضافه القسم</button>
    </form>
</div>
