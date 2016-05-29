addButtons();

$(document).ready(function() {
    cardList = buildTestCardList();
    createCards(cardList);

    addButtons();

    var id = $("#contextPatientId").val();

    if (id != "" && !isNaN(id)) {
        $("#name").html($("#contextPatientName").val());
    } else {
        id = $("#currentUserId").val();
        $("#name").html($("#currentUserName").val());
    }
    getPatientInfo(id);

    $("#placeOrder").click(function() {
        var modal_body = $(".modal-body");
        modal_body.empty();
        modal_body.append("<p>Thank you. Your order has been sent.</p>");
        $("select").each(function(index, element) {
            var select_val = $(element).val();
            if (parseInt(select_val) > 0) {
                var item_title = $(element).parent().parent().parent().find(".title").html();
                modal_body.append("<br>").append("<p>" + select_val + " " + item_title + "</p>");
            }
        });
        $(".modal-footer > .cancelButton").remove();
        $("#placeOrder").remove();

        $("<input>")
            .attr("class", "nextButton submit")
            .attr("type", "submit")
            .attr("id", "okay")
            .attr("name", "S")
            .attr("value", "Okay")
            .attr("data-dismiss", "modal")
            .appendTo($(".modal-footer"));

        $('#confirmModal').bind('hidden.bs.modal', function(e) {
            openPageWithAjax('../../dashboard/pages/portal_supplies.html', '', 'menu-content', undefined, undefined);
        })
    });
});

function getPatientInfo(patientId) {
    var arr = new Array();
    arr[0] = patientId;
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, "EMR", 'findPatientDetailsById', processResponse);
}

function processResponse(result) {
    if (result == null || result.success == false || result.message == "") {
    } else {
        var patientInfo = JSON.parse(result.message);
        $("#dob").html("DOB " + moment(patientInfo.dateOfBirth).format("MM/DD/YYYY"));
    }
}

function addButtons() {
    var top_level = $("#button-content");
    top_level.empty();

    $("<input>")
        .attr("class", "cancelButton reset")
        .attr("type", "reset")
        .attr("name", "C")
        .attr("value", "Cancel")
        .click(function() {
            openPageWithAjax('../../dashboard/pages/portal_supplies.html', '', 'menu-content', undefined, undefined);
        })
        .appendTo(top_level);

    $("<input>")
        .attr("class", "nextButton submit")
        .attr("type", "submit")
        .attr("id", "order")
        .attr("name", "S")
        .attr("value", "View Order")
        .attr("data-toggle", "modal")
        .attr("data-target", "#confirmModal")
        .click(function() {
            var modal_body = $(".modal-body");
            modal_body.empty();
            modal_body.append("<p>Confirming that you will be ordering:</p>");
            $("select").each(function(index, element) {
                var select_val = $(element).val();
                if (parseInt(select_val) > 0) {
                    var item_title = $(element).parent().parent().parent().find(".title").html();
                    modal_body.append("<br>").append("<p>" + select_val + " " + item_title + "</p>");
                }
            });
        })
        .appendTo(top_level);
}

function createCards(card_list) {
    card_list.forEach(function(element, index, array) {
        var top_level = $("<div>")
            .attr("class", "message_box_order")
            .appendTo("#supply-container");

        var image_column = $("<div>")
            .attr("class", "card-column card-order-image")
            .appendTo(top_level);
        var image_link = $("<a>")
            .attr("href", "#")
            .appendTo(image_column);
        $("<img>")
            .attr("src", element.imgSrc)
            .appendTo(image_link);

        var title_column = $("<div>")
            .attr("class", "card-column card-order")
            .appendTo(top_level);
        var inline_container = $("<div>")
            .attr("class", "inline-container")
            .appendTo(title_column);
        $("<div>")
            .attr("class", "left title")
            .css("font-size", "22px")
            .html(element.titleText)
            .appendTo(inline_container);
        inline_container = $("<div>")
            .attr("class", "inline-container")
            .appendTo(title_column);

        var quantity_holder = $("<div>")
            .attr("class", "right instruction delivery")
            .appendTo(inline_container);
        var quantity_select = $("<select>")
            .attr("class", "quantity")
            .css("font-size", "16px")
            .appendTo(quantity_holder);

        element.quantities.forEach(function(item, ind, arry) {
            $("<option>")
                .attr("value", item)
                .html(item)
                .appendTo(quantity_select);
        });

        $("<div>")
            .attr("class", "left")
            .html("Order Quantity:")
            .css("font-size", "16px")
            .appendTo(inline_container);

        inline_container = $("<div>")
            .attr("class", "inline-container")
            .css("font-size", "16px")
            .appendTo(title_column);
        $("<div>")
            .attr("class", "left")
            .css("font-size", "16px")
            .html(element.lastOrder + " ordered on " + element.lastOrderDate + " ETA " + element.lastOrderETA)
            .appendTo(inline_container);
    });
}

function buildTestCardList() {
    var testStrips = new Object();
    testStrips.imgSrc = "../../reports/images/report_succ.png";
    testStrips.titleText = "Glucose Test Strips";
    testStrips.lastOrder = "250";
    testStrips.lastOrderDate = "9/22/2014";
    testStrips.lastOrderETA = "10/01/2014";
    testStrips.quantities = ["0", "50", "100", "150", "200", "250", "300", "350", "400", "450", "500"];

    var lancets = new Object();
    lancets.imgSrc = "../../reports/images/report_succ.png";
    lancets.titleText = "Lancets";
    lancets.lastOrder = "250";
    lancets.lastOrderDate = "10/27/2014";
    lancets.lastOrderETA = "11/05/2014";
    lancets.quantities = ["0", "100", "200", "300", "400", "500"];

    var controlSolution = new Object();
    controlSolution.imgSrc = "../../reports/images/report_succ.png";
    controlSolution.titleText = "Control Solution";
    controlSolution.lastOrder = "1 box";
    controlSolution.lastOrderDate = "9/21/2014";
    controlSolution.lastOrderETA = "9/28/2014";
    controlSolution.quantities = ["0", "1"];

    var lansingPen = new Object();
    lansingPen.imgSrc = "../../reports/images/report_succ.png";
    lansingPen.titleText = "Lansing Pen";
    lansingPen.lastOrder = "1";
    lansingPen.lastOrderDate = "9/21/2014";
    lansingPen.lastOrderETA = "9/28/2014";
    lansingPen.quantities = ["0", "1"];

    var glucometer = new Object();
    glucometer.imgSrc = "../../reports/images/report_succ.png";
    glucometer.titleText = "Glucometer";
    glucometer.lastOrder = "1";
    glucometer.lastOrderDate = "9/21/2014";
    glucometer.lastOrderETA = "9/28/2014";
    glucometer.quantities = ["0", "1"];

    var wirelessAdapter = new Object();
    wirelessAdapter.imgSrc = "../../reports/images/report_succ.png";
    wirelessAdapter.titleText = "Wireless Adapter";
    wirelessAdapter.lastOrder = "1";
    wirelessAdapter.lastOrderDate = "9/21/2014";
    wirelessAdapter.lastOrderETA = "9/28/2014";
    wirelessAdapter.quantities = ["0", "1"];

    return [testStrips, lancets, controlSolution, glucometer, lansingPen, wirelessAdapter];
}
