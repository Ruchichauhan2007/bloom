<div class="wrapper2">
<?php
	include ('controller/patient_care_controller.php');
	include('../../common/util/CardFactory.php');
	$entityUtil = new EntityUtil();
	$dateUtil = new DateUtil();
	$patientUtil = new PatientUtil();
	$patientId = $patientUtil->getPatientIdFromContext();
    $entityId = $entityUtil->getLoggedInEntityId();
	$userName = $entityUtil->getLoggedInUserNameFromContext();
	if($_COOKIE['type']=="Provider")
	{
		$paramArray = array() ;
		//$paramArray[0] = $entityId;
		$paramArray[0] = $patientId;
		$stickyNotesInfos=$entityUtil->getObjectFromServer($paramArray, "getStickyNoteByPatientId", VMCPortalConstants::$API_EMR);
		
		$paramArray = array() ;
		$paramArray[0] = $entityId;
		$paramArray[1] = $patientId;
		$Notes=$entityUtil->getObjectFromServer($paramArray, "findDraftByEntityIdAndPatientId", VMCPortalConstants::$API_EMR);
		
		$paramArray = array() ;
		$paramArray[0] = $entityId;
		$providerInfo=$entityUtil->getObjectFromServer($paramArray, "findProviderById", VMCPortalConstants::$API_EMR);
	}
	else if(strtoupper($_COOKIE['type']) == "PATIENT")
	{
		$patientId = $entityId;
		$paramArray = array() ;
		$paramArray[0] = $entityId;
		$paramArray[1] = $patientId;
		$Notes=$entityUtil->getObjectFromServer($paramArray, "findDraftByEntityIdAndPatientId", VMCPortalConstants::$API_EMR);
		
	}
			
	$paramArray = array() ;
	$paramArray[0] = $patientId;
	$oldActionPlanStr = $entityUtil->getObjectFromServer($paramArray, "findPatientActionPlanByPatientId", VMCPortalConstants::$API_EMR);
	
?>
<style>
html {
	height: 100%;
}
body {
	height: 100%;
}
.col-xs-12.col-md-9 {
	overflow: hidden !important;
}
.animated
{
	overflow:auto !important;

}
.rightDate
{
float:right;
}
.pat_care_edit {
  width: 96% !important;
  padding-left: 26px;
  padding-top: 2px;
  font-size: 14px;
  padding-bottom: 5px;
}

</style>
<?php
	$contextPId = $_POST['contextPId'];
