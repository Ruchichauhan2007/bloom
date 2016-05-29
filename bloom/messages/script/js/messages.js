function callFunction() {
    var date = new Date();
    var dt = date.toISOString().replace('Z', '') + '-0000';

    var descriptionText = $(".new-message-input").val();
    var descriptionLength = $(".new-message-input").val().length;
    var isPatientViewable = $("#checkbox1");
    if (isPatientViewable.length > 0) {
        if ($(isPatientViewable).is(":checked")) {
            isPatientViewable = true;
        } else {
            isPatientViewable = false;
        }
    } else {
        isPatientViewable = true;
    }
	
	 var isUrgent = $("#checkbox2");
    if (isUrgent.length > 0) {
        if ($(isUrgent).is(":checked")) {
            isUrgent = true;
        } else {
            isUrgent = false;
        }
    } else {
        isUrgent = flase;
    }

    if (!(descriptionText == "")) {
        var patientIdVal = $("#contextPatientId").val();
        var editUserIdVal = $("#currentUserId").val();

        if (typeof patientIdVal == "null" || patientIdVal == "" || isNaN(patientIdVal)) {
            patientIdVal = $("#currentUserId").val();
        }
		$("#sending_message").show();
        var userIdVal = $("#currentUserId").val();
        var stickyNoteInfo = {
            editUserId: parseInt(editUserIdVal),
            patientId: parseInt(patientIdVal),
            userId: parseInt(userIdVal),
            state: INSERT,
            description: descriptionText,
            noteType: "STICKY",
            patientViewable: isPatientViewable,
			urgent :isUrgent
        }
        var arr = new Array();
        arr[0] = JSON.stringify(stickyNoteInfo);
        var dataVal = JSON.stringify(arr);
        $( document.body ).removeData( "message");
        var retVal = postDataToServer(dataVal, EMR, 'createUpdateStickyNote', processSubmitNotes);
       
    } else {
        $("#light").hide();
		$("#sending_message").hide();
		$("#confirmModal").hide();
        showPop();
        $("#txt").html("Please fill message content.")
    }
}


function processSubmitNotes(result) {
    if ($('#myModal').hasClass('in')) {
        //////jQuery.noConflict();
        $('#confirmModal').on('hidden.bs.modal', function(e) {
			$("#light").hide();
            openPageWithAjax('../../messages/pages/messages.html', '', 'menu-content', undefined, undefined);
        });
    } else {
        //////jQuery.noConflict();
    	//$('#myModal').modal('hide');
    	$('body').removeClass('modal-open');
    	$('.modal-backdrop').remove();
        openPageWithAjax('../../messages/pages/messages.html', '', 'menu-content', undefined, undefined);
        //////jQuery.noConflict();
        $('#confirmModal').on('hidden.bs.modal', function(e) {
            openPageWithAjax('../../messages/pages/messages.html', '', 'menu-content', undefined, undefined);
        });
        ////jQuery.noConflict();
        $('#confirmModal').modal('hide');
    }
}

function cancelMessage() {
    hideMessageBox();
    $( document.body ).removeData( message);
}

function showMessageBox() {
    $(".dashboard_box_bg_img").remove();
    $(".dashboard_box_bg_text").remove();
    $(".dashboard_box_bg").height("125px");

    //  $("#patient-avatar").on("click", function() {
    $("#selectedPatient").prepend("<input type='checkbox' id='checkbox1'><label for='checkbox1' id='checkbox-label'>&nbsp Show to patient</label>");
    $('#checkbox1').prop('checked', true);
	
    $("#patient-avatar").unbind("click");
    // });
	$("#messages-content").append("<p id='urgent'><input type='checkbox' id='checkbox2'><label for='checkbox2' id='checkbox-label2'>&nbsp Urgent</label></p>");
	var userType=$("#userType").val();
		if(userType.toUpperCase() =="PATIENT")
		{
		   // $('#selectedPatient').hide();
			
		}
		else
		{
				$('#urgent').hide();
		}
    $(".dashboard_box_bg").append("<div class='new-message-container'></div>"); //.append("<div id='triangle-topright'></div>");
	$('#checkbox2').prop('checked', false);
    $(".new-message-container").append("<span class='message-writer-name'>" + $("#currentUserName").val() + "</span>");
    $(".new-message-container").append("<textarea class='new-message-input' onkeyup='lengthValidate(this.id)' id='message_box' maxlength='800'></textarea>");
    $.data( document.body, "message", $.trim($('#message_box').val()) );
    console.log('date : '+$.data( document.body, "message"));
    $("#message_box").focus();

    $("<div class='button-content'><input class='cancelButton btn-neutral' type='reset' onClick='javascript:cancelMessage()' value='Cancel'><input class='nextButton btn-neutral' type='submit' value='Send' onClick='javascript:callFunction()' data-target='#confirmModal' data-toggle='modal'></div>").insertAfter(".dashboard_box_bg");
}

function lengthValidate(text_box) {
		var messageLength=$("#"+text_box).val();
		var newLines =messageLength.match(/(\r\n|\n|\r)/g);
        var addition = 0;
        if (newLines != null) {
            addition = newLines.length;
        }
		messageLength=messageLength.length + addition;
    if (messageLength >= 800) {
        $("#light").hide();
        showPop();
        $("#txt").html("Adding message reached maximum allowed limit.")
    }
}

function hideMessageBox() {
    $(".button-content").remove();
    $(".dashboard_box_bg").height("");
    $("#patient-avatar").unbind("click")
    $("#checkbox-label").remove();
    $("#checkbox1").remove();
	$("#checkbox-label2").remove();
    $("#checkbox2").remove();
	$('#urgent').remove();

    $(".dashboard_box_bg").html('<div class="dashboard_box_bg_text"><a href="#" onClick="javascript:showMessageBox()">New Message</a></div>');
}
var lastModifiedNames = [];
var timestamps = [];
var descriptions = [];
var pdfColor = []; 

