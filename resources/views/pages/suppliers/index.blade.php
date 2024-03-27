@extends('layouts.app')

@section('title', 'الموردين')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/suppliers.css') }}">

    <style>
        #startDate {
            max-width: 220px !important;
        }

        .remove-btn {
            background-color: #ff6767;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .dolar-icon {

            width: 15px;
        }

        .check-btn {
            background-color: #15d057;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
@endsection



@section('content')

    <h2 class="mt-5 mb-5">الموردين</h2>
    <!-- start of body -->
    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto">

        <div class="features shadow-sm p-4 d-flex justify-content-between align-items-center">

            <div class="component-right gap-4 d-flex align-items-center">

                <div class="add-button">
                    <button class="text-light main-btn mt-4"> اضافه مورد</button>
                </div>

                <form action="" class="gap-4 mb-0 d-flex align-items-center">
                    <div class="search-input">
                        <label for="search-name">بحث بالمورد</label>
                        <input type="search" placeholder="بحث بالاسم" id="search-name">
                    </div>
                    <div class="search-email">
                        <label for="search-email">بحث بالبريد</label>
                        <input type="search" placeholder="بحث البريد الالكتروني" id="search-email">
                    </div>
                    <div class="search-mobile">
                        <label for="search-mobile">بحث برقم الهاتف</label>
                        <input type="search" placeholder="بحث رقم الهاتف" id="search-mobile">
                    </div>


                    {{-- <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
                        <button onclick="dropdown('valuePay', 'listPay')">
                            <span class="fw-bold opacity-50 valueDropdown" id="valuePay">نوع الدفع</span>
                            <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">
                        </button>
                        <div class="options none">
                            <ul id="listPay">
                                <li>كاش</li>
                                <li>دفعات</li>
                            </ul>
                        </div>
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
                    </div> --}}
                    <div>
                        <label for="startDate">من تاريخ:</label>
                        <input type="date" id="startDate" name="date_from" value="{{ request('date_from') }}">
                    </div>

                    <!-- Filter by Date To -->
                    <div>
                        <label for="date_to">إلى تاريخ:</label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>

                    <button type="submit" class="main-btn mt-4" id="form">تأكيد</button>
                </form>


            </div>

            <div class="component-left me-3 gap-4 d-flex align-items-center">

                <div class="select-btn select position-relative rounded-3 d-flex align-items-center mt-4">
                    <button onclick="dropdown('valueRelease', 'listRelease')">
                        <span class="fw-bold opacity-50 valueDropdown " id="valueRelease">اصدار</span>
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

        <table class="w-100 mb-4 border" id="table">

            <thead class="head">
                <tr>
                    <th>اسم المورد</th>
                    <th>البريد الالكتروني</th>
                    {{-- <th> العنوان</th> --}}
                    <th>رقم الهاتف</th>
                    <th>نوع الدفع</th>
                    <th>بواسطه</th>
                    <th> التاريخ</th>
                    {{-- <th>الحاله</th> --}}
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

                @if (count($suppliers) === 0)
                    <tr>
                        <td colspan="7" class="text-center">
                            لا توجد بيانات
                        </td>
                    </tr>
                @endif

                @foreach ($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->email }}</td>
                        {{-- <td class="address">{{ $supplier->address }}</td> --}}
                        <td>{{ $supplier->phone }}</td>
                        <td class="cost">
                            @if ($supplier->payment_type == 'both')
                                الكل
                            @endif
                            @if ($supplier->payment_type == 'cash')
                                كاش
                            @endif
                            @if ($supplier->payment_type == 'deposit')
                                دفعات
                            @endif
                        </td>
                        <td>
                            <div class="up">
                                {{--                            <img src="{{asset('Assets/imgs/Avatar-4.png')}}" alt=""> --}}
                                <span class="fw-bold">{{ $supplier->added_by }}</span>
                            </div>
                        </td>
                        <td>{{ $supplier->updated_at->format('Y/m/d') }}</td>
                        {{-- <td>
                            @if ($supplier->is_active)
                                <span class="live">مفعل</span>
                            @else
                                <span class="died">غير مفعل</span>
                            @endif
                        </td> --}}
                        <td>
                            <div class="edit d-flex align-items-center justify-content-center">
                                <img src="{{ asset('Assets/imgs/edit-circle.png') }}" data-id="{{ $supplier->id }}"
                                    alt="" id="edit">


                                <img class="ms-2 me-2" src="{{ asset('Assets/imgs/trash (1).png') }}"
                                    data-id="{{ $supplier->id }}" alt="" id="trash">

                                <img class="ms-2 me-2 dolar-icon" src="{{ asset('Assets/imgs/dolar.svg') }}"
                                    data-id="{{ $supplier->id }}" alt="" id="dolar">

                            </div>
                        </td>
                        <td class="p-0">
                            <div
                                class="popup-edit  id-{{ $supplier->id }} popup pb-5 close shadow-sm rounded-3 position-fixed">
                                <form id="edit-cate" method="post"
                                    action="{{ route('supplier.update', $supplier->id) }}">
                                    @csrf
                                    @method('put')
                                    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}"
                                        alt="">
                                    <h2 class="text-center mt-4 mb-4 opacity-75">تعديل: {{ $supplier->name }} </h2>
                                    <div class="f-row d-flex gap-4">
                                        <div>
                                            <label class="d-block mb-1" for="category-name">اسم المورد</label>
                                            <input class="category-input" type="text" name="name"
                                                id="category-name" value="{{ $supplier->name }}"
                                                placeholder="اسم المورد">
                                        </div>
                                        <div>
                                            <label class="d-block mb-1" for="phone-number"> رقم الهاتف</label>
                                            <input class="category-input" type="number" minlength="11" name="phone"
                                                id="phone-number" value="{{ $supplier->phone }}"
                                                placeholder="رقم الهاتف">
                                        </div>
                                    </div>
                                    <div class="f-row d-flex gap-4">
                                        <div>
                                            <label class="d-block mb-1" for="buy-price">العنوان</label>
                                            <input class="category-input" type="text" name="address" id="buy-price"
                                                value="{{ $supplier->address }}" placeholder="العنوان">
                                        </div>
                                        <div class="">
                                            <label class="d-block mb-1" for="sale-buy">البريد الالكتروني</label>
                                            <input class="category-input" type="text" name="email" id="sale-buy"
                                                value="{{ $supplier->email }}" placeholder="البريد الالكتروني">
                                        </div>
                                    </div>

                                    <div class="">
                                        <label class="d-block mb-1" for="sale-buy">نوع الدفع</label>
                                        <select class="form-control form-select" id="department" name="payment_type">
                                            <option @if ($supplier->payment_type == 'both') selected @endif value="both">
                                                الكل
                                            </option>
                                            <option @if ($supplier->payment_type == 'cash') selected @endif value="cash">
                                                كاش
                                            </option>
                                            <option @if ($supplier->payment_type == 'deposit') selected @endif value="deposit">دفعات
                                            </option>
                                        </select>
                                    </div>

                                    {{-- <div class="form-check form-switch d-flex align-items-center  ms-2 me-2">
                                        <input class="form-check-input ms-3"
                                            @if ($supplier->is_active) checked @endif type="checkbox"
                                            role="switch" id="flexSwitchCheckDefault-99" name="is_active"
                                            value="1">
                                        <label for="flexSwitchCheckDefault-92">تفعيل</label>
                                    </div> --}}

                                    <div id="invalidEdit" class="invalid invalidEdit my-3"></div>

                                    <button class="main-btn">تحديث</button>
                                </form>
                            </div>

                        </td>

                        <div class="popup-delete id-{{ $supplier->id }} popup close shadow-sm rounded-3 position-fixed">
                            <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
                            <h3 class="fs-5 fw-bold mb-3">حذف المورد</h3>
                            <p>هل تريد الحذف متاكد !!</p>
                            <div class="buttons mt-5 d-flex">
                                <button onclick="fnDelete('{{ $supplier->id }}')" class="agree rounded-2">نعم
                                    أريد</button>
                                <button class="disagree me-3 text-light rounded-2 main-btn">لا أريد</button>
                            </div>
                        </div>

                        <div class="popup-dolar id-{{ $supplier->id }} popup close shadow-sm rounded-3 position-fixed">
                            <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
                            <div class="dolar-container p-5 d-flex flex-column">
                                <div
                                    class="dolar-info d-flex  flex-column justify-content-center  align-items-center gap-3">
                                    <p> <span class="fw-bold"> التكلفة الإجمالية المطلوبة :</span>
                                        <span>{{ number_format($supplier->total_required, 0, ',', ',') }} جنيه</span>
                                    </p>
                                    <p> <span class="fw-bold">التكلفة الإجمالية المدفوعة :</span>
                                        <span>{{ number_format($supplier->total_paid, 0, ',', ',') }} جنيه</span>
                                    </p>
                                    <p> <span class="fw-bold">إجمالي تكلفة المستحقات المتبقيه:</span>
                                        <span>{{ number_format($supplier->total_receivables, 0, ',', ',') }} جنيه</span>
                                    </p>

                                </div>
                                <form action="{{ route('supplier.deposits', $supplier->id) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <div class="buttons mt-5 d-flex justify-content-center">
                                        <div class="elements">
                                            <div id="addDepositsContainer">
                                                <div class="f-row d-flex gap-4 align-items-end deposit-section">
                                                    <div>
                                                        <label class="d-block mb-1" for="deposit-amount">المبلغ</label>
                                                        <input type="text" name="deposits[0][cost]"
                                                            class="deposit-amount form-control" placeholder="المبلغ"
                                                            value="{{ old('deposits.0.cost') }}">
                                                    </div>
                                                    <div>
                                                        <label class="d-block mb-1" for="deposit-date">التاريخ</label>
                                                        <input type="date" name="deposits[0][date]"
                                                            class="deposit-date form-control" placeholder="التاريخ"
                                                            value="{{ old('deposits.0.date') }}">
                                                    </div>
                                                    <button type="button" class="remove-btn p-3" hidden disabled><i
                                                            class="fa-solid fa-trash"></i></button>
                                                    <button type="button" class="check-btn p-3 ">
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <button type="button" class="main-btn p-2 ps-3 pe-3 specialBtn m-0 mt-2 mb-2"
                                                id="addElement">
                                                <svg class="pointer" xmlns="http://www.w3.org/2000/svg" width="26"
                                                    height="27" viewBox="0 0 26 27" fill="none">
                                                    <path d="M13 5.52753V20.6942" stroke="#fff" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M13 5.52753V20.6942" stroke="white" stroke-opacity="0.2"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M5.41663 13.1108H20.5833" stroke="#fff" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M5.41663 13.1108H20.5833" stroke="white" stroke-opacity="0.2"
                                                        stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="submit">
                                        تـأكيد
                                    </button>
                                </form>
                            </div>

                        </div>

                    </tr>
                @endforeach
            </tbody>


        </table>

        <div class="table-control d-flex justify-content-between align-items-center">
            <div class="buttons-div">
                @if ($suppliers->currentPage() != 1)
                    <a href="{{ $suppliers->previousPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">السابق</a>
                @endif

                @for ($i = max(1, $suppliers->currentPage() - 2); $i <= min($suppliers->lastPage(), $suppliers->currentPage() + 2); $i++)
                    <a href="{{ $suppliers->url($i) }}"
                        class="number-pages text-light ms-1 me-1 main-btn {{ $i == $suppliers->currentPage() ? 'bg-primary' : '' }}">{{ $i }}</a>
                @endfor

                @if ($suppliers->currentPage() != $suppliers->lastPage())
                    <a href="{{ $suppliers->nextPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">التالي</a>
                @endif
            </div>

            <div class="info-table opacity-50">
                <p>عرض <span>{{ $suppliers->firstItem() }}</span> إلى <span>{{ $suppliers->lastItem() }}</span>
                    من
                    <span>{{ $suppliers->total() }}</span> مدخلات
                </p>
            </div>
        </div>


    </section>

    @include('pages.suppliers.add')


    <div class="overlay position-fixed none w-100 h-100"></div>

