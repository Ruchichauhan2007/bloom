	var dataMess;
	var patsurvey;
	var patsurveyInfos;
	var pages;
	var questions;
	var answers;
	var responses;
	var type;
	var heading;
	var scaleValue;
	var measurementName1;
	var measurementName2;
	var xAxis = [1,2,3,4,5] ;
	var learnText;
	var questionsFirstPage;
	var quesCount = 0;
	var otherText;
	var ansId;
	var labelText;
	var careCommHeaderInfo = {};
	var careCommDetailInfo = {};
	function getPatientSurvey(id) {
		
		var arr = new Array();
		arr[0] = id;	
		var valueData = JSON.stringify(arr);
		var survey = postDataToServer(valueData, 'ADMIN', 'getPatientSurveys', surveyResponse);
	}

	function surveyResponse(result) 
	{
		if (result != null && result.message != null  && result.message != "" && result.success == true) 
		{
			if(result.message != "null" && result.message != null )
			{
			patsurvey = JSON.parse(result.message);
			}
		}
	}

	function getPatientAssesmentSurvey(id) {
		
				var arr = new Array();
		arr[0] = id;
		var dataVal = JSON.stringify(arr);
		var retVal = postDataToServer(dataVal, 'ADMIN', 'getPatientAssesmentSurvey', processResponse);
		
	}
	
	function processResponse(result) 
	{
		//console.log(result.message);
		//console.log(patsurvey);
		if (result != null && result.message != null  && result.message != "" && result.success == true) 
		{
			if(result.message != "null" && result.message != null )
			{
			$("#viewSurveys").hide(); 
			$("#assesments").show(); 
			patsurveyInfos = JSON.parse(result.message);
			var surveyStatus = patsurveyInfos.surveySummary.surveyStatus;
			pages = patsurveyInfos.pages;
			questions = pages[1].questions;
			
			questionsFirstPage = pages[0].questions;
			questionsFirstPage.forEach(function(q, o)
		   {
			   if(q.heading == "Date")
			   {
					 if(q.responses)
					 {
						if(q.responses != "")
						 {
							//console.log(q.responses);
							 var completeDate = q.responses[0].text;
							  var local  = moment.utc(completeDate).toDate();
							local = moment(local).format('MMMM D, YYYY');
							$("#completedDate").html(surveyStatus+" "+local);
						 }
					 }
					 else
					   {						  
						  $("#completedDate").html(surveyStatus);
					   }
			   }
			   
		   });
			//console.log(questions);
			var showQuestions = questions.slice(0,17);
			//console.log(showQuestions);
			var obj=[];
			var color;
			var containerNm = '';
			for(var i=0;i<showQuestions.length;i++)
			{
				answers = showQuestions[i].answers;
				if(!showQuestions[i].responses)
				{ 
					$("#assesments").append("<div class='errorMessageChart' align='center'>No assessment chart available to show.</div>");
					return false;
					
					
				}
				responses = showQuestions[i].responses;
				type = showQuestions[i].type;
				color = '#014D65';
				
				
				if(type.family == 'presentation')
				{
					if(heading == 'KNOWLEDGE')
					{
						color = '#b6d7a8';
						containerNm = 'chartContainerKnow';
						addGraphKnowledge(obj, containerNm, color, heading);
					}
					else if(heading == 'SELF-EFFICACY')
					{
						color = '#a2c4c9';
						containerNm = 'chartContainerSelf';
						addGraphSelf(obj, containerNm, color, heading);
						
					}
					else if(heading == 'PSYCHOLOGICAL')
					{
						color = '#b4a7d6';
						containerNm = 'chartContainerPsy';
						addGraphPsy(obj, containerNm, color, heading);
					}
					else if(heading == 'SOCIAL CONTEXT')
					{
						color = '#d5a6bd';
						containerNm = 'chartContainerSocial';
						addGraphSocial(obj, containerNm, color, heading);
						
					}
										
					//console.log(showQuestions[i]);
					obj = [];
					heading = showQuestions[i].heading;	
					 if(heading == 'LEARNING STYLE')
					{
						containerNm = 'chartContainerLearn';
						$('#'+containerNm).html("<label style='margin-left:3px;' class='ft16'>"+heading+"</label>");
						//addLearning(containerNm,heading);
					}
					continue;
					
				}
				if(type.family != 'presentation')
				{
					quesCount++;
				}
				if(responses.length > 0)
				{
					if(responses.length == 1)
					{
							answers.forEach(function(a, k) 
							{
								
								splitResp = responses[0].answer_id.split("_");
								
								if(a.answer_id == splitResp[0])
								{
									 if(responses[0].type == 'col')
									{
										
										var htmlData = "<div class='questionsDiv' style='display:none' id='"+a.answer_id+"'><label class='ft16'>QUESTION "+ quesCount+ "- "+ heading+"</label><div class='QA_QUE pt10' style='margin-top:-25px;'><label class='ft16'>Q. </label> "+showQuestions[i].heading+"</div><div class='QA_ANS' style='margin-top:-8px;'><label class='ft16'>A. </label> "+responses[0].text+"</div><div class='QA_OTHER'  id='otherText_"+i+"' style='margin-top:-15px;'></div>";
										$("#showQuestion").append(htmlData);
										scaleValue = responses[0].scaleValue;
										labelText = responses[0].scaleValue; 
										ansId = a.answer_id;
																			
										if(i == 16)
										{
											//learnText = a.text;
											addLearning("chartContainerLearn",heading,responses[0].text);
										}
										stop;
									}
									else if(responses[0].type == "other")
									{
										
										otherText = "<label class='ft16'>Other:</label> "+responses[0].text;
										var htmlData = "<div class='questionsDiv' style='display:none' id='"+a.answer_id+"'><label class='ft16'>QUESTION "+ quesCount+ "- "+ heading+"</label><div class='QA_QUE pt10' style='margin-top:-25px;'><label class='ft16'>Q. </label> "+showQuestions[i].heading+"</div><div class='QA_ANS' style='margin-top:-8px;'><label class='ft16'>A. </label></div><div class='QA_OTHER'  id='otherText_"+i+"' style='margin-top:-15px;'>"+otherText+"</div>";
										$("#showQuestion").append(htmlData);
										
										scaleValue = 5;
										labelText = "0"; 
										ansId = a.answer_id ;
									}
								}
							});
						obj.push({ y: scaleValue ,label: labelText,dataPoint : ansId });
					}
					else if (responses.length == 2)
					{
						var textOther = false;
						var textColumn = false;
						responses.forEach(function(r, j) 
						{
							splitResponse = r.answer_id.split("_");
							answers.forEach(function(a, k) 
							{
								
								//console.log(a);
								if(a.answer_id == splitResponse[0])
								{
									
									 if(r.type == 'col')
									{
										
										var htmlData = "<div class='questionsDiv' style='display:none' id='"+a.answer_id+"'><label class='ft16'>QUESTION "+ quesCount+ "- "+ heading+"</label><div class='QA_QUE pt10' style='margin-top:-25px;'><label class='ft16'>Q. </label> "+showQuestions[i].heading+"</div><div class='QA_ANS' style='margin-top:-8px;'><label class='ft16'>A. </label> "+r.text+"</div><div class='QA_OTHER'  id='otherText_"+i+"' style='margin-top:-15px;'>"+otherText+"</div>";
										$("#showQuestion").append(htmlData);
										scaleValue = r.scaleValue;
										ansId = a.answer_id;
										
										if(i == 16)
										{
											//learnText = a.text;
											addLearning("chartContainerLearn",heading,r.text);
										}
										stop;
									}
									else if(r.type == "other" && !textOther)
									{
										textOther = true;
										otherText = "<label class='ft16'>Other:</label> "+r.text;
										
										$("#otherText_"+i).html(otherText);
									}
								}
								
							});
							//otherText = "";
						});
						obj.push({ y: scaleValue ,label: scaleValue,dataPoint : ansId });
					}
				}
				else
				{
					//alert("0");
					var htmlData = "<div class='questionsDiv' style='display:none' id='"+showQuestions[i].question_id+"'><label class='ft16'>QUESTION "+ quesCount+ "- "+ heading+"</label><div class='QA_QUE pt10' style='margin-top:-25px;'><label class='ft16'>Q. </label> "+showQuestions[i].heading+"</div>";
					$("#showQuestion").append(htmlData);
					obj.push({ y: 5 ,label: "0",dataPoint : showQuestions[i].question_id });
				}
			}
			
		}
		else
		{
			$("#viewSurveys").show(); 
			$("#assesments").hide(); 
			
		}
		}
	}

	// Intialize Graph
	function intializeGraph(containerNm, obj, color, heading)
	{
		var GridColor = new Array();
		var obj = $(obj).toArray().reverse();
		obj.forEach(function(a, k) 
		{
			if(a.y == 5 && a.label == "0")
			{
				
				GridColor[k] = "#F8F8F8";
			}
			else
			{
				GridColor[k] = color;
			}
			
		});
		 CanvasJS.addColorSet("Shades",GridColor);
		var chart = new CanvasJS.Chart(containerNm,{
           colorSet: "Shades",     
		title :{
			text: heading,
			horizontalAlign: "left",
			fontSize: 18,
			fontColor: "#666666"
		},

		animationEnabled: true,
		axisX: {	
				interval:1,
				gridThickness: 0,
				labelFontSize: 12,
				labelFontStyle: "bold",
				lineThickness:0,
				tickThickness:0,
				labelFontWeight: "normal",
				lineColor: "#ffffff",
				labelFontFamily: "Lucida Sans Unicode",
				
				
		},

		axisY2: {				
				gridColor: "#ffffff",
				lineColor: "#ffffff",
				labelFontColor: "#ffffff",
				tickThickness:0,
				interval:1,
				maximum: 5
			},
		toolTip:{
				enabled: true   //enable here
			  },
		data: [{
				
			type: "bar",
			axisYType: "secondary",
			//color: GridColor,	
			//xValueType: "dateTime",
			dataPoints : obj,
			mouseover: function(e){
			$(".questionsDiv").hide();
			$("#"+e.dataPoint.dataPoint).show();
		    console.log(e.dataPoint.dataPoint);
			},
			/*mouseout: function(e){
			//$(".questionsDiv").hide();
			//$("#"+e.dataPoint.dataPoint).show();
		//	console.log(e.dataPoint.dataPoint);
			},*/

		}]
		});

		return chart;
	}
	
	
	function addGraphKnowledge(obj, containerNm, color, heading)
	{
		var chart =  intializeGraph(containerNm, obj, color, heading);

		chart.render();
		chart = {};
	}
	
	function addGraphPsy(obj, containerNm, color, heading)
	{
		var chartPsy = intializeGraph(containerNm, obj, color, heading);

		chartPsy.render();
		chartPsy = {};
	}
	
	function addGraphSocial(obj, containerNm, color, heading)
	{
		var chartSocial = intializeGraph(containerNm, obj, color, heading);

		chartSocial.render();
		chartSocial = {};
	}
	
	function addGraphSelf(obj, containerNm, color, heading)
	{
		var chartSelf = intializeGraph(containerNm, obj, color, heading);

		chartSelf.render();
		chartSelf = {};
	}
	function addLearning(containerNm,heading,learnText)
	{
		$('#'+containerNm).html("<label style='margin-left:3px;' class='ft16'>"+heading+"</label>");
		$('#'+containerNm).append("<div class='pvalblk'>"+learnText+"</div>");
	}
	
	$(document).ready(function()
	{
		
		$("div.card_create_report_1").css("display", "none");
		var id = $("#patIdGraph").val();
		$("#contextPatientId").val(id);
		if($("#updateCommunicationid").val() != "" && $("#dashcard").val() == "")
		{
			var updateCommunicationid = $("#updateCommunicationid").val();
			updateCommunication(updateCommunicationid,id,'');
			$(".showHide"+updateCommunicationid).val("HIDE..");
		}
		else if($("#dashcard").val() != "")
		{
			var ele = $("#dashcardLink");
			updateCareCommStatus($("#updateCommunicationid").val(),id,ele);
		}
setTimeout(function(){
		getPatientSurvey(id);
		getPatientAssesmentSurvey(id);
}, 400);	
//care  communication
$("span.tileDate").each(function( index, element) {
	var time = moment($(element).html());
	//time.subtract(time.zone(), 'minutes');
	var localTime  = moment.utc($(element).text()).toDate();
    localTime = moment(localTime).format('D MMM YYYY  h:mm A');
	localTime = localTime.toUpperCase();
	$(element).html(localTime);
});

$("span.updateDate").each(function( index, element) {
	var time = moment($(element).html());
	//time.subtract(time.zone(), 'minutes');
	var localTime  = moment.utc($(element).text()).toDate();
    localTime = moment(localTime).format('L  h:mm A');
	$(element).html(localTime);
});

});
	
