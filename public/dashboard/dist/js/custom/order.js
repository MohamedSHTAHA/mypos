$(document).ready(function () {
    //$(".add-product-btn").click(function (e) {
    $("body").on("click", ".add-product-btn", function (e) {
        e.preventDefault();

        let name = $(this).data("name");
        let id = $(this).data("id");
        let price = $(this).data("price");
        let stock = $(this).data("stock");

        $(this).removeClass("btn-success").addClass("btn-default disabled");
        /*<input type="hidden" name="products_ids[]" value="${id}">
            <td><input type="number" name="quantities[]" data-price="${price}" data-stock="${stock}" max="${stock}" min="1" value="1" class="form-control product-quantity" /></td>*/
        let html = `<tr>
            <td>${name}</td>
            <td><input type="number" name="products[${id}][quantity]" data-price="${price}" data-stock="${stock}" max="${stock}" min="1" value="1" class="form-control product-quantity" /></td>
            <td > ${$.number(price, 2)}</td>
            <td class="product-price">${$.number(price, 2)}</td>
            <td><button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}" > <i class="fa fa-trash"></i> </button> </td>
        </tr>`;
        $(".order-list").append(html);
        calculateTotal();
    });

    // prevent default
    $("body").on("click", ".remove-product-btn", function (e) {
        e.preventDefault();
        var id = $(this).data("id");

        $("#product-" + id)
            .removeClass("btn-default disabled")
            .addClass("btn-success");

        $(this).closest("tr").remove();
        calculateTotal();
    });

    // prevent default
    $("body").on("click", ".disabled", function (e) {
        e.preventDefault();
    });

    ///

    function calculateTotal() {
        var price = 0;

        $(".order-list .product-price").each(function (index) {
            price += parseFloat($(this).html().replace(/,/g, ""));
        });

        $(".total-price").html($.number(price, 2));

        //check if price > 0

        if (price > 0) {
            $("#add-order-form-btn").removeClass("disabled");
        } else {
            $("#add-order-form-btn").addClass("disabled");
        }
    }

    //change product quantity
    $("body").on("keyup change", ".product-quantity", function () {
        let quantity = parseInt($(this).val());

        let unitPrice = parseFloat($(this).data("price")); //.replace(/,/g, ''));
        let unitstock = parseFloat($(this).data("stock"));

        if (quantity > unitstock) {
            $("#add-order-form-btn").addClass("disabled");
            $(this).val(unitstock - 1);
            new Noty({
                theme: "metroui",
                type: "error",
                layout: "topRight",
                text: "هذة الكمية ليست متوفرة",
                timeout: 2500,
                killer: true,
            }).show();
        } else {
            $("#add-order-form-btn").removeClass("disabled");
        }
        let totalPrice = unitPrice * quantity; // accounting.formatNumber(unitPrice * quantity, 2) ;

        $(this)
            .closest("tr")
            .find(".product-price")
            .html($.number(totalPrice, 2));

        calculateTotal();
    }); //end of product quantity

    // show order products with ajax
    $(".order-products").click(function (e) {
        //$("body").on("click", ".order-products", function (e) {
        e.preventDefault();

        $("#order-product-list").empty();
        $("#loading").css("display", "flex");

        let url = $(this).data("url");
        let method = $(this).data("method");

        $(".btn-default").removeClass("btn-default").addClass("btn-primary");

        $(this).removeClass("btn-primary").addClass("btn-default");

        $.ajax({
            url: url,
            method: method,
            success: function (data) {
                $("#loading").css("display", "none");
                $("#order-product-list").empty();
                $("#order-product-list").append(data);
            },
        });
    }); //end show order products with ajax

    //print order
    $(document).on("click", ".print-btn", function () {
        $("#print-area").printThis();
    }); //end of click function

    // show order checkout with ajax
    $(".order-checkout").click(function (e) {
        //$("body").on("click", ".order-checkout", function (e) {
        e.preventDefault();
        $("#myModalInfo_checkout").modal("show");

        $("#checkout").empty();
        $("#loading2").css("display", "flex");

        let url = $(this).data("url");
        let method = $(this).data("method");

        $(".btn-default").removeClass("btn-default").addClass("btn-success");

        $(this).removeClass("btn-success").addClass("btn-default");

        $.ajax({
            url: url,
            method: method,
            success: function (data) {
                $("#loading2").css("display", "none");
                $("#checkout").empty();
                $("#checkout").append(data);
            },
        });
    }); //end show order checkout with ajax
});
