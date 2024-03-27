<style>
    .check-box {
        width: fit-content !important;
    }
</style>
<!-- start of popup -->
<div class="popup-add overflow-auto popup close shadow-sm rounded-3 position-fixed">
    <img class="position-absolute" src="{{ asset('Assets/imgs/Close.png') }}" alt="">
    <form id="add-cate" action="{{ route('role.add') }}" method="post">
        @csrf
        <h2 class="text-center mt-4 mb-4 opacity-75">اضافة وظيفة جديدة</h2>
        <div class="flex-column d-flex gap-4">
            <div>
                <label class="d-block mb-1" for="role-name">الاسم</label>
                <input class="category-input" type="text" name="name" id="role-name"
                    placeholder="ادخل اسم الصلاحية" value="{{ old('name') }}"
                    class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                @if ($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            {{-- <div>
                <label class="d-block mb-1" for="role-permissions">الصلاحيات</label>
                <select name="permissions[]" id="role-permissions" multiple
                    class="form-control {{ $errors->has('permissions') ? 'is-invalid' : '' }}">
                    @foreach ($permissions as $permission)
                        <option value="{{ $permission['org'] }}"
                            {{ in_array($permission['name'], (array) old('permissions')) ? 'selected' : '' }}>
                            {{ $permission['name'] }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('permissions'))
                    <div class="invalid-feedback">
                        {{ $errors->first('permissions') }}
                    </div>
                @endif
            </div> --}}
            <div class="d-flex gap-3 flex-wrap">
                @foreach ($permissions as $permission)
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input  check-box" type="checkbox" value="{{ $permission['org'] }}"
                            id="flexCheckDefault"
                            {{ in_array($permission['name'], (array) old('permissions')) ? 'selected' : '' }}>
                        <label class="form-check-label px-3 d-block" for="flexCheckDefault">
                            {{ $permission['name'] }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div id="invalidAdd" class="invalid my-3"></div>

        <button class="main-btn mt-3" type="submit">اضافة</button>
    </form>
</div>
<!-- end of popup -->
