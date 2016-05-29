$(document).ready(function()
{
var userType=$("#UserType").val();
	if(userType.toUpperCase() =="PATIENT")
	{
	$("#createReportDiv").hide();
	$(".reporthead img").hide();
    var id = $("#Userid").val();
	
    $("#contextPatientId").val(id);
	}
});
$("div.card_create_report_1").css("display", "none");

$('#submit-adhoc').click(function(e) {
    //$("#PopUpOnSubmit").modal('show');

});

function createNewReport() {
    $("div.card_create_report_1").css("display", "block");
    $("div.card_create_report").css("display", "none");
}

function getReports(patientId) {
    var arr = new Array();
    arr[0] = patientId;
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, "EMR", 'getReportsByPatientId', processResponse);
}

function processResponse(result) {
    console.log(result);
    if (result == null || result.success == false || result.message == "") {} else {
        var messageJson = JSON.parse(result.message);
		var reporthtml = "";
		var reportCardDivHtml = $("#reportCardDiv");
		var startTimestamp;
		var endTimestamp;
		var carttype;
		var cartImage;
		var cartStatus;
		var pending;
		var cardStatus = false;
		for (i = 0; i < messageJson.length; ++i) {
			carttype = messageJson[i].status;
			var patId = $("#contextPatientId").val();
			if(carttype=="PENDING")
			{
				cardStatus = true;
			cartImage = "<a id='"+messageJson[i].reportHistId+"'><img src='../../reports/images/report_Pending.jpg' /></a>";
			cartStatus= " .....Pending....";
			}
			else if(carttype=="SUCCESS")
			{
			cartImage = "<a href='#' id='"+messageJson[i].reportHistId+"' onclick='openReport(this.id)'><img src='../../reports/images/report_succ.png' /></a>";
			cartStatus= "";

			}
			else if(carttype=="FAIL")
			{
			cartImage="<a  id='"+messageJson[i].reportHistId+"'><img src='../../reports/images/report_fail.jpg' /></a>";
			cartStatus= " .....Failed....";

			}
			startTimestamp = moment(messageJson[i].startDate);
			endTimestamp = moment(messageJson[i].endDate);
			reporthtml = "<div class=''><div class='card_report'><div class='row'><div class='col-md-2 card_create_report_img'>";
			reporthtml = reporthtml+cartImage+"</div>";
			reporthtml =reporthtml+"<div class='col-md-6 card_create_report_link'><p>"+ messageJson[i].reportTitle +cartStatus+"</p><ul class='createrName'><li>Created by: "+messageJson[i].provFirstName+" "+ messageJson[i].provLastName+", "+messageJson[i].provCredentials+"</li></ul></div> <div class='col-md-4 date_span'>"+startTimestamp.format("MMM D YYYY")+" - "+ endTimestamp.format("MMM D YYYY")+"</div></div></div></div>";
			reportCardDivHtml.append(reporthtml);
		}
			if(cardStatus) 
			{
				 setTimeout(function(){	openPageWithAjax('../../reports/pages/report_weekly_dashboard.php','contextPId='+patId,'menu-content','',this); }, 10000);
			}

		
    }
}
/*
startDate
endDate
reportTitle
kannactReportConfigId
*/

$("#reportConfigDropDown").change(function()
{
  var reportConfigDropVal = $("#reportConfigDropDown option:selected").text();
  $("#report-title").val(reportConfigDropVal);
});

function scheduleAdHocReport() {
    var reportInfo = new Object();
    reportInfo.status = "PENDING";
    reportInfo.providerId = parseInt($("#currentUserId").val());
    reportInfo.patientId = parseInt($("#contextPatientId").val());
    reportInfo.state = 1;

    var title = $("#report-title").val();
    if( title == "" ) {
        title = $("#report-title").attr("placeholder");
    }
    reportInfo.reportTitle = title;
    reportInfo.kannactReportConfigId = $("#reportConfigDropDown").val();
	
    var arr = new Array();
    arr[0] = JSON.stringify(reportInfo);
    var dataVal = JSON.stringify(arr);
    console.log(dataVal);
    var retVal = postDataToServer(dataVal, "EMR", 'scheduleAdhocReport', processSchedule);
}

function processSchedule(result) {
    console.log(result);
}

var myModal = $('#PopUpOnSubmit').on('hide.bs.modal', function() {
    clearTimeout(myModal.data('hideInteval'));
    var id = setTimeout(function() {
        myModal.modal('hide');
        $("div.card_create_report_1").css("display", "none");
        $("div.card_create_report").css("display", "block");
    }, 500);
    myModal.data('hideInteval', id);
});

$('#PopUpOnSubmit').on('hide.bs.modal', function() {
    $("div.card_create_report_1").css("display", "none");
    $("div.card_create_report").css("display", "block");

    if ($(".pending").length == 0) {

        var card_parent = $("<div>")
            .attr("class", "col-lg-12")
            .insertAfter($(".card_create_report_1").parent());

        card_parent = $("<div>")
            .attr("class", "card_report pending")
            .appendTo(card_parent);

        var card_img = $("<div>")
            .attr("class", "col-lg-2 card_create_report_img")
            .appendTo(card_parent);

        $("<a>")
            .attr("href", "#")
            .appendTo(card_img)
            .append("<img src='../../reports/images/report_panding.png' />");

        var card_link = $("<div>")
            .attr("class", "col-lg-10 card_create_report_link")
            .appendTo(card_parent);

        $("<p>")
            .html("Patient Biometric Report <span>.....Pending........</span>")
            .appendTo(card_link);

        $("<ul>")
            .attr("class", "createrName")
            .html('<li>Create by: Nancy Baker, RN</li><li style="float:right;">July 11 2014 - Nov 11 2014</li>')
            .appendTo(card_link);
    }
});
$(function() {

    var id = $("#contextPatientId").val();

    $(".reporthead span").html($("#contextPatientName").val());
    $(".reporthead img").attr("src", $("#contextPatientImage").val());
    getReports(id);
	

    $('#fromDateInput').on('keydown', function(event) {
        return false;
    });

    $('#datetimepicker1').datetimepicker({
        pickTime: false,
        maxDate: moment().subtract(1, 'days')
    });


    $('#toDateInput').on('keydown', function(event) {
        return false;
    });

    $('#datetimepicker2').datetimepicker({
        pickTime: false,
        maxDate: moment()
    });
    $('#datetimepicker2').data("DateTimePicker").setDate(moment());
    $('#datetimepicker1').data("DateTimePicker").setDate(moment().subtract(30, 'days'));

    $("#datetimepicker2").on("dp.change", function(e) {
        $('#datetimepicker1').data("DateTimePicker").setMinDate(e.date.subtract(90, 'days'));
    });
    $("#datetimepicker1").on("dp.change", function(e) {
        $('#datetimepicker2').data("DateTimePicker").setMaxDate(e.date.add(90, 'days'));
        if ($('#datetimepicker2').data("DateTimePicker").getDate() > e.date.add(90, 'days')) {
            $("#datetimepicker2").data("DateTimePicker").setDate($('#datetimepicker1').data("DateTimePicker").getDate().add(90, 'days'));
        } else if ($('#datetimepicker2').data("DateTimePicker").getDate() <= e.date) {
            $("#datetimepicker2").data("DateTimePicker").setDate($('#datetimepicker1').data("DateTimePicker").getDate().add(1, 'days'));
        }
    });
});
function openReport(reporId)
{
	window.open('show_content.php?reportContentId='+reporId,'video','top=150, left=352, width=700, height=500, toolbar=no, menubar=no, location=no, scrollbars=no, resizable=no');
	return false;
}

