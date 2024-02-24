@extends('layouts.app')

@section('title', 'اضافه حفله جديده')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/add-concert.css') }}">
@endsection

@section('content')
    <!-- start of body -->
    <h2 class="mb-2 mt-5">اضافه معلومات الفاتوره للحفله "{{ $party->name }}"</h2>

    <div class="mt-5 mb-5 special">
        <button class="secound-btn active-btn total-product mb-2 tabs"
            id="ourProduct"style="padding: 15px; width: 170px;">منتجاتنا</button>
        <button class="me-2 secound-btn element-found mb-2 tabs" id="rent"
            style="padding: 15px; width: 170px;">ايجار</button>
        <button class="secound-btn element-not-found mb-2 style="
            id="specialConcert"style="padding: 15px; width: 170px;">مخصص</button>
    </div>

    <div class="part show gap-4" id="ourProduct">
        <div class="products ps-2 pe-2">
            <div class="info p-2 mb-1 d-flex gap-4 align-items-center">
                <div class="w-50">
                    <input type="search" name="search" id="search-name" placeholder="بحث">
                </div>
                <div class="select-btn w-50 select position-relative rounded-3 d-flex align-items-center">
                    <button class="w-100 d-flex justify-content-between"
                        onclick="dropdown('valueDateAddLast3', 'listDateAddLast3')">
                        <span class="fw-bold opacity-50 valueDropdown" id="valueDateAddLast3">الحاله</span>
                        <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">

                    </button>
                    <div class="options none">
                        <ul id="listDateAddLast3">
                            <li>النوع 1</li>
                            <li>النوع 2</li>
                            <li>النوع 3</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="up p-2 d-flex gap-3">
                @foreach ($products as $product)
                    <div class="box">
                        <div class="info-box p-3">
                            {{ $product->id }}
                            <span class="d-block fs-5">{{ $product->name }}</span>
                            <span class="fs-5">الكميه المتاحه: {{ $product->quantity }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="part gap-4" id="rent">
        <div class="products">
            <div class="info p-2 mb-1 d-flex gap-4 align-items-center">
                <div class="w-50">
                    <input type="search" name="search" id="search-name" placeholder="بحث">
                </div>
                <div class="select-btn w-50 select position-relative rounded-3 d-flex align-items-center">
                    <button class="w-100 d-flex justify-content-between"
                        onclick="dropdown('valueDateAddLast3', 'listDateAddLast3')">
                        <span class="fw-bold opacity-50 valueDropdown" id="valueDateAddLast3">الحاله</span>
                        <img src="./Assets/imgs/chevron-down.png" alt="">
                    </button>
                    <div class="options none">
                        <ul id="listDateAddLast3">
                            <li>النوع 1</li>
                            <li>النوع 2</li>
                            <li>النوع 3</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="up p-2 d-flex justify-content-between overflow-auto">
                @foreach ($rents as $rent)
                    <div class="box">
                        <div class="info-box p-3">
                            {{-- {{ $rent->id }} --}}
                            <dib class="d-block fs-5">{{ $rent->name }}</dib>
                            <div class="fs-5">السعر: {{ $rent->sale_price }}</div>
                            <div class="fs-5">الكميه المتاحه: {{ $rent->quantity }}</div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <div class="carts rounded-3 d-flex flex-column justify-content-between">
        <div class="elements">
            <div class="info d-flex gap-3 justify-content-between">
                <span>الاسم</span>
                <span>الكميه</span>
                <span>سعر الوحده</span>
                <span>اجمالي السعر</span>
                <span>النوع</span>
                <span>الحاله</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 25" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                        stroke="#4B465C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M10.325 4.42784C10.751 2.67184 13.249 2.67184 13.675 4.42784C13.8046 4.9629 14.182 5.40386 14.6907 5.61459C15.1993 5.82531 15.7779 5.78044 16.248 5.49384C17.791 4.55384 19.558 6.31984 18.618 7.86384C18.3318 8.33369 18.2871 8.91192 18.4975 9.42022C18.708 9.92852 19.1484 10.3058 19.683 10.4358C21.439 10.8618 21.439 13.3598 19.683 13.7858C19.1479 13.9155 18.707 14.2929 18.4963 14.8015C18.2855 15.3101 18.3304 15.8888 18.617 16.3588C19.557 17.9018 17.791 19.6688 16.247 18.7288C15.7771 18.4427 15.1989 18.3979 14.6906 18.6084C14.1823 18.8188 13.805 19.2593 13.675 19.7938C13.249 21.5498 10.751 21.5498 10.325 19.7938C10.1954 19.2588 9.81797 18.8178 9.30935 18.6071C8.80073 18.3964 8.22206 18.4412 7.752 18.7278C6.209 19.6678 4.442 17.9018 5.382 16.3578C5.66819 15.888 5.71295 15.3098 5.50247 14.8015C5.292 14.2932 4.85157 13.9158 4.317 13.7858C2.561 13.3598 2.561 10.8618 4.317 10.4358C4.85206 10.3062 5.29302 9.92881 5.50375 9.42019C5.71447 8.91157 5.6696 8.3329 5.383 7.86284C4.443 6.31984 6.209 4.55284 7.753 5.49284C8.753 6.10084 10.049 5.56284 10.325 4.42784Z"
                        stroke="white" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <circle cx="12" cy="12.1108" r="3" stroke="#4B465C" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <circle cx="12" cy="12.1108" r="3" stroke="white" stroke-opacity="0.2" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="element" id="element">
                <span class="productName"></span>
                <span class="countity"> </span>
                <span class="price"></span>
                <span class="totalPrice"></span>
                <span class="type "></span>
                <span class="status live"></span>
                <div class="edit">
                    <img src="{{ asset('Assets/imgs/edit-circle.png') }}" alt="" id="edit">
                    <img src="{{ asset('Assets/imgs/trash (1).png') }}" alt="" id="trash">
                </div>
            </div>
            <div class="total active-btn mt-2" id="totalPrice">اجمالي السعر 900</div>
        </div>
    </div>

    <div class="popup-add popup close shadow-sm rounded-3 position-fixed" id="popupAddOurProduct" data-type="items">
        <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">

        <h2 class="text-center mt-4 mb-4 opacity-75">اضافة <span id="nameProduct"></span></h2>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="countity">الكميه</label>
                <input type="text" name="text" id="countity" placeholder="...">
            </div>
            <div>
                <label class="d-block mb-1" for="unit-price">سعر الوحده</label>
                <input type="text" name="text" id="unit-price" placeholder="...">
            </div>
        </div>
        <div class="f-row">
            <div class="select-form gap-2">
                <label for="" class="mb-2">النوع</label>
                <select name="" id="" class="w-100 p-2 rounded-2" id="type">
                    <option value="rent">ايجار</option>
                    <option value="sale">بيع</option>
                    <option value="eol">هالك</option>
                </select>
            </div>

        </div>
        <div class="eolReason ">
            <label class="d-block" for="textarea">سبب الهلاك</label>
            <textarea name="textarea" id="textarea" cols="30" rows="10" placeholder=".."></textarea>
        </div>
        <div class="form-check-2 form-check-checkbox">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault20" checked>
            <label class="form-check-label" for="flexCheckDefault20" id="status">جاهز</label>
        </div>
        <button class="main-btn" id="AddToCart">اضافه</button>
    </div>

    <div class="popup-edit popup close shadow-sm rounded-3 position-fixed" id="popupEditOurProduct" data-type="items">
        <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
        <h2 class="text-center mt-4 mb-4 opacity-75">تعديل <span id="nameProduct"></span></h2>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="category-name">الكميه</label>
                <input type="text" name="text" id="category-name" placeholder="...">
            </div>
            <div>
                <label class="d-block mb-1" for="category-name">سعر الوحده</label>
                <input type="text" name="text" id="category-name" placeholder="...">
            </div>
        </div>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="buy-price">اجمالي السعر</label>
                <input type="text" name="text" id="buy-price" placeholder="...">
            </div>
            <div class="select-form">
                <label for="">النوع</label>
                <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                    <button class="w-100 d-flex justify-content-between"
                        onclick="dropdown('valueCategoriesNameEdit', 'listCategoriesNameEdit')">
                        <span class="fw-bold opacity-50 valueDropdown" id="valueCategoriesNameEdit"></span>
                        <img src="./Assets/imgs/chevron-down.png" alt="">
                    </button>
                    <div class="options none">
                        <ul id="listCategoriesNameEdit">
                            <li class="p-0" id="search">
                                <input class="search" type="search" placeholder="بحث">
                            </li>
                            <li>النوع</li>
                            <li>النوع 1</li>
                            <li>النوع 2</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <div>
            <label class="d-block" for="textarea">سبب الهلاك (لو هالك)</label>
            <textarea name="textarea" id="textarea" cols="30" rows="10" placeholder=".."></textarea>
        </div>
        <div class="form-check-2 form-check-checkbox">
            <input class="form-check-input children" type="checkbox" value="" id="flexCheckDefault2">
            <label class="form-check-label children" for="flexCheckDefault2">قيد التحضير</label>
            <!-- <label class="form-check-label beReady none" for="flexCheckDefault2">جاهز</label> -->
        </div>
        <button class="main-btn">اضافه</button>
    </div>
    <!-- end of popup  ourProduct-->

    <!-- start of popup rent -->
    <div class="popup-add popup close shadow-sm rounded-3 position-fixed" id="popupAddRent" data-type="rent">
        <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
        <h2 class="text-center mt-4 mb-4 opacity-75">اضافة <span id="nameProduct"></span></h2>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="category-name">الكميه</label>
                <input type="text" name="text" id="category-name countity" placeholder="...">
            </div>
            <div class="select-form">
                <label for="" class="mb-1">النوع</label>
                <div class="select-form gap-2">
                    <select name="" id="" class="w-100 p-2 rounded-2" id="type">
                        <option value="rent">ايجار</option>
                        <option value="sale">بيع</option>
                        <option value="eol">هالك</option>
                    </select>
                </div>
            </div>
        </div>
        <div>
            <label class="d-block" for="textarea">سبب الهلاك (لو هالك)</label>
            <textarea name="textarea" id="textarea" cols="30" rows="10" placeholder=".."></textarea>
        </div>
        <div class="form-check-2 form-check-checkbox">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault23" checked>
            <label class="form-check-label" for="flexCheckDefault23">جاهز</label>
        </div>
        <button class="main-btn" id="AddToCart">اضافه</button>
    </div>

    <div class="popup-edit popup close shadow-sm rounded-3 position-fixed" id="popupEditRent" data-type="rent">
        <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
        <h2 class="text-center mt-4 mb-4 opacity-75">تعديل <span id="nameProduct"></span></h2>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="category-name">الكميه</label>
                <input type="text" name="text" id="category-name" placeholder="...">
            </div>
            <div class="select-form">
                <label for="">النوع</label>
                <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                    <button class="w-100 d-flex justify-content-between"
                        onclick="dropdown('valueCategoriesNameEdit3', 'listCategoriesNameEdit3')">
                        <span class="fw-bold opacity-50 valueDropdown" id="valueCategoriesNameEdit3"></span>
                        <img src="./Assets/imgs/chevron-down.png" alt="">
                    </button>
                    <div class="options none">
                        <ul id="listCategoriesNameEdit3">
                            <li class="p-0" id="search">
                                <input class="search" type="search" placeholder="بحث">
                            </li>
                            <li>النوع</li>
                            <li>النوع 1</li>
                            <li>النوع 2</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <label class="d-block" for="textarea">سبب الهلاك (لو هالك)</label>
            <textarea name="textarea" id="textarea" cols="30" rows="10" placeholder=".."></textarea>
        </div>
        <div class="form-check-2 form-check-checkbox">
            <input class="form-check-input children" type="checkbox" value="" id="flexCheckDefault25">
            <label class="form-check-label children" for="flexCheckDefault25">قيد التحضير</label>
            <!-- <label class="form-check-label beReady none" for="flexCheckDefault2">جاهز</label> -->
        </div>
        <button class="main-btn">اضافه</button>
    </div>
    <!-- end of popup rent -->

    <!-- start of popuo special -->
    <div class="popup-add popup close shadow-sm rounded-3 position-fixed" id="popupAddSpecial" data-type="custom">
        <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
        <h2 class="text-center mt-4 mb-4 opacity-75">تكلفه اضافيه مخصصه</h2>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="category-name">الاسم</label>
                <input type="text" name="text" id="category-name" placeholder="...">
            </div>
        </div>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="category-name">السعر </label>
                <input type="text" name="text" id="category-name" placeholder="...">
            </div>
        </div>
        <div class="form-check-2 form-check-checkbox">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault29" checked>
            <label class="form-check-label" for="flexCheckDefault29">جاهز</label>
        </div>
        <button class="main-btn" id="AddToCart">اضافه</button>
    </div>

    <div class="popup-edit popup close shadow-sm rounded-3 position-fixed" id="popupEditSpecial" data-type="custom">
        <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
        <h2 class="text-center mt-4 mb-4 opacity-75">تعديل تكلفه اضافيه</h2>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="category-name">الاسم</label>
                <input type="text" name="text" id="category-name" placeholder="...">
            </div>
        </div>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="category-name">السعر </label>
                <input type="text" name="text" id="category-name" placeholder="...">
            </div>
        </div>
        <div class="form-check-2 form-check-checkbox">
            <input class="form-check-input children" type="checkbox" value="" id="flexCheckDefault27">
            <label class="form-check-label children" for="flexCheckDefault27">قيد التحضير</label>
            <!-- <label class="form-check-label beReady none" for="flexCheckDefault2">جاهز</label> -->
        </div>
        <button class="main-btn">اضافه</button>
    </div>
    <!-- end of popuo special -->

    <div class="popup-delete popup close shadow-sm rounded-3 position-fixed">
        <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
        <h3 class="fs-5 fw-bold mb-3">حذف العنصر</h3>
        <p>هل تريد الحذف متاكد !!</p>
        <div class="buttons mt-5 d-flex">
            <button class="agree rounded-2">نعم أريد</button>
            <button class="disagree me-3 text-light rounded-2 main-btn">لا أريد</button>
        </div>
    </div>

    <div class="overlay position-absolute none w-100 h-100"></div>

    <div class="w-100 d-flex justify-content-end mt-5 mb-5" id="addNewProduct">
        <form action="{{ route('party.addBillStore', $id) }}" method="post">
            @csrf
            <button class="submit main-btn p-3 ps-4 pe-4" type="submit">اضافه</button>
        </form>
    </div>
    {{-- @endif --}}
@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/add-concert.js') }}"></script>
    <script>
        let name = document.querySelector("#popupAddOurProduct h2 span");
        let quantity = document.querySelector("#popupAddOurProduct #countity");
        let unitPrice = document.querySelector("#popupAddOurProduct #unit-price");
        let select = document.querySelector("#popupAddOurProduct select");

        // select.addEventListener("change", () => {


        // })

        let textarea = document.querySelector("#popupAddOurProduct textarea");
        let checbox = document.querySelector("#popupAddOurProduct .form-check-2 label");
        let type = document.querySelector("#popupAddOurProduct").dataset.type;
        // let boxs = document.querySelectorAll("#ourProduct .products .box");
        let mainProducts = [];

        document.querySelector("#popupAddOurProduct #AddToCart").addEventListener("click", () => {

            if (checbox.innerHTML === "جاهز") {
                checbox.classList.add("ready")
                checbox.classList.remove("perparing");
            } else {
                checbox.classList.remove("ready");
                checbox.classList.add("perparing");
            }

            let popupAdd = document.querySelectorAll(".popup-add")
            popupAdd.forEach(popup => {

                mainProducts.push(
                    bill = {
                        "party_id": {{ $party->id }},
                        "from": type,
                        "product_id": "",
                        "rent_id": "",
                        "name": name.innerHTML,
                        "quantity": quantity.value,
                        "unitPrice": unitPrice.value,
                        "totalPrice": totalPrice.value,
                        "type": select.value,
                        "eol_ression": textarea.value,
                        "status": checbox.classList[1]
                    }
                )

            })

            // console.log(mainProducts);

            let values = JSON.stringify(mainProducts);
            localStorage.setItem("products", values);

            let object = localStorage.getItem("products");
            let realObject = JSON.parse(object)
            let lastObject = realObject[mainProducts.length - 1];

            let element = document.createElement("div");
            element.classList.add("element");

            let productName = document.createElement("span");
            let productNameText = document.createTextNode(lastObject.name)
            productName.appendChild(productNameText);
            productName.classList.add("productName");

            let countity = document.createElement("span");
            let countityText = document.createTextNode(lastObject.quantity);
            countity.appendChild(countityText);
            countity.classList.add("countity");

            let price = document.createElement("span");
            let priceText = document.createTextNode(lastObject.unitPrice);
            price.appendChild(priceText);
            price.classList.add("price");

            let totalPricee = document.createElement("span");
            let totalPriceeText = document.createTextNode(lastObject.unitPrice * lastObject.quantity);
            totalPricee.appendChild(totalPriceeText);
            totalPricee.classList.add("totalPrice");

            let typeA = document.createElement("span");
            let typeAText = document.createTextNode(lastObject.type);
            typeA.appendChild(typeAText);
            typeA.classList.add("type");

            let status = document.createElement("span");
            let statusText = document.createTextNode(lastObject.status);
            status.appendChild(statusText);
            status.classList.add("status");

            let edit = document.createElement("div");
            edit.classList.add("edit");
            let editIcon = document.createElement("img");
            editIcon.src = "{{ asset('Assets/imgs/edit-circle.png') }}";
            let removeIcon = document.createElement("img");
            removeIcon.src = "{{ asset('Assets/imgs/trash (1).png') }}";
            edit.appendChild(editIcon);
            edit.appendChild(removeIcon);


            element.appendChild(productName);
            element.appendChild(countity);
            element.appendChild(price);
            element.appendChild(totalPricee);
            element.appendChild(typeA);
            element.appendChild(status);
            element.appendChild(edit);

            console.log(element);
            if (typeA.innerHTML === "sale") {
                typeA.innerHTML = "بيع"
            } else if (typeA.innerHTML === "rent") {
                typeA.innerHTML = "ايجار"
            } else {
                typeA.innerHTML = "هالك"
            }

            if (status.innerHTML === "ready") {
                status.innerHTML = "جاهز"
                status.classList.add("live");
            } else {
                status.innerHTML = "قيد التحضير"
                status.classList.add("died");
            }

            document.querySelector(".elements .total").before(element);
            document.querySelector("#popupAddOurProduct").classList.add("close");
            document.querySelector(".overlay").classList.add("none");
            document.querySelector("body").classList.remove("overflow-hidden");

        });
    </script>


@endsection
