var insulin_items = ["NovoLog", "Apidra", "Humalog", "Humulin R", "Novolin R", "Humulin N", "Novolin N", "Levemir", "Lantus"];
var available_insulin_items = ["NovoLog", "Apidra", "Humalog", "Humulin R", "Novolin R", "Humulin N", "Novolin N", "Levemir", "Lantus"];
var patientDevice= null;
var patientVitalLog = null;
var vitalLogInsulin;
var finished_init = false;


function getPatientDeviceDetails(GLUCOSE_VITALS,patientId) {
    var arr = new Array();
    arr[0] = GLUCOSE_VITALS;
	arr[1] = patientId;
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, EMR, 'getDeviceByPatientIdAndVitalType', processDeviceDetails);
}

function processDeviceDetails(result) {
    patientDevice = JSON.parse(result.message);
	if(patientDevice == null || patientDevice =="null")
	{
	popupshow();
	$("#txt_div").text("No Glucometer device Assigned to the user.");
	$("#addBO").attr('disabled','disabled');
	$("#addBO").fadeTo(100,0.33);

	}
	
}
function getVitalsInfo(id) {
    var vitalsFilterInfo = new Object();
    vitalsFilterInfo.patientId = id;
    vitalsFilterInfo.deviceConfigId =$("#deviceConfigID").val();
    var startDate = new Date();
    startDate.setDate(startDate.getDate() - 90);
    var dt = startDate.toISOString().replace('Z', '') + '-0000';

    var endDate = new Date();
    endDate.setDate(endDate.getDate() + 1);
    var edt = endDate.toISOString().replace('Z', '') + '-0000';

    vitalsFilterInfo.startDate = dt;
    vitalsFilterInfo.endDate = edt;

    var arr = new Array();
    arr[0] = JSON.stringify(vitalsFilterInfo);
    var dataVal = JSON.stringify(arr);
	console.log(dataVal);
    var retVal = postDataToServer(dataVal, EMR, 'getPatientVitalInfo', processResponse);
	
}
function processResponse(result) {
	console.log(result);
    if (result != null && result.message != null && result.success == true) {
        patientDevices = JSON.parse(result.message);
		
		//console.log(patientDevices);
		patientDevices.forEach(function(patientDevice) {
   		 if(patientDevice.patientVitalId == $("#patVitalId").val())
		 {
			 patientVitalLog = patientDevice.patientVitalsLogInfo;
			 localStorage.setItem('patientDevice',JSON.stringify(patientDevice));
			 //localStorage.setItem('patientVitalLog',JSON.stringify(patientVitalLog));

		 		initFields(patientDevice,patientVitalLog);
		 }
		});
		
    }
}
function initFields(patientDevices,patientVitalLog) {
	
	if(patientDevices != null)
	{
		$("#bodyGlucose").val(patientDevices.unitValue1);
		var dateVital = moment(patientDevices.vitalTime).format('MM/D/YYYY hh:mm A');
		$("#vitalDateInput").val(dateVital);
		$("#notes").val(patientDevices.notes);
		var mealType = patientDevices.mealType;
		//patientVitalLog = patientDevices.patientVitalsLogInfo;
		if (patientVitalLog != null) 
		{
			$("#carbs").val(patientVitalLog.carbs);
			$("#mood").val(patientVitalLog.mood);
			$("#activity").val(patientVitalLog.activity);
			$("#feel").val(patientVitalLog.health);
			
			$("#bKetone").val(patientVitalLog.bloodKeetone);
			$("#urineKetone").val(patientVitalLog.urineKetone);
			 
			var urine_input = patientVitalLog.urineKetone;
			//console.log(urine_input);
			$("span[data="+urine_input+"]").addClass("active");
	 		$("span[data="+mealType+"]").addClass("active");
	        $("#mealType").val($("span[data="+mealType+"]").attr('data'));
			
			//$(".pre-post-meal a span."+mealType).addClass("active");					
			 
			 var  patientInsulinInfos = patientVitalLog.patientInsulinInfos.length;
			 //console.log(patientVitalLog.patientInsulinInfos);
			 for(var i=0; i < patientInsulinInfos; i++)
			 {
				var valueInsulin = patientVitalLog.patientInsulinInfos[i].insulinQty;
				//console.log(valueInsulin);
				$("#add-button").click();
				$("table tbody").find(".insulin-input").eq(i).val(valueInsulin);
				
			}
		}
	}
}

