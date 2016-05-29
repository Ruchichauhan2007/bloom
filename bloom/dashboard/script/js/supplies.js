var cardList;
var PatientSupplyInfo = null;
var SupplyConfigInfo = null;

$(document).ready(function() {
    var id = $("#contextPatientId").val();

    if (id != "" && !isNaN(id)) {
        addButtons();

        $("#name").html($("#contextPatientName").val());
    } else {
        id = $("#currentUserId").val();
        $("#name").html($("#currentUserName").val());
    }

    getPatientInfo(id);
    getPatientSupplyInfo(id);
    getSupplyConfigInfo();
});

function getPatientSupplyInfo(patientId) {
    var arr = new Array();
    arr[0] = patientId;
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, "EMR", 'getPatientSupplies', processPatientSupplyResponse);
}

function processPatientSupplyResponse(result) {
    console.log("patient supplies: ");
    console.log(result);
    if (result == null || result.success == false || result.message == "") {} else {
        var messageJson = JSON.parse(result.message);
        PatientSupplyInfo = messageJson;
    }

    if (PatientSupplyInfo != null && SupplyConfigInfo != null) {
        var cardList = buildCardList();
        createCards(cardList);
    }
}

function getSupplyConfigInfo() {
    var arr = new Array();
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, "EMR", 'getSupplyList', processSupplyConfigResponse);
}

function processSupplyConfigResponse(result) {
    console.log("supply config: ");
    console.log(result);
    if (result == null || result.success == false || result.message == "") {} else {
        var messageJson = JSON.parse(result.message);
        SupplyConfigInfo = messageJson;
    }

    if (PatientSupplyInfo != null && SupplyConfigInfo != null) {
        var cardList = buildCardList();
        createCards(cardList);
    }
}

// PatientSupplyInfo
/*
    private long patientSupplyId = 0;
    private Calendar createTimeStamp;
    private Calendar updateTimeStamp;
    private long patientId;
    private long supplyConfigId;
    private long patientDeviceDetailId;
    private Calendar lastOrderDate;
    private long totalQuantity;
    private long remainingQuantity;
    */

// SupplyConfigInfo
/*
    private long supplyConfigId = 0;
    private Calendar createTimeStamp;
    private Calendar updateTimeStamp;
    private String imageName = "";
    private String supplyCode = "";
    private String supplyDescription = "";
    private long defaultQuantity;
    */

function buildCardList() {
    var arr = new Array();
    PatientSupplyInfo.forEach(function(index, element, array) {
        var supplyConfigId = -1;
        for( var i = 0; i < SupplyConfigInfo.length; ++i) {
            if(SupplyConfigInfo[i].supplyConfigId == element.supplyConfigId) {
                supplyConfigId == i;
                break;
            }
        }

        var eta = moment(messageJson[i].lastOrderDate);
        var newItem = new Object();
        newItem.imgSrc = SupplyConfigInfo[supplyConfigId].imageName;
        newItem.titleText = SupplyConfigInfo[supplyConfigId].supplyDescription;
        newItem.lastOrder = element.totalQuantity;
        newItem.lastOrderDate = eta.format("MM/D/YYYY");
        eta.add(10, 'days');
        newItem.lastOrderETA = eta.format("MM/D/YYYY");
        newItem.usage = "4 per day"
        newItem.remaining = element.totalQuantity;
        var today = moment();
        newItem.delivery = "" + eta.diff(today, 'days');

        arr.push(newItem);
    });

    return arr;
}

function getPatientInfo(patientId) {
    var arr = new Array();
    arr[0] = patientId;
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, "EMR", 'findPatientDetailsById', processPatientInfoResponse);
}

function processPatientInfoResponse(result) {
    if (result == null || result.success == false || result.message == "") {
        alert("Unable to load messages");
    } else {
        var patientInfo = JSON.parse(result.message);
        $("#dob").html("DOB " + moment(patientInfo.dateOfBirth).format("MM/DD/YYYY"));
    }
}

function buildTestCardList() {
    var testStrips = new Object();
    testStrips.imgSrc = "../../reports/images/report_succ.png";
    testStrips.titleText = "Glucose Test Strips";
    testStrips.lastOrder = "250";
    testStrips.lastOrderDate = "9/22/2014";
    testStrips.lastOrderETA = "10/01/2014";
    testStrips.usage = "4 per day"
    testStrips.remaining = "40";
    testStrips.delivery = "10";

    var lancets = new Object();
    lancets.imgSrc = "../../reports/images/report_succ.png";
    lancets.titleText = "Lancets";
    lancets.lastOrder = "250";
    lancets.lastOrderDate = "10/27/2014";
    lancets.lastOrderETA = "11/05/2014";
    lancets.usage = "4 per day"
    lancets.remaining = "25";
    lancets.delivery = "10";

    var controlSolution = new Object();
    controlSolution.imgSrc = "../../reports/images/report_succ.png";
    controlSolution.titleText = "Control Solution";
    controlSolution.lastOrder = "1 box";
    controlSolution.lastOrderDate = "9/21/2014";
    controlSolution.lastOrderETA = "9/28/2014";
    controlSolution.usage = "See Manual"
    controlSolution.remaining = "1";
    controlSolution.delivery = "10";

    return [testStrips, lancets, controlSolution];
}

