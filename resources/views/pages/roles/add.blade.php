<!-- start of popup -->
<div class="popup-add popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <form action="{{ route('role.add') }}" method="post">
        @csrf
        <h2 class="text-center mt-4 mb-4 opacity-75">اضافة وظيفة جديدة</h2>
        <div class="f-row d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="role-name">الاسم</label>
                <input
                    type="text"
                    name="name"
                    id="role-name"
                    placeholder="ادخل اسم الصلاحية"
                    value="{{ old('name') }}"
                    class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                >
                @if ($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div>
                <label class="d-block mb-1" for="role-permissions">الصلاحيات</label>
                <select
                    name="permissions[]"
                    id="role-permissions"
                    multiple
                    class="form-control {{ $errors->has('permissions') ? 'is-invalid' : '' }}"
                >
                    @foreach($permissions as $permission)
                        <option value="{{ $permission['org'] }}" {{ in_array($permission['name'], (array)old('permissions')) ? 'selected' : '' }}>
                            {{ $permission['name'] }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('permissions'))
                    <div class="invalid-feedback">
                        {{ $errors->first('permissions') }}
                    </div>
                @endif
            </div>
        </div>
        <button class="main-btn mt-3" type="submit">اضافة</button>
    </form>
</div>
<!-- end of popup -->