function addInsulinItem(event) {
    if ($(".insulin-item").length < 6) {
        var insulin_content = $(event.target).parents(".section");
		if ($(".insulin-item").length > 2) {
		var whiteDivHeight= $("#whiteDiv").height();
		whiteDivHeight=whiteDivHeight+200;
		$("#whiteDiv").height(whiteDivHeight);
	}

        var content_container = $("<tr><td align='right'><span>")
            .attr("class", "insulin-item")
            .appendTo(insulin_content);

        var insulin_select = $("<select>")
            .on("change", checkInsulinItems)
            .appendTo(content_container);
        $("<span aria-hidden='true'><span>")
            .attr("type", "text")
            .attr("class", " coloredTable")
            .appendTo(content_container);
			 $("<input>")
            .attr("type", "text")
            .attr("class", "insulin-input limited-input lbsText  req entry")
            .appendTo(content_container);
        $("<span class='UnitTable'><br>")
            .text("mg/dL")
            .appendTo(content_container);

        available_insulin_items.forEach(function(element, index, array) {
            $("<option>")
                .html(element)
                .val(element)
                .appendTo(insulin_select);
        });
        available_insulin_items.shift();

        checkInsulinItems();

        if (entityType.toUpperCase() == "PATIENT" || entityType.toUpperCase() == "PROVIDER") {
            $('.limited-input').on('keydown', function(event) {
        if (($(this).val().length > 5 && event.which != 8  && event.which != 9) || isNaN(String.fromCharCode(event.which))  && event.which != 9 && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode != 190 && event.keyCode != 110)
                    return false;
            });
			
      $('.insulin-input').on('keydown', function(event) {
        var num =$(this).val();
		var digits = num.toString().split('');
		var LengthOfValue=$(this).val().length;
        if (digits[0] == "." || digits[0] == undefined && LengthOfValue == 0 ) {
		$(this).attr("maxlength","3");
        }
        else if (digits[1] == "."  || digits[1] == undefined  && LengthOfValue == 1 ) {
		$(this).attr("maxlength","4");
        }
        else if (digits[2] == undefined  && LengthOfValue == 2 ) {
		$(this).attr("maxlength","5");
		if (event.which != 8  && event.which != 9 && event.keyCode != 190 && event.keyCode != 110)
           return false;
        }
        else if (digits[3] == "."  && LengthOfValue == 2 ) {
		if ((event.which != 8) || isNaN(String.fromCharCode(event.which)) && event.which != 9 && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105))
           return false;
        }
      });
        } else {
            $('.limited-input').on('keydown', function(event) {
                return false;
            });
        }
    }
}

