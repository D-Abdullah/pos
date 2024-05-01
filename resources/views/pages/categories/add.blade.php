<style>
    .invalid {
        color: red;
        font-size: 12px;
        text-align: center;
    }
</style>

<div class="popup-add popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute normal-dismiss" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <h2 class="text-center mt-4 mb-4 opacity-75">اضافة قسم جديدة</h2>
    <form id="add-cate" method="post" action="{{ route('department.add') }}">
        @csrf
        <div>
            <span class="d-block mb-1">اسم الفئة</span>
            <input type="text" name="name" class="category-input" placeholder="اسم القسم">
        </div>
        <div>
            <span class="d-block">وصف الفئة</span>
            <textarea name="description" class="" cols="30" rows="10" placeholder="وصف القسم"></textarea>
        </div>
        <div id="invalidAdd" class="invalid invalidAdd my-3"></div>
        <button class="main-btn mt-5" type="submit">اضافه القسم</button>
    </form>
</div>
