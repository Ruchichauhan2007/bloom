// Global vars: 
var SUP_CFG_ID_STRIPS = 11;	
var SUP_CFG_ID_SOLNAFTER = 13;
var SUP_CFG_ID_LANCETS = 12;
var SUP_CFG_ID_GLUCOID = 8;
// Configrable params. will be populated onpageload: 
var stripsSupplyId = 0;
var solutionAfterSupplyId = 0;
var lancetsSupplyId = 0;
var glucoIdSupplyId = 0; 
var frequency = 0;

// Set valueChanged flags:
var stripsChanged = false;
var lancetsChanged = false;
var solutionAfterChanged = false;
var glucoIdChanged = false;

var defaultValsMap = {};

$( document ).ready(function() {
	if(patId == "") {
		patId = $("#currentUserId").val();	
	}
	
	$("#solutionAfter").datepicker({
		showOn: "button",
		buttonImage: "/gladstone/portal/bloom/dashboard/images/celender-icon.png",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat: "mm/dd/yy",
		changeMonth: true,
		changeYear: true,
		yearRange: "2002:2020"
	});
	
	$('#strips').change(function() {
		stripsChanged = true;
	});
	$('#lancets').change(function() {
		lancetsChanged = true;
	});
	/*$('#solutionAfter').change(function() {
		solutionAfterChanged = true;
	});*/
	$('#glucoId').change(function() {
		glucoIdChanged = true;
	});
	
	$("#supplyForm").submit(function() {
		return supplyLevelsFormSubmited();
	});
	
	$("#createOrder").click(function() {
		/*var orderNote = $("#orderNote").val();
		var shipMethod = $("#shipMethod").val();
		if(shipMethod == "Select Method") {
			$(".cart_page").html("Shipping Method");
			$(".txt_div").html("Please select shipping method!");
			$("#aboutPopup").show();
			
			return;
		}
		
		if(!orderNote && orderNote.length == 0) {
			$(".cart_page").html("Order Note");
			$(".txt_div").html("Please enter some orderNote!");
			$("#aboutPopup").show();
			return;
		}
		else
		{*/
		$('#confirm').modal('show');
		//}
	});
	$("#yes").click(function() {
		createOrderBtnClicked();
	});
	
	// Supply Levels: 
	populateSupplyLevels();
	
	// Supply List Table, Header: 
	//populateCoachName();
	//populateDeviceDetails();
	populateSupplyList();
	
	// Order History Table: 
	populateOrderHistory();

	$("#createOrder").prop('disabled', true);
});