function viewSurvey (event)
{
	//console.log(patsurveyInfos);
patsurvey.forEach(function(p, s) 
{
	if(patsurveyInfos)
	{
		if(patsurveyInfos.survey_id == p.surveyId)
		{
			var sName = patsurveyInfos.surveyTitle.split("'").join('_');
			openPageWithAjax('../../patientSurvey/pages/surveyDetail.php','surveyId='+patsurveyInfos.survey_id+'&pageId='+patsurveyInfos.pages[1].page_id+'&patientId='+patsurveyInfos.patientId+'&surveyStatus='+patsurveyInfos.surveySummary.surveyStatus+'&surveyName='+sName+'&uniqueSurveyId='+p.uniqueSurveyId,'menu-content',event,this);
		}
	}
});
}

	
function assignSurvey (event)
{
	var contextPId = $("#contextPatientId").val();
	if(contextPId)
	{
	openPageWithAjax('../../survey/pages/showSurvey.php','contextPId='+contextPId,'menu-content',event,this);
	}
}
// care communication start
function createCommunication()
{
    careCommHeaderInfo = {};
	careCommDetailInfo = {};
	var providerId = $("#provider").val();
	var editProviderId = $("#editProviderId").val();
	// var provFirstName = $('option:selected', "#provider").attr('firstName');
	// var provLastName = $('option:selected', "#provider").attr('lastName');
	// var provCredentials = $('option:selected', "#provider").attr('credentials');
	
	var provFirstName =   $("#editProvFirstName").val();
	var provLastName =    $("#editProvLastName").val();
	var provCredentials = $("#editProvCredentials").val();
	
	
	var patientId = $("#contextPatientId").val();
    var status = "ACTIVE";
    var reason = $("#reason").val();
	var careMessage = $("#communication").val();

	if ($("#urgent").prop("checked")) 
	{
		var urgent = true;
	}
	else
	{
		var urgent = false;
	}
	var array = [];
	careCommDetailInfo.careMessage = careMessage;
	careCommDetailInfo.read = false;
	careCommDetailInfo.urgent = urgent;
	careCommDetailInfo.assignUserId = providerId;
	careCommDetailInfo.createUserId = editProviderId;
	careCommDetailInfo.createCareProvFirstName = provFirstName;
	careCommDetailInfo.createCareProvLastName = provLastName;
	careCommDetailInfo.createCareProvCredential = provCredentials;
	
	
	careCommDetailInfo.patientId = patientId;
	careCommDetailInfo.state = INSERT;
    array[0] = careCommDetailInfo;
	careCommHeaderInfo.providerId = editProviderId;
	//careCommHeaderInfo.editProviderId = editProviderId;
	careCommHeaderInfo.patientId = patientId;
	careCommHeaderInfo.status = status;
	careCommHeaderInfo.reason = reason;
	careCommHeaderInfo.careCommDetailInfos = array;
	careCommHeaderInfo.state = INSERT;
	
	var arr = new Array();

	arr[0] = JSON.stringify(careCommHeaderInfo);
	var dataVal = JSON.stringify(arr);
	console.log(dataVal);
	
	// start validation
	
	if(reason == "")
		{
		$(".cart_page").html("Reason");
		$(".txt_div").html("Please enter the reason.");
		$("#aboutPopup").show();
		$("#About_fadediv").show();
        $("#reason").focus();		
		return false;
		}
		else if(careMessage == "")
		{
		$(".cart_page").html("Communication");
		$(".txt_div").html("Please enter the message.");
		$("#aboutPopup").show();
		$("#About_fadediv").show();
		$("#communication").focus();
		return false;
		}
		else if($("#urgent").prop("checked") != true && $("#notUrgent").prop("checked") != true )
		{
		$(".cart_page").html("Urgent");
		$(".txt_div").html("Please mark  message as urgent or not-urgent.");
		$("#aboutPopup").show();
		$("#About_fadediv").show();
		return false;
		}
		else{
	var retVal = postDataToServer(dataVal, EMR, 'createUpdateCareCommunication', processCareResponse);
		}

}
function processCareResponse(result) 
	{
		if (result != null && result.message != null  && result.message != "" && result.success == true) 
		{
			if(result.message != "null" && result.message != null )
			{
				var carePatId = $("#contextPatientId").val();
				 openPageWithAjax('../../dashboard/pages/portal_careManagement.php', 'patientId='+carePatId+'&type=EDIT', 'menu-content', undefined, undefined);
				
			}
		}
	}	
