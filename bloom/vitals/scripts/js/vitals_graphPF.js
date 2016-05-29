var dataMess;
var patVitalInfos;
var unitName1;
var measurementName1;
var measurementName2;
var lowerRangeUnit1 ;
var	upperRangeUnit1 ;
var lowerRangeUnit1Height;
var upperRangeUnit1Height;
var topMarginUpper;
var topMarginLower;
var provFirstName = "";
var provLastName = "";
var today = new Date();
today.setDate(today.getDate()+1);
var limit;
var markTrue = false;

function getVitalsGraphData(id) {
    var vitalsFilterInfo = new Object();
    vitalsFilterInfo.patientId = id;
    vitalsFilterInfo.deviceConfigId =$("#deviceConfigID").val();
	//alert(vitalsFilterInfo.deviceConfigId);
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
    var retVal = postDataToServer(dataVal, EMR, 'getPatientVitalInfo', processResponse);
	
}
function processResponse(result) {
	//console.log(result);
    if (result != null && result.message != null && result.success == true) {
        patVitalInfos = JSON.parse(result.message);
			console.log(patVitalInfos);

		if(result.message != "[]")
		{
		loadGraph();
		$("#vitalName").val(patVitalInfos[0]["deviceConfigId"]);
		}
		else
		{
			$("#chartContainer").html("<h4 class='message'>No data available to show.</h4>");
		}
	}
dataMess = result.message;
}
function getLastmonth(){
    //var today = new Date();
    var lastMonth = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 30);
    return lastMonth ;
}
function getLastWeek(){
    //var today = new Date();
    var lastWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 7);
    return lastWeek ;
}
function getLast3Months(){
   // var today = new Date();
    var last3Months = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 90);
    return last3Months ;
}
function loadGraph()
{
	var obj=[];
	var obj2=[];
	patVitalInfos.forEach(function(d, i) {
	console.log(d);
	lowerRangeUnit1  = d.lowerRangeUnit1;
	upperRangeUnit1  = d.upperRangeUnit1;
	lowerRangeUnit1Height = (lowerRangeUnit1 *100 / 450);
	upperRangeUnit1Height = (upperRangeUnit1 *100 / 450);
	lowerRangeUnit1Height = parseInt(lowerRangeUnit1Height);
	upperRangeUnit1Height = parseInt(upperRangeUnit1Height);
	topMarginUpper = 450 - upperRangeUnit1;
    topMarginLower = 450 - lowerRangeUnit1;
	
	if( new Date(d.vitalTime) >= new Date(limit) && new Date(d.vitalTime) <= today)
	{
			unitName1 = d.unitName1;
			measurementName1 = d.measurementName1;
			measurementName2 = d.measurementName2 ;
			var localTime  = moment.utc(d.vitalTime).toDate();
			localTime = moment(localTime).format('ddd D MMM h:mm A');
			provFirstName = "";
			provLastName = "";
			if(d.provFirstName != "" || d.provLastName != "")
			{
				provFirstName = d.provFirstName;
				provLastName = d.provLastName;
			}
			if(d.unitValue1 > 0)
			{
				obj.push({x: new Date(d.vitalTime), y: d.unitValue1});
			}
			if(d.unitValue2 > 0)
			{
			obj2.push({x: new Date(d.vitalTime), y: d.unitValue2});
			markTrue = true;
			}
			loadGrid(d.measurementName1,localTime,d.unitValue1,d.unitValue2,provFirstName,provLastName);
	}
			
		});
	if($(".selectedDate").text() == "7 Days")
	{
		  var chart = new CanvasJS.Chart("chartContainer",{
      	title :{
      		text: unitName1,
			horizontalAlign: "right",
      	},
      	axisX: {	
				valueFormatString: "DD-MMM" ,
				interval:2,
				intervalType: "day",
				labelFontColor: "rgb(0,75,141)",
				minimum: new Date(limit),
				maximum: today
      		//title: "Vital Taken",
			//valueFormatString: "DD-MMM" 
			//maximum: today,
			//minimum: limit
            //labelAngle: -50
       		
      	},
      	axisY: {						
      		//title: "Readings"
			maximum: 450
      	},
		axisY2: {				
				//title: "Readings",
                lineColor: "#4F81BC",
                //lineThickness: 2
				maximum: 450
			},
			legend:{
				verticalAlign: "bottom",
				horizontalAlign: "center",
			},
      	data: [{
			    click: function(e){
					$("#tbodyId tr").removeClass("selected-Weight");
				var local  = moment.utc(e.dataPoint.x).toDate();
				local = moment(local).format('ddd D MMM h:mm A');
        		//alert(local);
				  console.log($("tr:contains("+local+")").each(
				  function()
				  { 
				  console.log($(this).addClass("selected-Weight"));
				  }));

				},
      		type: "line",
			showInLegend: true,
			lineThickness: 2,
			name: measurementName1,
			//xValueType: "dateTime",
      		dataPoints : obj
      	},
		{
			click: function(e){
					$("#tbodyId tr").removeClass("selected-Weight");
        	var local  = moment.utc(e.dataPoint.x).toDate();
				local = moment(local).format('ddd D MMM h:mm A');
				console.log($("tr:contains("+local+")").each(
				  function()
				  { 
				  console.log($(this).addClass("selected-Weight"));
				  }));
			},
      		type: "line",
			showInLegend: markTrue,
			lineThickness: 2,
			name: measurementName2,
			//xValueType: "dateTime",
      		dataPoints : obj2
      	}]
      });
	
	$("#chartContainer").append("<div class='heightColorLower'></div>");
	$("#chartContainer").append("<div class='heightColorUpper'></div>");
	$("#chartContainer canvas").eq(1).css({"z-index":"99999"});
	$(".heightColorUpper").css({"height":upperRangeUnit1-110+"px","top":80+topMarginUpper+"px"});
	$(".heightColorLower").css({"height":lowerRangeUnit1-55+"px","top":topMarginLower+22});
		  
	}
	else if($(".selectedDate").text() == "30 Days")
	{
		 var chart = new CanvasJS.Chart("chartContainer",{
      	title :{
      		text: unitName1,
			horizontalAlign: "right",
      	},
      	axisX: {	
				valueFormatString: "DD-MMM" ,
				interval: 7,
				intervalType: "day",
				labelFontColor: "rgb(0,75,141)",
				minimum: new Date(limit),
				maximum: today
      		//title: "Vital Taken",
			//valueFormatString: "DD-MMM" 
			//maximum: today,
			//minimum: limit
            //labelAngle: -50
       		
      	},
      	axisY: {						
      		//title: "Readings"
			maximum: 450
      	},
		axisY2: {				
				//title: "Readings",
                lineColor: "#4F81BC",
                //lineThickness: 2
				maximum: 450
			},
			legend:{
				verticalAlign: "bottom",
				horizontalAlign: "center",
			},
      	data: [{
			    click: function(e){
					$("#tbodyId tr").removeClass("selected-Weight");
				var local  = moment.utc(e.dataPoint.x).toDate();
				local = moment(local).format('ddd D MMM h:mm A');
        		//alert(local);
				  console.log($("tr:contains("+local+")").each(
				  function()
				  { 
				  console.log($(this).addClass("selected-Weight"));
				  }));

				},
      		type: "line",
			showInLegend: true,
			lineThickness: 2,
			name: measurementName1,
			//xValueType: "dateTime",
      		dataPoints : obj
      	},
		{
			click: function(e){
					$("#tbodyId tr").removeClass("selected-Weight");
        	var local  = moment.utc(e.dataPoint.x).toDate();
				local = moment(local).format('ddd D MMM h:mm A');
				console.log($("tr:contains("+local+")").each(
				  function()
				  { 
				  console.log($(this).addClass("selected-Weight"));
				  }));
			},
      		type: "line",
			showInLegend: markTrue,
			lineThickness: 2,
			name: measurementName2,
			//xValueType: "dateTime",
      		dataPoints : obj2
      	}]
      });
		 $("#chartContainer").append("<div class='heightColorLower'></div>");
	$("#chartContainer").append("<div class='heightColorUpper'></div>");
	$("#chartContainer canvas").eq(1).css({"z-index":"99999"});
	$(".heightColorUpper").css({"height":upperRangeUnit1-80+"px","top":90+topMarginUpper+"px"});
	$(".heightColorLower").css({"height":lowerRangeUnit1-10+"px","top":topMarginLower+20});
	}
	else if($(".selectedDate").text() == "90 Days")
	{
		  var chart = new CanvasJS.Chart("chartContainer",{
      	title :{
      		text: unitName1,
			horizontalAlign: "right",
      	},
      	axisX: {	
				valueFormatString: "DD-MMM" ,
				interval: 30,
				intervalType: "day",
				labelFontColor: "rgb(0,75,141)",
				minimum: new Date(limit),
				maximum: today
      		//title: "Vital Taken",
			//valueFormatString: "DD-MMM" 
			//maximum: today,
			//minimum: limit
            //labelAngle: -50
       		
      	},
      	axisY: {						
      		//title: "Readings"
			maximum: 450
      	},
		axisY2: {				
				//title: "Readings",
                lineColor: "#4F81BC",
                //lineThickness: 2
				maximum: 450
			},
			legend:{
				verticalAlign: "bottom",
				horizontalAlign: "center",
			},
      	data: [{
			    click: function(e){
					$("#tbodyId tr").removeClass("selected-Weight");
				var local  = moment.utc(e.dataPoint.x).toDate();
				local = moment(local).format('ddd D MMM h:mm A');
        		//alert(local);
				  console.log($("tr:contains("+local+")").each(
				  function()
				  { 
				  console.log($(this).addClass("selected-Weight"));
				  }));

				},
      		type: "line",
			showInLegend: true,
			lineThickness: 2,
			name: measurementName1,
			//xValueType: "dateTime",
      		dataPoints : obj
      	},
		{
			click: function(e){
					$("#tbodyId tr").removeClass("selected-Weight");
        	var local  = moment.utc(e.dataPoint.x).toDate();
				local = moment(local).format('ddd D MMM h:mm A');
				console.log($("tr:contains("+local+")").each(
				  function()
				  { 
				  console.log($(this).addClass("selected-Weight"));
				  }));
			},
      		type: "line",
			showInLegend: markTrue,
			lineThickness: 2,
			name: measurementName2,
			//xValueType: "dateTime",
      		dataPoints : obj2
      	}]
      });
		  $("#chartContainer").append("<div class='heightColorLower'></div>");
	$("#chartContainer").append("<div class='heightColorUpper'></div>");
	$("#chartContainer canvas").eq(1).css({"z-index":"99999"});
	$(".heightColorUpper").css({"height":upperRangeUnit1-80+"px","top":90+topMarginUpper+"px"});
	$(".heightColorLower").css({"height":lowerRangeUnit1-10+"px","top":topMarginLower+20});
	}	
	  chart.render();
		//
}

