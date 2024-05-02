$(document).ready(function () {
    //init ddws
    $(".js-example-basic-single.product").select2({
        placeholder: "ابحث بالقسم",
    });
    $(".js-example-basic-single.type").select2({
        placeholder: "اختر النوع",
    });

    //get data
    function getData(
        type = null,
        page = 1,
        name = null,
        department = null,
        id = null
    ) {
        if (type !== null) {
            return $.ajax({
                url: "/party/data/" + type + "/",
                method: "GET",
                data: {
                    type: type,
                    page: page,
                    name: name,
                    department: department,
                    id: id,
                },
            });
        }
    }

    function openModalEvent() {
        //modals actions
        $(".open-modal").click(function () {
            let type = $(this).data("type");
            let id = $(this).data("id");
            let action = $(this).data("action");
            let modal = $("#popupModal");
            let title = modal.find("#modalTitle");
            let modalForm = modal.find("#modalFormElement");
            let formBtn = modal.find("#modalSubmitBtn");

            //reset inputs required
            modal.find(".modalInputsContainers").each(function () {
                $(this).find("input, select, textarea").attr("required", false);
            });

            // status checkbox change inner text
            modal
                .find("#statusContainer input#statusInput")
                .on("change", function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    let $parent = $(this).parent();
                    let $lable = $parent.find("label");
                    if ($parent.hasClass("notReady")) {
                        $parent.removeClass("notReady");
                        $lable.text("جاهز");
                    } else {
                        $parent.addClass("notReady");
                        $lable.text("قيد التحضير");
                    }
                });

            //eol reason toggle
            modal
                .find("#typeInputContainer select#typeInput")
                .on("change", function () {
                    if ($(this).val() == "eol") {
                        modal.find("#eolReasonContainer").slideDown(300);
                    } else {
                        modal.find("#eolReasonContainer").slideUp(300);
                    }
                });

            // form button name
            if (action == "add") {
                formBtn.text("اضافه الى الفاتوره");
                modalForm.find("input#from").val(type);
                // modal inputs data debend on type
                switch (type) {
                    case "product":
                        title.text("اضافه عنصر من المخزن");
                        productInputs(modal, id);
                        break;
                    case "rent":
                        title.text("اضافه عنصر من قايمه الإيجار");
                        rentInputs(modal, id);
                        break;
                    case "custom":
                        title.text("اضافه عنصر مخصص");
                        customInputs(modal);
                        break;
                    default:
                        break;
                }
                if (type === "product" || type === "rent") {
                    let SData = getData(type, null, null, null, id);
                    $.when(SData).done(function (response) {
                        let data = response.data[0];
                        productAndRentInputs(modal, type, data);
                        validateModal(modalForm, modal, type, data);
                        setTimeout(() => {
                            modal
                                .find("#infoContainer")
                                .addClass("d-flex")
                                .slideDown();
                        }, 300);
                    });
                } else {
                    modal.find("#infoContainer").removeClass("d-flex").hide(0);
                    validateModal(modalForm, modal, type);
                }
            } else if (action == "edit") {
                formBtn.text("تعديل الفاتوره");
            } else if (action == "delete") {
                formBtn.text("حذف الفاتوره");
            } else {
                formBtn.text("حفظ التعديلات");
            }
            // open this modal
            openModal(modal);

            // listen on dismiss modal
            $(".popup img#dismiss").click(function () {
                if (!$(this).parent().hasClass("none")) {
                    closeModal(modal);
                }
            });

            $(".overlay-alfa").on("click", function (e) {
                if ($(e.target).hasClass("overlay-alfa")) {
                    closeModal(modal);
                }
            });
        });
    }

    // append elements
    function appendElements(type, data, pagination = false) {
        let container = $("#" + type + "Data");
        if (!pagination) {
            container.html("");
        }
        container.find(".loading-spinner").remove();
        if (data.length == 0) {
            container.append(`
                <div class="box">
                    <div class="info-box p-3">
                        <span class="d-block fs-5 text-center"><b>لا يوجد بيانات</b></span>
                    </div>
                </div>
            `);
            return;
        }
        for (let i = 0; i < data.length; i++) {
            let element = `
                <div class="box open-modal" data-type="${type}" data-id="${
                data[i].id
            }" data-action="add">
            <div style="width: 100%; height: 300px; overflow: hidden;">
                <img src="${window.location.origin}/${data[i].image}"
                    style="padding: 25px; border-radius: 22px; width: 100%; height: 100%; object-fit: cover;"
                    alt="${data[i].name}">
            </div>

                    <div class="info-box p-3">
                        <span class="d-block fs-5"><b>اسم:</b> ${
                            data[i].name
                        }</span>
                        <span class="${
                            type == "rent" ? "d-none" : "d-block"
                        } fs-5"><b>قسم:</b> ${
                type == "rent" ? "" : data[i].department.name
            }</span>
                        <span class="d-block fs-5"><b>سعر:</b> ${
                            type == "rent"
                                ? data[i].rent_price
                                : data[i].unit_price
                        } جنيه</span>
                        <span class="d-block fs-5"><b>كميه:</b> ${
                            data[i].quantity
                        }</span>
                    </div>
                </div>`;
            container.append(element);
        }

        openModalEvent();
    }

    // init product data
    let dataPromise = getData("product");
    $.when(dataPromise).done(function (response) {
        let data = response.data;
        appendElements("product", data);
    });

    // Function to append loading spinner
    function appendLoadingSpinner(container) {
        if (!container.find(".loading-spinner").length) {
            container.append(`
            <div class="loading-spinner">
                <div class="dot-container">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>`);
        }
    }

    // Function to check if the user has scrolled near the bottom of the container
    function isNearBottom(container) {
        let scrollTop = container.scrollTop();
        let scrollHeight = container.prop("scrollHeight");
        let containerHeight = container.innerHeight();
        let distanceToBottom = scrollHeight - (scrollTop + containerHeight);
        let threshold = 50;
        return distanceToBottom < threshold;
    }

    // Function to handle pagination for a given container type
    function handlePagination(container, type) {
        let loading = false;
        let page = 1;
        let lPage = 0;
        container.scroll(function () {
            if (lPage == 0) {
                if (!loading && isNearBottom(container)) {
                    loading = true;
                    appendLoadingSpinner(container);
                    setTimeout(() => {
                        page++;
                        let dataPromise = getData(type, page);
                        $.when(dataPromise)
                            .done(function (response) {
                                let data = response.data;
                                if (data.length > 0) {
                                    appendElements(type, data, true);
                                } else {
                                    container.find(".loading-spinner").remove();
                                    lPage = page;
                                    if (container.find("h4.noData").length) {
                                        container.append(
                                            `<h4 class="noData">لا يوجد عناصر اخرى</h4>`
                                        );
                                    }
                                }
                                loading = false;
                            })
                            .fail(function () {
                                loading = false;
                            });
                    }, 1000);
                }
            }
        });
    }

    //init pagination
    handlePagination($("#productData"), "product");
    handlePagination($("#rentData"), "rent");

    //tabs btns
    $(".tabs").on("click", function () {
        page = 1;
        lPage = 0;
        let $button = $(this);
        let goto = $(this).data("goto");

        $(".tabs").removeClass("active-btn");
        $button.addClass("active-btn");
        $(".part").hide().removeClass("show");
        $(`#${goto}`).css("display", "flex").addClass("show");

        // get data
        let dataPromise = getData(goto);
        $.when(dataPromise).done(function (response) {
            let data = response.data;
            appendElements(goto, data);
        });
    });

    //filter
    $("input#productFilterWithName").on("input", function () {
        let name = $(this).val();
        let dataPromiseProduct = getData(
            "product",
            1,
            name,
            $("select#productFilterWithDepartment").val()
        );
        $.when(dataPromiseProduct).done(function (response) {
            let data = response.data;
            appendElements("product", data);
        });
    });
    $("select#productFilterWithDepartment").on("change", function () {
        let departmentId = $(this).val();
        let dataPromise = getData(
            "product",
            1,
            $("input#productFilterWithName").val(),
            departmentId
        );
        $.when(dataPromise).done(function (response) {
            let data = response.data;
            appendElements("product", data);
        });
    });

    $("input#rentFilterWithName").on("input", function () {
        let name = $(this).val();
        let dataPromise = getData("rent", 1, name);
        $.when(dataPromise).done(function (response) {
            let data = response.data;
            appendElements("rent", data);
        });
    });

    /*************************************************************** */

    //init hide modal inputs
    function hideModalInputs(modal) {
        modal.find(".modalInputsContainers").hide();
        modal.find("#infoContainer").removeClass("d-flex").hide(0);
        let validationContainer = modal.find("#validationContainer");
        let validationTxt = validationContainer.find("small");
        validationContainer.hide();
        validationTxt.text("");
        return;
    }

    //init modal reset
    function resetModalInputs(modal) {
        modal.find("input#productId").val("");
        modal.find("input#rentId").val("");
        modal.find("input#from").val("");
        modal.find("input#partyId").val("");

        modal.find("#nameContainer input#name").val("");
        modal.find("#totalPriceContainer input#totalPrice").val("");
        modal.find("#quantityContainer input#quantity").val("");
        modal.find("#unitPriceContainer input#unitPrice").val("");
        modal
            .find("#typeInputContainer select#typeInput")
            .val("")
            .trigger("change");
        modal
            .find("#typeInputContainer select#typeInput")
            .val(
                modal
                    .find("#typeInputContainer select#typeInput")
                    .prop("defaultSelected")
            );
        modal.find("#eolReasonContainer textarea#eolReason").val("");
        modal.find("#statusContainer").removeClass("notReady");
        modal.find("#statusContainer label").text("جاهز");
        modal.find("#statusContainer input#statusInput").val("0");
        modal.find("#statusContainer input#statusInput").prop("checked", true);

        hideModalInputs(modal);
    }

    //init modal open
    function openModal(modal) {
        modal.removeClass("close");
        $("body").addClass("overflow-hidden");
        $(".overlay-alfa").removeClass("none");
    }

    //init close modal
    function closeModal(modal) {
        modal.addClass("close");
        $("body").removeClass("overflow-hidden");
        $(".overlay-alfa").addClass("none");
        resetModalInputs(modal);
    }

    //init product inputs
    function productInputs(modal, id) {
        modal.find("#productId").val(id);
    }

    //init rent inputs
    function rentInputs(modal, id) {
        modal.find("#rentId").val(id);
    }

    //init product and rents inputs
    function productAndRentInputs(modal, type, data) {
        modal.find("#quantityContainer").show();
        modal.find("#unitPriceContainer").show();
        modal.find("#statusContainer").show();
        modal.find("#modalInfoName span").text(data.name);
        modal.find("#modalInfoQuantity span").text(data.quantity);
        modal
            .find("img#modalInfoImage")
            .attr("src", window.location.origin + "/" + data.image);
        if (type == "product") {
            modal.find("#typeInputContainer").show();
            modal.find("#modalInfoDepartment").show();
            modal.find("#modalInfoPrice span").text(data.unit_price);
            // modal.find("#modalInfoDepartment span").text(data.department.name);
        } else {
            modal.find("#typeInputContainer").hide();
            modal.find("#modalInfoDepartment").hide();
            modal.find("#modalInfoPrice span").text(data.rent_price);
        }
    }

    //init custom inputs
    function customInputs(modal) {
        modal.find("#nameContainer").show();
        modal.find("#totalPriceContainer").show();
    }

    // calculate and update total price
    function updateTotalPrice(modal) {
        var totalPrice = 0;
        $("#dataTableBody tr:not(.type-eol)").each(function () {
            var rowTotal = parseFloat(
                $(this).find("td.totalPriceTableItem").text()
            );
            totalPrice += +rowTotal;
        });
        $("#totalPriceCell").text(totalPrice);
        $("button#payButton").removeAttr("disabled").css("cursor", "pointer");
        openModalEvent();
        closeModal(modal);
        new Swal({
            title: "تمت العمليه بنجاح",
            text: "تمت اضافه العنصر بنجاح.",
            icon: "success",
            confirmButtonText: "حسناً",
        });
    }

    // appent into table
    function addToTable(form, modal, type, data = null) {
        let product_id = form.find("input#productId").val();
        let rent_id = form.find("input#rentId").val();
        let from = form.find("input#from").val();
        let party_id = form.find("input#partyId").val();
        let name = form.find("#nameContainer input").val();
        let total_price = form.find("#totalPriceContainer input").val();
        let quantity = form.find("#quantityContainer input").val();
        let unit_price = form.find("#unitPriceContainer input").val();
        let status = form.find("#statusContainer input").prop("checked");
        let typeInput = form.find("#typeInputContainer select").val();
        let eol = form.find("#eolReasonContainer textarea").val();
        let tbody = $("tbody#dataTableBody");
        let billForm = $("form#requestBillForm");

        // Create a new row with data
        var newRow = $("<tr>");
        if (typeInput == "eol") {
            newRow.addClass("type-eol");
        }

        let fromVal =
            from == "product"
                ? "مخزن"
                : from == "rent"
                ? "إيجار"
                : from == "custom"
                ? "مخصص"
                : "-";
        let typeVal =
            typeInput == "rent"
                ? "ايجار"
                : typeInput == "sale"
                ? "بيع"
                : typeInput == "eol"
                ? "هالك"
                : "-";
        let statusVal = status ? "جاهز" : "قيد التحضير";
        let statusReqVal = status ? "ready" : "preparing";
        let nameVal =
            type == "product" || type == "rent"
                ? data.name
                : type == "custom"
                ? name
                : "-";
        let eolVal = typeInput == "eol" ? eol : "-";

        // Append table data (td) elements with data values
        newRow.append(`<td class="text-center" style="vertical-align: middle;">
            <img src="${
                window.location.origin
            }/${type == "custom" ? "imgs/default.png" : data.image}" width="75" height="75" style="object-fit: cover; border-radius: 25px">
        </td>`);
        newRow.append(
            `<td class="text-center" style="vertical-align: middle;">` +
                fromVal +
                "</td>"
        );
        newRow.append(
            `<td class="text-center" style="vertical-align: middle;">` +
                nameVal +
                "</td>"
        );
        newRow.append(
            `<td class="text-center" style="vertical-align: middle;">` +
                quantity +
                "</td>"
        );
        newRow.append(
            `<td class="text-center" style="vertical-align: middle;">` +
                unit_price +
                "</td>"
        );
        newRow.append(
            '<td class="text-center totalPriceTableItem" style="vertical-align: middle;">' +
                +total_price +
                "</td>"
        );
        newRow.append(
            `<td class="text-center" style="vertical-align: middle;">` +
                typeVal +
                "</td>"
        );
        newRow.append(
            `<td class="text-center" style="vertical-align: middle;">` +
                statusVal +
                "</td>"
        );
        newRow.append(
            `<td class="text-center" style="vertical-align: middle;">` +
                eolVal +
                "</td>"
        );
        newRow.append(`
            <td class="text-center" style="vertical-align: middle;">
                <div class="edit d-flex align-items-center justify-content-center">
                    <img src="${
                        window.location.origin
                    }/Assets/imgs/edit-circle.png" alt="" class="open-modal" data-type="${type}" data-id="${type == "custom" ? "" : data.id}" data-action="edit">
                    <img src="${
                        window.location.origin
                    }/Assets/imgs/trash (1).png" alt="" class="ms-2 me-2 open-modal" data-type="${type}" data-id="${type == "custom" ? "" : data.id}" data-action="delete">
                </div>
            </td>
        `);
        newRow.append("</tr>");
        // Append the new row to the table body
        tbody.find("#emptyDataTable").remove();
        tbody.append(newRow);

        // // Append hidden input fields for each item
        billForm.append(
            '<input type="hidden" name="bill[' +
                tbody.find("tr").length +
                '][from]" value="' +
                from +
                '">'
        );
        billForm.append(
            '<input type="hidden" name="bill[' +
                tbody.find("tr").length +
                '][name]" value="' +
                name +
                '">'
        );
        billForm.append(
            '<input type="hidden" name="bill[' +
                tbody.find("tr").length +
                '][quantity]" value="' +
                quantity +
                '">'
        );
        billForm.append(
            '<input type="hidden" name="bill[' +
                tbody.find("tr").length +
                '][unit_price]" value="' +
                unit_price +
                '">'
        );
        billForm.append(
            '<input type="hidden" name="bill[' +
                tbody.find("tr").length +
                '][total_price]" value="' +
                total_price +
                '">'
        );
        billForm.append(
            '<input type="hidden" name="bill[' +
                tbody.find("tr").length +
                '][type]" value="' +
                typeInput +
                '">'
        );
        billForm.append(
            '<input type="hidden" name="bill[' +
                tbody.find("tr").length +
                '][status]" value="' +
                statusReqVal +
                '">'
        );
        billForm.append(
            '<input type="hidden" name="bill[' +
                tbody.find("tr").length +
                '][party_id]" value="' +
                party_id +
                '">'
        );
        billForm.append(
            '<input type="hidden" name="bill[' +
                tbody.find("tr").length +
                '][product_id]" value="' +
                product_id +
                '">'
        );
        billForm.append(
            '<input type="hidden" name="bill[' +
                tbody.find("tr").length +
                '][rent_id]" value="' +
                rent_id +
                '">'
        );
        billForm.append(
            '<input type="hidden" name="bill[' +
                tbody.find("tr").length +
                '][eol_reason]" value="' +
                eol +
                '">'
        );

        // Calculate and update total price
        updateTotalPrice(modal);
    }
    function handleModalBtnClickEvent(type, modal, modalForm, data) {
        return function () {
            let validationContainer = modalForm.find("#validationContainer");
            let validationTxt = validationContainer.find("small");

            let name = modalForm.find("#nameContainer input");
            let total_price = modalForm.find("#totalPriceContainer input");
            let quantity = modalForm.find("#quantityContainer input");
            let unit_price = modalForm.find("#unitPriceContainer input");
            let status = modalForm.find("#statusContainer input");
            let typeInput = modalForm.find("#typeInputContainer select");
            let eol = modalForm.find("#eolReasonContainer textarea");
            if (type == "product" || type == "rent") {
                if (quantity.val() == "") {
                    validationTxt.text("الكميه مطلوبه.");
                    validationContainer.slideDown();
                    quantity.focus();
                    return;
                } else if (+quantity.val() > +data.quantity) {
                    validationTxt.text(
                        "الكميه المدخله اكبر من الكميه المتاحه."
                    );
                    validationContainer.slideDown();
                    quantity.focus();
                    return;
                } else if (unit_price.val() == "") {
                    validationTxt.text("التكلفه مطلوبه.");
                    validationContainer.slideDown();
                    unit_price.focus();
                    return;
                } else if (typeInput.val() == "" && type == "product") {
                    validationTxt.text("النوع مطلوبه.");
                    validationContainer.slideDown();
                    typeInput.focus();
                    return;
                } else if (
                    typeInput.val() == "eol" &&
                    eol.val() == "" &&
                    type == "product"
                ) {
                    validationTxt.text("السبب مطلوب.");
                    validationContainer.slideDown();
                    eol.focus();
                    return;
                } else {
                    validationContainer.slideUp();
                    validationTxt.text("");
                    total_price.val(+quantity.val() * +unit_price.val());
                    addToTable(modalForm, modal, type, data);
                    return;
                }
            } else if (type == "custom") {
                if (name.val() == "") {
                    validationTxt.text("اسم العنصر مطلوب.");
                    validationContainer.slideDown();
                    name.focus();
                    return;
                } else if (total_price.val() == "") {
                    validationTxt.text("التكلفه مطلوبه.");
                    validationContainer.slideDown();
                    total_price.focus();
                    return;
                } else {
                    validationContainer.slideUp();
                    validationTxt.text("");
                    quantity.val(1);
                    unit_price.val(total_price.val());
                    status.val("1");
                    status.prop("checked", true);
                    typeInput.val("sale").trigger("change");
                    addToTable(modalForm, modal, type, null);
                    return;
                }
            }
            return;
        };
    }
    // validate modal
    function validateModal(modalForm, modal, type, data = null) {
        // click event on submit btn for the modal modalForm
        modalForm
            .find("#modalSubmitBtn")
            .off("click")
            .on(
                "click",
                handleModalBtnClickEvent(type, modal, modalForm, data)
            );
    }
});