// care communication end

// Update care communication start
function findCareCommunication(carePatientId) {
    var arr = new Array();
	arr[0] = carePatientId;
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, EMR, 'findCareCommunicationByPatientId', processUpdateCommDetails);
	//console.log(retVal);
}

function processUpdateCommDetails(result) {
	if (result != null && result.message != null  && result.message != "" && result.success == true) 
		{
			if(result.message != "null" && result.message != null )
			{
				
				
				careCommHeaderInfo = JSON.parse(result.message);
				
				
			}
			
		}
}
function updateCommunication(careCommHeaderId,carePatientId,ele)
{
	$("div.card_create_report_1").css("display", "none");
$("div.card_create_report").css("display", "block");
	var showUrgent = "";

	findCareCommunication(carePatientId);
setTimeout(function(){
	careCommHeaderInfo = JSON.stringify(careCommHeaderInfo).replace(/'/g, "\&rsquo;");
	careCommHeaderInfo = JSON.parse(careCommHeaderInfo);
	careCommHeaderInfo.forEach(function(headerInfo, i)
	{
		if(headerInfo.careCommHeaderId == careCommHeaderId)
		{
			careCommDetailInfo = headerInfo.careCommDetailInfos;
			
					
					var careHtml = "<div class='col-lg-12 reportCardDiv1 card_create_report_1' id='reportCardDiv1'><div class='' style='padding:10px 15px;'><form class='form-horizontal' id='update-care-form' action='javascript:updateCareCommunication("+JSON.stringify(headerInfo)+")'><fieldset><div class='form-group'><div class='col-md-8'><div class='clearfix wRightLbl'><label for='selectbasic' class=''>ASSIGN TO</label><select id='updateProvider' name='updateProvider' class='form-control' style='border:1px solid #333333;'>"+$('#provider').html()+"</select></div></div><div class='col-md-3'><div class='clearfix'> </div><div class='clearfix'><input name='cancelComm' id='cancelComm' class='btn btn-default btn-linktype newText btn-bottom-align' value='SAVE' type='submit'></div></div></div><div class='col-md-8'><div class='form-group'><label for='inputText' class=''>COMMUNICATION</label><div class='pull-right right-radio'><label class='radio-inline radio-image'><input name='urgentRadio' id='newNotUrgent' value='N' type='radio'><img src='/gladstone/portal/bloom/dashboard/images/radio-1.png' class='img-circle' width='15px' height='15px'>&nbsp;<span class='radio-align'>Not Urgent</span></label><label class='radio-inline radio-image left-radio'><input name='urgentRadio' id='newUrgent' value='Y' type='radio' checked='checked'><img src='/gladstone/portal/bloom/dashboard/images/radio-1.png' class='img-circle' width='15px' height='15px'><span class='radio-align'>&nbsp; Urgent</span></label></div> <textarea class='form-control' rows='3' name='newCommunication' id='newCommunication'></textarea></div></div><div class='col-md-4'><div class='clearfix'><label>&nbsp;</label></div><div class='clearfix'>                <label>&nbsp;</label></div><div class='clearfix'><label>&nbsp;</label></div><div class='pull-right'><input type='submit' name='replyMsg' value='Send' id='replyMsg'class='btn btn-success colorSend increase-size'><input type='hidden' name='replyMsg' id='replyMsg'></div></div><div>&nbsp;</div><div class='row border-top'><div class='urgentMessage border-none' style=''><div class='equal'><div>&nbsp;</div>";
				careCommDetailInfo.forEach(function(detailInfo, j)
				{
						var localTime  = moment.utc(detailInfo.createTimeStamp).toDate();
   						 localTime = moment(localTime).format('D MMM h:mm A');
						 var careMessage = detailInfo.careMessage.replace("'",'&rsquo;');						 
						// var careCommMessage = unescape(careMessage);
						if(detailInfo.urgent == true)
						{
							showUrgent = " - URGENT";
						}
					careHtml = careHtml+"<div class='col-md-12'><div class='col-md-10'><span class='labelBold'>"+detailInfo.createCareProvFirstName+" "+detailInfo.createCareProvLastName+" - </span><span class='msgTime labelBold'>"+localTime+"</span><span  class='labelBold'>"+showUrgent+"</span></div><div class='col-md-12'><p>"+careMessage+"</p></div></div>";
		showUrgent = "";
			  });
					careHtml = careHtml+"</div></div><div class='row'><div class='' style='margin:'><div class='col-md-5'>&nbsp;</div><div class='col-md-7'><div class='pull-right'><input type='hidden' name='headerId' id='headerId' val='"+headerInfo.careCommHeaderId+"'/><div style='display:none;'>"+$('#editProvider').html()+"</div></div></div></fieldset></form></div></div>";
					$('#reportCardDiv1').remove();
					$(careHtml).insertAfter('#careDetail_'+headerInfo.careCommHeaderId);
					//$('#updateProvider').val(headerInfo.providerId);
					$("#updateProvider").focus();
		}
		
	});
	
},500);
/*if($(ele).val().trim() == "SHOW..")
{
$(".showHide"+careCommHeaderId).val("HIDE..");
$("div a img.imageSize").attr("src","/gladstone/portal/bloom/login/images/warningGray.png");
}
else
{
	$(".showHide"+careCommHeaderId).val("SHOW..");
	$('#reportCardDiv1').remove();
	
}*/
}
function updateCareCommunication(headerInfo)
{
	newCareCommDetailInfo = {};
		
	var providerId = $("#updateProvider").val();
	var editProviderId = $("#editProviderId").val();
	// var provFirstName = $('option:selected', "#provider").attr('firstName');
	// var provLastName = $('option:selected', "#provider").attr('lastName');
	// var provCredentials = $('option:selected', "#provider").attr('credentials');
	
	var provFirstName =   $("#editProvFirstName").val();
	var provLastName =    $("#editProvLastName").val();
	var provCredentials = $("#editProvCredentials").val();
    var updatePatientId = $("#contextPatientId").val();
	var careMessage = $("#newCommunication").val();
	var headerId = headerInfo.careCommHeaderId;
	 newCareCommDetailInfo = headerInfo.careCommDetailInfos[0];
	 console.log(newCareCommDetailInfo);
	 
	if ($("#newUrgent").prop("checked")) 
	{
		var urgent = true;
	}
	else
	{
		var urgent = false;
	}
	var array = [];
	
	
	if(careMessage != "")
	{
		insertCareCommDetailInfo = {};
		insertCareCommDetailInfo.careMessage = careMessage;
		insertCareCommDetailInfo.urgent = urgent;
		insertCareCommDetailInfo.msgRead = false;
		insertCareCommDetailInfo.assignUserId = providerId;
		insertCareCommDetailInfo.createUserId = editProviderId;
		insertCareCommDetailInfo.createCareProvFirstName = provFirstName;
		insertCareCommDetailInfo.createCareProvLastName = provLastName;
		insertCareCommDetailInfo.createCareProvCredential = provCredentials;
		insertCareCommDetailInfo.patientId = updatePatientId;
		insertCareCommDetailInfo.state = INSERT;
		array[0] = insertCareCommDetailInfo;
	}
	else
	{
		newCareCommDetailInfo.assignUserId = providerId;
		newCareCommDetailInfo.createUserId = editProviderId;
		newCareCommDetailInfo.createCareProvFirstName = provFirstName;
		newCareCommDetailInfo.createCareProvLastName = provLastName;
		newCareCommDetailInfo.createCareProvCredential = provCredentials;
		newCareCommDetailInfo.state = UPDATE;
		array[0] = newCareCommDetailInfo;
	}
	var Reason = headerInfo.reason;
	Reason = Reason.replace(/\u2019/g, "'");
	headerInfo.status = "ACTIVE";
	headerInfo.reason = Reason;
	headerInfo.careCommDetailInfos = array;
	headerInfo.state = UPDATE;
	
	var arr = new Array();

	arr[0] = JSON.stringify(headerInfo);
	var dataVal = JSON.stringify(arr);
	var retVal = postDataToServer(dataVal, EMR, 'createUpdateCareCommunication', processUpdateCareResponse);
}
function processUpdateCareResponse(result) 
	{
		if (result != null && result.message != null  && result.message != "" && result.success == true) 
		{
			if(result.message != "null" && result.message != null )
			{
				console.log(result.message);
				var carePatId = $("#contextPatientId").val();
			   openPageWithAjax('../../dashboard/pages/portal_careManagement.php', 'patientId='+carePatId+'&type=EDIT', 'menu-content', undefined, undefined);
				
			}
		}
	}	
	function myDateFormatter (dob) {
			//var d = new Date(dob);
			var d = dob;
			var day = d.getDate();
			var month = d.getMonth()+1;
			var year = d.getFullYear();
			var date =  month +"/"+ day + "/" + year;
			console.log(date);
			return date;
		}
function careCommDetailId(ele,id){
	$(ele).toggleClass('readCheck');
	if($(ele).hasClass('readCheck'))
	{
	var checkBox = $("<input name='careCommDetailId[]' value='"+id+"' class='form-control input-md' id='careCommDetailId"+id+"' type='hidden' />");
 	$("#update-care-form").append(checkBox);
	}
	else
	{
		$("#update-care-form #careCommDetailId"+id).remove();
	}
}
$("#reason").on("keyup change input focusout",function(){
		var val = $(this).val();
        var len = val.length;
        $('#charCount').text(len+"/80");
       
      });

function updateCareCommStatusPopup(careCommHeaderId,commPatientId,ele)
{
		$('#myModal').modal('show');
		$("#updateCareCommStatusPopup").click(function()
		 {
			 updateCareCommStatus(careCommHeaderId,commPatientId,ele);
		});
	
}

function updateCareCommStatus(careCommHeaderId,commPatientId,ele)
{
	var newCareCommDetailInfo = {};	
	var newHeaderInfo = {};
	findCareCommunication(commPatientId);
	setTimeout(function(){	
		headerInfos = careCommHeaderInfo;
		headerInfos.forEach(function(headerInfo, d)
		{
			if($(ele).hasClass('status'))
			{
				var textStatus = $(ele).text();
				if(textStatus.trim() == "ACTIVE")
				{
					headerInfo.status = "ADDRESSED";
				}
				else
				{
					headerInfo.status = "ACTIVE";
				}
			}
			var headerId = headerInfo.careCommHeaderId;
			if(careCommHeaderId == headerId)
			{
				var array = [];
				newCareCommDetailInfo = headerInfo.careCommDetailInfos;
				newCareCommDetailInfo.forEach(function(detailInfo, i)
				{
					if($(ele).hasClass('envelopeImage'))
					{
						if($(ele).find('img').hasClass('imageImageGray'))
						{
							detailInfo.msgRead = false;
						}
						else
						{
							detailInfo.msgRead = true;
							
						}	
					}
					else if($(ele).hasClass('showHide'+careCommHeaderId))
					{
						if($(ele).val() == "SHOW..")
						{						
							detailInfo.urgent = false;
							detailInfo.msgRead = true;
						}
						
					}
					detailInfo.state = UPDATE;				
					array[i] = detailInfo; 
				});
				
				headerInfo.careCommDetailInfos = array;
				headerInfo.state = UPDATE;
				newHeaderInfo = headerInfo;
			}
		})
	
	var arr = new Array();

	arr[0] = JSON.stringify(newHeaderInfo);
	
	var dataVal = JSON.stringify(arr);
	if($(ele).hasClass('showHide'+careCommHeaderId))
	{
		if($(ele).val().trim() == "SHOW..")
		{	
		 	var retVal = postDataToServer(dataVal, EMR, 'createUpdateCareCommunication', processUpdateCareUrgent);
		}
		else
		{
			$(".showHide"+careCommHeaderId).val("SHOW..");
			$('#reportCardDiv1').remove();
		}
	}
	else
	{
	var retVal = postDataToServer(dataVal, EMR, 'createUpdateCareCommunication', processUpdateCareStatus);
	}
},1000);
}
function processUpdateCareStatus(result) 
	{
		if (result != null && result.message != null  && result.message != "" && result.success == true) 
		{
			if(result.message != "null" && result.message != null )
			{
				var carePatId = $("#contextPatientId").val();
			   openPageWithAjax('../../dashboard/pages/portal_careManagement.php', 'patientId='+carePatId+'&type=EDIT', 'menu-content', undefined, undefined);
				
			}
		}
	}
function processUpdateCareUrgent(result) 
	{
		if (result != null && result.message != null  && result.message != "" && result.success == true) 
		{
			if(result.message != "null" && result.message != null )
			{
				var newInfo = JSON.parse(result.message);
				var newCareCommHeaderId = newInfo.careCommHeaderId;
				var newPatId = newInfo.patientId;
			  openPageWithAjax('../../dashboard/pages/portal_careManagement.php', 'careCommHeaderId='+newCareCommHeaderId+'&patientId='+newPatId+'&type=EDIT', 'menu-content', undefined, undefined);
			}
		}
	}
	
