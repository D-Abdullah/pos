@if(Session::has('error'))
    <style>
        :root {
            /* main-background */
            --main-Background-color: #F8F7FA;
            --secound-Background-color: #FFF;
            /* main-background */

            /* active scroll hover botton and border*/
            --active-and-scroll: linear-gradient(72deg, #7367F0 22.16%, rgba(115, 103, 240, 0.70) 76.47%);
            --hover-menu: linear-gradient(0deg, rgba(255, 255, 255, 0.80) 0%, rgba(255, 255, 255, 0.80) 100%), #8692D0;
            --main-btn: #7367F0;
            --active-btn: #7367F0;
            --main-btn-hover: rgba(115, 103, 240, 0.16);
            --cancel-btn: #F8F7FA;
            --hover-list-dropdown: rgba(115, 103, 240, 0.08);
            /* active scroll hover botton */

            /* p span label h2 h3 h4 h5 */
            --text-color: #4B465C;
            /* p span label h2 h3 h4 h5 */

            /* table */
            --thead-table-color: #DFDFE3;
            --cost-table-color: #7367F0;
            --live-background: rgba(40, 199, 111, 0.16);
            --live-color: #28C76F;
            --contract-background: rgba(115, 103, 240, 0.16);
            --contract-color: #7367F0;
            --died-color: #EA5455;
            --died-background: rgba(234, 84, 85, 0.16);
            --preparing-background:  rgba(255, 159, 67, 0.16);
            --preparing-color: #FF9F43;
            --disable-background: #dddddd1e;
            /* table */

            /* shadow  border-color raduis overlay font-weight transition*/
            --shadow-menu-and-header-and-btn: 0px 2px 4px 0px rgba(165, 163, 174, 0.30);
            --shadow-list-dropdown: 0px 4px 16px 0px rgba(165, 163, 174, 0.45);
            --divider-color: #DBDADE;
            --main-radius: 6px;
            --overlay-color: rgba(0, 0, 0, 0.302);
            --weight-normal: 600;
            --weight-medium: 800;
            --weight-bold: bold;
            --main-transition: .5s;
            /* shadow  border-color raduis overlay font-weight transition*/
        }

        .error {
            background-color: var(--died-background);
            border-radius: var(--main-radius);
        }

        .error .up > img {
            cursor: pointer;
        }

        .error p {
            color:  var(--died-color);
        }
    </style>

    <div class="error p-3">
        <div class="up d-flex justify-content-between align-items-center">
            <div class="data d-flex align-items-center">
                <img src="{{asset('Assets/imgs/notSureIcon.png')}}" alt="">
                <p class="me-3 fw-bold fs-4">
                    {{Session::get('error')}}</p>
            </div>
            <img src="{{asset('Assets/imgs/notSure-x.png')}}" alt="">
        </div>
    </div>

    <script>
        document.querySelector(".error .up > img").addEventListener("click", (e) => {

            e.target.parentElement.parentElement.style.display = "none";

        })
    </script>
@endif
