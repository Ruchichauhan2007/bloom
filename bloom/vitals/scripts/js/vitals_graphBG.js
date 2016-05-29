var dataMess;
var patVitalInfos;
var unitName1;
var measurementName1;
var measurementName2;
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
	///console.log(result);
    if (result != null && result.message != null && result.success == true) {
        patVitalInfos = JSON.parse(result.message);
			console.log(patVitalInfos);

		if(result.message != "[]")
		{
		$("#vitalName").val(patVitalInfos[0].deviceConfigId);
		loadGraph();
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
function getLastTwoWeek(){
   // var today = new Date();
    var lastTwoWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 14);
    return lastTwoWeek ;
}
function loadGraph()
{
	var obj=[];
	var obj2=[];
	var mealType = $("#meal-type").val();
//	console.log(patVitalInfos);
	patVitalInfos.forEach(function(d, i) {
//	alert(mealType);
	if(d.mealType == mealType)
	{
		if( new Date(d.vitalTime) >= new Date(limit) && new Date(d.vitalTime) <= today)
		{
				unitName1 = d.unitName1;
				measurementName1 = d.measurementName1;
				measurementName2 = d.measurementName2 ;
				var localTime  = moment.utc(d.vitalTime).toDate();
				var patientVitalId = d.patientVitalId;
				localTime = moment(localTime).format('ddd D MMM h:mm A');
				var unitValue1 = d.unitValue1;
				var tempunitValue1 = d.unitValue1;
				provFirstName = "";
				provLastName = "";

				if(d.provFirstName != "" || d.provLastName != "")
				{
					provFirstName = d.provFirstName;
					provLastName = d.provLastName;
				}
				
				var unitValuExceeded = false;
			   if(unitValue1 > 0)
			   {
					if(unitValue1 > 600)
					{ 
						unitValuExceeded = true;
						unitValue1 = 600;
						obj.push({x: new Date(d.vitalTime), y: unitValue1});
					}
					else
					{
						unitValue1 = d.unitValue1;
						obj.push({x: new Date(d.vitalTime), y: unitValue1});
					}
			   }
				if(d.unitValue2 > 0)
				{
				obj2.push({x: new Date(d.vitalTime), y: d.unitValue2});
				markTrue = true;
				}
				loadGrid(d.measurementName1,localTime,d.unitValue1,d.unitValue2,patientVitalId,d.vitalTime,d.observationMode,provFirstName,provLastName);
		}
	}
	else if(mealType == "ALL")
	{
		//console.log();
		if( new Date(d.vitalTime) >= new Date(limit) && new Date(d.vitalTime) <= today)
		{
				unitName1 = d.unitName1;
				measurementName1 = d.measurementName1;
				measurementName2 = d.measurementName2 ;
				var localTime  = moment.utc(d.vitalTime).toDate();
				var patientVitalId = d.patientVitalId;
				localTime = moment(localTime).format('ddd D MMM h:mm A');
				var unitValue1 = d.unitValue1;
				var tempunitValue1 = d.unitValue1;
				var unitValuExceeded = false;
				provFirstName = "";
				provLastName = "";

				if(d.provFirstName != "" || d.provLastName != "")
				{
					provFirstName = d.provFirstName;
					provLastName = d.provLastName;
				}
			   if(unitValue1 > 0)
			   {
					if(unitValue1 > 600)
					{ 
						unitValuExceeded = true;
						unitValue1 = 600;
						obj.push({x: new Date(d.vitalTime), y: unitValue1});
					}
					else
					{
						unitValue1 = d.unitValue1;
						obj.push({x: new Date(d.vitalTime), y: unitValue1});
					}
			   }
				if(d.unitValue2 > 0)
				{
				obj2.push({x: new Date(d.vitalTime), y: d.unitValue2});
				markTrue = true;
				}
				loadGrid(d.measurementName1,localTime,d.unitValue1,d.unitValue2,patientVitalId,d.vitalTime,d.observationMode,provFirstName,provLastName);
		}
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
			maximum: 600
      	},
		axisY2: {				
				//title: "Readings",
                lineColor: "#4F81BC",
                //lineThickness: 2
				maximum: 600
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
	}
	else if($(".selectedDate").text() == "14 Days")
	{
		 var chart = new CanvasJS.Chart("chartContainer",{
      	title :{
      		text: unitName1,
			horizontalAlign: "right",
      	},
      	axisX: {	
				valueFormatString: "DD-MMM" ,
				interval: 4,
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
			maximum: 600
      	},
		axisY2: {				
				//title: "Readings",
                lineColor: "#4F81BC",
				maximum: 600
                //lineThickness: 2
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
			maximum: 600
      	},
		axisY2: {				
				//title: "Readings",
                lineColor: "#4F81BC",
                //lineThickness: 2
				maximum: 600
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
	}
	else{
		alert($(".selectedDate").text());
	}
 
	  chart.render();
		//
}

function loadGrid(measurementName1,date,unit1,unit2,patientVitalId,vitalTime,observationMode,provFirstName,provLastName)
{
	var observationIcon = "" ;
	if(observationMode == "PAT_TAKEN_MANUAL" || observationMode == "PROV_TAKEN_MANUAL")
	{
		observationIcon = "*";
	}
	if(measurementName1 == "Diastolic")
	{
		var trHTML =  "<tr  class='"+date+"'><td>"+date+"</td><td class='col-sm-1'>"+unit2+"/"+unit1+"</td><td class='col-sm-1'><img src='/gladstone/portal/bloom/vitals/images/WhiterDot.png' /></td></tr>";
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
		
		var trHTML =  "<tr  class='"+date+"'><td>"+date+"</td><td>"+unit1+"</td><td class='col-sm-1'>"+unit2+"</td><td class='col-sm-1'><img src='/gladstone/portal/bloom/vitals/images/WhiterDot.png' /></td></tr>";
		$("tbody#tbodyId").append(trHTML);
	}
	else
	{
		var unit11 = unit1;
		if(unit1 < 20) {unit11 = "LO";}
		else if (unit1 > 600) {unit11 = "HI";}
	var trHTML =  "<tr  class='"+date +" "+measurementName1+"' id='"+measurementName1+'_'+patientVitalId+"' unit='"+unit1+"' vitalTime='"+vitalTime+"' observationMode='"+observationMode+"'onclick='getpatientVitalId(this.id)'><td>"+date+"</br>"+provFirstName+" "+provLastName+"</td><td class='col-sm-1'>"+unit11+" "+observationIcon+"</td><td class='col-sm-1'>";
	trHTML = trHTML+"<img src='/gladstone/portal/bloom/vitals/images/WhiterDot.png' /></td></tr>";
	
		$("tbody#tbodyId").append(trHTML);
	}
}

$(document).ready(function()
{
		var deviceId = $("#vitalName").val();
		$("#meal-type").val($('.pre-post-meal button.active').attr('data'));
		var deviceName = $("#vitalName option:selected").text();
		var mealType;
		if($('.pre-post-meal button').hasClass('active')){
			if(deviceName == "Glucose")
			{
		$("#meal-type").val($('.pre-post-meal button.active').attr('data'));
		mealType = $("#meal-type").val();
			}
		}
		$("#vitalName").change(function (event){
		deviceId = $("#vitalName").val();
	    deviceName = $("#vitalName option:selected").text();
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
		
		$('div.pre-post-meal').on('click', 'button', function() {
    $('.pre-post-meal button.active').removeClass('active');
	var deviceName = $("#vitalName option:selected").text();vitalName
//	var deviceName = $("#vitalName").text();
	
    $(this).addClass('active');
	if(deviceName.trim() == "Glucose")
	{
			$("#meal-type").val($(this).attr('data'));
			mealType = $("#meal-type").val();
			clearGraph();
			
	}
});

  var dps ;
limit = getLastWeek();
var id = $("#contextPatientId").val();

if (id == "" || isNaN(id)) {
	id = $("#currentUserId").val();
}
	 getVitalsGraphData(id);
	
$('.days_GBW').on('click', 'button', function() {
	console.log('clicked');

    $('.days_GBW button.active').removeClass('active');
    $('.days_GBW button').removeClass('selectedDate');
    $(this).addClass('active');
    $(this).addClass('selectedDate');
	if($(".selectedDate.active").text() == "7 Days")
	{
		 limit = getLastWeek();
	}
	else if($(".selectedDate.active").text() == "14 Days")
	{
		 
		 limit =getLastTwoWeek();
	}
	else if($(".selectedDate.active").text() == "30 Days")
	{
		 limit = getLastmonth();
	}	
	//console.log(patVitalInfos+"mmmmmmmmmmmmm");
	//if(patVitalInfos != "[ ]")
	//{
		clearGraph(limit);
	//}

});


/*$("tr.Glucose").click(function (){
var patientVitalId = $(this).attr("patientvitalid");
alert(patientVitalId);
								
});
*/
});


function clearGraph() {
	if(dataMess != "[]")
	{
    $("#chartContainer").html("");
	$("tbody#tbodyId").html("");
	loadGraph("");
}
else
{
	$("#chartContainer").html("<h4 class='message'>No data available to show.</h4>");
}

}

function graphWithMealType(mealType) {
	if(dataMess != "[]")
	{
    $("#chartContainer").html("");
	$("tbody#tbodyId").html("");
	loadGraph(mealType);
	//alert()
}
else
{
	$("#chartContainer").html("<h4 class='message'>No data available to show.</h4>");
}

}

function getpatientVitalId(id)
{
	var vitalUserType = $("#vitaUserType").val();
	var unitValue1 = $('#'+id).attr("unit");
	var observationMode = $('#'+id).attr("observationMode");
	var vitalTime = $('#'+id).attr("vitalTime");
	var deviceConfigID = $("#deviceConfigID").val()

	var data = id.split("_");
	if(data[0] =="Glucose")
	{
		if($('#'+id).hasClass('selected-Weight') && (vitalUserType == "PATIENT"))
		{
		openPageWithAjax('/gladstone/portal/bloom/vitals/pages/vitals_glucose_entry.php','deviceConfigID='+deviceConfigID+'&glucoseStatus=edit&inputType="GLUCOSE"&patientVitalId='+data[1]+'&vitalTime='+vitalTime,'menu-content','','')	;
		}
		else if($('#'+id).hasClass('selected-Weight') && (vitalUserType == "PROVIDER"))
		{
			var idPatient = $("#contextPatientId").val();
		openPageWithAjax('/gladstone/portal/bloom/vitals/pages/vitals_glucose_entry.php','deviceConfigID='+deviceConfigID+'&glucoseStatus=edit&inputType="GLUCOSE"&patientVitalId='+data[1]+'&vitalTime='+vitalTime+'&contextPId='+idPatient,'menu-content','','')	;
		}

	}
}