function loadGrid(measurementName1,date,unit1,unit2,provFirstName,provLastName)
{
	if(measurementName1 == "Diastolic")
	{
		var trHTML =  "<tr  class='"+date+"'><td>"+date+"</br>"+provFirstName+" "+provLastName+"</td><td class='col-sm-1'>"+unit2+"/"+unit1+"</td><td class='col-sm-1'><img src='/gladstone/portal/bloom/vitals/images/WhiterDot.png' /></td></tr>";
		$("tbody#tbodyId").append(trHTML);
	}
	else if(measurementName1 == "Pulse")
	{
		if(unit1 <= 0)
		{
			unit1 = "";
		}
		else
		{
			unit1 = unit1+" BPM";	
		}
		var trHTML =  "<tr  class='"+date+"'><td>"+date+"</br>"+provFirstName+" "+provLastName+"</td><td>"+unit1+"</td><td class='col-sm-1'>"+unit2+"</td><td class='col-sm-1'><img src='/gladstone/portal/bloom/vitals/images/WhiterDot.png' /></td></tr>";
		$("tbody#tbodyId").append(trHTML);
	}
	else
	{
	var trHTML =  "<tr  class='"+date+"'><td>"+date+"</br>"+provFirstName+" "+provLastName+"</td><td class='col-sm-1'>"+unit1+"</td><td class='col-sm-1'><img src='/gladstone/portal/bloom/vitals/images/WhiterDot.png' />	</td></tr>";
		$("tbody#tbodyId").append(trHTML);
	}
}