?>
<!--Including css files used in all the html pages -->
<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/patientcare/script/css/patientcare.css" rel="stylesheet" type="text/css">
<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/script/css/common-css.css" rel="stylesheet" type="text/css">
<div class="col-md-8 padd-top20">
<input type="hidden" id="userType" value="<?php echo $_COOKIE['type']; ?>" />
<div class="row card-container">
  <div class="patientcare_bg">
    <div class="patientcare_bgt_content" id="patientinfor">
      <div class="learn_patient_content_align">
        <div id="selectedPatient" class="learn_patient_contentimg"><a href="#"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/portalLearn/images/learn_patient_img.jpg" alt=""></a> </div>
        <h3 style="padding-top:10px;">Smith , Joe</h3>
       
        
      </div>
    </div>
    <div class="patientcare_tabs">
      <ul>
        <li><a href="#" id="patient_care_link">Action Plan</a></li>
      <!--  <li><a href="#" id="observation_link">Observations</a></li>-->
        <li><a href="#" id="notes_link">My Notes</a></li>
        <!-- <li><a href="#" id="carePlan_link">Care Plan</a></li> -->
      
      </ul>
      
    </div>
    <!--<p class="pat_care_edit">Edited by <?php// echo " ".$providerInfo->{lastName}.", ".$providerInfo->{firstName}." ".$dateUtil->formatPatientCareHeaderDatetoStr($oldActionPlanStr->{updateTimeStamp}); ?> </p>-->
    <div id="div_form">
      <form action="" method="post" id="patient_care_form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/patientcare/pages/patient_care.php','patient_care_form','menu-content',event)">
        <div class="patient_care_form" id="patient_care">
            <div class="form-group">
                <?php if($oldActionPlanStr != NULL and $oldActionPlanStr != "") {
				
				?> 
			<input type="hidden" id="createdBy" value="<?php echo " ".$oldActionPlanStr->{editedProvLastName}.", ".$oldActionPlanStr->{editedProvFirstName};?>" >
			<input type="hidden" id="createdDate" value="<?php echo $oldActionPlanStr->{updateTimeStamp}; ?>" >
           <p class="pat_care_edit">Edited by:<?php echo " ".$oldActionPlanStr->{editedProvLastName}.", ".$oldActionPlanStr->{editedProvFirstName};?><span class="rightDate"><?php echo $oldActionPlanStr->{updateTimeStamp}; ?></span></p>
               <?php }?>
                
                <div class="patientcare_messagebg1">
              
                  <h5 class="top-text" id="providerInfor"><?php echo  $providerInfo->{lastName}.", ".$providerInfo->{firstName}." ".$providerInfo->{credentials}; ?> </h5>
                  <textarea class="form-control animated" id="patient_care_title" name="patient_care_title" style="border:none; box-shadow:none; font-size:16px;" maxlength="2000"><?php echo $oldActionPlanStr->{goals} ?></textarea>
                </div>
            </div>
        </div>
        <div class="patient_care_form" id="observation">
          <div class="patient_form_area">

          <div class="textareaBloom">
          <textarea cols="82" placeholder="New Observation" name="observation_title" id="observation_title" maxlength="800" style="height:55px;margin-left:28px;padding-left: 11px;width:91.75%;"></textarea>
          </div>
          </div>
          <div class="patientcare_messagebg" style="height:275px; overflow:auto;">
            <?php  echo addObservations($stickyNotesInfos); ?>
          </div>
        </div>
        <div class="patient_care_form" id="notes">
          <div class="patientcare_messagebg">
            <div class="patientcare_messagebg_text">
             <!-- <h4 style="padding:5px;"><?php echo  $providerInfo->{lastName}.", ".$providerInfo->{firstName}."  ".$providerInfo->{credentials}; ?> </h4>-->
                <?php
				 $notedValue = addNotes($Notes);
				 $notesinfo = explode('_',$notedValue);
				 $draftId = $notesinfo[0];
				 $notesData = $notesinfo[1];
				
			  ?>
				  <input type="hidden" name="draftId" value="<?php echo $draftId;?>"  />
              <textarea name="notes_description" id="notes_description" style=" height:320px;" maxlength="800"><?php echo $notesData;?></textarea>
            </div>
            <input type="hidden" name="submit" value="<?php echo constantAppResource::$COMMON_BUTTON_SAVE;?>"/>
            <input type="hidden" name="contextPId" value="<?php echo $patientUtil->getPatientIdFromContext()?>"/>
          </div>
        </div>
        <div style="clear:both;"></div>
        <div class="button-content">
          <input type="Reset" class="btn-neutral" value="Cancel" id="reset">
          <input type="submit" class="btn-neutral" value="Post" name="submit" id="submit">
          <input type="text" name="page" id="page" style="display:none;"/>
        </div>
      </form>
    </div>
    <div id="careplan">
      <div class="patientCards" id="addContent">
        <div class="col-md-2"> <a href="#"><img src="/gladstone/portal/bloom/dashboard/images/addpatient.png" alt=""></a> </div>
        <div class="col-md-7" style="font-size:21px; padding-top:26px;">Click to add more content</div>
      </div>
      <div class="patientCards">
        <div class="col-md-2"> <a href="#"><img src="/gladstone/portal/bloom/patientcare/images/careplan.png" alt=""></a> </div>
        <div class="col-md-6">
          <h4>Action plan</h4>
          <h3>My Sticky Description</h3>
        </div>
        <div class="col-md-3 pat_but">
          <input type="reset" value="Delete" class="pat_but1">
          <h3>Sep 10 6:11 P.M.</h3>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<div class="clear"></div>
