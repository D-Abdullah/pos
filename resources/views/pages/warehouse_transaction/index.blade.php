@extends('layouts.app')

@section('title', 'تحويلات المستودع')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/transaction.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .dateInp,
        .search-input,
        .search-div {
            max-width: 180px;
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

        .select2-container {
            width: 280px !important;
        }
    </style>
@endsection

@section('content')
    <h2 class="mt-5 mb-5">معاملات المستودع</h2>
    <!-- start of body -->
    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto">

        <div class="features shadow-sm p-4 d-flex justify-content-between align-items-end">
            <div class="component-right gap-4 d-flex align-items-end">
                <form action="{{ url()->current() }}" method="GET" class="gap-4 d-flex align-items-end mb-0">

                    <div>

                        <label class="d-block">اختر المنتج</label>
                        <select class="js-example-basic-single" name="product">

                            <option value=""
                                {{ request('product') ? 'disabled hidden' : 'selected disabled hidden' }}>
                                اختر المنتج
                            </option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ request('product') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="search-input">
                        <label class="d-block">من</label>
                        <input type="search" name="from" value="{{ request('from') }}" placeholder="بحث">
                    </div>
                    <div class="search-input">
                        <label class="d-block">الى</label>
                        <input type="search" name="to" value="{{ request('to') }}" placeholder="بحث">
                    </div>
                    <div>
                        <label for="startDate">من تاريخ:</label>
                        <input type="date" id="startDate" name="date_from" value="{{ request('date_from') }}">
                    </div>

                    <!-- Filter by Date To -->
                    <div>
                        <label for="date_to">إلى تاريخ:</label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>

                    <button type="submit" class="main-btn" id="form">تأكيد</button>
                </form>
            </div>
            <div class="component-left me-3 gap-4 d-flex align-items-center">
                <div class="select-btn select position-relative rounded-3 d-flex align-items-center">
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
                    <th>اسم المنتج</th>
                    <th>الكميه</th>
                    <th>من</th>
                    <th>الي</th>
                    <th>التاريخ</th>
                </tr>
            </thead>

            <tbody>
                @if (count($wts) === 0)
                    <tr>
                        <td colspan="5" class="text-center">
                            لا توجد بيانات
                        </td>
                    </tr>
                @endif
                @foreach ($wts as $wt)
                    <tr>
                        <td>{{ $wt->product->name }}</td>
                        <td>{{ $wt->quantity }}</td>
                        <td>{{ $wt->from }}</td>
                        <td>{{ $wt->to }}</td>
                        <td> {{ $wt->updated_at->format('Y/m/d') }}</td>
                    </tr>
                @endforeach

            </tbody>


        </table>

        <div class="table-control d-flex justify-content-between align-items-center">
            <div class="buttons-div">
                @if ($wts->currentPage() != 1)
                    <a href="{{ $wts->previousPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">السابق</a>
                @endif

                @for ($i = max(1, $wts->currentPage() - 2); $i <= min($wts->lastPage(), $wts->currentPage() + 2); $i++)
                    <a href="{{ $wts->url($i) }}"
                        class="number-pages text-light ms-1 me-1 main-btn {{ $i == $wts->currentPage() ? 'bg-primary' : '' }}">{{ $i }}</a>
                @endfor

                @if ($wts->currentPage() != $wts->lastPage())
                    <a href="{{ $wts->nextPageUrl() }}" class="p-2 rounded-3 bg-primary text-white">التالي</a>
                @endif
            </div>

            <div class="info-table opacity-50">
                <p>عرض <span>{{ $wts->firstItem() }}</span> إلى <span>{{ $wts->lastItem() }}</span>
                    من
                    <span>{{ $wts->total() }}</span> مدخلات
                </p>
            </div>
        </div>

    </section>
    <!-- end of body -->

@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/transaction.js') }}"></script>


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
        function printTable() {
            // Clone the table
            var myTable = document.getElementById("table").cloneNode(true);
            myTable.setAttribute('border', '1');
            myTable.setAttribute('cellpadding', '5');


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



            // Apply text alignment style to <th> and <td> elements inside the table
            var tableCells = table.querySelectorAll('th, td');
            tableCells.forEach(function(cell) {
                cell.style.textAlign = "right";
            });

            // Render the modified table to canvas
            html2canvas(table, {
                onrendered: function(canvas) {


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
    </script>
@endsection
