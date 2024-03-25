@extends('layouts.app')

@section('title', 'المنتجات')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/products.css') }}">
@endsection
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
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #eee
    }

    .select-btn i {
        font-size: 14px;
        transition: transform 0.3s linear;
    }

    .wrapperFilter {
        cursor: pointer;
    }

    .wrapperFilter.active .select-btn i {
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

    .wrapperFilter.active .content {
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
    .select-btn-edit,
    li {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .select-btn-edit {
        padding: 10px 20px;
        gap: 10px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #eee
    }

    .select-btn-edit i {
        font-size: 14px;
        transition: transform 0.3s linear;
    }

    .wrapperEdit {
        cursor: pointer;
    }

    .wrapperEdit.active .select-btn-edit i {
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

    .wrapperEdit.active .content {
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
    .select-btn-add,
    li {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .select-btn-add {
        padding: 10px 20px;
        gap: 10px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #eee
    }

    .select-btn-add i {
        font-size: 14px;
        transition: transform 0.3s linear;
    }

    .dropdown {
        cursor: pointer;
    }

    .dropdown.active .select-btn-add i {
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
    .dateInp,
    .search-input {
        max-width: 180px;
    }
</style>

@section('content')
    <!-- end of frame-5 (header) -->
    <h2 class="mt-5 mb-5">المنتجات</h2>
    <!-- start of body -->
    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto">

        <div class="features shadow-sm p-4 d-flex justify-content-between align-items-center">

            <div class="component-right gap-4 d-flex align-items-center">

                <div class="add-button">
                    <button class="main-btn"> اضافه منتج</button>
                </div>

                <form action="" class="gap-4 d-flex align-items-center mb-0">
                    <div class="search-input">
                        <label for="search">بحث بالاسم :</label>
                        <input type="search" placeholder="بحث" id="search">
                    </div>

                    <div class="wrapperFilter">
                        <label class="d-block mb-1"> القسم</label>
                        <div class="select-btn">
                            <span>اختر القسم</span>
                            <input class="input_id" type="hidden" value="" name="department_id">
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



                    <!-- Filter by Date From -->
                    <div class="dateInp">
                        <label for="startDate">من تاريخ:</label>
                        <input type="date" id="startDate" name="date_from" value="{{ request('date_from') }}">
                    </div>

                    <!-- Filter by Date To -->
                    <div class="dateInp">
                        <label for="date_to">إلى تاريخ:</label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>

                    {{-- <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                        <button onclick="dropdown('valueCategories', 'listCategories')">
                            <span class="fw-bold opacity-50 valueDropdown" id="valueCategories">الفئه</span>
                            <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">
                        </button>
                        <div class="options none">
                            <ul id="listCategories">
                                <li class="p-0" id="search">
                                    <input class="search" type="search" placeholder="بحث">
                                </li>
                                <li class="active">الفئة</li>
                                <li>فئه 1</li>
                                <li>فئه 2</li>
                                <li>فئه 3</li>
                            </ul>
                        </div>
                    </div> --}}
                    <button type="submit" class="main-btn" id="form">تأكيد</button>
                </form>

            </div>

            <div class="component-left me-3 gap-4 d-flex align-items-center">

                <div class="select-btn border-0 select position-relative rounded-3 d-flex align-items-center">
                    <button onclick="dropdown('valueRelease', 'listRelease')">
                        <span class="fw-bold opacity-50 valueDropdown" id="valueRelease">اصدار</span>
                        <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">
                    </button>
                    <div class="options none">
                        <ul id="listRelease">
                            <li id="pdf">PDF</li>
                            <li id="excel">EXCEL</li>
                            <li id="print">PRINT</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <table id="table" class="w-100 mb-4 border">

            <thead class="head">
                <tr>
                    <th>المنتج</th>
                    <th>القسم</th>
                    {{-- <th>الكميه</th> --}}
                    <th>بواسطه</th>
                    <th>التاريخ</th>
                    <th class="print-hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 25"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                                stroke="#4B465C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                                stroke="white" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <circle cx="12" cy="12.1108" r="3" stroke="#4B465C" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="12" cy="12.1108" r="3" stroke="white" stroke-opacity="0.2"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </th>
                </tr>
            </thead>

            <tbody>
                @if (count($products) === 0)
                    <tr>
                        <td colspan="6" class="text-center">
                            لا توجد بيانات
                        </td>
                    </tr>
                @endif

                @foreach ($products as $product)
                    <tr>
                        <td class="opacity-50">
                            {{ $product->name }}
                        </td>
                        <td>{{ $product->department_id }}</td>
                        {{-- <td>{{ $product->description }}</td> --}}
                        {{-- <td>{{ $product->quantity }}</td> --}}
                        <td>
                            {{ $product->added_by }}
                        </td>
                        <td>
                            {{ $product->date }}
                        </td>
                        {{-- <td>
                                @if ($product->is_active)
                                    <span class="live">مفعل</span>
                                @else
                                    <span class="died">غير مفعل</span>
                                @endif
                            </td> --}}
                        <td class="print-hidden">
                            <div class="edit d-flex align-items-center justify-content-center">
                                <img src="{{ asset('Assets/imgs/edit-circle.png') }}" data-id="{{ $product->id }}"
                                    alt="" id="edit">


                                <img class="ms-2 me-2" src="{{ asset('Assets/imgs/trash (1).png') }}"
                                    data-id="{{ $product->id }}" alt="" id="trash">

                            </div>
                        </td>
                        <td class="p-0">
                            <div class="popup-edit id-{{ $product->id }} popup close shadow-sm rounded-3 position-fixed">
                                <form id="edit-cate" method="post"
                                    action="{{ route('product.update', $product->id) }}">
                                    @csrf
                                    @method('put')

                                    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}"
                                        alt="">
                                    <h2 class="text-center mt-4 mb-4 opacity-75"> تعديل: {{ $product->name }} </h2>
                                    <div class="f-row d-flex gap-4">
                                        <div>
                                            <label class="d-block mb-1" for="category-name">اسم المنتج</label>
                                            <input type="text" class="category-input" name="name"
                                                value="{{ $product->name }}" id="category-name"
                                                placeholder="اسم المنتج">
                                        </div>

                                        <div class="wrapperEdit">
                                            <label class="d-block mb-1"> القسم</label>
                                            <div class="select-btn">
                                                <span>اختر القسم</span>
                                                <input class="input_id" type="hidden" value=""
                                                    name="department_id">
                                                <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">
                                            </div>
                                            <div class="content">
                                                <div class="search">
                                                    <i class="uil uil-search"></i>
                                                    <input class="input" spellcheck="false" type="text"
                                                        placeholder="بحث في الاقسام">
                                                </div>
                                                <ul class="options"></ul>
                                            </div>
                                        </div>

                                    </div>
                                    {{-- <div class="f-row d-flex gap-4">
                                                <div>
                                                    <label class="d-block mb-1" for="buy-price"> الكمية</label>
                                                    <input type="number" name="quantity" value="{{ $product->quantity }}"
                                                        min="0" id="buy-price" placeholder="الكميه الموجوده">
                                                </div>
                                            </div> --}}
                                    <div>
                                        <label class="d-block" for="textarea">وصف المنتج</label>
                                        <textarea name="description" class="category-input" id="textarea" cols="30" rows="10"
                                            placeholder="وصف المنتج">{{ $product->description }}</textarea>
                                    </div>
                                    {{-- <div class="form-check form-switch d-flex align-items-center  ms-2 me-2">
                                                <input class="form-check-input ms-3"
                                                    @if ($product->is_active) checked @endif type="checkbox"
                                                    role="switch" id="flexSwitchCheckDefault-97" name="is_active"
                                                    value="1">

                                                <label for="flexSwitchCheckDefault-97">تفعيل</label>
                                            </div> --}}

                                    <div id="invalidEdit" class="invalid my-3"></div>

                                    <button class="main-btn">تحديث</button>
                                </form>
                            </div>

                        </td>
                        <div class="popup-delete id-{{ $product->id }} popup close shadow-sm rounded-3 position-fixed">
                            <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
                            <h3 class="fs-5 fw-bold mb-3">حذف المنتج</h3>
                            <p>هل تريد الحذف متاكد !!</p>
                            <div class="buttons mt-5 d-flex">
                                <button class="agree rounded-2">نعم
                                    أريد</button>

                                <button class="disagree me-3 text-light rounded-2 main-btn">لا أريد</button>
                            </div>
                        </div>


                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="table-control d-flex justify-content-between align-items-center">
            <div class="buttons-div">
                @if ($products->currentPage() != 1)
                    <a href="{{ $products->previousPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">السابق</a>
                @endif

                @for ($i = max(1, $products->currentPage() - 2); $i <= min($products->lastPage(), $products->currentPage() + 2); $i++)
                    <a href="{{ $products->url($i) }}"
                        class="number-pages text-light ms-1 me-1 main-btn {{ $i == $products->currentPage() ? 'bg-primary' : '' }}">{{ $i }}</a>
                @endfor

                @if ($products->currentPage() != $products->lastPage())
                    <a href="{{ $products->nextPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">التالي</a>
                @endif
            </div>

            <div class="info-table opacity-50">
                <p>عرض <span>{{ $products->firstItem() }}</span> إلى <span>{{ $products->lastItem() }}</span>
                    من
                    <span>{{ $products->total() }}</span> مدخلات
                </p>
            </div>
        </div>


    </section>
    <!-- end of body -->
    <!-- start of popup -->
    @include('pages.items.add')


    <div class="overlay position-fixed none w-100 h-100"></div>
    <!-- end of popup -->

@endsection

@section('script')

    {{-- For Exel --}}
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    {{-- For PDF --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
    </script>

    {{-- For Drobdown input Add --}}
    <script>
        const wrapperFilter = document.querySelector(".wrapperFilter"),
            selectBtnFilter = wrapperFilter.querySelector(".select-btn"),
            searchInpFilter = wrapperFilter.querySelector(".input"),
            optionsFilter = wrapperFilter.querySelector(".options"),
            FilterHiddenInput = wrapperFilter.querySelector(".input_id");

        let departsFilter = "{{ $departments }}";
        let partsFilter = JSON.parse(departsFilter.replaceAll("&quot;", '"'))

        if (departsFilter) {
            console.log("wrapperFilter", wrapperFilter);
        }



        function addCateFilter(selectedPart) {
            optionsFilter.innerHTML = "";
            partsFilter && partsFilter.forEach(category => {
                let isSelectedAdd = category.name == selectedPart ? "selected" : "";
                let li = `<li onclick="updateFilter(this)" class="${isSelectedAdd}">${category.name}</li>`;
                optionsFilter.insertAdjacentHTML("beforeend", li);
                FilterHiddenInput.value = category.id
            });
        }
        addCateFilter();

        function updateFilter(selectedli) {
            searchInpFilter.value = "";
            addCateFilter(selectedli.innerText);
            wrapperFilter.classList.remove("active");
            selectBtnFilter.firstElementChild.innerText = selectedli.innerText;
        }

        searchInpFilter.addEventListener("keyup", () => {

            let arr = [];
            let searchWord = searchInpFilter.value.toLowerCase();
            arr = partsFilter.filter(onePart => {
                return onePart.name.toLowerCase().startsWith(searchWord);
            }).map(onePart => {
                let isSelectedAdd = onePart.name === selectBtnFilter.firstElementChild.innerText ?
                    "selected" :
                    "";
                return `<li onclick="update(this)" class="${isSelectedAdd}">${onePart.name}</li>`;
            }).join("");
            optionsFilter.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! not found</p>`;
        });




        selectBtnFilter.addEventListener("click", () => wrapperFilter.classList.toggle("active"));
    </script>
    {{-- For Drobdown input Filter --}}
    <script>
        const wrapperAdd = document.querySelector(".dropdown"),
            selectBtnAdd = wrapperAdd.querySelector(".select-btn-add"),
            searchInpAdd = wrapperAdd.querySelector(".input"),
            optionsAdd = wrapperAdd.querySelector(".options"),
            addHiddenInput = wrapperAdd.querySelector("#add_input_id");

        let departs = "{{ $departments }}";
        let parts = JSON.parse(departs.replaceAll("&quot;", '"'))


        console.log("dropdown", wrapperAdd);


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
    {{-- For Drobdown input Edit --}}
    {{-- <script>
        const wrapperEdit = document.querySelector(".wrapperEdit"),
            selectBtnEdit = wrapperEdit.querySelector(".select-btn"),
            searchInpEdit = wrapperEdit.querySelector(".input"),
            optionsEdit = wrapperEdit.querySelector(".options"),
            EditHiddenInput = wrapperEdit.querySelector(".input_id");

        let departsEdit = "{{ $departments }}";
        let partsEdit = JSON.parse(departsEdit.replaceAll("&quot;", '"'))



        function addCateEdit(selectedPart) {
            optionsEdit.innerHTML = "";
            partsEdit && partsEdit.forEach(category => {
                let isSelectedAdd = category.name == selectedPart ? "selected" : "";
                let li = `<li onclick="updateEdit(this)" class="${isSelectedAdd}">${category.name}</li>`;
                optionsEdit.insertAdjacentHTML("beforeend", li);
                EditHiddenInput.value = category.id
            });
        }
        addCateEdit();

        function updateEdit(selectedli) {
            searchInpEdit.value = "";
            addCateEdit(selectedli.innerText);
            wrapperEdit.classList.remove("active");
            selectBtnEdit.firstElementChild.innerText = selectedli.innerText;
        }

        if (searchInpEdit) {
            searchInpEdit.addEventListener("keyup", () => {
                let arr = [];
                let searchWord = searchInpEdit.value.toLowerCase();
                arr = partsEdit.filter(onePart => {
                    return onePart.name.toLowerCase().startsWith(searchWord);
                }).map(onePart => {
                    let isSelectedAdd = onePart.name === selectBtnEdit.firstElementChild.innerText ?
                        "selected" :
                        "";
                    return `<li onclick="updateEdit(this)" class="${isSelectedAdd}">${onePart.name}</li>`;
                }).join("");
                optionsEdit.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! not found</p>`;
            });
        }

        selectBtnEdit.addEventListener("click", () => {
            wrapperEdit.classList.toggle("active")
        });
    </script> --}}
    {{-- Print and Pdf and Excel  --}}
    <script>
        function printTable() {
            // Clone the table
            var myTable = document.getElementById("table").cloneNode(true);
            myTable.setAttribute('border', '1');
            myTable.setAttribute('cellpadding', '5');

            // Remove last column from the cloned table
            var rows = myTable.getElementsByTagName("tr");
            for (var i = 0; i < rows.length; i++) {
                var cols = rows[i].getElementsByTagName("td");
                if (cols.length > 0) {
                    rows[i].removeChild(cols[cols.length - 1]);
                }
            }

            // Open a new window for printing
            var printWindow = window.open('');
            printWindow.document.write('<html dir="rtl"><head><title>Table Contents</title>');

            // Print the Table CSS.
            // var table_style = document.getElementById("table_style").innerHTML;
            printWindow.document.write('<style type="text/css">');
            // printWindow.document.write(table_style);
            printWindow.document.write('.print-hidden{display:none;}')
            printWindow.document.write('#table{width:100%;}')
            printWindow.document.write('</style>');
            printWindow.document.write('</head>');

            // Print the cloned table
            printWindow.document.write('<body>');
            printWindow.document.write('<div id="dvContents">');
            printWindow.document.write(myTable.outerHTML);
            printWindow.document.write('</div>');
            printWindow.document.write('</body>');

            printWindow.document.write('</html>');
            printWindow.document.close();
            printWindow.print();
        }

        const print = document.getElementById("print");
        print.addEventListener('click', () => {
            printTable();
        });
        //End Print Table

        // Start PDF File
        function Export() {
            // Hide the last column of the table
            var table = document.getElementById('table');

            var lastColumnCells = table.querySelectorAll('td:last-child, th:last-child');
            lastColumnCells.forEach(function(cell) {
                cell.style.display = 'none';
            });

            // Apply text alignment style to <th> and <td> elements inside the table
            var tableCells = table.querySelectorAll('th, td');
            tableCells.forEach(function(cell) {
                cell.style.textAlign = "right";
            });

            // Render the modified table to canvas
            html2canvas(table, {
                onrendered: function(canvas) {
                    // Restore the visibility of the last column
                    lastColumnCells.forEach(function(cell) {
                        cell.style.display = '';
                    });

                    // Remove text alignment style from <th> and <td> elements inside the table
                    tableCells.forEach(function(cell) {
                        cell.style.textAlign = "";
                    });

                    // Convert canvas to base64 data URL
                    var data = canvas.toDataURL();

                    // Create PDF
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Table.pdf");
                }
            });
        }


        const pdfBtn = document.getElementById("pdf");
        pdfBtn.addEventListener('click', () => {
            Export()
        });
        // End PDF File

        // Start Exel Sheet
        function htmlTableToExcel(type) {
            var data = document.getElementById('table');


            // Remove last column
            var rows = data.getElementsByTagName('tr');
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName('td');
                if (cells.length > 0) {
                    rows[i].deleteCell(cells.length - 1);
                }
            }

            var excelFile = XLSX.utils.table_to_book(data, {
                sheet: "sheet1"
            });
            XLSX.write(excelFile, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            });
            XLSX.writeFile(excelFile, 'ExportedFile:HTMLTableToExcel.' + type);
        }

        const exelBtn = document.getElementById("excel");
        exelBtn.addEventListener('click', () => {
            htmlTableToExcel('xlsx')
        });
        // End Exel Sheet
    </script>

    {{-- Validation For Edits Edit --}}
    {{-- <script>
        document.querySelectorAll("table #edit").forEach((edit) => {
            let id = edit.dataset.id;

            edit.addEventListener("click", () => {

                let popUp = document.querySelector(".popup-edit.id-" + id),
                    editForm = popUp.querySelector("#edit-cate"),
                    editInputs = editForm.querySelectorAll(".category-input"),
                    editMessage = editForm.querySelector("#invalidEdit");

                editForm.addEventListener('submit', (event) => {
                    editMessage.textContent = '';

                    editInputs.forEach(input => {
                        if (input.value.trim() === "") {
                            event.preventDefault();
                            const inputName = input.getAttribute('placeholder');
                            editMessage.textContent = `الحقل ${inputName} مطلوب`;
                            input.focus();
                            return;
                        }
                    });
                });

                const wrapperEdit = editForm.querySelector(".wrapperEdit"),
                    selectBtnEdit = wrapperEdit.querySelector(".select-btn"),
                    searchInpEdit = wrapperEdit.querySelector(".input"),
                    optionsEdit = wrapperEdit.querySelector(".options"),
                    EditHiddenInput = wrapperEdit.querySelector(".input_id");

                let departsEdit = "{{ $departments }}";
                let partsEdit = JSON.parse(departsEdit.replaceAll("&quot;", '"'))



                function addCateEdit(selectedPart) {
                    optionsEdit.innerHTML = "";
                    partsEdit && partsEdit.forEach(category => {
                        let isSelectedAdd = category.name == selectedPart ? "selected" : "";
                        let li =
                            `<li onclick="updateEdit(this)" class="${isSelectedAdd}">${category.name}</li>`;
                        optionsEdit.insertAdjacentHTML("beforeend", li);
                        EditHiddenInput.value = category.id
                    });
                }
                addCateEdit();

                function updateEdit(selectedli) {
                    searchInpEdit.value = "";
                    addCateEdit(selectedli.innerText);
                    wrapperEdit.classList.remove("active");
                    selectBtnEdit.firstElementChild.innerText = selectedli.innerText;
                }

                if (searchInpEdit) {
                    searchInpEdit.addEventListener("keyup", () => {
                        let arr = [];
                        let searchWord = searchInpEdit.value.toLowerCase();
                        arr = partsEdit.filter(onePart => {
                            return onePart.name.toLowerCase().startsWith(searchWord);
                        }).map(onePart => {
                            let isSelectedAdd = onePart.name === selectBtnEdit
                                .firstElementChild.innerText ?
                                "selected" :
                                "";
                            return `<li onclick="updateEdit(this)" class="${isSelectedAdd}">${onePart.name}</li>`;
                        }).join("");
                        optionsEdit.innerHTML = arr ? arr :
                            `<p style="margin-top: 10px;">Oops! not found</p>`;
                    });
                }

                selectBtnEdit.addEventListener("click", () => {
                    wrapperEdit.classList.toggle("active")
                });



            });
        });
    </script> --}}
    <script>
        // Define addCateEdit function
        function addCateEdit(selectedPart, optionsEdit, partsEdit, EditHiddenInput) {
            optionsEdit.innerHTML = "";
            partsEdit.forEach(category => {
                let isSelectedAdd = category.name == selectedPart ? "selected" : "";
                let li =
                    `<li onclick="updateEdit(this, '${category.name}', '${category.id}', searchInpEdit)" class="${isSelectedAdd}">${category.name}</li>`;
                optionsEdit.insertAdjacentHTML("beforeend", li);
                EditHiddenInput.value = category.id;
            });
        }

        // Define updateEdit function
        function updateEdit(selectedli, selectedPart, categoryId, searchInput) {
            searchInput.value = "";
            wrapperEdit.classList.remove("active");
            selectBtnEdit.firstElementChild.innerText = selectedPart;
            EditHiddenInput.value = categoryId;
        }

        document.querySelectorAll("table #edit").forEach((edit) => {
            let id = edit.dataset.id;

            edit.addEventListener("click", () => {
                let popUp = document.querySelector(".popup-edit.id-" + id),
                    editForm = popUp.querySelector("#edit-cate"),
                    editInputs = editForm.querySelectorAll(".category-input"),
                    editMessage = editForm.querySelector("#invalidEdit"),
                    wrapperEdit = editForm.querySelector(".wrapperEdit"),
                    selectBtnEdit = wrapperEdit.querySelector(".select-btn"),
                    searchInpEdit = wrapperEdit.querySelector(".input"),
                    optionsEdit = wrapperEdit.querySelector(".options"),
                    EditHiddenInput = wrapperEdit.querySelector(".input_id");

                editForm.addEventListener('submit', (event) => {
                    editMessage.textContent = '';

                    editInputs.forEach(input => {
                        if (input.value.trim() === "") {
                            event.preventDefault();
                            const inputName = input.getAttribute('placeholder');
                            editMessage.textContent = `الحقل ${inputName} مطلوب`;
                            input.focus();
                            return;
                        }
                    });
                });

                let departsEdit = "{{ $departments }}";
                let partsEdit = JSON.parse(departsEdit.replaceAll("&quot;", '"'));

                addCateEdit(null, optionsEdit, partsEdit, EditHiddenInput);

                if (searchInpEdit) {
                    searchInpEdit.addEventListener("keyup", () => {
                        let arr = [];
                        let searchWord = searchInpEdit.value.toLowerCase();
                        arr = partsEdit.filter(onePart => {
                            return onePart.name.toLowerCase().startsWith(searchWord);
                        }).map(onePart => {
                            let isSelectedAdd = onePart.name === selectBtnEdit
                                .firstElementChild.innerText ?
                                "selected" :
                                "";
                            return `<li onclick="updateEdit(this, '${onePart.name}', '${onePart.id}', searchInpEdit)" class="${isSelectedAdd}">${onePart.name}</li>`;
                        }).join("");
                        optionsEdit.innerHTML = arr ? arr :
                            `<p style="margin-top: 10px;">Oops! not found</p>`;
                    });
                }

                selectBtnEdit.addEventListener("click", () => {
                    wrapperEdit.classList.toggle("active")
                });
            });
        });
    </script>




    {{-- Validation For Edits Add --}}

    <script>
        const myForm = document.getElementById("add-cate");
        const inputs = document.querySelectorAll(".category-input");
        const messageAdd = document.querySelector("#invalidAdd.invalid.invalidAdd");

        myForm.addEventListener('submit', (event) => {
            messageAdd.textContent = '';
            inputs.forEach(input => {
                if (input.value.trim() === "") {
                    event.preventDefault();
                    const inputName = input.getAttribute('placeholder');
                    messageAdd.innerText = `الحقل ${inputName} مطلوب`;
                    input.focus();
                    return;
                }
            });
        });
    </script>

    {{-- Delete --}}
    <script>
        document.querySelectorAll("#trash").forEach((trash) => {
            let id = trash.dataset.id;

            trash.addEventListener("click", (e) => {
                document.querySelector("body").classList.add("overflow-hidden");

                document.querySelector(".overlay").classList.remove("none");

                document.querySelector(".popup-delete").classList.remove("close");

                document
                    .querySelector(".popup-delete .agree")
                    .addEventListener("click", () => {


                        fnDelete(id)

                        document
                            .querySelector("body")

                            .classList.remove("overflow-hidden");

                        document.querySelector(".overlay").classList.add("none");

                        document.querySelector(".popup-delete").classList.add("close");



                    });

                document
                    .querySelector(".popup-delete .disagree")
                    .addEventListener("click", () => {
                        document
                            .querySelector("body")
                            .classList.remove("overflow-hidden");

                        document.querySelector(".overlay").classList.add("none");

                        document.querySelector(".popup-delete").classList.add("close");
                    });
            });
        });
    </script>


    <script>
        function fnDelete(id) {
            // Get the form element
            var form = document.createElement('form');
            form.setAttribute('method', 'POST');
            form.setAttribute('action', `{{ url('product') }}/${id}`);
            form.style.display = 'none';

            // Add CSRF token field
            var csrfTokenField = document.createElement('input');
            csrfTokenField.setAttribute('type', 'hidden');
            csrfTokenField.setAttribute('name', '_token');
            csrfTokenField.setAttribute('value', '{{ csrf_token() }}');
            form.appendChild(csrfTokenField);

            // Add method spoofing for DELETE request
            var methodField = document.createElement('input');
            methodField.setAttribute('type', 'hidden');
            methodField.setAttribute('name', '_method');
            methodField.setAttribute('value', 'DELETE');
            form.appendChild(methodField);

            // Append the form to the document body
            document.body.appendChild(form);

            // Submit the form
            form.submit();
        }
    </script>



    <script src="{{ asset('Assets/JS files/products.js') }}"></script>
@endsection