$(document).ready(function()
{
	$("#vitalName").change(function (event){
		var deviceId = $("#vitalName").val();
		var deviceName = $("#vitalName option:selected").text();
		var patientId = $("#contextPatientId").val();
		var devicename;
		if(deviceName == "Glucose")
		{
			devicename = "Blood-Glucose";
		}
		
		else if(deviceName == "Blood Oxygen")
		{
			devicename = "Blood-Oxygen";
		}
		else if(deviceName == "Blood Pressure")
		{
			devicename = "Blood-Pressure";
		}
		else if(deviceName == "Weight")
		{
			devicename = "Body-Weight";
		}
		else if(deviceName == "Peak Flow")
		{
			devicename = "Peak-Flow";
		}
		if(deviceName == "Glucose")
			{
			openPageWithAjax("../../vitals/pages/vitals_graphBG.php","contextPId="+patientId+"&deviceConfigId="+deviceId+"&vitalType="+devicename,"menu-content",event,this);
			}
			else if(deviceName == "Peak Flow")
			{
				openPageWithAjax("../../vitals/pages/vitals_graphPF.php","contextPId="+patientId+"&deviceConfigId="+deviceId+"&vitalType="+devicename,"menu-content",event,this);
			}
			else
			{
				openPageWithAjax("../../vitals/pages/vitals_graphBP.php","contextPId="+patientId+"&deviceConfigId="+deviceId+"&vitalType="+devicename,"menu-content",event,this);
			}
	});
  var dps ;
limit = getLastWeek();
var id = $("#contextPatientId").val();

if (id == "" || isNaN(id)) {
	id = $("#currentUserId").val();
}
	 getVitalsGraphData(id);
	
$('.days_GBW').on('click', 'li', function() {

    $('.days_GBW li.selectedDate').removeClass('selectedDate');
    $(this).addClass('selectedDate');
	if($(".selectedDate").text() == "7 Days")
	{
		 limit = getLastWeek();
	}
	else if($(".selectedDate").text() == "30 Days")
	{
		 limit = getLastmonth();
	}
	else if($(".selectedDate").text() == "90 Days")
	{
		 limit = getLast3Months();
	}	
	//console.log(patVitalInfos+"mmmmmmmmmmmmm");
	//if(patVitalInfos != "[ ]")
	//{
		clearGraph();
	//}

});
});

function clearGraph() {
	if(dataMess != "[]")
	{
    $("#chartContainer").html("");
	$("tbody#tbodyId").html("");
	loadGraph();
	
}
else
{
	$("#chartContainer").html("<h4 class='message'>No data available to show.</h4>");
}

}