function supplyLevelsFormSubmited() {
	var stripsCnt = $('#strips').val();
	var lancetsCnt = $('#lancets').val();
	//var slnAfter = $('#solutionAfter').val();
	var glucometerId = $('#glucoId').val();

	if(stripsCnt.length==0 || stripsCnt == NaN || stripsCnt<0 )
	{
		  $(".txt_div").html("Please enter a valid Strips Value");
		  $(".cart_page").html("Invalid Supply Levels");
		  $("#aboutPopup").show();
		return false;
	}
	if(lancetsCnt.length==0 || lancetsCnt == NaN || lancetsCnt<0 )
	{
		  $(".txt_div").html("Please enter a valid Lancets Value");
		  $("cart_page").html("Invalid Supply Levels");
		  $("#aboutPopup").show();
		return false;
	}
	/*if(slnAfter.length==0 || slnAfter == NaN || slnAfter<0 )
	{
		  $(".txt_div").html("Please enter a valid Solution After Value");
		  $("cart_page").html("Invalid Supply Levels");
		  $("#aboutPopup").show();
		return false;
	}*/
	if(glucometerId.length==0 || glucometerId == NaN || glucometerId<0 )
	{
		  $(".txt_div").html("Please enter a valid Glucometer Id Value");
		  $("cart_page").html("Invalid Supply Levels");
		  $("#aboutPopup").show();
		return false;
	}
	
	//update Gluocometer and glucometer id 
	if(stripsChanged) {
		var patientSupplyInfo = {};
		patientSupplyInfo["patientId"]= patId;
		var supplyConfigId = $('#strips').attr("supplyConfigId");
		var supplyId = $('#strips').attr("supplyId");
		if(supplyId)
		{
		patientSupplyInfo["patientSupplyId"]= supplyId;
		patientSupplyInfo["supplyConfigId"]= supplyConfigId;
		patientSupplyInfo["state"]= 2;
		}
		else
		{
			patientSupplyInfo["state"]= 1;
			patientSupplyInfo["supplyConfigId"] = $("#SUP_CFG_ID_STRIPS").val();
		}
		patientSupplyInfo["remainingQuantity"] = stripsCnt;
		//patientSupplyInfo["vendorDeviceId"] = glucometerId;
		
		invokeRESTApi("emr/patientSupplies", "PUT", patientSupplyInfo, function() {
			stripsChanged = false;
		}, function() {
			
		});
	}
	
	//update lancets
	if(lancetsChanged){
		patientSupplyInfo = {};
		patientSupplyInfo["patientId"]= patId;
		var lenSupplyConfigId = $('#lancets').attr("supplyConfigId");
		var lencetSupId = $('#lancets').attr("supplyId");
		if(lencetSupId)
		{
		patientSupplyInfo["patientSupplyId"]= lencetSupId;
		patientSupplyInfo["supplyConfigId"]= lenSupplyConfigId;
		patientSupplyInfo["state"]= 2;
		}
		else
		{
			patientSupplyInfo["state"]= 1;
			patientSupplyInfo["supplyConfigId"] = $("#SUP_CFG_ID_LANCETS").val();
		}
		patientSupplyInfo["remainingQuantity"] = lancetsCnt;
		
		invokeRESTApi("emr/patientSupplies", "PUT", patientSupplyInfo, function() {
			lancetsChanged = false;
		}, function() {
			
		});
	}
	
	//update controlsolution
	/*if(solutionAfterChanged){
		patientSupplyInfo = {};
		patientSupplyInfo["patientId"]= patId;
		var solSupplyConfigId = $('#solutionAfter').attr("supplyConfigId");
		var solutionSupId = $('#solutionAfter').attr("supplyId");
		if(solutionSupId)
		{
		patientSupplyInfo["patientSupplyId"]= solutionSupId;
		patientSupplyInfo["supplyConfigId"] = solSupplyConfigId;
		patientSupplyInfo["state"]= 2;
		}
		else
		{
			patientSupplyInfo["state"]= 1;
			patientSupplyInfo["supplyConfigId"] = $("#SUP_CFG_ID_SOLNAFTER").val();
		}
		patientSupplyInfo["solutionAfter"] = new Date(slnAfter);
		
		invokeRESTApi("emr/patientSupplies", "PUT", patientSupplyInfo, function() {
			solutionAfterChanged = false;
		}, function() {
			
		});
	}*/
	
	// GlucId:
	if(glucoIdChanged){ 
		patientSupplyInfo = {};
		patientSupplyInfo["patientId"]= patId;
		var gluSupplyConfigId = $('#glucoId').attr("supplyConfigId");
		var glucoSupId = $('#glucoId').attr("supplyId");
		if(glucoSupId)
		{
		patientSupplyInfo["patientSupplyId"]= glucoSupId;
		patientSupplyInfo["supplyConfigId"] = gluSupplyConfigId;
		patientSupplyInfo["state"]= 2;
		}
		else
		{
			patientSupplyInfo["state"]= 1;
			patientSupplyInfo["supplyConfigId"] = $("#SUP_CFG_ID_GLUCOID").val();
		}
		patientSupplyInfo["vendorDeviceId"] = glucometerId;
		
		invokeRESTApi("emr/patientSupplies", "PUT", patientSupplyInfo, function() {
			glucoIdChanged = false;	
		}, function() {
			
		});
		
	}
	openPageWithAjax('../../dashboard/pages/portal_addSupplies.php?patientId='+patId
		+'&patientLastName='+params.patientLastName+'&patientFirstName='+params.patientFirstName+'&type=EDIT',
		'','menu-content',event,this);

	return false;
}

