<!doctype html>
<html lang="ar" dir="rtl">

@include('includes.head')

<body>
    {{-- Loader --}}
    <div id="spinner" aria-label="Loading" role="alert">
        <div class="spinner-border" style="width: 5rem; height: 5rem; color:#7367f0;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>



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
    <script>
        // Start Loader
        const loader = document.querySelector("#spinner");

        document.addEventListener("DOMContentLoaded", () => {
            loader.style.display = "flex";
        });
        document.addEventListener("DOMContentLoaded", function() {
            loader.style.display = "none";
        });
        document.addEventListener("load", () => {
            loader.style.display = "none";
        });
        $(document).ajaxError(function(event, jqXHR, ajaxSettings, thrownError) {
            // Display error message to user
            alert("An error occurred: " + thrownError);
        });
    </script>


</body>

</html>
