<?php
include 'controller/portal_dashboard_controller.php';
$type = strtoupper($_COOKIE['type']);
?>
<div class="scrollbar1 scroll-outer" style="overflow:auto;">
        <div class="content scroll-inner" id="dashCard">
				<div id="patientreviewedcard_ALL" class="patientreviewedcard_ALL">
				<?php
					echo addReviewedDashboardCards($dashboardCards, $_COOKIE['type']);
				?>
				</div>
				<div id="patientreview_ALL" style="display:none;">
				<?php
					echo addDashboardCards($dashboardCards,$_COOKIE['type']);
				?>
				</div>
				</div>
			</div>
<script>
$(document).ready(function(){
$("h5.time_date").each(function( index, element) {
	var time = moment($(element).html());
	//time.subtract(time.zone(), 'minutes');
	var localTime  = moment.utc($(element).text()).toDate();
    localTime = moment(localTime).format('MMM D h:mm A');
	$(element).html(localTime);
	$(element).removeClass("time_date");
});
	  var patientsValue = $("#patients").val();
  	  var cardType = $('#cards').val();
	  //var cardType = $("#cardTypeList ul li.active").attr('value');
  	  var activeTabId= $('button.active').attr('id');
  	  var dashboardCards = $('div.dashboardCards');
	  var activeDiv = "patientreview_ALL";
  	  if(activeTabId === "reviewedList")
  	  {
  		activeDiv = "patientreviewedcard_ALL";

  	  }
  	  else
  	  {
  		activeDiv = "patientreview_ALL";
  	  }
/*	   //$(dashboardCards).hide();
	  		$('#'+activeDiv+' .dashboardCards').each(function(index){
	  				checkCards(this,cardType);
	  	});

*/	//changeCards('');
   var patientsValue = $("#patients").val();
			if(patientsValue =="PATIENT" || patientsValue == "Patient")
			{

				$("#patientreview_ALL div.dashboardCards").show();
				$("#patientreview_ALL div.dashboardCards div.AdminImg").find('img').hide();
				$("#patientreviewedcard_ALL div.dashboardCards").removeClass('col-md-9');
				$("#patientreviewedcard_ALL div.dashboardCards").addClass('col-md-11');
				$("#patientreviewedcard_ALL div.dashboardCards").css('width','95%');
				$("#patientreviewedcard_ALL div.dashboardCards h3").find('img').hide();


			}

			$("#patientreviewedcard_ALL").show();
			$("#patientreview_ALL").hide();
			$("#reviewedList").addClass("active");
		//	$("#review_new").removeClass("active");var $scrollOuter = $('div.scroll-outer:eq(0)');




});

