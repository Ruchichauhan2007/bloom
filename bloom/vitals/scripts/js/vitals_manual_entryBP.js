var patientDevice;


function getPatientDeviceDetails(Measurement1,patientId) {
    var arr = new Array();
    arr[0] = Measurement1;
	arr[1] = patientId;
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, EMR, 'getDeviceByPatientIdAndVitalType', processDeviceDetails);
}

function processDeviceDetails(result) {
	console.log(result);
    patientDevice = JSON.parse(result.message);
	if(patientDevice == null || patientDevice =="null")
	{
	popupshow();
	$("#txt_div").text("No Blood Pressure device Assigned to the user.");
	$("#addBP").attr('disabled','disabled');
	$("#addBP").fadeTo(100,0.33);

	}
	
}
function callFunctionBP() {
	//dateFormate();
    var systolic = $("#systolic").val();
    var diastolic = $("#diastolic").val();
    var pulseRate = $("#pulseRate").val();
    var notes = $("#notes").val();
	var vitalDateInput = $("#vitalDateInput").val();
	var date = new Date(vitalDateInput);
	var dt = date.toISOString().replace('Z', '') + '-0000';   
	patientDevice.vitalTime = dt;
	patientDevice.unitValue2 = systolic;
	patientDevice.unitValue1 = diastolic;
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
		var	patID = $("#contextPatientId").val();
		var deviceConfigId = $("#deviceConfigID").val();
    if (result.success == true) {
        if ($('#myModal').hasClass('in')) {
            //jQuery.noConflict();
            $('#confirmModal').on('hidden.bs.modal', function(e) {
                openPageWithAjax('../../vitals/pages/vitals_graphBP.php', 'deviceConfigId='+deviceConfigId+'&vitalType=Blood Pressure&contextPId='+patID, 'menu-content', undefined, undefined);
            });
        } else {
           // jQuery.noConflict();
            //$('#myModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            openPageWithAjax('../../vitals/pages/vitals_graphBP.php', 'deviceConfigId='+deviceConfigId+'&vitalType=Blood Pressure&contextPId='+patID, 'menu-content', undefined, undefined);
           // jQuery.noConflict();
            $('#confirmModal').on('hidden.bs.modal', function(e) {
                openPageWithAjax('../../vitals/pages/vitals_graphBP.php', 'deviceConfigId='+deviceConfigId+'&vitalType=Blood Pressure&contextPId='+patID, 'menu-content', undefined, undefined);
            });
           // jQuery.noConflict();
            $('#confirmModal').modal('hide');
        }
		    //jQuery.noConflict();
			$('#myModal').removeClass('in')
            $('#confirmModal').modal('hide');

    } else {
        alert(result.message);
    }
}

$(document).ready(function() {
	 $('#systolic').on('keydown', function(event) {	
        if (($(this).val().length > 2 && event.which != 8 && event.which != 9) || isNaN(String.fromCharCode(event.which)) && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105))
		{
            return false;
		}
    });
	 $('#diastolic').on('keydown', function(event) {	
        if (($(this).val().length > 2 && event.which != 8 && event.which != 9) || isNaN(String.fromCharCode(event.which)) && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105))
		{
            return false;
		}
    });

$(function() {
  $('#bp-form').on('keydown', '#systolic,#diastolic', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
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
	getPatientDeviceDetails(Measurement1,id);
    $('#datetimepicker1').datetimepicker({
        pickTime: true,
        maxDate: moment(),
	defaultDate: new Date(),		
    });
	
$("#bp-form input.entry").on('keyup change',function()
{
	if($(this).val()!="")
	{
	$(this).removeClass("req");
	}
	else
	{
	$(this).addClass("req");	
	}
	checkReqField();	
});

function checkReqField()
{
var reqField = $("#bp-form input.req").length
	if(reqField >1)
	{
		$("#addBP").attr("disabled","disabled");
		$("#addBP").addClass("disabled");
	}
	else
	{
		$("#addBP").removeAttr("disabled");
		$("#addBP").removeClass("disabled");
	}

}
});