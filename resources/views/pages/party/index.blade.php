@extends('layouts.app')

@section('title', 'الحفلات')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/concerts.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .dateInp,
        .search-input,
        .search-div {
            max-width: 180px;
            min-width: 180px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 0;
            outline: none;
            border: 1px solid #ddd;
            height: 30px !important;

        }

        .select2-container--default .select2-selection--single {
            height: 45px !important;
            border: 1px solid #ddd;
        }

        .select2-container[dir="rtl"] .select2-selection--single .select2-selection__rendered {
            padding-top: 7px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 0px !important;
            top: 50% !important;
        }

        .js-example-basic-single.client {
            min-width: 160px;
        }

        .js-example-basic-single.the-state {
            min-width: 120px;
        }
    </style>
@endsection

@section('content')
    <h2 class="mt-5 mb-5">الحفلات</h2>
    <!-- start of body -->

    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto">

        <div class="features shadow-sm p-4 d-flex justify-content-between align-items-end">

            <div class="component-right gap-4 d-flex align-items-end">
                <div class="add-concert">
                    <a href="{{ route('party.add') }}">
                        <button class="text-light main-btn concert"> اضافه حفله</button>
                    </a>
                </div>

                <div class="search-div">
                    <label for="search">ابحث بالاسم:</label>
                    <input type="text" id="search" name="q" value="{{ request('q') }}"
                        placeholder="ابحث بالاسم ">
                </div>


                <div>
                    <label for="client" class="d-block">اختر العميل</label>
                    <select class="js-example-basic-single client" name="client_id" id="client">
                        <option value="" {{ request('client') ? 'disabled hidden' : 'selected disabled hidden' }}>
                            اختر العميل
                        </option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ request('client') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
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
                    <button onclick="dropdown('valueStatus', 'listStatus')">
                        <span class="fw-bold opacity-50 valueDropdown" id="valueStatus">الحاله</span>
                        <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">
                    </button>
                    <div class="options none">
                        <ul id="listStatus">
                            <li class="p-0" id="search">
                                <input class="search" type="search" placeholder="بحث">
                            </li>
                            <li class="active">متعاقد</li>
                            <li>منقول</li>
                            <li>منتهي</li>
                        </ul>
                    </div>
                </div> --}}

                <div class="w-100">
                    <select class="js-example-basic-single the-state" id="">
                        <option disabled selected>
                            الحاله
                        </option>

                        <option value="">متعاقد</option>
                        <option value="">منقول</option>
                        <option value="">منتهي</option>
                    </select>
                </div>

                <button class="main-btn" id="form">تأكيد</button>

            </div>

            <div class="component-left me-3 gap-4 d-flex align-items-center">

                <div class="select-btn border-0 p-0 select position-relative rounded-3 d-flex align-items-center">
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
        <table class="w-100 mb-4 border" id="table">

            <thead class="head">
                <tr>
                    <th>العميل</th>
                    <th>اسم الحفله</th>
                    <th>العنوان</th>
                    <th>التاريخ</th>
                    <th>بواسطه</th>
                    <th>الحاله</th>
                    <th>اجمالي الفاتوره</th>
                    {{-- <th>التفاصيل</th> --}}
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

                @if (count($parties) === 0)
                    <tr>
                        <td colspan="7" class="text-center">
                            لا توجد بيانات
                        </td>
                    </tr>
                @endif


                @foreach ($parties as $party)
                    <tr>
                        <td><i class="fas fa-dot-circle" style="color: {{ $party->readyBill ? 'green' : 'red' }};"></i>
                            {{ $party->client->name }}</td>
                        <td>{{ $party->name }}</td>
                        <td>{{ $party->address }}</td>
                        <td>{{ $party->date }}</td>
                        <td>{{ $party->added_by }}</td>
                        <td>
                            <span class="contracting">
                                @if ($party->status === 'contracted')
                                    متعاقد
                                @elseif ($party->status === 'transported')
                                    منقول
                                @elseif ($party->status === 'completed')
                                    منتهي
                                @else
                                    غير معرف
                                @endif
                            </span>
                        </td>
                        <td>{{ number_format($party->total_price, 2) }}</td>
                        <td>
                            <div class="edit d-flex align-items-center justify-content-center">
                                <a href="{{ route('party.edit', $party->id) }}"
                                    class="ms-2 me-2 {{ $party->status === 'completed' ? 'd-none' : '' }}">
                                    <img src="{{ asset('Assets/imgs/edit-circle.png') }}" alt="">
                                </a>

                                <img class="ms-2 me-2 {{ $party->status === 'completed' || $party->status === 'transported' ? 'd-none' : '' }}"
                                    src="{{ asset('Assets/imgs/trash (1).png') }}" data-id="{{ $party->id }}"
                                    alt="" id="trash">

                                <a onclick="confirmComplete('{{ route('party.complete', $party->id) }}')" href="#"
                                    class="ms-2 me-2"
                                    style="display: {{ $party->status !== 'completed' && $party->readyBill ? 'inline-block' : 'none' }};color: #6f6b7d;font-size: 20px;"><i
                                        class="fa-solid fa-check"></i></a>
                                @if ($party->status === 'completed')
                                    <p style="font-weight: 900; font-size: 20px; color: #090">منتهي</p>
                                @endif
                            </div>
                        </td>
                        <td class="p-0">
                            <div
                                class="popup-delete id-{{ $party->id }} popup close shadow-sm rounded-3 position-fixed">
                                <img class="position-absolute normal-dismiss" src="{{ asset('Assets/imgs/Close.png') }}"
                                    alt="">
                                <h3 class="fs-5 fw-bold mb-3">حذف الحفله</h3>
                                <p>هل تريد الحذف متاكد !!</p>
                                <div class="buttons mt-5 d-flex">
                                    <button class="agree rounded-2">نعم
                                        أريد</button>

                                    <button class="disagree me-3 text-light rounded-2 main-btn">لا أريد</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

        <div class="table-control d-flex justify-content-between align-items-center">
            <div class="buttons-div">
                @if ($parties->currentPage() != 1)
                    <a href="{{ $parties->previousPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">السابق</a>
                @endif

                @for ($i = max(1, $parties->currentPage() - 2); $i <= min($parties->lastPage(), $parties->currentPage() + 2); $i++)
                    <a href="{{ $parties->url($i) }}"
                        class="number-pages text-light ms-1 me-1 main-btn {{ $i == $parties->currentPage() ? 'bg-primary' : '' }}">{{ $i }}</a>
                @endfor

                @if ($parties->currentPage() != $parties->lastPage())
                    <a href="{{ $parties->nextPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">التالي</a>
                @endif
            </div>

            <div class="info-table opacity-50">
                <p>عرض <span>{{ $parties->firstItem() }}</span> إلى <span>{{ $parties->lastItem() }}</span>
                    من
                    <span>{{ $parties->total() }}</span> مدخلات
                </p>
            </div>
        </div>

    </section>

    <div class="overlay position-absolute none w-100 h-100"></div>
@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/concerts.js') }}"></script>
    {{-- <script src="{{ asset('Assets/JS files/dropdown.js"') }}"></script> --}}

    {{-- For Exel --}}
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    {{-- For PDF --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
    </script>
    {{-- For JQuery --}}
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




    {{-- Print and Pdf and Excel  --}}
    <script>
        function fnDelete(id) {
            // Get the form element
            var form = document.createElement('form');
            form.setAttribute('method', 'POST');
            form.setAttribute('action', `{{ url('party') }}/delete/${id}`);
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





    {{-- For Select JQuery  --}}
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
        $(document).ready(function() {
            $('.js-example-basic-single.the-state').select2();
        });
    </script>

    <script>
        function confirmComplete(url) {
            if (confirm('هل انت متأكد من انهاء هذه الحفله')) {
                // redirect to the get url from the parameter
                window.location.href = url;
            }
        }
    </script>

@endsection