function  Cards(carttype)
{
	$("#menu-content").unbind('scroll');
	var patient_id = carttype.split('_');
	patient_id=patient_id[0];
	var cartTypes = $("#"+carttype).attr('class');
	var cardType = $("#"+carttype).attr('cardType');
	var deviceId = $("#"+carttype).attr('deviceId');
	var careCommHeaderId  = $("#"+carttype).attr('careCommHeaderId');
	if(cartTypes=="notes")
	{
	setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/messages/pages/messages.html?patientId='+patient_id);
	}
	else if(cartTypes =="pdf_video")
	{
	setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/portalLearn/pages/portal_learn.php');

	}
	else if(cartTypes =="vitals")
	{
		if(cardType.toUpperCase() == "<?php echo VMCPortalConstants::$GLUCOSE; ?>")
		{
			$("#deviceConfigID").val(deviceId);
			setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/vitals/pages/vitals_graphBG.php?vitalType=Blood-Glucose');			
		}
		else if(cardType.toUpperCase() == "<?php echo VMCPortalConstants::$OXYGEN; ?>")
		{
			$("#deviceConfigID").val(deviceId);
			setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/vitals/pages/vitals_graphBP.php?vitalType=Blood-Oxygen');			
		}
		else if(cardType.toUpperCase() == "<?php echo VMCPortalConstants::$WEIGHT; ?>")
		{
			$("#deviceConfigID").val(deviceId);
			setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/vitals/pages/vitals_graphBP.php?vitalType=Body-Weight');			
		}
		else if(cardType.toUpperCase() == "<?php echo VMCPortalConstants::$DIASTOLIC; ?>" || cardType.toUpperCase() == "<?php echo VMCPortalConstants::$SYSTOLIC; ?>")
		{
			$("#deviceConfigID").val(deviceId);
			setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/vitals/pages/vitals_graphBP.php?vitalType=Blood-Pressure');			
		}
		else if(cardType.toUpperCase() == "PEAKFLOW")
		{
			$("#deviceConfigID").val(deviceId);
			setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/vitals/pages/vitals_graphPF.php?vitalType=Peak-Flow');			
		}

	}
	else if(cartTypes =="survey" && "PATIENT" == "<?php echo $type;?>")
	{
	setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/survey/pages/survey.php');

	}
	else if(cartTypes =="care")
	{
	setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/dashboard/pages/portal_careManagement.php?careCommHeaderId='+careCommHeaderId+'&patientId='+patient_id+'&type=EDIT&dashcard=dashcard');

	}
	else if(cartTypes =="patient" || cartTypes =="PATIENT")
	{
	var userType = "<?php echo $type;?>";
	if(userType == "PATIENT")
	{
		setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/patientcare/pages/patient_care.php');
	}
	else
	{
		setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/dashboard/pages/portal_careManagement.php?patientId='+patient_id+'&type=EDIT');
	}

	}

	var image = $("#"+carttype).attr('name');
	var name = $("#"+carttype).attr('alt');
	var id = patient_id ;
	$('#contextPatientName').val(name);
	var patName ;
	if(name.length > 11)
	{
	 patName = name.substring(0,11)+"..";
	}
	 else
	 {
		patName = name;
	 }
	$('#contextPatientId').val(id);
	$('#contextPatientImage').val(image);
	
	$('#patients option[value="selectedPatient"]').show();
	$('#patients option[value="selectedPatient"]').text(patName);
	//$("#patients").append('<option value="'+patientName+'">'+patientName+'</option>');
	$("#patients").prop("selectedIndex", 3); 
	$('#patImage').show();
	$('#patsImages').hide();
	$("#patients").show();
	$("#headerMenu li").attr("ref",id);

}
//alert click
function  alertCards(cardId)
{
	$("#menu-content").unbind('scroll');
	var card_id = cardId.split('_');
	patient_id=card_id[0];
	var reviewId = $("#"+cardId).attr('reviewId');
	var cardTypes ;
	var careCommHeaderId  = $("#"+cardId).attr('careCommHeaderId');
	if($("#"+cardId).hasClass("btn_vitals") || $("#"+cardId).hasClass("btn_notes"))
	{
	  cardTypes = "notes";
	  
	  
	}
	else if($("#"+cardId).hasClass("btn_care"))
	{
		cardTypes = "care";
		
	}
	else
	{
	cardTypes = $("#"+cardId).attr('class');
	}
	if(cardTypes=="notes" || cardTypes=="vitals")
	{
	setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/patientcare/pages/reviewAlert.php?patientId='+patient_id+'&reviewId='+reviewId);
	}
	else if(cardTypes=="care")
	{
		setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/dashboard/pages/portal_careManagement.php?type=EDIT&dashcard=dashcard&careCommHeaderId='+careCommHeaderId+'&patientId='+patient_id);
	}
	
	if($("#"+cardId).hasClass("btn-green"))
	{
	  var ele = $("#"+cardId).parent().parent();
		var image = $(ele).find("img").attr('name');
		var name = $(ele).find("img").attr('alt');
	}
	else
	{
	var image = $("#"+cardId).attr('name');
	var name = $("#"+cardId).attr('alt');
	}
	var id = patient_id ;
	$('#contextPatientName').val(name);
	var patName ;
	if(name.length > 11)
	{
	 patName = name.substring(0,11)+"..";
	}
	 else
	 {
		patName = name;
	 }
	$('#contextPatientId').val(id);
	$('#contextPatientImage').val(image);
	
	$('#patients option[value="selectedPatient"]').show();
	$('#patients option[value="selectedPatient"]').text(patName);
	//$("#patients").append('<option value="'+patientName+'">'+patientName+'</option>');
	$("#patients").prop("selectedIndex", 3); 
	$('#patImage').show();
	$('#patsImages').hide();
	$("#patients").show();
	$("#headerMenu li").attr("ref",id);

}
var taHTML = $('#menu-content').html();
var showScroll = $("#getScroll").val();
var counter = 0;
$('#menu-content').bind('scroll', function(e)
{
		var action = $("a.nextPage").attr("action");
		var params = $("a.nextPage").attr("params");
		var resultingDivId = $("a.nextPage").attr("resultingDivId");
if($(this).scrollTop() + $(this).innerHeight()>=$(this)[0].scrollHeight)
{
		if(showScroll)
		 {
		 		if(counter == 0)
				{	
				openPagewithScroll(action,params,resultingDivId,e,"a.nextPage");
				}
				counter++;
				
		 }		
}
});
$(document).ready(function ()
{
   var patientsValue = $("#patients").val();

			if(patientsValue =="PATIENT" || patientsValue == "Patient")
			{
			var cardsLength = 5;
			}
			else
			{
			var cardsLength = 10;
			}
setTimeout(function(){ 
var windowHeight= $(window).height();
var cardLength =  $(".patientreviewedcard_ALL").find('.dashboardCards').length;
	if(windowHeight>700 && cardLength == cardsLength)
	{
	
			var action = $("a.nextPage").attr("action");
			var params = $("a.nextPage").attr("params");
			var resultingDivId = $("a.nextPage").attr("resultingDivId");
			openPagewithScroll(action,params,resultingDivId,'',"a.nextPage");
		//	alert(menuHeight);
	
	}
	}, 100);
});

</script>