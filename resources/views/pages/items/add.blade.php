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
                    <input id="input_id" type="hidden" value="" name="department_id">
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
        <div id="invalid" class="invalid my-3"></div>
        <button class="main-btn mt-5">اضافه</button>
</div>

{{-- For Drobdown input --}}


<script>
    const wrapperAdd = document.querySelector(".dropdown"),
        selectBtnAdd = wrapperAdd.querySelector(".select-btn-add"),
        searchInpAdd = wrapperAdd.querySelector(".input"),
        optionsAdd = wrapperAdd.querySelector(".options"),
        addHiddenInput = wrapperAdd.querySelector("#input_id");

    // let parts = ["part 1", "part 3", "part 2"];
    let departs = "{{ $departments }}";
    let parts = JSON.parse(departs.replaceAll("&quot;", '"'))
    console.log(parts);

    function addCate(selectedPart) {
        optionsAdd.innerHTML = "";
        parts && parts.forEach(category => {
            let isSelectedAdd = category.name == selectedPart ? "selected" : "";
            let li = `<li onclick="update(this)" class="${isSelectedAdd}">${category.name}</li>`;
            optionsAdd.insertAdjacentHTML("beforeend", li);
            addHiddenInput.value = category.id
        });
    }
    addCate();

    function update(selectedli) {
        searchInpAdd.value = "";
        addCate(selectedli.innerText);
        wrapperAdd.classList.remove("active");
        selectBtnAdd.firstElementChild.innerText = selectedli.innerText;
    }

    if (searchInpAdd) {
        searchInpAdd.addEventListener("keyup", () => {

            let arr = [];
            let searchWord = searchInpAdd.value.toLowerCase();
            arr = parts.filter(onePart => {
                return onePart.name.toLowerCase().startsWith(searchWord);
            }).map(onePart => {
                let isSelectedAdd = onePart.name === selectBtnAdd.firstElementChild.innerText ?
                    "selected" :
                    "";
                return `<li onclick="update(this)" class="${isSelectedAdd}">${onePart.name}</li>`;
            }).join("");
            optionsAdd.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! not found</p>`;
        });
    }



    selectBtnAdd.addEventListener("click", () => wrapperAdd.classList.toggle("active"));
</script>

{{-- For Validation --}}


<script>
    const myForm = document.getElementById("add-cate");
    const inputs = document.querySelectorAll(".category-input");
    const message = document.getElementById("invalid");

    myForm.addEventListener('submit', (event) => {
        message.textContent = '';

        inputs.forEach(input => {
            if (input.value.trim() === "") {
                event.preventDefault();
                const inputName = input.getAttribute('placeholder');
                message.textContent = `الحقل ${inputName} مطلوب`;
                input.focus();
                return;
            }
        });
    });
</script>
