<style>
    .invalid {
        color: red;
        font-size: 12px;
        text-align: center;
    }
</style>

<div class="popup-add popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <form id="add-cate" method="post" action="{{ route('eol.add') }}">
        @csrf
        <h2 class="text-center mt-4 mb-4 opacity-75">اضافة هالك</h2>
        <div class="f-row d-flex gap-4">

            <div>
                <label class="d-block"> اختر المنتج</label>
                <select class="js-example-basic-single add" name="product_id">
                    <option value="" {{ request('product') ? 'disabled hidden' : 'selected disabled hidden' }}>
                        اختر المنتج
                    </option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" {{ request('product') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="d-block mb-1" for="category">الكميه</label>
                <input class="category-input" type="number" name="quantity" id="category" placeholder="الكمية">
            </div>
        </div>
        <div>
            <span class="d-block mb-1">سبب الهالك</span>
            <textarea class="category-input" name="reason" id="textarea" cols="30" rows="10" placeholder="سبب الهالك"></textarea>
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