<div class="push"></div>
</div>

<script>
<?php
	if($_COOKIE['type']=="Provider")
	{
	//print ("$('#btnExportPDF').show();")
	}
?>
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
	
	if($('#patient_care_link').hasClass("active"))
	{
		doc.text(15,30,'Edited By:'+" "+$('#createdBy').val());
		var timeEdit = $('#createdDate').val();
		doc.text(120,30,timeEdit.substring(5,7)+"/"+timeEdit.substring(8,10)+"/"+timeEdit.substring(2,4)+" "+timeEdit.substring(11,16));

		
		//doc.setFontSize(12);
		var textToPrint = $('#patient_care_title').html();
		lines = doc.splitTextToSize(textToPrint,180);
		doc.text(15,45,lines);
		doc.save('Action Plan_'+filePdf+'.pdf');	 
	}
	else if($('#observation_link').hasClass("active"))
	{
		var y = 30;
		
		$("[id^='Observation_']").each(function (i, elem) {
			
			//Condition to print time stamp in alignment
			if ( $(elem).attr('id') == "Observation_createdTimeStamp")
			doc.text(135,y,$(elem).text());
			else
			doc.text(15,y,$(elem).text());
		
			//Space To Add Description of Present Record
			if ( $(elem).attr('id') != "Observation_lastModifiedName")
			y+=10;

			//Space To Add Next Record
			if ( $(elem).attr('id') == "Observation_obsDescription")
			y+=10;
		})	
		doc.save('Observations_'+filePdf+'.pdf');	 
	}		
}

 $(document).ready(function() { 
	$("h5.time_date").each(function( index, element) {
	var time = moment($(element).html());
	//time.subtract(time.zone(), 'minutes');
	var localTime  = moment.utc($(element).text()).toDate();
    localTime = moment(localTime).format('MMM D YYYY hh:mm A');
	$(element).html(localTime);
});

	$("span.rightDate").each(function( index, element) {
	var time = moment($(element).html());
	//time.subtract(time.zone(), 'minutes');
	var localTime  = moment.utc($(element).text()).toDate();
    localTime = moment(localTime).format('MM/DD/YY hh:mm A');
	$(element).html(localTime);
});
});
 $(document).ready(function() { 
 var patientType=$("#userType").val();
 window.location.hash = '/patient_care';
	if(patientType.toUpperCase() =="PATIENT")
	{
		$("#submit,#reset,#submit").hide();
		//$("#notes_description").attr("disabled","disabled");
		$("#patient_care_link").addClass('active');
		$("#notes_link").removeClass('active');
		$("#patient_care").css('display', 'block');
		$("#observation").css('display', 'none');
		$("#notes").css('display', 'none');	
		$("#careplan").css('display', 'none');
		 $("#patient_care_link").click(function()
		{
		$("#submit,#reset,#submit").hide();
		$("#notes_description").attr("disabled","disabled");
		});
	
		$("#providerInfor,#patientinfor,#addContent").hide();
	
		$("#observation_link").parent("li").hide();
		$("#patient_care_title").attr("disabled","disabled");
		//$("#notes_description").attr("disabled","disabled");
		$("#patient_care_title").unbind();
		$("#patient_care_title").css({"backgroundColor":"#fff"});
		$("#notes_description").css({"backgroundColor":"#fff"});
		$("#notes_link").click(function() { 
		    $("#submit,#reset,#submit").show();
			$("#submit").attr('disabled','disabled');
			$("#submit").fadeTo(100,0.33);
			$("#notes_description").removeAttr("disabled","disabled");
			
		 });
	}
 	else
	{	
	
		$("#patient_care_link").css('display', 'none');
		$("#notes_link").addClass('active');
		$("#observation").css('display', 'none');
		$("#notes").css('display', 'block');	
		 $("#careplan").css('display', 'none');
		 $("#patient_care").css('display', 'none');
		 $("#submit").attr('disabled','disabled');
			$("#submit").fadeTo(100,0.33);
		 
	 }
	document.getElementById('page').value = "PATIENT_CARE";
	 var  currentMenu=$("#portal-menu").attr("Ref");
	 if(currentMenu=="observation_link")
	 {
	  $("#observation").css('display', 'block');
	  $("#notes").css('display', 'none');
	  
	  $("#careplan").css('display', 'none');
	  $("#div_form").css('display', 'block');
	  //alert($("#page").value = "OBSERVATION");
	  document.getElementById('page').value = "OBSERVATION";
	  $("#observation_link").addClass('active');
	  $("#notes_link").removeClass('active');
	  $("#patient_care_link").removeClass('active');
	  $("#carePlan_link").removeClass('active');
	  $("#portal-menu").attr("Ref","observation_link");
	 }
	 else if(currentMenu=="notes_link")
	 {
	       $("#observation").css('display', 'none');
	  $("#notes").css('display', 'block');
	  $("#patient_care").css('display', 'none');
	   $("#careplan").css('display', 'none');
	   $("#div_form").css('display', 'block');
	  document.getElementById('page').value = "NOTES";
	  $("#notes_link").addClass('active');
	  $("#observation_link").removeClass('active');
	  $("#patient_care_link").removeClass('active');
	  $("#carePlan_link").removeClass('active');
	  $("#portal-menu").attr("Ref","notes_link");
	 }
	 else if(currentMenu=="carePlan_link")
	 {
	  $("#careplan").css('display', 'block');
      $("#observation").css('display', 'none');
	  $("#div_form").css('display', 'none');
	  $("#patient_care").css('display', 'none');
	  $("#notes").css('display', 'none');
	  document.getElementById('page').value = "CARE";
	  $("#carePlan_link").addClass('active');
	  $("#observation_link").removeClass('active');
	  $("#patient_care_link").removeClass('active');
	  $("#notes_link").removeClass('active');
	  $("#portal-menu").attr("Ref","carePlan_link");
	 }

    $("#patient_care_link").click(function() {  
      $("#observation").css('display', 'none');
	  $("#notes").css('display', 'none');
	   $("#careplan").css('display', 'none');
	  $("#patient_care").css('display', 'block');
	   $("#div_form").css('display', 'block');
	 // alert($("#page").value = "PATIENT_CARE");
	 document.getElementById('page').value = "PATIENT_CARE";
	  $("#patient_care_link").addClass('active');
	   $("#notes_link").removeClass('active');
	  $("#observation_link").removeClass('active');
	  $("#carePlan_link").removeClass('active');
	  $("#portal-menu").attr("Ref","");

	});  
});

   $("#observation_link").click(function() {  
      $("#observation").css('display', 'block');
	  $("#notes").css('display', 'none');
	  $("#patient_care").css('display', 'none');
	   $("#careplan").css('display', 'none');
	    $("#div_form").css('display', 'block');
	  //alert($("#page").value = "OBSERVATION");
	  document.getElementById('page').value = "OBSERVATION";
	  $("#observation_link").addClass('active');
	  $("#notes_link").removeClass('active');
	   $("#patient_care_link").removeClass('active');
	   $("#carePlan_link").removeClass('active');
	   	$("#portal-menu").attr("Ref","observation_link");

    });  

   $("#notes_link").click(function() {  
      $("#observation").css('display', 'none');
	  $("#notes").css('display', 'block');
	  $("#patient_care").css('display', 'none');
	   $("#careplan").css('display', 'none');
	   $("#div_form").css('display', 'block');
	  document.getElementById('page').value = "NOTES";
	  $("#notes_link").addClass('active');
	  $("#observation_link").removeClass('active');
	  $("#patient_care_link").removeClass('active');
	  $("#carePlan_link").removeClass('active');
	$("#portal-menu").attr("Ref","notes_link");
	
	  
    });  
   $("#carePlan_link").click(function() {  
   $("#careplan").css('display', 'block');
      $("#observation").css('display', 'none');
	  $("#div_form").css('display', 'none');
	  
	  $("#patient_care").css('display', 'none');
	  $("#notes").css('display', 'none');
	  document.getElementById('page').value = "CARE";
	  $("#carePlan_link").addClass('active');
	  $("#observation_link").removeClass('active');
	  $("#patient_care_link").removeClass('active');
	  $("#notes_link").removeClass('active');
	  $("#portal-menu").attr("Ref","carePlan_link");
    }); 
	$(".nav li a").click(function()
	{
	$("#portal-menu").attr("Ref","");
	});

