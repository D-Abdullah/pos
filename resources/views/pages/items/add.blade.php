<style>
    #search {
        min-width: 250px !important;
    }

    #category-name:invalid {
        border: 1px solid red
    }

    #category-name:valid {
        border: 1px solid #0075ff
    }
</style>

<style>
    .select-btn,
    li {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .select-btn {
        padding: 10px 20px;
        gap: 10px;
        border-radius: 5px;
        justify-content: space-between;
        border: 1px solid #eee
    }

    .select-btn i {
        font-size: 14px;
        transition: transform 0.3s linear;
    }

    .dropdown.active .select-btn i {
        transform: rotate(-180deg);
    }

    .content {
        display: none;
        padding: 20px;
        margin-top: 15px;
        background: #fff;
        border-radius: 5px;
        border: 1px solid #eee;
        position: fixed;
    }

    .dropdown.active .content {
        display: block;
    }

    .content .search {
        position: relative;
    }

    .search input {
        height: 50px;
        width: 100%;
        outline: none;
        font-size: 17px;
        border-radius: 5px;
        padding: 0 20px 0 43px;
        border: 1px solid #B3B3B3;
    }

    .search input:focus {
        padding-left: 42px;
        border: 2px solid #4285f4;
    }

    .search input::placeholder {
        color: #bfbfbf;
    }

    .content .options {
        margin-top: 10px;
        max-height: 250px;
        overflow-y: auto;
        padding-right: 7px;
    }

    .options::-webkit-scrollbar {
        width: 7px;
    }

    .options::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 25px;
    }

    .options::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 25px;
    }

    .options::-webkit-scrollbar-thumb:hover {
        background: #b3b3b3;
    }

    .options li {
        padding: 5px 13px;
    }

    .options li:hover,
    li.selected {
        border-radius: 5px;
        background: #f2f2f2;
    }
</style>

<div class="popup-add popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <h2 class="text-center mt-4 mb-4 opacity-75">اضافة منتج جديد</h2>
    <form method="post" action="{{ route('product.add') }}">
        @csrf
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="category-name">اسم المنتج</label>
                <input type="text" name="name" id="category-name" placeholder="اسم المنتج"
                    pattern="[a-zA-Z\u0600-\u06FF]{2,}"
                    title="Please enter a valid name with at least 2 Latin alphabet letters" required>
            </div>
            {{-- drobdown search --}}
            <div class="dropdown">
                <label class="d-block mb-1" for="category-name"> القسم</label>
                <div class="select-btn-add">
                    <span>اختر القسم</span>

                    <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">
                </div>
                <div class="content">
                    <div class="search">
                        <i class="uil uil-search"></i>
                        <input spellcheck="false" name="categoryDropdownQuery" type="text" placeholder="بحث في الاقسام">
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
            <textarea name="description" id="textarea" cols="30" rows="10" placeholder="ادخل وصف المنتج"></textarea>
        </div>

        {{-- <div class="form-check form-switch d-flex align-items-center  ms-2 me-2">
            <input value="1" name="is_active" class="form-check-input ms-3" checked type="checkbox" role="switch"
                   id="flexSwitchCheckDefault-90">
            <label for="flexSwitchCheckDefault-90">تفعيل</label>
        </div> --}}
        <button class="main-btn mt-5">اضافه</button>
</div>

{{-- For Drobdown input --}}


<script>
    const wrapperAdd = document.querySelector(".dropdown"),
        selectBtnAdd = wrapperAdd.querySelector(".select-btn-add"),
        searchInpAdd = wrapperAdd.querySelector("input"),
        optionsAdd = wrapperAdd.querySelector(".options");

    let parts = ["part 1", "part 3", "part 2"];

    function addCate(selectedPart) {
        optionsAdd.innerHTML = "";
        parts.forEach(category => {
            let isSelectedAdd = category == selectedPart ? "selected" : "";
            let li = `<li onclick="update(this)" class="${isSelectedAdd}">${category}</li>`;
            optionsAdd.insertAdjacentHTML("beforeend", li);
        });
    }
    addCate();

    function update(selectedli) {
        searchInpAdd.value = "";
        addCate(selectedli.innerText);
        wrapperAdd.classList.remove("active");
        selectBtnAdd.firstElementChild.innerText = selectedli.innerText;
    }

    searchInpAdd.addEventListener("keyup", () => {
        let arr = [];
        let searchWord = searchInpAdd.value.toLowerCase();
        arr = parts.filter(onePart => {
            return onePart.toLowerCase().startsWith(searchWord);
        }).map(onePart => {
            let isSelectedAdd = onePart == selectBtnAdd.firstElementChild.innerText ? "selected" : "";
            return `<li onclick="update(this)" class="${isSelectedAdd}">${onePart}</li>`;
        }).join("");
        optionsAdd.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! not found</p>`;
    });

    selectBtnAdd.addEventListener("click", () => wrapperAdd.classList.toggle("active"));
</script>
