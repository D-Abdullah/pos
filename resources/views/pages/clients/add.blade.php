<style>
    #customer-name:invalid,
    #category:invalid {
        border: 1px solid red
    }

    #customer-name:valid,
    #category:valid {
        border: 1px solid #0075ff
    }
</style>

<div class="popup-add popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <form method="post" action="{{ route('client.add') }}">
        @csrf
        <h2 class="text-center mt-4 mb-4 opacity-75">اضافة عميل جديد</h2>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="customer-name">اسم العميل</label>
                <input type="text" name="name" id="customer-name" placeholder="اسم العميل"
                    pattern="[a-zA-Z\u0600-\u06FF]{2,}"
                    title="Please enter a valid name with at least 2 Latin alphabet letters" required>
            </div>
            <div>
                <label class="d-block mb-1" for="category">رقم الهاتف</label>
                <input type="number" minlength="11" name="phone" id="category" placeholder="رقم الهاتف"
                    pattern="[a-zA-Z\u0600-\u06FF]{2,}"
                    title="Please enter a valid name with at least 2 Latin alphabet letters" required>
            </div>
        </div>
        {{-- <div class="form-check form-switch d-flex align-items-center  ms-2 me-2">
        <input name="is_active" value="1" class="form-check-input ms-3" checked type="checkbox" role="switch" id="flexSwitchCheckDefault-90">
        <label for="flexSwitchCheckDefault-90">تفعيل</label>
    </div> --}}
        <button class="main-btn mt-5">اضافه</button>
    </form>
</div>