function processGetNotes(result) {
    if (result == null || result.success == false || result.message == "") {
        alert("Unable to load messages");
    } else {
        $("#PatientList_part_bg").empty();
		
		lastModifiedNames = [];
		timestamps = [];
		descriptions = [];
		pdfColor = [];
		
		
        var messageJson = JSON.parse(result.message);

        for (i = 0; i < messageJson.length; ++i) {

            if (messageJson[i].noteType == "STICKY") {
                color = "blue";
                editUserId = messageJson[i].editUserId;
                patientId = messageJson[i].patientId;

                if (editUserId == patientId) {
                    color = "yellow";
                }
                createdTimestamp = moment(messageJson[i].createTimeStamp);
                var messagehtml = "";
                messagehtml = messagehtml + "<div class='message-container'><div class='message_box_bg'><div class='message_box_bg_";
                messagehtml = messagehtml + color + "'><h2>" + messageJson[i].lastModifiedName + "</h2><h4>" + createdTimestamp.format("MMM D h:mm A") + "</h4></div><div class='message_text_cl'><h3>";
                messagehtml = messagehtml + messageJson[i].description + "</h3></div></div><a class='message-box-btn received-msg' href='#'><img src='../../common/images/message-received-icon.svg'></a></div>"

				lastModifiedNames.push(messageJson[i].lastModifiedName);
				timestamps.push(createdTimestamp.format("MMM D h:mm A"));
				descriptions.push(messageJson[i].description);
				pdfColor.push(color);
				
                var patientList = $("#PatientList_part_bg");
                patientList.append(messagehtml);
            }
        }
    }
}

function getStickyNoteCards(patientId) {
    var arr = new Array();
    arr[0] = patientId;
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, EMR, 'getStickyNoteByPatientId', processGetNotes);
}

$(document).ready(function() {
    var id = $("#contextPatientId").val();

    if (id == "" || isNaN(id)) {
        id = $("#currentUserId").val();
    }
    //id = 57;
    getStickyNoteCards(id);

    var $scrollOuter = $('div.scroll-outer:eq(0)');
    var $scrollInner = $('div.scroll-inner:eq(0)');

    $scrollOuter.scroll({
        minimalScrollbarHeight: 50,
        accelerator: 4
    });
});

function hidePopup() {
    $("#light").hide();
	$("#sending_message").hide();
	////jQuery.noConflict();
    $('#confirmModal').modal('hide');
}

function showPop() {
    $(".dashboard_box_bg").prepend("<div class='white_content' id='light'><p class='cart1'>Message<a href='#' id='img_close'  onClick='javascript:hidePopup()'><img src='../images/close.jpg' align='right' class='close1'></a></p><div class='dashboard_box_bg_text'><a href='#'></a></div><div class='alert'><img src='../images/alert.jpg' align='left'  /><div id='txt'></div><a href = '#' id='okey_close'  onClick='javascript:hidePopup()'>Okay</a></div>");

}
function showPopAlert() {
    $(".dashboard_box_bg").prepend("<div class='white_content' id='light'><p class='cart1'>Message<a href='#' id='img_close'  onClick='javascript:hidePopup()'><img src='../images/close.jpg' align='right' class='close1'></a></p><div class='dashboard_box_bg_text'><a href='#'></a></div><div class='alert'><img src='../images/alert.jpg' align='left'  /><div id='txt'></div><a href = '#' id='okey_close' class='cancelButton btn-neutral'  onClick='javascript:hidePopup()'>No</a><a href = '' class='nextButton btn-neutral' id='yesResponse'  onClick='javascript:hidePopup()'>Okay</a></div>");

}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

function exportToPDF() {
	
	var doc = new jsPDF();
	var xCord = 10; //x coordinate set to 10px
	var yCord = 30; //y coordinate set to 10px
	var filePdf = moment().format('lll');

	var fileName = $('#contextPatientName').val();
	if ( fileName.length == 0 ) fileName = 'Admin';
	doc.text(15,7,'Logged In As:');
	
	var userName = getCookie("userName") ;
	userName = userName.replace('+', ' ');
	doc.text(52,7,userName);      //userName
	
	doc.text(7,14,'Generated Time:');
	
	//alert(moment().format('lll'));
	
	doc.text(52,14,moment().format('lll'));
	doc.text(18,21,'Created For:');
	doc.text(52,21,fileName);

	doc.setLineWidth(0.5);
	doc.line(5, 23, 200, 23);
	
	var textDisplay;
	
	for (var i = 0; i < lastModifiedNames.length ; i++ ) {
		
		if(pdfColor[i] =='yellow')
		{
			doc.setDrawColor(0);
			doc.setFillColor(255,255,0);   //Color value is Yellow
			doc.rect(xCord-4,yCord-6,180,10,'F');
		}
		else
		{
			doc.setDrawColor(0);
			doc.setFillColor(33,150,243);   //Color value is Blue
			doc.rect(xCord-4,yCord-6,180,10,'F');
		}

		if(yCord>=280)
		{
			yCord = 10;
			doc.addPage();
		}
		doc.text(xCord,yCord,lastModifiedNames[i]);
		doc.text(xCord+130,yCord,timestamps[i]);
		//doc.text(xCord,yCord +10, descriptions[i]);
		textDisplay = doc.splitTextToSize(descriptions[i],170);
		yCord +=10;
		doc.text(15,yCord,textDisplay);
		//For formating
		yCord +=10;
		
		
		// if y == 280 or > 280 add page and reset y to 10
		yCord += (textDisplay.length*10);
	}
		doc.save('Messages_'+filePdf+'.pdf');	 
}