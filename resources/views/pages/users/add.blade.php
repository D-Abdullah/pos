<div class="popup-add popup pb-5 close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <h2 class="text-center mt-4 mb-4 opacity-75">اضافة مستخدم جديد</h2>
    <form method="post" action="{{ route('user.add') }}" id="add-cate">
        @csrf

        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="user-name">اسم المستخدم</label>
                <input type="text" name="name" id="user-name" placeholder="ادخل اسم المستخدم"
                    class="category-input" value="{{ old('name') }}"
                    class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                @if ($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div>
                <label class="d-block mb-1" for="gmail">البريد الالكتروني</label>
                <input type="email" name="email" id="gmail" placeholder="ادخل البريد الاكتروني"
                    class="category-input" value="{{ old('email') }}"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="f-row d-flex gap-4 align-items-end">
            <div>
                <label class="d-block mb-1" for="phone">رقم الهاتف</label>
                <input type="number" name="phone" id="phone" maxlength="11" placeholder="ادخل رقم الهاتف"
                    class="category-input" value="{{ old('phone') }}"
                    class="{{ $errors->has('phone') ? 'is-invalid' : '' }}">
                @if ($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
            </div>

            <div class="select-form">
                <label class="d-block mb-1" for="role">الصلاحيه</label>
                <select name="role" id="role"
                    class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }}">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('role'))
                    <div class="invalid-feedback">
                        {{ $errors->first('role') }}
                    </div>
                @endif
            </div>
        </div>
        <div id="invalidAdd" class="invalid invalidAdd my-3"></div>

        <button class="main-btn mt-5">اضافه</button>
    </form>
</div>