function createCards(card_list) {
    card_list.forEach(function(element, index, array) {
        var top_level = $("<div>")
            .attr("class", "message_box_bg")
            .appendTo("#supply-container");

        var image_column = $("<div>")
            .attr("class", "card-column card-image")
            .appendTo(top_level);
        var image_link = $("<a>")
            .attr("href", "#")
            .appendTo(image_column);
        $("<img>")
            .attr("src", element.imgSrc)
            .appendTo(image_link);

        var title_column = $("<div>")
            .attr("class", "card-column card-title")
            .appendTo(top_level);
        var inline_container = $("<div>")
            .attr("class", "inline-container")
            .appendTo(title_column);
        $("<div>")
            .attr("class", "left")
            .css("font-size", "22px")
            .html(element.titleText)
            .appendTo(inline_container);
        inline_container = $("<div>")
            .attr("class", "inline-container")
            .appendTo(title_column);
        inline_container = $("<div>")
            .attr("class", "inline-container")
            .appendTo(title_column);
        $("<div>")
            .attr("class", "left")
            .html(element.lastOrder + " ordered on " + element.lastOrderDate + " ETA " + element.lastOrderETA)
            .appendTo(inline_container);

        var detail_column = $("<div>")
            .attr("class", "card-column card-details")
            .appendTo(top_level);
        inline_container = $("<div>")
            .attr("class", "inline-container")
            .appendTo(detail_column);
        $("<div>")
            .attr("class", "right instruction usage")
            .html(element.usage)
            .appendTo(inline_container);
        $("<div>")
            .attr("class", "left")
            .html("Usage:")
            .appendTo(inline_container);
        inline_container = $("<div>")
            .attr("class", "inline-container")
            .appendTo(detail_column);
        $("<div>")
            .attr("class", "right instruction remaining")
            .attr("id", "remaining")
            .html(element.remaining)
            .appendTo(inline_container);
        $("<div>")
            .attr("class", "left")
            .html("Remaining Quantity:")
            .appendTo(inline_container);
        inline_container = $("<div>")
            .attr("class", "inline-container")
            .appendTo(detail_column);
        $("<div>")
            .attr("class", "right instruction delivery")
            .html(element.delivery + " days")
            .appendTo(inline_container);
        $("<div>")
            .attr("class", "left")
            .html("Next Delivery:")
            .appendTo(inline_container);
    });
}

function addButtons() {
    var top_level = $("#button-content");
    top_level.empty();

    /*$("<input>")
        .attr("class", "cancelButton reset")
        .attr("type", "reset")
        .attr("name", "C")
        .attr("value", "Edit")
        .click(function() {
            $(".remaining").each(function(index, element) {
                $(element).html($(element).html().replace(/(\d+)/g, "<input type=text value='$1' style='display:inline;width:25px'>"));
            });
            $(".usage").each(function(index, element) {
                $(element).html($(element).html().replace(/(\d+)/g, "<input type=text value='$1' style='display:inline;width:25px'>"));
            });

            replaceButtons();
        })
        .appendTo(top_level);*/

    $("<input>")
        .attr("class", "nextButton submit")
        .attr("type", "submit")
        .attr("id", "order")
        .attr("name", "S")
        .attr("value", "Special Order")
        .click(function() {
            openPageWithAjax('../../dashboard/pages/portal_suppliesSpecialOrder.html', '', 'menu-content', undefined, undefined);
        })
        .appendTo(top_level);
}

function replaceButtons() {
    var top_level = $("#button-content");
    top_level.empty();

    $("<input>")
        .attr("class", "cancelButton reset")
        .attr("type", "reset")
        .attr("name", "C")
        .attr("value", "Cancel")
        .click(function() {
            for (var i = 0; i < cardList.length; ++i) {
                $($(".remaining")[i]).html($($(".remaining")[i]).html().replace(/<.*>/, cardList[i].remaining));
                $($(".usage")[i]).html($($(".usage")[i]).html().replace(/<.*>/, cardList[i].remaining));
            }

            addButtons();
        })
        .appendTo(top_level);

    $("<input>")
        .attr("class", "nextButton submit")
        .attr("type", "submit")
        .attr("name", "S")
        .attr("value", "Save")
        .click(function() {
            $(".remaining").each(function(index, element) {
                $(element).html($(element).html().replace(/<.*>/, $(element).find("input").val()));
            });
            $(".usage").each(function(index, element) {
                $(element).html($(element).html().replace(/<.*>/, $(element).find("input").val()));
            });

            addButtons();
        })
        .appendTo(top_level);
}

function insertInputs() {
    $("#delivery").html().replace(/(\d+)/g, "<input type=text value='$1'>");
}