function createOrderBtnClicked() {
	var orderNote = $("#orderNote").val();
	var shipMethod = $("#shipMethod").val();
	var shipmentHeaderInfo = new Object();
	shipmentHeaderInfo.carrier = shipMethod;
	shipmentHeaderInfo.orderNote = orderNote;
	shipmentHeaderInfo.orderStatus = "PENDING";
	shipmentHeaderInfo.state = 1;
	shipmentHeaderInfo.orderDate = new Date();
	shipmentHeaderInfo.shipmentDetails = [];

	var cnt = 0;
	var childs = $("#orderTable tbody").children();
	for (var i = 0; i < childs.length; i++) {
		var eachTr = childs[i];
		var chk = eachTr.getElementsByTagName("input")[0];
		var txt = eachTr.getElementsByTagName("input")[1];
		var isChecked = chk.getAttribute("checked");
		// alert(isChecked)
		if (isChecked == "checked" || isChecked == "true") {
			var shipmentdetails = { 
				"supplyConfigId": eachTr.id, 
				"itemName": chk.getAttribute("name"), 
				"supplyDescription": chk.getAttribute("value"),
				"quantity": txt.value,
				"state":1 };
			shipmentHeaderInfo.shipmentDetails[cnt] = shipmentdetails;
			cnt++;
		}
	}
	// alert(JSON.stringify(shipmentHeaderInfo))
	//$('#confirm').modal({ backdrop: 'static', keyboard: false })
      //  .one('click', '#yes', function() 
		//{
			$('#confirm').modal('hide');
            invokeRESTApi("shipping/patient/orderSupply/"+patId, "POST", shipmentHeaderInfo, function() {
			openPageWithAjax('../../dashboard/pages/portal_addSupplies.php?patientId='+patId
				+'&patientLastName='+params.patientLastName+'&patientFirstName='+params.patientFirstName+'&type=EDIT',
				'','menu-content','',this);
		}, function() {
		$(".txt_div").html("Failed to create order!");
		$("#aboutPopup").show();
				
		});
      //  });
}