@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/suppliers.js') }}"></script>

    {{-- For Exel --}}
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    {{-- For PDF --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
    </script>

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
            var table = document.getElementById('table');

            var lastColumnCells = table.querySelectorAll('td:last-child, th:last-child');
            lastColumnCells.forEach(function(cell) {
                cell.style.display = 'none';
            });

            var tableCells = table.querySelectorAll('th, td');
            tableCells.forEach(function(cell) {
                cell.style.textAlign = "right";
            });

            html2canvas(table, {
                onrendered: function(canvas) {
                    lastColumnCells.forEach(function(cell) {
                        cell.style.display = '';
                    });

                    tableCells.forEach(function(cell) {
                        cell.style.textAlign = "";
                    });

                    var data = canvas.toDataURL();

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

    <script>
        document.querySelectorAll("table #edit").forEach((edit) => {
            let id = edit.dataset.id;

            edit.addEventListener("click", () => {
                let popUp = document.querySelector(".popup-edit.id-" + id),
                    editForm = popUp.querySelector("#edit-cate"),
                    editInputs = editForm.querySelectorAll(".category-input"),
                    editMessage = editForm.querySelector("#invalidEdit");

                editForm.addEventListener('submit', (event) => {
                    editMessage.textContent = '';
                    let notValid = false;
                    for (let i = 0; i < editInputs.length; i++) {
                        if (editInputs[i].value.trim() === "") {
                            event.preventDefault();
                            const inputName = editInputs[i].getAttribute('placeholder');
                            editMessage.textContent = `الحقل ${inputName} مطلوب`;
                            editInputs[i].focus();
                            notValid = true;
                            if (notValid) {
                                break;
                            }

                        }
                    }
                });
            });
        });
    </script>

    {{-- Validation For Add --}}
    <script>
        const addForm = document.getElementById("add-cate");
        const addInputs = addForm.querySelectorAll(".category-input");
        const addMessage = document.getElementById("invalidAdd");

        addForm.addEventListener('submit', (event) => {
            addMessage.textContent = '';
            let notValid = false;

            for (let i = 0; i < addInputs.length; i++) {
                if (addInputs[i].value.trim() === "") {
                    event.preventDefault();
                    const inputName = addInputs[i].getAttribute('placeholder');
                    addMessage.textContent = `الحقل ${inputName} مطلوب`;
                    addInputs[i].focus();
                    notValid = true;
                    if (notValid) {
                        break;
                    }
                }
            }
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


        function fnDelete(id) {
            // Get the form element
            var form = document.createElement('form');
            form.setAttribute('method', 'POST');
            form.setAttribute('action', `{{ url('supplier') }}/${id}`);
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

    <script>
        document.querySelectorAll("#dolar").forEach((dolar) => {
            let id = dolar.dataset.id;

            dolar.addEventListener("click", (e) => {
                document.querySelector("body").classList.add("overflow-hidden");

                document.querySelector(".overlay").classList.remove("none");

                document.querySelector(".popup-dolar").classList.remove("close");

                document
                    .querySelector(".popup-dolar .agree")
                    .addEventListener("click", () => {


                        fnDelete(id)

                        document
                            .querySelector("body")

                            .classList.remove("overflow-hidden");

                        document.querySelector(".overlay").classList.add("none");

                        document.querySelector(".popup-dolar").classList.add("close");



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
        function addElement() {
            let depositsContainer = document.getElementById('addDepositsContainer');
            let newDepositSection = depositsContainer.querySelector('.deposit-section').cloneNode(true);
            var I = depositsContainer.childElementCount;
            newDepositSection.querySelectorAll('input').forEach(function(input) {
                input.value = '';
                let name = input.name;
                let index = name.match(/\d+/g);
                if (index == null) {
                    return;
                } else {
                    finalName = name.replace(/(\d)+/, I);
                }
                input.setAttribute('name', finalName);
            });

            newDepositSection.querySelector('.remove-btn').removeAttribute('disabled');
            newDepositSection.querySelector('.remove-btn').removeAttribute('hidden');

            depositsContainer.appendChild(newDepositSection);

            initRemoveButtons(); // Initialize remove buttons after adding a new section
        }

        function removeElement(button) {
            let depositsContainer = document.getElementById('addDepositsContainer');

            if (depositsContainer.childElementCount > 1) {
                depositsContainer.removeChild(button.parentNode);
            } else {
                button.setAttribute('disabled', 'disabled');
                button.setAttribute('hidden', 'hidden');
            }
        }

        function initRemoveButtons() {
            document.querySelectorAll('.remove-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    removeElement(button);
                });
            });
        }

        document.getElementById('addElement').addEventListener('click', addElement);

        // Initialize remove buttons on page load
        initRemoveButtons();
    </script>

@endsection