// Post button Disable/Enable on text entry

/*$(document).ready(function(){ 
			$("#submit").attr('disabled','disabled');
			$("#submit").fadeTo(100,0.33);
 
});
*/
$("#patient_care_title").keyup(function()
{
var patient_care_length=$("#patient_care_title").val().length;
document.getElementById('page').value = "PATIENT_CARE";
if(patient_care_length != "")
{
$("#patient_care_title").focus();
$("#submit").removeAttr('disabled');
$("#submit").fadeTo(100,1);
}
});

$("#observation_title").keyup(function()
{
var observation_length=$("#observation_title").val().length;
document.getElementById('page').value = "OBSERVATION";
if(observation_length != "")
{
$("#observation_title").focus();
$("#submit").removeAttr('disabled');
$("#submit").fadeTo(100,1);
}
});


$("#notes_description").keyup(function()
{
var notes_length=$("#notes_description").val().length;
document.getElementById('page').value = "NOTES";
if(notes_length != "")
{
$("#notes_description").focus();
$("#submit,#reset,#submit").show();
$("#submit").removeAttr('disabled');
$("#submit").fadeTo(100,1);
}
});

// Limit maximum length text area

			$("#observation_title").keyup(function()
			{
			var length=$("#observation_title").val().length;
			if(length >= 800)
			{
			  hidePopup();
			  showPop();
			}
			});
