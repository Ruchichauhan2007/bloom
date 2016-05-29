var patientDevice;
var patientVitalLog = null;

function getPatientDeviceDetails(PULSE_OXIMETER,patientId) {
    var arr = new Array();
    arr[0] = PULSE_OXIMETER;
	arr[1] = patientId;
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, EMR, 'getDeviceByPatientIdAndVitalType', processDeviceDetails);
}

function processDeviceDetails(result) {
	//console.log(result);
    patientDevice = JSON.parse(result.message);
	if(patientDevice == null || patientDevice =="null")
	{
	popupshow();
	$("#txt_div").text("No Blood Oxymeter device Assigned to the user.");
	$("#addBO").attr('disabled','disabled');
	$("#addBO").fadeTo(100,0.33);

	}
	
}
function callFunctionBO() {
	//dateFormate();
    var SpO2 = $("#SpO2").val();
    var pulseRate = $("#pulse").val();
    var notes = $("#notes").val();
	var vitalDateInput = $("#vitalDateInput").val();
	var date = new Date(vitalDateInput);
	var dt = date.toISOString().replace('Z', '') + '-0000';   
	patientDevice.vitalTime = dt;
	patientDevice.unitValue2 = SpO2;
	if(pulseRate != "")
	{
	patientDevice.unitValue1 = pulseRate;
	}
	patientDevice.notes = notes;
	patientDevice.state = INSERT;
	patientDevice.fkPatientDeviceDetailId = patientDevice.patientDeviceDetailId;
	var userType = $("#userType").val();
	 userType = userType.toUpperCase();
	 var patientID ;
	 if(userType == "PROVIDER")
	 {
		patientDevice.observationMode = PROV_TAKEN_MANUAL;
		patientID = $("#contextPatientId").val();
		patientDevice.providerId = $("#currentProvId").val();
		var name = $("#currentProvName").val().split(" ");
		patientDevice.provFirstName = name[0];
		patientDevice.provLastName = name[1];
	 }
	 
	 else
	 {
		 patientID = $("#currentUserId").val(); 
		 patientDevice.observationMode = PAT_TAKEN_MANUAL;
	 }
	 patientDevice.patientId = patientID;
	var arr = new Array();
	arr[0] = JSON.stringify(patientDevice);
	var dataVal = JSON.stringify(arr);
	var retVal = postDataToServer(dataVal, EMR, 'createUpdatePatientVitals', processResponse);
	
      
}



function processResponse(result) {
   patVitalInfos = JSON.parse(result.message);
	$("#deviceConfigID").val(patVitalInfos.deviceConfigId);
    if (result.success == true) {
		var vitalId = patVitalInfos.patientVitalId ;
		// if (entityType.toUpperCase() == "PATIENT") {
        if (patientVitalLog == null) {
            patientVitalLog = new Object();
			patientVitalLog.mood = $("#mood").val();
            patientVitalLog.state = 1;
        } else {
            patientVitalLog.state = 2;
        }

        patientVitalLog.patientVitalId = vitalId;

        var arr = new Array();
        arr[0] = JSON.stringify(patientVitalLog);
        var dataVal = JSON.stringify(arr);
        var retVal = postDataToServer(dataVal, EMR, 'createUpdatePatientVitalsLog', processSaveResponse);
   /* } else {
        processSaveResponse("result");
    }*/
        

    } else {
        alert(result.message);
    }
}
function processSaveResponse(result) {
	var	patID = $("#contextPatientId").val();
	var deviceConfigId = $("#deviceConfigID").val();
    if ($('#myModal').hasClass('in')) {
            //jQuery.noConflict();
            $('#confirmModal').on('hidden.bs.modal', function(e) {
                openPageWithAjax('../../vitals/pages/vitals_graphBP.php', 'vitalType=Blood Oxygen&deviceConfigId='+deviceConfigId+'&contextPId='+patID, 'menu-content', undefined, undefined);
            });
        } else {
           // jQuery.noConflict();
            //$('#myModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            openPageWithAjax('../../vitals/pages/vitals_graphBP.php', 'vitalType=Blood Oxygen&deviceConfigId='+deviceConfigId+'&contextPId='+patID, 'menu-content', undefined, undefined);
           // jQuery.noConflict();
            $('#confirmModal').on('hidden.bs.modal', function(e) {
                openPageWithAjax('../../vitals/pages/vitals_graphBP.php', 'vitalType=Blood Oxygen&deviceConfigId='+deviceConfigId+'&contextPId='+patID, 'menu-content', undefined, undefined);
            });
           // jQuery.noConflict();
            $('#confirmModal').modal('hide');
        }
		    //jQuery.noConflict();
			$('#myModal').removeClass('in')
            $('#confirmModal').modal('hide');
}
$(document).ready(function() {
$('#SpO2').on('keydown', function(event) {	
       
	   if (($(this).val().length > 2 && event.which != 8 && event.which != 9) || isNaN(String.fromCharCode(event.which)) && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105))
		{
		
            return false;
		}
    });
$('#pulse').on('keydown', function(event) {	
       
	   if (($(this).val().length > 2 && event.which != 8 && event.which != 9) || isNaN(String.fromCharCode(event.which)) && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105))
		{
		
            return false;
		}
    });

$(function() {
  $('#bp-form').on('keydown', '#SpO2,#pulse', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
});
	var userType = $("#userType").val();
	 userType = userType.toUpperCase();
	 if(userType == "PROVIDER")
	 {
		var	id = $("#contextPatientId").val();
	 }
	 else
	 {
		var	id = $("#currentUserId").val(); 
	 }
    getPatientDeviceDetails(PULSE_OXIMETER,id);
    $('#datetimepicker1').datetimepicker({
        pickTime: true,
        maxDate: moment(),
	defaultDate: new Date(),	
    });
	
$("#bp-form input.entry").on('keyup change',function()
{
	if($(this).val()!="")
	{
	$(this).removeClass("rq");
	}
	else
	{
	$(this).addClass("rq");	
	}
	checkReqField();	
});

function checkReqField()
{
var reqField = $("#bp-form input.rq").length
	if(reqField >0)
	{
		$("#addBO").attr("disabled","disabled");
		$("#addBO").addClass("disabled");
	}
	else
	{
		$("#addBO").removeAttr("disabled");
		$("#addBO").removeClass("disabled");
	}

}
});