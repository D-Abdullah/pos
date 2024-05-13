@extends('layouts.app')

@section('title', ' المخزن')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/warehouse.css') }}">


@endsection
@section('content')

    <!-- start of buttons -->
    <div class="mt-5 mb-5 special ">
        <a href="{{ url()->current() }}?type=all"
            class="btn border-0 p-2 ps-4 pe-4 secound-btn {{ request('type') == 'all' ? 'active-btn' : '' }} mb-2">
            @if (request('type') == 'all')
                <img class="light" src="{{ asset('Assets/imgs/box-light.png') }}" alt="">
            @else
                <img class="dark" src="{{ asset('Assets/imgs/box.png') }}">
            @endif
            اجمالي
        </a>
        <a href="{{ url()->current() }}?type=current"
            class="btn border-0 p-2 ps-4 pe-4 ms-2 me-2 secound-btn {{ request('type') == 'current' ? 'active-btn' : '' }} mb-2">
            @if (request('type') == 'current')
                <img class="light" src="{{ asset('Assets/imgs/file-check-light.png') }}" alt="">
            @else
                <img class="dark" src="{{ asset('Assets/imgs/file-check.png') }}" alt="">
            @endif
            الفعليه
        </a>
        <a href="{{ url()->current() }}?type=party"
            class="btn border-0 p-2 ps-4 pe-4 secound-btn {{ request('type') == 'party' ? 'active-btn' : '' }} mb-2">
            @if (request('type') == 'party')
                <img class="light" src="{{ asset('Assets/imgs/file-import-light.png') }}" alt="">
            @else
                <img class="dark" src="{{ asset('Assets/imgs/file-import.png') }}" alt="">
            @endif
            عهده
        </a>
    </div>
    <!-- end of buttons -->

    <h2 class="mb-5">المخزن</h2>


    <div class="component-left me-3 d-flex align-items-center justify-content-end mb-2">

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
    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto">


        <table class="w-100 mb-4 border" id="table">
            <thead class="head">
                <tr>
                    <th>اسم المنتج</th>
                    <th>القسم</th>
                    <th>الكميه</th>
                </tr>
            </thead>

            <tbody>
                @if (count($wts) === 0)
                    <tr>
                        <td colspan="3" class="text-center">
                            لا توجد بيانات
                        </td>
                    </tr>
                @endif
                @foreach ($wts as $wt)
                    <tr>
                        <td>{{ $wt->name }}</td>
                        @if ($wt->department)
                            <td>{{ $wt->department->name }}</td>
                        @else
                            <td class="text-danger fw-bold">لم يتم التحديد</td>
                        @endif
                        <td>
                            {{ request('type') == 'party' ? $wt->party_qty : $wt->quantity }}
                        </td>
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

@endsection

@section('script')
    <script src="{{ asset('Assets/JS files/warehouse.js') }}"></script>
    {{-- For Exel --}}
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    {{-- For PDF --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
    </script>

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
            var table = document.getElementById('table');

            var lastColumnCells = table.querySelectorAll('td:last-child, th:last-child');


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

@endsection
