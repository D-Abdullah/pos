<div class="popup-add popup close shadow-sm rounded-3 position-fixed overflow-y-auto overflow-x-hidden">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <form id="add-cate" method="post" action="{{ route('ft.add') }}">
        @csrf
        <h2 class="text-center mt-4 mb-4 opacity-75">اضافة معامله ماليه جديده</h2>
        <div class="d-flex">
            <label class="d-block mb-1"><b>النوع: </b></label>
            <div class="text-center w-100 d-flex justify-content-around">
                <div>
                    <input style="height: 20px!important; width: 20px!important" class="category-input" type="radio"
                        value="income" name="type" id="income" checked>
                    <label for="income">
                        <b style="color: #080">دخل</b>
                    </label>
                </div>
                <div>
                    <input style="height: 20px!important; width: 20px!important" class="category-input" type="radio"
                        value="expense" name="type" id="expense">
                    <label for="expense">
                        <b style="color: #f00">مصروف</b>
                    </label>
                </div>
            </div>
        </div>
        <div class="f-row d-flex mt-2">
            <div>
                <label class="d-block mb-1" for="description">الوصف</label>
                <input dir="rtl" class="category-input" style="direction: rtl" type="text" name="description"
                    id="description" placeholder="الوصف">
            </div>
        </div>
        <div class="f-row d-flex mt-2">
            <div>
                <label class="d-block mb-1" for="amount">القيمه</label>
                <input dir="rtl" class="category-input" style="direction: rtl" type="number" name="amount"
                    id="amount" placeholder="القيمه">
            </div>
        </div>
        <div class="f-row d-flex mt-2">
            <div>
                <div class="">
                    <label for="ftType" class="d-block">نوع المعامله الماليه</label>
                    <select class="js-example-basic-single add type" name="financial_transaction_type_id"
                        id="ftType">
                        <option value="" selected disabled hidden>نوع المعامله الماليه
                        </option>
                        @foreach ($ftTypes as $ft)
                            <option value="{{ $ft->id }}">{{ $ft->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <div class="f-row d-flex mt-2">
            <div>
                <div class="">
                    <label for="from" class="d-block">من / الى</label>
                    <select class="js-example-basic-single add from" name="from" id="from">
                        <option selected disabled hidden>من / الى</option>
                        <option value="safe">الخزنه</option>
                        <option value="custody">عهده موظف</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="f-row d-flex">
            <div>
                <div class="" id="custodyContainer" style="display: none">
                    <label for="employee" class="d-block">اسم الموظف</label>
                    <select class="js-example-basic-single add employee" name="employee_id" id="employee">
                        <option value="" selected disabled hidden>اختر الموظف
                        </option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="f-row d-flex">
            <div>
                <div class="" id="safeContainer" style="display: none">
                    <label for="safe" class="d-block">اسم الخزنه</label>
                    <select class="js-example-basic-single add safe" name="safe_id" id="safe">
                        <option value="" selected disabled hidden>اختر الخزنه
                        </option>
                        @foreach ($safes as $safe)
                            <option value="{{ $safe->id }}">{{ $safe->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="f-row d-flex mt-2">
            <div>
                <div class="">
                    <label for="party" class="d-block">الحفله (اختياري)</label>
                    <select class="js-example-basic-single add party" name="party_id" id="party">
                        <option value="" selected disabled hidden>الحفله (اختياري)
                        </option>
                        @foreach ($parties as $party)
                            <option value="{{ $party->id }}">{{ $party->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div id="invalidAdd" class="invalid invalidAdd my-3"></div>
        <button class="main-btn mt-5">اضافه</button>
    </form>
</div>

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
                if (addInputs[i].name == 'party_id') {
                    continue;
                }
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
