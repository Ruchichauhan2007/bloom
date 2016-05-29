var patientDevice;
var patientVitalLog = null;

function getPatientDeviceDetails(PEAK_FLOW_METER,patientId) {
    var arr = new Array();
    arr[0] = PEAK_FLOW_METER;
	arr[1] = patientId;
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, EMR, 'getDeviceByPatientIdAndVitalType', processDeviceDetails);
}

function processDeviceDetails(result) {
    patientDevice = JSON.parse(result.message);
	if(patientDevice == null || patientDevice =="null")
	{
	popupshow();
	$("#txt_div").text("No Peak flow meter device Assigned to the user.");
	$("#addBO").attr('disabled','disabled');
	$("#addBO").fadeTo(100,0.33);

	}
	
}
function callFunctionPF() {
	//dateFormate();
    var peakFlow = $("#peakFlow").val();
    var range = $("#range").val();
    var notes = $("#notes").val();
	var vitalDateInput = $("#vitalDateInput").val();
	var date = new Date(vitalDateInput);
	var dt = date.toISOString().replace('Z', '') + '-0000';   
	patientDevice.vitalTime = dt;
	patientDevice.unitValue1 = peakFlow;
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
			patientVitalLog.mood = $("#range").val();
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
  patVitalInfos = JSON.parse(result.message);
  var	patID = $("#contextPatientId").val();
  var deviceConfigId = $("#deviceConfigID").val();
        if ($('#myModal').hasClass('in')) {
            //jQuery.noConflict();
            $('#confirmModal').on('hidden.bs.modal', function(e) {
                openPageWithAjax('../../vitals/pages/vitals_graphPF.php', 'vitalType=Peak Flow&deviceConfigId='+deviceConfigId+'&contextPId='+patID, 'menu-content', undefined, undefined);
            });
        } else {
           // jQuery.noConflict();
            //$('#myModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            openPageWithAjax('../../vitals/pages/vitals_graphPF.php', 'vitalType=Peak Flow&deviceConfigId='+deviceConfigId+'&contextPId='+patID, 'menu-content', undefined, undefined);
           // jQuery.noConflict();
            $('#confirmModal').on('hidden.bs.modal', function(e) {
                openPageWithAjax('../../vitals/pages/vitals_graphPF.php', 'vitalType=Peak Flow&deviceConfigId='+deviceConfigId+'&contextPId='+patID, 'menu-content', undefined, undefined);
            });
           // jQuery.noConflict();
            $('#confirmModal').modal('hide');
        }
		    //jQuery.noConflict();
			$('#myModal').removeClass('in')
            $('#confirmModal').modal('hide');

}
$(document).ready(function() {
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
	getPatientDeviceDetails(PEAK_FLOW_METER,id);
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