<!-- start of menu -->
<div class="menu">

    <div class="logo d-flex pe-4 justify-content-start align-items-center">
        <img class="logoImg-2" src="{{ asset('Assets/imgs/vuexy-logo.png') }}" alt="">
        <div class="frame-1 me-3 d-flex align-items-center">
            <span>{{config('app.name')}}</span>
            <button class="main-btn p-1 ps-3 pe-3 d-flex me-3 d-none">
                <i class="fa-solid fa-arrow-right fs-5"></i>
            </button>
        </div>
    </div>

    <div class="apps-pages">

        @role('super_admin')
        <div class="list {{ Request::is('dashboard') ? "active" : "" }} statistics d-flex align-items-center">
            <img class="dark" src="{{ asset('Assets/imgs/home.png') }}" alt="">
            <img class="none" src="{{ asset('Assets/imgs/home-light.png') }}" alt="">
            <a class="m-0" href="{{route('dashboard')}}">الاحصائيات</a>
        </div>
        @endrole

        @can('read department')
            <div
                class="list {{ Request::is('department/all') ? "active" : "" }} categories d-flex justify-content-between align-items-center">
                <img class="dark" src="{{ asset('Assets/imgs/checkup-list.png') }}" alt="">
                <img class="none" src="{{ asset('Assets/imgs/checkup-list-light.png') }}" alt="">
                <a href="{{route('department.all')}}" class="m-0">الاقسام</a>
            </div>
        @endcan
        @can('read product')
            <div
                class="list {{ Request::is('product/all') ? "active" : "" }} products d-flex justify-content-between align-items-center">
                <img class="dark" src="{{ asset('Assets/imgs/box.png') }}" alt="">
                <img class="none" src="{{ asset('Assets/imgs/box-light.png') }}" alt="">
                <a class="mb-0" href="{{route('product.all')}}">المنتجات</a>
            </div>
        @endcan
        @can('read supplier')
            <div
                class="list {{ Request::is('supplier/all') ? "active" : "" }} suppliers d-flex justify-content-between align-items-center">
                <img class="dark" src="{{ asset('Assets/imgs/tir.png') }}" alt="">
                <img class="none" src="{{ asset('Assets/imgs/tir-light.png') }}" alt="">
                <a class="mb-0" href="{{route('supplier.all')}}">الموردين</a>
            </div>
        @endcan
        @can('read purchase')
            <div
                class="list {{ Request::is('purchase/all') ? "active" : "" }} purchases d-flex justify-content-between align-items-center">
                <img class="dark" src="{{ asset('Assets/imgs/file-check.png') }}" alt="">
                <img class="none" src="{{ asset('Assets/imgs/file-check-light.png') }}" alt="">
                <a class="mb-0" href="{{route('purchase.all')}}">المشتريات</a>
            </div>
        @endcan

        <div class="list warehouse d-flex justify-content-between align-items-center">
            <img class="dark" src="{{ asset('Assets/imgs/building-bank.png') }}" alt="">
            <img class="none" src="{{ asset('Assets/imgs/building-warehouse-light.png') }}" alt="">
            <a class="mb-0" href="{{route('warehouse.all')}}">المخزن</a>
        </div>


        <div class="list {{ Request::is('warehouse-transaction/all') ? "active" : "" }} transaction d-flex justify-content-between align-items-center">
            <img class="dark" src="{{ asset('Assets/imgs/switch-horizontal.png') }}" alt="">
            <img class="none" src="{{ asset('Assets/imgs/switch-horizontal-light.png') }}" alt="">
            <a class="mb-0" href="{{route('warehouse-transaction.all')}}">معاملات المخزن </a>
        </div>

        @can('read client')
        <div class="list {{ Request::is('client/all') ? "active" : "" }} customers d-flex justify-content-between align-items-center">
            <img class="dark" src="{{ asset('Assets/imgs/users.png') }}" alt="">
            <img class="none" src="{{ asset('Assets/imgs/users-light.png') }}" alt="">
            <a class="mb-0" href="{{route('client.all')}}">العملاء</a>
        </div>
        @endcan
        @can('read damaged')
        <div class="list {{ Request::is('eol/all') ? "active" : "" }} perished d-flex justify-content-between align-items-center">
            <img class="dark" src="{{ asset('Assets/imgs/trash-x.png') }}" alt="">
            <img class="none" src="{{ asset('Assets/imgs/trash-x-light.png') }}" alt="">
            <a class="mb-0" href="{{route('eol.all')}}">الهالك</a>
        </div>
        @endcan
        @can('read user')
        <div class="list  {{ Request::is('user/all') ? "active" : "" }} data-users d-flex justify-content-between align-items-center">
            <img class="dark" src="{{ asset('Assets/imgs/User Info.png') }}" alt="">
            <img class="none" src="{{ asset('Assets/imgs/User Info-light.png') }}" alt="">
            <a class="mb-0" href="{{route('user.all')}}">اعضاء الاداره</a>
        </div>
        @endcan

        @can('read role')
        <div class="list  {{ Request::is('role/all') ? "active" : "" }} jobs d-flex justify-content-between align-items-center">
            <img class="dark" src="{{ asset('Assets/imgs/git-compare.png') }}" alt="">
            <img class="none" src="{{ asset('Assets/imgs/git-compare-light.png') }}" alt="">
            <a class="mb-0" href="{{route('role.all')}}">الصلاحيات</a>
        </div>
        @endcan

        @can('read rent')
        <div class="list  {{ Request::is('rent/all') ? "active" : "" }} rent d-flex justify-content-between align-items-center">
            <img class="dark" src="{{ asset('Assets/imgs/arrows-horizontal.png') }}" alt="">
            <img class="none" src="{{ asset('Assets/imgs/arrows-horizontal-light.png') }}" alt="">
            <a class="mb-0" href="{{route('rent.all')}}">الايجار</a>
        </div>
        @endcan
        @can('read party')
        <div class="list  {{ Request::is('party/all') ? "active" : "" }}  concerts d-flex justify-content-between align-items-center">
            <img class="dark" src="{{ asset('Assets/imgs/gift.png') }}" alt="">
            <img class="none" src="{{ asset('Assets/imgs/gift-light.png') }}" alt="">
            <a class="mb-0"  href="{{route('party.all')}}"> الحفلات</a>
        </div>
        @endcan
        <div class="list reports d-flex justify-content-between align-items-center">
            <img class="dark" src="{{ asset('Assets/imgs/report-analytics.png') }}" alt="">
            <!-- <img class="none" src="{{ asset('Assets/imgs/report-analytics-light.png') }}" alt=""> -->
            <a class="mb-0" href="{{route('report.all')}}"> التقارير</a>
        </div>
    </div>
</div>
<!-- end of menu -->