function checkInsulinItems() {
    available_insulin_items = insulin_items.slice(0, insulin_items.length);

    $(".insulin-item > select").each(function(index) {
        var item_index = available_insulin_items.indexOf($(this).val());
        if (index > -1) {
            available_insulin_items.splice(item_index, 1);
        }
    });

    $(".insulin-item > select").each(function(index) {
        var currentItem = $(this).val();

        var current = $(this);

        current
            .find('option')
            .remove()
            .end();

        $("<option>")
            .html(currentItem)
            .val(currentItem)
            .appendTo(current);

        available_insulin_items.forEach(function(element, index, array) {
            $("<option>")
                .html(element)
                .val(element)
                .appendTo(current);
        });
    });
}
function initInsulin(vitalLogInsulin) {

    for( var i = 0; i < vitalLogInsulin.length -1; ++i) {
        $("#add-button").click();
    }

    var insulinItems = $(".insulin-item");
    for( var i = 0; i < vitalLogInsulin.length; ++i) {
        $(insulinItems[i]).find("input").val(vitalLogInsulin[i].insulinQty);
        $(insulinItems[i]).find("select").val(vitalLogInsulin[i].insulinType);
    }
}
/*$('input[type=submit]').click(function() {
    $(this).attr('disabled', 'disabled');
	$(this).unbind( "click" );
    //$(this).parents('form').submit();
})*/
function callFunctionBG() {

	var mealType = $("#mealType").val();
	if(mealType == "")
	{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Warning");
		$("#txt_div").text("Please select state(Meal Type).");
		$("#okey").focus();
		return false;
	}
	else if($('#bodyGlucose').val() == 0)
	{
	$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Warning");
		$("#txt_div").text("Blood glucose value must not be 0.");
		$("#okey").focus();
		return false;
	
	}
	else
	{
		$("#addBG").attr('disabled', 'disabled');
		$('#bp-form span').addClass('disabled')
		$("#addBG").unbind( "click" );
	}
	
    var bodyGlucose = $("#bodyGlucose").val();
    var notes = $("#notes").val();
	var vitalDateInput = $("#vitalDateInput").val();
    var mealType = $("#mealType").val();
    var urineKetone = $("#urineKetone").val();
	var bKetone = $("#bKetone").val();
    var carbs = $("#carbs").val();
	var mood = $("#mood").val();
	var activity = $("#activity").val();
	var feel = $("#feel").val();
	 var insulin_to_save = new Array();

	if (!$("#patVitalId").val()) {
		patientVitalLog = new Object();
		patientVitalLog.state = INSERT;
		}
		else
		{
			patientVitalLog.state = UPDATE;
			patientVitalLog.patientVitalId = $("#patVitalId").val();
	
		}

    var iter = 0;

    $(".insulin-item").each(function(index) {
        var currentItem = $(this).find("select").val();
        var currentValue = $(this).find("input").val();

        if (currentValue.trim() != "") {
            var currentInsulin = new Object();
            currentInsulin.insulinType = currentItem;
            currentInsulin.insulinQty = parseFloat(currentValue);
           // currentInsulin.patientVitalId = vitalId;
            if (patientVitalLog.patientInsulinInfos != null && patientVitalLog.patientInsulinInfos.length > iter) {
                patientVitalLog.patientInsulinInfos[iter].state = 2;
                patientVitalLog.patientInsulinInfos[iter].insulinType = currentInsulin.insulinType;
                patientVitalLog.patientInsulinInfos[iter].insulinQty = currentInsulin.insulinQty;
            } else {
                currentInsulin.state = 1;
                insulin_to_save.push(currentInsulin);
            }
        }
        iter++;
    });
    if (insulin_to_save.length > 0) {
        patientVitalLog.patientInsulinInfos = insulin_to_save;
    }
	var date = new Date(vitalDateInput);
	var dt = date.toISOString().replace('Z', '') + '-0000';
	console.log(patientDevice);
	if(carbs == ""){carbs = 0;} if(urineKetone == ""){urineKetone = 0;} if(bKetone == ""){bKetone = 0;}
	patientVitalLog.mood = mood;
	patientVitalLog.carbs = carbs;
	patientVitalLog.activity = activity;
	patientVitalLog.health = feel;
	patientVitalLog.urineKetone = urineKetone;
	patientVitalLog.bloodKeetone = bKetone;
	
	if(!$("#patVitalId").val())
	{
		patientDevice.state = INSERT;
	}
	else
	{
		patientDevice.state = UPDATE;
		patientDevice.patientVitalId = $("#patVitalId").val();


	}
	
	patientDevice.patientVitalsLogInfo = patientVitalLog;
	patientDevice.vitalTime = dt;
	patientDevice.unitValue1 = bodyGlucose;
	patientDevice.notes = notes;
	patientDevice.mealType = mealType;
	
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
	//var getlocalStorage = localStorage.getItem('patientDevice');
	//patientDevice = JSON.parse(getlocalStorage);
	////var date = new Date(patientDevice.vitalTime);
	//var dt = date.toISOString().replace('Z', '') + '-0000';
		//patientDevice.unitValue1 = 220;
		//patientDevice.vitalTime = "2015-11-19T09:21:34.450+0530";

	//patientDevice.state = UPDATE;
	arr[0] = JSON.stringify(patientDevice);
	var dataVal = JSON.stringify(arr);
	//console.log(dataVal);
	var retVal = postDataToServer(dataVal, EMR, 'createUpdatePatientVitals', processSaveResponse);
	
      
}
function processSaveResponse(result) {
	console.log(result);
  patVitalInfos = JSON.parse(result.message);
	$("#deviceConfigID").val(patVitalInfos.deviceConfigId);
	var	patID = $("#contextPatientId").val();
	var deviceConfigId = $("#deviceConfigID").val();
    if (result.success == true) {

        if ($('#myModal').hasClass('in')) {
            //jQuery.noConflict();
            $('#confirmModal').on('hidden.bs.modal', function(e) {
                openPageWithAjax('../../vitals/pages/vitals_graphBG.php', 'deviceConfigId='+deviceConfigId+'&vitalType=Blood Glucose&contextPId='+patID, 'menu-content', undefined, undefined);
            });
        } else {
           // jQuery.noConflict();
            //$('#myModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            openPageWithAjax('../../vitals/pages/vitals_graphBG.php', 'deviceConfigId='+deviceConfigId+'&vitalType=Blood Glucose&contextPId='+patID, 'menu-content', undefined, undefined);
           // jQuery.noConflict();
            $('#confirmModal').on('hidden.bs.modal', function(e) {
                openPageWithAjax('../../vitals/pages/vitals_graphBG.php', 'deviceConfigId='+deviceConfigId+'&vitalType=Blood Glucose&contextPId='+patID, 'menu-content', undefined, undefined);
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
						   
 $('#bodyGlucose').on('keydown', function(event) {	
       
	   if (($(this).val().length > 2 && event.which != 8 && event.which != 9) || isNaN(String.fromCharCode(event.which)) && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105))
		{
		
            return false;
		}
    });
 
  $('#bodyGlucose').on('focusout', function()
	{	
		if($(this).val() == 0)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Warning");
		$("#txt_div").text("Blood glucose value must not be 0.");
		$("#okey").focus();
		return false;
		}
    });
  $('#carbs').on('keydown', function(event) {	
        if (($(this).val().length > 2 && event.which != 8 && event.which != 9) || isNaN(String.fromCharCode(event.which)) && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105))
		{
            return false;
		}
    });
   $('#bKetone').on('keydown', function(event) {	
        if (($(this).val().length > 1 && event.which != 8 && event.which != 9) || isNaN(String.fromCharCode(event.which)) && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105))
		{
            return false;
		}
    });
 
	var patVitalId = $("#patVitalId").val();
	var patVitalTime = $("#vitalTime").val();
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
	
	if(patVitalId)
	{
	getVitalsInfo(id);
	}
    getPatientDeviceDetails(GLUCOSE_VITALS,id);
	
    $('#datetimepicker1').datetimepicker({
        pickTime: true,
        maxDate: moment(),
	defaultDate: new Date(),	
    });
	//setupInsulin(insulin_content);
	
$("#bp-form input.entry").on('keyup change mouseover',function()
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
$(document).mousemove(function()
{
 var vitalDateInput = $("#vitalDateInput").val();
 var bodyGlucose = $("#bodyGlucose").val();
 
if(vitalDateInput !=""  && bodyGlucose !="")
 {
	
	  $("#bp-form input.entry").removeClass("rq");
	  checkReqField();
 } 
});
function checkReqField()
{
var reqField = $("#bp-form input.rq").length;
	if(reqField >0)
	{
		$("#addBG").attr("disabled","disabled");
		$("#addBG").addClass("disabled");
	}
	else
	{
		if(!$('#bp-form span').hasClass('disabled'))
		{
		$("#addBG").removeAttr("disabled");
		$("#addBG").removeClass("disabled");
		}
	}

}


$('td.pre-post-meal').on('click', 'span', function() {
	if(!$(this).hasClass('disabled'))
	{
    $('.pre-post-meal span.active').removeClass('active');
    $(this).addClass('active');
	$("#mealType").val($(this).attr('data'));
	}
});
});
/*
	var userType = $("#userType").val();
	 userType = userType.toUpperCase();
	 if(userType == "PROVIDER")
	 {
		 setInterval(function(){
		$("#bp-form input,select,textarea").attr("disabled","disabled");
		$("#bp-form span").addClass("disabled");
		$("#add-button").removeAttr("onclick");
		$("#addBG").attr("disabled","disabled");
		$("#addBG").addClass("disabled");
		}, 20);
		
	 }*/