function populateSupplyLevels() {
	localStorage.clear();
	invokeGET("emr/patientSupplies?patientId="+patId, function (data) {
		for (var i = 0; i < data.length; i++) {
			
			if ((data[i].supplyDescription.toUpperCase() == 'GLSTRIPS')|| (data[i].supplyDescription.toUpperCase() == 'GLUCOSE_TEST_STRIPS')) {
				$("#strips").val(data[i].remainingQuantity);
				stripsSupplyId = data[i].patientSupplyId;
				$("#strips").attr("supplyId",stripsSupplyId);
				$("#strips").attr("supplyConfigId",data[i].supplyConfigId);
				window.localStorage.setItem("stripValue",data[i].remainingQuantity);
			}
			/*if ((data[i].supplyDescription.toUpperCase() == 'CONTROL_SOLUTION')|| (data[i].supplyDescription.toUpperCase() == 'GLSOLUTION')) {
				console.log(data[i].solutionAfter);
				
				if(data[i].solutionAfter != null)
				{
				$("#solutionAfter").val(getFormatedDate(data[i].solutionAfter));
				window.localStorage.setItem("solutionAfter",getFormatedDate(data[i].solutionAfter));
				}
				solutionAfterSupplyId = data[i].patientSupplyId;
				$("#solutionAfter").attr("supplyId",solutionAfterSupplyId);
				$("#solutionAfter").attr("supplyConfigId",data[i].supplyConfigId);
				
				
			}*/
			if ((data[i].supplyDescription.toUpperCase() == 'GLLANCETS') || (data[i].supplyDescription.toUpperCase() == 'LANCETS')) {
				
				$("#lancets").val(data[i].remainingQuantity);
				lancetsSupplyId = data[i].patientSupplyId;
				$("#lancets").attr("supplyId",lancetsSupplyId);
				$("#lancets").attr("supplyConfigId",data[i].supplyConfigId);
				window.localStorage.setItem("lancetsValue",data[i].remainingQuantity);
				
			}
			if ((data[i].supplyDescription.toUpperCase() == 'GLMETER2GTM')||(data[i].supplyDescription.toUpperCase() == 'GLMETER3GTM')||(data[i].supplyDescription.toUpperCase() == 'GLMETER3GATT') ||(data[i].supplyDescription.toUpperCase() == 'WIRELESS_ADAPTER')) 
			{
				$("#glucoId").val(data[i].vendorDeviceId);
				$("#glucoType").text(data[i].type);
				glucoIdSupplyId = data[i].patientSupplyId;
				$("#glucoId").attr("supplyId",glucoIdSupplyId);
				$("#glucoId").attr("supplyConfigId",data[i].supplyConfigId);
				window.localStorage.setItem("glucoId",data[i].vendorDeviceId);
				window.localStorage.setItem("glucoType",data[i].type);
			}
		}
	});
}
function getFormatedDate(timestamp) {
	var d = new Date(timestamp);
	return padWithZeroes(d.getMonth() + 1) + '/' + padWithZeroes(d.getDate()) + '/' + d.getFullYear();
}

var shipmentDetailsArr = [];
function populateOrderHistory() {
	invokeGET("shipping/patient/orderdetail/"+patId, function(data) {
		for(var i=0;i<data.length;i++) {
			if(data[i].shipmentHeaderId == '')
			{
				data[i].shipmentHeaderId = '-';
			}
			if(data[i].orderNote == '')
			{
				data[i].orderNote = '-';
			}
			if(data[i].carrier == '')
			{
				data[i].carrier = '-';
			}
			if(data[i].orderStatus == '')
			{
				data[i].orderStatus = '-';
			}
			if(data[i].trackingNumber == '')
			{
				data[i].trackingNumber = '-';
			}

			var newRow =  "<tr class='orderHistRow' id='"+i+"' onclick='javascript: showOrderDetails("+i+")'>"
				+" <td>"+getFormatedDate(data[i].createTimeStamp)+"</td>"
				+" <td>"+data[i].shipmentHeaderId+"</td>"
				+" <td>"+data[i].orderNote+"</td>"
				+" <td>"+data[i].carrier+"</td>"
				+" <td>"+data[i].orderStatus+"</td>"
				+" <td>"+data[i].trackingNumber+"</td></tr>";
			$("#histTable tbody").append(newRow); 

			shipmentDetailsArr[i] = data[i].shipmentDetails;
		}
	});   
}

function showOrderDetails(index) {
	
	$("#orderDetailsTable").show();
	var shipmentDetails = shipmentDetailsArr[index];
	$("#orderDetailsTable tbody").empty();
	for(var j = 0; j < shipmentDetails.length; j++) {
		var newSupplyDetailsRow =  "<tr><td>" + shipmentDetails[j].itemName +" </td>"
			+" <td>"+shipmentDetails[j].supplyDescription+ "</td>"
			+" <td>"+shipmentDetails[j].quantity+"</td></tr>";
		$("#orderDetailsTable tbody").append(newSupplyDetailsRow); 
	}
}

function populateCoachName() {
	invokeGET("emr/patientPrimaryProvider?patientId="+patId, function(data) {
		$("#coach").html(data.firstName);
	});
}

