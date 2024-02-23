<!-- start of frame-5 (header) -->
<header class="shadow-sm rounded-3 ps-4 pe-4 d-flex justify-content-between align-items-center">
    <!--all of the dropdown in the page the same thing you can change or edit as you like -->
    <div class="up d-flex align-items-center gap-4">
        <button class="main-btn p-2 ps-4 pe-4 d-flex ">
            <i class="fa-solid fa-arrow-right fs-5"></i>
        </button>
    </div>

    <div class="info position-relative d-flex align-items-center justify-content-end">
        <div class="avatar">
            {{ auth()->user()->name }}
        </div>
        <div class="manage position-absolute none">
            <ul>
                <li class="position-relative">
                    <svg class="position-absolute" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <circle cx="9" cy="7" r="4" stroke="#46515C" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="9" cy="7" r="4" stroke="white" stroke-opacity="0.2"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3 21V19C3 16.7909 4.79086 15 7 15H11C13.2091 15 15 16.7909 15 19V21" stroke="#46515C"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3 21V19C3 16.7909 4.79086 15 7 15H11C13.2091 15 15 16.7909 15 19V21" stroke="white"
                            stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M16 11L18 13L22 9" stroke="#46515C" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M16 11L18 13L22 9" stroke="white" stroke-opacity="0.2" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <a href="{{ route('profile') }}">حسابي</a>

                </li>
                <li class="position-relative" id="logout" style="padding: 10px 40px 10px 20px !important">
                    <svg class="position-absolute" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <path
                            d="M14 8V6C14 4.89543 13.1046 4 12 4H5C3.89543 4 3 4.89543 3 6V18C3 19.1046 3.89543 20 5 20H12C13.1046 20 14 19.1046 14 18V16"
                            stroke="#46515C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M14 8V6C14 4.89543 13.1046 4 12 4H5C3.89543 4 3 4.89543 3 6V18C3 19.1046 3.89543 20 5 20H12C13.1046 20 14 19.1046 14 18V16"
                            stroke="white" stroke-opacity="0.2" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M7 11.25C6.58579 11.25 6.25 11.5858 6.25 12C6.25 12.4142 6.58579 12.75 7 12.75V11.25ZM21 12V12.75C21.3033 12.75 21.5768 12.5673 21.6929 12.287C21.809 12.0068 21.7448 11.6842 21.5303 11.4697L21 12ZM18.5303 8.46967C18.2374 8.17678 17.7626 8.17678 17.4697 8.46967C17.1768 8.76256 17.1768 9.23744 17.4697 9.53033L18.5303 8.46967ZM17.4697 14.4697C17.1768 14.7626 17.1768 15.2374 17.4697 15.5303C17.7626 15.8232 18.2374 15.8232 18.5303 15.5303L17.4697 14.4697ZM21.5303 12.5303C21.8232 12.2374 21.8232 11.7626 21.5303 11.4697C21.2374 11.1768 20.7626 11.1768 20.4697 11.4697L21.5303 12.5303ZM7 12.75H21V11.25H7V12.75ZM21.5303 11.4697L18.5303 8.46967L17.4697 9.53033L20.4697 12.5303L21.5303 11.4697ZM18.5303 15.5303L21.5303 12.5303L20.4697 11.4697L17.4697 14.4697L18.5303 15.5303Z"
                            fill="#46515C" />
                        <path
                            d="M7 11.25C6.58579 11.25 6.25 11.5858 6.25 12C6.25 12.4142 6.58579 12.75 7 12.75V11.25ZM21 12V12.75C21.3033 12.75 21.5768 12.5673 21.6929 12.287C21.809 12.0068 21.7448 11.6842 21.5303 11.4697L21 12ZM18.5303 8.46967C18.2374 8.17678 17.7626 8.17678 17.4697 8.46967C17.1768 8.76256 17.1768 9.23744 17.4697 9.53033L18.5303 8.46967ZM17.4697 14.4697C17.1768 14.7626 17.1768 15.2374 17.4697 15.5303C17.7626 15.8232 18.2374 15.8232 18.5303 15.5303L17.4697 14.4697ZM21.5303 12.5303C21.8232 12.2374 21.8232 11.7626 21.5303 11.4697C21.2374 11.1768 20.7626 11.1768 20.4697 11.4697L21.5303 12.5303ZM7 12.75H21V11.25H7V12.75ZM21.5303 11.4697L18.5303 8.46967L17.4697 9.53033L20.4697 12.5303L21.5303 11.4697ZM18.5303 15.5303L21.5303 12.5303L20.4697 11.4697L17.4697 14.4697L18.5303 15.5303Z"
                            fill="white" fill-opacity="0.2" />
                    </svg>
                    تسجيل خروج

                </li>
            </ul>
        </div>
    </div>
</header>
<!-- end of frame-5 (header) -->
