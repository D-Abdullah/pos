<!doctype html>
<html lang="ar" dir="rtl">

@include('includes.head')

<body>

<div class="page position-relative">

    <!-- start of vertical-menu -->
    <div class="vertical-menu gap-5 d-flex ps-5">

        @include('includes.sidebar')

        <!-- start of main-container -->
        <div class="main-container pt-4 d-flex flex-column">
            @include('includes.header')

            @include('components.alerts.danger')
            @include('components.alerts.success')
            @include('components.alerts.warning')

            @yield('content')

            @include('includes.footer')

        </div>
        <!-- end of main-container -->

    </div>
    <!-- end of vertical-menu -->

</div>

@include('includes.scripts')
</body>
</html>