function populateDeviceDetails() {
	invokeGET("emr/patientDeviceDetails?patientId="+patId, function(data) {
		for(var i = 0; i < data.length; i++) {
			if(data[i].deviceConfigId == 1) { 
				frequency = data[i].frequencyReading;
				$("#freq").html(frequency);
			}
		}
	});
}
 
function populateSupplyList() {
	invokeGET("emr/config/supplyListFreqPrimaryProvider/" + patId, function (data) {
																			
		for (var i = 0; i < data.length-1; i++) {
			var inventory = data[i];
			if(inventory.supplyCode == "GLStrips")
			{
				$("#SUP_CFG_ID_STRIPS").val(inventory.supplyConfigId);
			}
			else if(inventory.supplyCode == "GLLancets")
			{
				$("#SUP_CFG_ID_LANCETS").val(inventory.supplyConfigId);
			}
			else if(inventory.supplyCode == "GLSolution")
			{
				$("#SUP_CFG_ID_SOLNAFTER").val(inventory.supplyConfigId);
			}
			else if(inventory.supplyCode == "GLMeter2GTM" || inventory.supplyCode == "GLMeter3GTM" || inventory.supplyCode == "GLMeter3GATT")
			{
				$("#SUP_CFG_ID_GLUCOID").val(inventory.supplyConfigId);
			}
		}
		for (var i = data.length-2; i < data.length; i++) {
			var inventory = data[i];
			if(inventory.supplyDescription=="COACHNAME")
			{
				var coachName = inventory.supplyCode;
				//$("#coach").html(coachName);
			}
			if(inventory.supplyDescription=="FREQUENCYREADING")
			{
				var frequency = inventory.supplyCode;
				$("#freq").html(frequency);
			}
		}

		for (var i = 0; i < data.length-2; i++) {
			var inventory = data[i];
			
			if(((inventory.supplyCode == "GLStrips") ||(inventory.supplyCode == "GLLancets")))
			{
				if(frequency != undefined)
				{
					boxCount = inventory.defaultQuantity;
				    inventory.defaultQuantity = Math.ceil((frequency*90/50))*50/boxCount;
					
				}
				else
				{
					inventory.defaultQuantity = 0;
				}
				
			}
			// console.log(inventory);
			defaultValsMap[inventory.supplyConfigId] = inventory.defaultQuantity;
			
			var newRow = "<tr class='suppRow' style='cursor: pointer;' id='" + inventory.supplyConfigId + "'>"
				+" <td><input type='checkbox' name='" + inventory.supplyCode + "' value='"+ inventory.supplyDescription+"' /></td>"
				+" <td>" + inventory.supplyCode + " </td>"
				+" <td>" + inventory.supplyDescription + " </td>"
				+" <td style='padding: 5px;'>"
				+"   <input name='textinput" + i + "' class='form-control input-md' required='' value='"+inventory.defaultQuantity+"'"
				+"     style='display: none; width: 50px; height: 25px; text-align: center;' type='text'>"
				+" </td></tr>";

			$("#orderTable tbody").append(newRow);
		}


		$(".suppRow").click(function () {
			var chk = $(this).find("input[type='checkbox']");
			var txt = $(this).find("input[type='text']");
			var isChecked = chk.attr("checked");
			
			if (isChecked == "checked") {
				if (!txt.is(":focus")) {
					chk.prop("checked", false)
					chk.attr("checked", false)
					txt.css('display', 'none');	
					
					checkandEnableCreateOrderBtn();
				}
			} else {
				chk.prop("checked", true)
				chk.attr("checked", true)
				txt.css('display', 'block');
				
				// Enable createOrder button: 
				checkandEnableCreateOrderBtn();
				
				txt.val(defaultValsMap[$(this).attr('id')])
			}
		});

		$(".suppRow td input[type='text']").change(function () {
			if (isNaN($(this).val())) {
				$(".txt_div").html("Invalid number: " + $(this).val());
				$("#aboutPopup").show();
				$("#createOrder").prop('disabled', true);
			} else if ($(this).val() <= 0) {
				$(".txt_div").html("Amount shoud be more than 0");
				$("#aboutPopup").show();
				$("#createOrder").prop('disabled', true);
			} else {
				checkandEnableCreateOrderBtn();
			}
		});
	});
}
function checkandEnableCreateOrderBtn() {
	// CHeck if all are unchecked and disable createOrder button:
	$("#createOrder").prop('disabled', true);
	var invalidVal = false;
	var atleastOneChecked = false;
	$(".suppRow").each(function () {
		var chk = $(this).find("input[type='checkbox']");
		var txt = $(this).find("input[type='text']");
		var isChecked = chk.attr("checked");
		
		if (isChecked == "checked") {
			if (isNaN(txt.val()) || txt.val() <= 0) {
				invalidVal = true;
			} else {
				atleastOneChecked = true;
			}
		}
	});
	
	if(!invalidVal && atleastOneChecked) {
		$("#createOrder").prop('disabled', false);
	}
}

