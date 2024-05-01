<div class="popup-add popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute normal-dismiss" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <form id="add-cate" method="post" action="{{ route('safe.add') }}">
        @csrf
        <h2 class="text-center mt-4 mb-4 opacity-75">اضافة خزنه جديد</h2>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="customer-name">اسم الخزنه</label>
                <input class="category-input" type="text" name="name" id="customer-name" placeholder="اسم الخزنه">
            </div>
        </div>
        {{-- <div class="form-check form-switch d-flex align-items-center  ms-2 me-2">
        <input name="is_active" value="1" class="form-check-input ms-3" checked type="checkbox" role="switch" id="flexSwitchCheckDefault-90">
        <label for="flexSwitchCheckDefault-90">تفعيل</label>
    </div> --}}
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
