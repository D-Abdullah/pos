<div class="popup-add popup pb-5 close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="./Assets/imgs/Close.png" alt="">
    <h2 class="text-center mt-4 mb-4 opacity-75">اضافة عنصر جديد</h2>
    <div class="f-row d-flex gap-4 align-items-end">
        <div>
            <label class="d-block mb-1" for="suppliers-name">اسم المورد</label>
            <input type="text" name="text" id="suppliers-name" placeholder="...">
        </div>
        <div>
            <input type="search" name="search" id="suppliers-search" placeholder="بحث">
        </div>
    </div>
    <div class="select-form">
        <span>الفئه</span>
        <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
            <button class="w-100 d-flex justify-content-between" onclick="dropdown('valueStatusAdd', 'listStatusAdd')">
                <span class="fw-bold opacity-50 valueDropdown" id="valueStatusAdd"></span>
                <img src="./Assets/imgs/chevron-down.png" alt="">
            </button>
            <div class="options none">
                <ul id="listStatusAdd">
                    <li class="p-0" id="search">
                        <input class="search" type="search" placeholder="بحث">
                    </li>
                    <li>فئة 1</li>
                    <li>فئه 2</li>
                    <li>فئه 3</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="form-check form-switch d-flex align-items-center  ms-2 me-2">
        <input class="form-check-input ms-3" checked type="checkbox" role="switch" id="flexSwitchCheckDefault-90">
        <label for="flexSwitchCheckDefault-90">تفعيل</label>
    </div>
    <button class="main-btn">اضافه</button>
</div>
