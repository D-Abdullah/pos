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
            }">
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

    //init hide modal inputs
    function hideModalInputs(modal) {
        modal.find(".modalInputsContainers").hide();
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
        modal.find("#statusContainer label#status").text("جاهز");
        modal.find("#statusContainer input#flexCheckDefault20").val("");
        modal
            .find("#statusContainer input#flexCheckDefault20")
            .prop("checked", true);

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
    function productAndRentInputs(modal, type) {
        modal.find("#quantityContainer").show();
        modal
            .find("#quantityContainer")
            .find("input#quantity")
            .attr("required", true);
        if (type == "items") {
            modal.find("#typeInputContainer").show();
            modal
                .find("#typeInputContainer")
                .find("select#typeInput")
                .attr("required", true);
        }
        modal.find("#statusContainer").show();
    }

    //init custom inputs
    function customInputs(modal) {
        modal.find("#nameContainer").show();
        modal.find("#nameContainer").find("input#name").attr("required", true);
        modal.find("#totalPriceContainer").show();
        modal
            .find("#totalPriceContainer")
            .find("input#totalPrice")
            .attr("required", true);
    }

    // calculate and update total price
    function updateTotalPrice(modal) {
        var totalPrice = 0;
        $("#dataTableBody tr:not(.type-eol)").each(function () {
            var rowTotal = parseFloat(
                $(this).find("td#totalPriceTableItem").text()
            );
            totalPrice += +rowTotal;
        });
        $("#totalPriceCell").text("الاجمالي: " + totalPrice);
        closeModal(modal);
    }

    // get name of the product or the rent
    function getNameFromServer(id, type) {
        return $.ajax({
            url: "/party/get-name/" + type + "/",
            method: "GET",
            data: {
                id: id,
            },
        });
    }

    // appent into table
    function addToTable(data, modal) {
        // Remove the empty data row if it exists
        $("#emptyDataTable").remove();

        // Create a new row with data
        var newRow = $("<tr>");
        if (data.type == "eol") {
            newRow.addClass("type-eol");
        }

        let from =
            data.from == "items"
                ? "المنتجات"
                : data.from == "rent"
                ? "الايجارات"
                : "مخصص";
        let type =
            data.type == "rent"
                ? "ايجار"
                : data.type == "sale"
                ? "بيع"
                : "هالك";
        let status = data.status ? "جاهز" : "غير جاهز";

        // Usage in your code
        let productPromise = null;
        let rentPromise = null;
        if (data.product_id !== "----") {
            productPromise = getNameFromServer(data.product_id, "product");
        }

        if (data.rent_id !== "----") {
            rentPromise = getNameFromServer(data.rent_id, "rent");
        }

        if (data.from == "custom") {
            // Append table data (td) elements with data values
            newRow.append("<td>" + from + "</td>");
            newRow.append("<td>" + data.name + "</td>");
            newRow.append("<td>" + "----" + "</td>");
            newRow.append("<td>" + "----" + "</td>");
            newRow.append(
                '<td id="totalPriceTableItem">' + data.total_price + "</td>"
            );
            newRow.append("<td>" + "----" + "</td>");
            newRow.append("<td>" + status + "</td>");
            newRow.append("<td>" + "----" + "</td>");
            newRow.append("<td>" + "----" + "</td>");
            newRow.append("<td>" + "----" + "</td>");
            // Append hidden input fields for each item
            $("#requestBillForm").append(
                '<input type="hidden" name="bill[' +
                    $("#dataTableBody tr").length +
                    '][from]" value="' +
                    data.from +
                    '">'
            );
            $("#requestBillForm").append(
                '<input type="hidden" name="bill[' +
                    $("#dataTableBody tr").length +
                    '][name]" value="' +
                    data.name +
                    '">'
            );
            $("#requestBillForm").append(
                '<input type="hidden" name="bill[' +
                    $("#dataTableBody tr").length +
                    '][quantity]" value="' +
                    data.quantity +
                    '">'
            );
            $("#requestBillForm").append(
                '<input type="hidden" name="bill[' +
                    $("#dataTableBody tr").length +
                    '][unit_price]" value="' +
                    data.unit_price +
                    '">'
            );
            $("#requestBillForm").append(
                '<input type="hidden" name="bill[' +
                    $("#dataTableBody tr").length +
                    '][total_price]" value="' +
                    data.total_price +
                    '">'
            );
            $("#requestBillForm").append(
                '<input type="hidden" name="bill[' +
                    $("#dataTableBody tr").length +
                    '][type]" value="' +
                    data.type +
                    '">'
            );
            $("#requestBillForm").append(
                '<input type="hidden" name="bill[' +
                    $("#dataTableBody tr").length +
                    '][status]" value="' +
                    data.status +
                    '">'
            );
            $("#requestBillForm").append(
                '<input type="hidden" name="bill[' +
                    $("#dataTableBody tr").length +
                    '][party_id]" value="' +
                    data.party_id +
                    '">'
            );
            $("#requestBillForm").append(
                '<input type="hidden" name="bill[' +
                    $("#dataTableBody tr").length +
                    '][product_id]" value="' +
                    data.product_id +
                    '">'
            );
            $("#requestBillForm").append(
                '<input type="hidden" name="bill[' +
                    $("#dataTableBody tr").length +
                    '][rent_id]" value="' +
                    data.rent_id +
                    '">'
            );
            $("#requestBillForm").append(
                '<input type="hidden" name="bill[' +
                    $("#dataTableBody tr").length +
                    '][eol_reason]" value="' +
                    data.eol_reason +
                    '">'
            );
            // Append the new row to the table body
            $("#dataTableBody").append(newRow);

            // Calculate and update total price
            updateTotalPrice(modal);
        } else {
            // Resolve promises and set names
            $.when(productPromise, rentPromise).done(function (
                productResponse,
                rentResponse
            ) {
                let res, resPrice;
                if (productResponse) {
                    res = productResponse[0];
                    resPrice = res.avg_price;
                }
                if (rentResponse) {
                    res = rentResponse[0];
                    resPrice = res.sale_price;
                }
                // Append table data (td) elements with data values
                newRow.append("<td>" + from + "</td>");
                newRow.append("<td>" + data.name + "</td>");
                newRow.append("<td>" + data.quantity + "</td>");
                newRow.append("<td>" + resPrice + "</td>");
                newRow.append(
                    '<td id="totalPriceTableItem">' +
                        resPrice * data.quantity +
                        "</td>"
                );
                newRow.append("<td>" + type + "</td>");
                newRow.append("<td>" + status + "</td>");
                if (rentResponse) {
                    newRow.append("<td>" + "----" + "</td>");
                    newRow.append("<td>" + res.name + "</td>");
                }
                if (productResponse) {
                    newRow.append("<td>" + res.name + "</td>");
                    newRow.append("<td>" + "----" + "</td>");
                }
                newRow.append("<td>" + data.eol_reason + "</td>");

                // Append hidden input fields for each item
                $("#requestBillForm").append(
                    '<input type="hidden" name="bill[' +
                        $("#dataTableBody tr").length +
                        '][from]" value="' +
                        data.from +
                        '">'
                );
                $("#requestBillForm").append(
                    '<input type="hidden" name="bill[' +
                        $("#dataTableBody tr").length +
                        '][name]" value="' +
                        data.name +
                        '">'
                );
                $("#requestBillForm").append(
                    '<input type="hidden" name="bill[' +
                        $("#dataTableBody tr").length +
                        '][quantity]" value="' +
                        data.quantity +
                        '">'
                );
                $("#requestBillForm").append(
                    '<input type="hidden" name="bill[' +
                        $("#dataTableBody tr").length +
                        '][unit_price]" value="' +
                        data.unit_price +
                        '">'
                );
                $("#requestBillForm").append(
                    '<input type="hidden" name="bill[' +
                        $("#dataTableBody tr").length +
                        '][total_price]" value="' +
                        data.total_price +
                        '">'
                );
                $("#requestBillForm").append(
                    '<input type="hidden" name="bill[' +
                        $("#dataTableBody tr").length +
                        '][type]" value="' +
                        data.type +
                        '">'
                );
                $("#requestBillForm").append(
                    '<input type="hidden" name="bill[' +
                        $("#dataTableBody tr").length +
                        '][status]" value="' +
                        data.status +
                        '">'
                );
                $("#requestBillForm").append(
                    '<input type="hidden" name="bill[' +
                        $("#dataTableBody tr").length +
                        '][party_id]" value="' +
                        data.party_id +
                        '">'
                );
                $("#requestBillForm").append(
                    '<input type="hidden" name="bill[' +
                        $("#dataTableBody tr").length +
                        '][product_id]" value="' +
                        data.product_id +
                        '">'
                );
                $("#requestBillForm").append(
                    '<input type="hidden" name="bill[' +
                        $("#dataTableBody tr").length +
                        '][rent_id]" value="' +
                        data.rent_id +
                        '">'
                );
                $("#requestBillForm").append(
                    '<input type="hidden" name="bill[' +
                        $("#dataTableBody tr").length +
                        '][eol_reason]" value="' +
                        data.eol_reason +
                        '">'
                );
                // Append the new row to the table body
                $("#dataTableBody").append(newRow);

                // Calculate and update total price
                updateTotalPrice(modal);
            });
        }
    }

    // validate modal
    function validateModal(salePrice, modal, type) {
        //data object for the request
        let data = {
            from: modal.find("#from").val()
                ? modal.find("#from").val()
                : "----",
            name: modal.find("#name").val()
                ? modal.find("#name").val()
                : "----",
            quantity: modal.find("#quantity").val()
                ? +modal.find("#quantity").val()
                : "----",
            unit_price: salePrice ? salePrice : "----",
            type: modal.find("#typeInput").val()
                ? modal.find("#typeInput").val()
                : "----",
            status: modal
                .find("#statusContainer input#flexCheckDefault20")
                .prop("checked")
                ? "ready"
                : "preparing",
            party_id: modal.find("#partyId").val()
                ? +modal.find("#partyId").val()
                : "----",
            product_id: modal.find("#productId").val()
                ? +modal.find("#productId").val()
                : "----",
            rent_id: modal.find("#rentId").val()
                ? +modal.find("#rentId").val()
                : "----",
            eol_reason: modal.find("#eolReason").val()
                ? modal.find("#eolReason").val()
                : "----",
            total_price: 0,
        };

        if (data.from == "items" || data.from == "rent") {
            let quantity = +modal.find("input#quantity").val();
            if (!isNaN(quantity) && salePrice) {
                data.total_price = quantity * salePrice;
            }
        } else {
            let totalPriceInput = modal
                .find(
                    '#totalPriceContainer input#totalPrice[required="required"]'
                )
                .val();
            if (totalPriceInput) {
                data.total_price = totalPriceInput;
            }
        }
        addToTable(data, modal);
    }

    //modals actions
    $(".open-modal").click(function () {
        // debugger;
        let type = $(this).data("type");
        let id = $(this).data("id");
        let action = $(this).data("action");
        let salePrice = $(this).data("saleprice");
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
            .find("#statusContainer input#flexCheckDefault20")
            .on("change", function () {
                let $parent = $(this).parent();
                let $lable = $parent.find("label#status");
                if ($parent.hasClass("notReady")) {
                    $parent.removeClass("notReady");
                } else {
                    $parent.addClass("notReady");
                }
                if ($parent.hasClass("notReady")) {
                    $lable.text("قيد التحضير");
                } else {
                    $lable.text("جاهز");
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
        if (!action) {
            formBtn.text("اضافه الى الفاتوره");

            //init default values
            modal.find("#from").val(type);
            modal.find("#partyId").val("{{ $id }}");

            // modal inputs data debend on type
            switch (type) {
                case "items":
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
            if (type === "items" || type === "rent") {
                productAndRentInputs(modal, type);
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

        // stop modal form submit
        modalForm.submit(function (e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
        });
        // click event on submit btn for the modal form
        modalForm.find("button#modalSubmitBtn").click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            if (modalForm.find('[required="required"]').val() == "") {
                return;
            } else {
                validateModal(salePrice, modal, type);
            }
        });

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
});
