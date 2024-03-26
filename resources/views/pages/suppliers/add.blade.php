<style>
    #category-name:invalid,
    #phone-number:invalid,
    #buy-price:invalid,
    #sale-buy:invalid {
        border: 1px solid red
    }

    #category-name:valid,
    #phone-number:valid,
    #buy-price:valid,
    #sale-buy:valid {
        border: 1px solid #0075ff
    }
</style>


<div class="popup-add popup pb-5 close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <h2 class="text-center mt-4 mb-4 opacity-75">اضافة مورد جديد</h2>
    <form method="post" action="{{ route('supplier.add') }}">
        @csrf
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="category-name">اسم المورد</label>
                <input class="for-valid" type="text" name="name" id="category-name" placeholder="اسم المورد"
                    title="Please enter a valid name with at least 2 Latin alphabet letters" required>
            </div>
            <div>
                <label class="d-block mb-1" for="phone-number"> رقم الهاتف</label>
                <input class="for-valid" type="number" minlength="11" name="phone" id="phone-number"
                    placeholder="رقم الهاتف" title="Please enter a valid name with at least 2 Latin alphabet letters"
                    required>
            </div>
        </div>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="buy-price">العنوان</label>
                <input class="for-valid" type="text" name="address" id="buy-price" placeholder="العنوان"
                    title="Please enter a valid name with at least 2 Latin alphabet letters" required>
            </div>
            <div class="">
                <label class="d-block mb-1" for="sale-buy">البريد الالكتروني</label>
                <input class="for-valid" type="text" name="email" id="sale-buy" placeholder="البريد الالكتروني "
                    title="Please enter a valid name with at least 2 Latin alphabet letters" required>
            </div>
        </div>


        <div class="select-form">
            <span>نوع الدفع</span>
            <select class="form-control form-select" id="department" name="payment_type">
                <option selected value="both">الكل</option>
                <option value="cash">كاش</option>
                <option value="deposit">دفعات</option>
            </select>

        </div>

        {{-- <div class="form-check form-switch d-flex align-items-center  ms-2 me-2">
            <input name="is_active" value="1" class="form-check-input ms-3" checked type="checkbox" role="switch"
                   id="flexSwitchCheckDefault-90">
            <label for="flexSwitchCheckDefault-90">تفعيل</label>
        </div> --}}
        <button class="main-btn mt-5" type="submit">اضافه</button>
</div>
