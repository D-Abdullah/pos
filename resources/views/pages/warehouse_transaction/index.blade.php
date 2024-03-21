@extends('layouts.app')

@section('title', 'تحويلات المستودع')

@section('styles')
    <link rel="stylesheet" href="{{ asset('Assets/Css files/transaction.css') }}">
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
        justify-content: space-between;
        border: 1px solid #eee
    }

    .select-btn i {
        font-size: 14px;
        transition: transform 0.3s linear;
    }

    .wrapper.active .select-btn i {
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

    .wrapper.active .content {
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
@section('content')
    <h2 class="mt-5 mb-5">معاملات المستودع</h2>
    <!-- start of body -->
    <section class="pt-0 rounded-3 position-relative shadow-sm overflow-auto">

        <div class="features shadow-sm p-4 d-flex justify-content-between align-items-center">
            <div class="component-right gap-4 d-flex align-items-center">
                <div class="search-input">
                    <input type="search" placeholder="بحث" id="search">
                </div>
                <div class="wrapper">
                    <div class="select-btn">
                        <span>Select</span>

                        <img src="{{ asset('Assets/imgs/chevron-down.png') }}" alt="">
                    </div>
                    <div class="content">
                        <div class="search">
                            <i class="uil uil-search"></i>
                            <input spellcheck="false" name="categoryDropdownQuery" type="text" placeholder="بحث">
                        </div>
                        <ul class="options"></ul>
                    </div>
                </div>
                <button type="submit" class="main-btn" id="form">تأكيد</button>
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
                @foreach ($wts as $wt)
                    <tr>
                        <td>{{ $wt->product_id }}</td>
                        <td>{{ $wt->quantity }}</td>
                        <td>{{ $wt->from }}</td>
                        <td>{{ $wt->to }}</td>
                        <td>{{ $wt->date }}</td>
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

    {{-- For Drobdown input --}}
    <script>
        const wrapper = document.querySelector(".wrapper"),
            selectBtn = wrapper.querySelector(".select-btn"),
            searchInp = wrapper.querySelector("input"),
            options = wrapper.querySelector(".options");

        let countries = ["Afghanistan", "Algeria", "Argentina"];

        function addCountry(selectedCountry) {
            options.innerHTML = "";
            countries.forEach(country => {
                let isSelected = country == selectedCountry ? "selected" : "";
                let li = `<li onclick="updateName(this)" class="${isSelected}">${country}</li>`;
                options.insertAdjacentHTML("beforeend", li);
            });
        }
        addCountry();

        function updateName(selectedLi) {
            searchInp.value = "";
            addCountry(selectedLi.innerText);
            wrapper.classList.remove("active");
            selectBtn.firstElementChild.innerText = selectedLi.innerText;
        }

        searchInp.addEventListener("keyup", () => {
            let arr = [];
            let searchWord = searchInp.value.toLowerCase();
            arr = countries.filter(data => {
                return data.toLowerCase().startsWith(searchWord);
            }).map(data => {
                let isSelected = data == selectBtn.firstElementChild.innerText ? "selected" : "";
                return `<li onclick="updateName(this)" class="${isSelected}">${data}</li>`;
            }).join("");
            options.innerHTML = arr ? arr : `<p style="margin-top: 10px;">Oops! not found</p>`;
        });

        selectBtn.addEventListener("click", () => wrapper.classList.toggle("active"));
    </script>
    {{-- Print and Pdf and Excel  --}}
    <script>
        // Start Print Table
        // Start Print Table
        function printTable() {
            var el = document.getElementById("table");
            el.setAttribute('border', '1');
            el.setAttribute('cellpadding', '5');

            // Remove last column from the table
            var rows = el.rows;
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].cells;
                if (cells.length > 0) {
                    var lastCellIndex = cells.length - 1;
                    rows[i].deleteCell(lastCellIndex);
                }
            }

            var newPrint = window.open("");
            newPrint.document.write(el.outerHTML);
            newPrint.print();
            newPrint.close();
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

            // Render the modified table to canvas
            html2canvas(table, {
                onrendered: function(canvas) {
                    // Restore the visibility of the last column
                    lastColumnCells.forEach(function(cell) {
                        cell.style.display = '';
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
@endsection