$(function(){
	$('#selectedPatient').find('img').attr('src',$('#contextPatientImage').val());
	$('#selectedPatient').next().html($('#contextPatientName').val());
});

</script>
<script src='<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/patientcare/script/js/jquery.autosize.js'></script> 
<script>
				$('.normal').autosize();
				$('.animated').autosize();
				
				
function hidePopup() {
    $("#light").hide();
}

function showPop() {
    $("#menu-content").prepend("<div class='white_content' id='light'><p class='cart1'>Warning<a href='#' id='img_close'  onClick='javascript:hidePopup()'><img src='../images/close.jpg' align='right' class='close1'></a></p><div class='dashboard_box_bg_text'>Text limit exceeded...<a href='#'></a></div><div class='alert'><img src='../images/alert.jpg' align='left'  /><div id='txt'></div><a href = '#' id='okey_close'  onClick='javascript:hidePopup()'>Okay</a></div>");

}

				
</script>			
<style>
.cart1 {
	background: rgba(0, 0, 0, 0) linear-gradient(to bottom, #f7f7f7 0%, #f5f5f7 6%, #e4e3e8 32%, #e4e3e9 35%, #bab9c7 100%) repeat scroll 0 0;
	margin: 0;
	padding: 10px;
}
img.close1 {
  margin: -10px;
  height: 40px;
}
.dashboard_box_bg_text {
  padding-left: 80px;
  padding-top: 15px;
}
div#light {
  height: 185px;
}
.alert img {
  margin-top: -40px;
}
</style>
