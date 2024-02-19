@extends('layouts.app')

@section('title', 'المنتجات')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/products.css') }}">
@endsection

@section('content')
    <!-- end of frame-5 (header) -->
    <h2 class="mt-5 mb-5">المنتجات</h2>
    <!-- start of body -->
    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto">

        <div class="features shadow-sm p-4 d-flex justify-content-between align-items-center">

            <div class="component-right gap-4 d-flex align-items-center">

                @can('create product')
                    <div class="add-button">
                        <button class="main-btn"> اضافه منتج</button>
                    </div>
                @endcan
                @can('read product')
                    <div class="search-input">
                        <input type="search" placeholder="بحث" id="search">
                    </div>

                    <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                        <button onclick="dropdown('valueStatus', 'listStatus')">
                            <span class="fw-bold opacity-50 valueDropdown" id="valueStatus">الحاله</span>
                            <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">
                        </button>
                        <div class="options none">
                            <ul id="listStatus">
                                <li class="p-0" id="search">
                                    <input class="search" type="search" placeholder="بحث">
                                </li>
                                <li class="active">الحاله</li>
                                <li>الحاله 1</li>
                                <li>الحاله 2</li>
                            </ul>
                        </div>
                    </div>

                    <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
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
                    </div>

                    <button class="main-btn" id="form">تأكيد</button>
                @endcan
            </div>

            <div class="component-left me-3 gap-4 d-flex align-items-center">

                <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                    <button onclick="dropdown('valueRelease', 'listRelease')">
                        <span class="fw-bold opacity-50 valueDropdown" id="valueRelease">اصدار</span>
                        <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">
                    </button>
                    <div class="options none">
                        <ul id="listRelease">
                            <li>PDF</li>
                            <li>ECXEL</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        @can('read product')
            <table class="w-100 mb-4 border">

                <thead class="head">
                    <tr>
                        <th>المنتج</th>
                        <th>القسم</th>
                        <th>وصف</th>
                        <th>الكميه</th>
                        <th>بواسطه</th>
                        <th>الحاله</th>
                        <th>
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
                    @foreach ($products as $product)
                        <tr>
                            <td class="opacity-50">
                                {{ $product->name }}
                            </td>
                            <td>{{ $product->department_id }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>
                                {{ $product->added_by }}
                            </td>
                            <td>
                                @if ($product->is_active)
                                    <span class="live">مفعل</span>
                                @else
                                    <span class="died">غير مفعل</span>
                                @endif
                            </td>
                            <td>
                                <div class="edit d-flex align-items-center justify-content-center">
                                    @can('update product')
                                        <img src="{{ asset('Assets/imgs/edit-circle.png') }}" data-id="{{ $product->id }}"
                                            alt="" id="edit">
                                    @endcan

                                    @can('delete product')
                                        <img class="ms-2 me-2" src="{{ asset('Assets/imgs/trash (1).png') }}"
                                            data-id="{{ $product->id }}" alt="" id="trash">
                                    @endcan
                                </div>
                            </td>
                            <td>
                                @can('update product')
                                    <div class="popup-edit id-{{ $product->id }} popup close shadow-sm rounded-3 position-fixed">
                                        <form method="post" action="{{ route('product.update', $product->id) }}">
                                            @csrf
                                            @method('put')

                                            <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}"
                                                alt="">
                                            <h2 class="text-center mt-4 mb-4 opacity-75"> تعديل: {{ $product->name }} </h2>
                                            <div class="f-row d-flex gap-4">
                                                <div>
                                                    <label class="d-block mb-1" for="category-name">اسم المنتج</label>
                                                    <input type="text" name="name" value="{{ $product->name }}"
                                                        id="category-name" placeholder="اسم المنتج">
                                                </div>
                                                <div class="select-form">
                                                    <div class="select-form">
                                                        <label for="department">القسم</label>
                                                        <select class="form-control form-select" id="department"
                                                            name="department_id">
                                                            @foreach ($departments as $department)
                                                                <option value="{{ $department->id }}"
                                                                    @if ($product->department_id == $department->id) selected @endif>
                                                                    {{ $department->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="f-row d-flex gap-4">
                                                <div>
                                                    <label class="d-block mb-1" for="buy-price"> الكمية</label>
                                                    <input type="number" name="quantity" value="{{ $product->quantity }}"
                                                        min="0" id="buy-price" placeholder="الكميه الموجوده">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="d-block" for="textarea">وصف المنتج</label>
                                                <textarea name="description" id="textarea" cols="30" rows="10" placeholder="وصف المنتج">{{ $product->description }}</textarea>
                                            </div>
                                            <div class="form-check form-switch d-flex align-items-center  ms-2 me-2">
                                                <input class="form-check-input ms-3"
                                                    @if ($product->is_active) checked @endif type="checkbox"
                                                    role="switch" id="flexSwitchCheckDefault-97" name="is_active"
                                                    value="1">

                                                <label for="flexSwitchCheckDefault-97">تفعيل</label>
                                            </div>
                                            <button class="main-btn">تحديث</button>
                                        </form>
                                    </div>
                                @endcan
                            </td>
                            @can('delete product')
                                <div class="popup-delete id-{{ $product->id }} popup close shadow-sm rounded-3 position-fixed">
                                    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
                                    <h3 class="fs-5 fw-bold mb-3">حذف المنتج</h3>
                                    <p>هل تريد الحذف متاكد !!</p>
                                    <div class="buttons mt-5 d-flex">
                                        <button class="agree rounded-2">نعم أريد</button>
                                        <button class="disagree me-3 text-light rounded-2 main-btn">لا أريد</button>
                                    </div>
                                </div>
                            @endcan

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
        @endcan

    </section>
    <!-- end of body -->
    <!-- start of popup -->
    @include('pages.items.add')


    <div class="overlay position-fixed none w-100 h-100"></div>
    <!-- end of popup -->

@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/products.js') }}"></script>
@endsection