/// *************************** Utility methods: *************************** ///
function invokeRESTApi(endPoint, method, data, successCallBack, errorCallBack) {
	jQuery.ajax({
		headers: {
			'Authorization': authorizationToken,
			'Accept': 'application/json',
			'Content-Type': 'application/json'
		},
		'type': method,
		'url': window.location.origin + "/gladstone/rest/"+endPoint,
		'data': JSON.stringify(data),
		'dataType': 'json',
		'complete': function (jqXHR, textStatus) {
			switch (jqXHR.status) {
				case 401:
					console.log("Invalid Token");
					refreshAuthToken(function (token) {
						authorizationToken = token;
						invokeRESTApi(endPoint, method, data, successCallBack, errorCallBack);
					});
					break;
				case 200: 
					if(successCallBack != undefined) {
						successCallBack(jqXHR.data);
					}
					break;
				default:
					if(errorCallBack != undefined) { 
						errorCallBack(jqXHR.data);
					}
			}
		}

    });
}

function invokeGET(endPoint, successCallback, errorCallBack) {
	$.ajax({
		type: 'GET',
		beforeSend: function (request) {
			request.setRequestHeader("Authorization", authorizationToken);
		},
		url: window.location.origin + "/gladstone/rest/" + endPoint,
		statusCode: {
			401: function () {
				console.log("Invalid Token");
				refreshAuthToken(function (token) {
					authorizationToken = token;
					invokeGET(endPoint, successCallback, errorCallBack);
				});
			},
			200: function (data) {
				if(successCallback != undefined) {
					successCallback(data);
				}
			}
		}
	});
}

function padWithZeroes(val, length) {
	if(length == undefined) {
		length = 2;
	}

    var my_string = '' + val;
    while (my_string.length < length) {
        my_string = '0' + my_string;
    }

    return my_string;
}
function getQueryParams(qs) {
	qs = qs.split('+').join(' ');

	var params = {},
		tokens,
		re = /[?&]?([^=]+)=([^&]*)/g;

	while (tokens = re.exec(qs)) {
		params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
	}

	return params;
}
function isEmpty(obj) {
	if (obj == undefined)
		return true;
	for (var prop in obj) {
		if (obj.hasOwnProperty(prop))
			return false;
	}

	return true;
}
$("#cancelSupply").click(function() {
		var strips = localStorage.getItem("stripValue");
		var lencets = localStorage.getItem("lancetsValue");
		//var solutionAfter = localStorage.getItem("solutionAfter");
		var glucometerId = localStorage.getItem("glucoId");
		var type = localStorage.getItem("glucoType");
		$("#strips").val(strips);
		$('#lancets').val(lencets);
		/*if(solutionAfter)
		{
	    $('#solutionAfter').val(solutionAfter);
		}
		else
		{
			$('#solutionAfter').val("");
		}
*/	    $('#glucoId').val(glucometerId);
		$('#glucoType').val(type);
 });