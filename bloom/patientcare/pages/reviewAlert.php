<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/patientcare/script/css/patientcare.css" rel="stylesheet" type="text/css">
<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/script/css/common-css.css" rel="stylesheet" type="text/css">
<?php
	include ('controller/review_alert_controller.php');
	include('../../common/util/CardFactory.php');
	$reviewNotes = "";
	$entityUtil = new EntityUtil();
	$dateUtil = new DateUtil();
	$patientUtil = new PatientUtil();
	$patientId = $_REQUEST['patientId'];
   	if($_COOKIE['type']=="Provider")
	{
    $entityId = $entityUtil->getLoggedInEntityId();
	$paramArray = array() ;
	$paramArray[0] = $entityId;
	$providerInfo=$entityUtil->getObjectFromServer($paramArray, "findProviderById", VMCPortalConstants::$API_EMR);
	
	$paramArray = array();
	$paramArray[0] = "Provider";
	$paramArray[1] = 0;
	$paramArray[2] = $_REQUEST['patientId'];
	$paramArray[3] = "All Patients";
	$dashboardCards = $entityUtil->getObjectFromServer($paramArray, "getAllDashboardCardsByCategory", VMCPortalConstants::$API_ADMIN);
	//var_dump($dashboardCards);
	foreach($dashboardCards as $dashCard)
	{
	
		if($dashCard->{cardType} == "VITALS_OUT_OF_RANGE" && $dashCard->{alertNotification} == true  ||  $dashCard->{cardType} == "STICKY_NOTE" && $dashCard->{alertNotification} == true)
		{
			if($dashCard->{dashboardDetailId} == $_REQUEST['reviewId'])
				{
					
					$reviewNotes = $dashCard->{reviewNotes};
					$reviewtime =  $dashCard->{viewedTime};
					$providerDetail =  $dashCard->{contentData};
					$providerName = $providerDetail->{providerLastName}." ".$providerDetail->{providerFirstName}." ".$providerDetail->{credentials};
					//$reviewtime = $dateUtil->formatDatetoStr($dashCard->{viewedTime});
					
				}
			
		}
	}
}
		
?>
<div id="div_form">
      <form action="" method="post" id="reviewAlert" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/patientcare/pages/reviewAlert.php','reviewAlert','menu-content',event)">
        
        <div class="patient_care_form" id="observation">
          <div class="patient_form_area">

          <div class="textareaBloom">
<?php /*?>          <h5 class="top-text" id="providerInfor" style="padding: 5px 0px 5px 28px;"><?php echo  $providerInfo->{lastName}.", ".$providerInfo->{firstName}." ".$providerInfo->{credentials}; ?> </h5><?php */?>
          <textarea cols="82" placeholder="Write Review" name="observation_title" id="observation_title" maxlength="800" style="height:55px;margin-left:28px;padding-left: 11px;width:91.75%;"></textarea>
          </div>
          </div>
          <div class="patientcare_messagebg" style="height:275px; overflow:auto;">
          <div class="patientcare_messagebg_text">
          <?php
		  if($reviewtime == "")
		  {
		   ?>
           <h5 style="float:right;" ></h5>
           <?php
		   }
		   else
		   {
		   ?>
          <h4 class="col-md-8"><?php  echo $providerName; ?></h4>
          <h5 style="text-align:right;" class="col-md-4 time_date"><?php  echo $reviewtime ; ?></h5>
          <?php
		  }
		  ?>
          <p><?php  echo $reviewNotes; ?></p>
          
            </div>
          </div>
        </div>
        
        <div style="clear:both;"></div>
        <div class="patientcare_button" style="padding-right:26px;">
          <input type="Reset" value="Cancel" onclick="location.reload();" id="resetAlert">
          <input type="Reset" value="Cancel" id="resetAlert1" style="display:none;">
          <input type="submit" value="Review" name="submit" id="submit">
          <input type="hidden" name="page" id="page"  value="OBSERVATION" />
          <input type="hidden" name="patientId" id="patientId"  value="<?php echo $_REQUEST['patientId'];?>" />
          <input type="hidden" name="contextPId" id="contextPId"  value="<?php echo $_REQUEST['patientId'];?>" />
          <input type="hidden" name="reviewedID" id="reviewedID"  value="<?php echo $_REQUEST['reviewId'];?>" />
          <input type="hidden" name="oldReview" id="oldReview"  value="<?php echo $reviewNotes ;?>" />
          <input type="hidden" name="reviewtime" id="reviewtime"  value="<?php echo $reviewtime ;?>" />
          <input type="hidden" value="submit" name="submit" >
        </div>
      </form>
    </div>
<script>

 $(document).ready(function() { 
	$("h5.time_date").each(function( index, element) {
	var time = moment($(element).html());
	//time.subtract(time.zone(), 'minutes');
	var localTime  = moment.utc($(element).text()).toDate();
    localTime = moment(localTime).format('MMM D, YYYY h:mm A');
	$(element).html(localTime);
});
$("#resetAlert1").click(function()
{
$("#resetAlert").show();
$("#resetAlert1").hide();
});


$("#observation_title").keyup(function()
{
var textLength = $(this).val().length;
if(textLength == 0)
{
$("#resetAlert").show();
$("#resetAlert1").hide();
}
else
{
$("#resetAlert").hide();
$("#resetAlert1").show();

}


});




$("#submit").click(function()
{
var obValue=$("#observation_title").val();
if(obValue.trim() == "")
{
	$(".cart_page").html("Review");
   	$(".txt_div").html("Please provide review.");
	$("#aboutPopup").show();
	$("#About_fadediv").show();
	return false;
}

});

});
</script>
<?php /*?><script src='<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/patientcare/script/js/jquery.autosize.js'></script> <?php */?>
<?php /*?><script>
				$('.normal').autosize();
				$('.animated').autosize();
</script><?php */?>