<?php 
include('controller/assignSurvey_controller.php');
//var_dump($surveyResp);?>
<link rel="stylesheet" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/portalLearn/script/css/portal_learn.css">
<div class="col-md-8 padd-top20"> 
 <div class="portal_learn_rightpart card">
    <div class="learn_patient_content">
      <div class="learn_patient_content_align">
		<h1 align="center">Select survey to assign<span id="patientName"></span></h1>
      </div>
    </div>
  <div class="scrollbar1 scroll-outer">
        <div class="content scroll-inner" style="height:83%;">
    <div id="PatientList_part_bg">
				<?php 
						echo  assignSurveyCards($surveyResp,$surveyList);
				 ?>
      </div>
      <div class="button-content">
		<form id="assign-form"
  onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/survey/pages/assignSurvey.php','assign-form','menu-content',event)">
			<input type="reset" value="Cancel" id="cancel"/>
			<input type="hidden" name="saveAssign" value="true" />
			<input type="hidden" name="contextPId" value="<?php echo $_REQUEST['contextPId'];?>" />
			<input type="submit" id="assign" class="submit" value="Assign" />
		</form>
	</div>
    </div>
	</div>
	</div>
</div>	
   <div class="col-md-4 padd-top50">
			<div class="sidebar-filter">
				<div class="card">
					<div class="filter-tabs">
						<div class="padd-15">
							<button class="btn btn-neutral">All</button>
							<button class="btn btn-default active">Pre Meal</button>
							<button class="btn btn-neutral">Post Meal</button>
						</div>
						<div class="divider"></div>
						<div class="padd-15">
							<button class="btn btn-default active">7 Days</button>
							<button class="btn btn-neutral">14 Days</button>
							<button class="btn btn-neutral">30 Days</button>
						</div>
				</div>
			</div>
</div>
<script>
$(document).ready(function(){ 
			window.location.hash = '/Survey';
			$("#assign").attr('disabled','disabled');
			$("#assign").fadeTo(100,0.33);
});
$(function() {
$('#cancel').click(function(e){
openPageWithAjax('../../survey/pages/showSurvey.php?contextPId=<?php echo $_REQUEST['contextPId'];?>','','menu-content',e);
});
});
$(function(){
	$('#patientName').html($('#contextPatientName').val());
	// hide delete
	$('.learn_box_content_button').find('a').hide();
	$('.learn_box_content_button').find('span').css({'margin-top':'65px','display':'inline-block'});
	$('.learn_content_bg').click(function(){
		$(this).toggleClass('selectedCard');
		var valueOfcart=$(this).find('img').attr('id');
		var  enableButton = false;
		$('.learn_content_bg').each(function(){
			if($(this).hasClass('selectedCard'))
			{
				enableButton = true;
				
			}
		});
		
		if(enableButton)
		{
			$("#assign").removeAttr('disabled').fadeTo(100,1);
		}
		else{
		
			$("#assign").attr('disabled','disabled').fadeTo(100,0.33);;
		}
		if($(this).hasClass('selectedCard'))
		{
		var currentSrc=$(this).find('img').attr('src');
		var customSrc=$(this).find('img').attr('alt');
		$(this).find('img').attr('src',customSrc);
		$(this).find('img').attr('alt',currentSrc);
		if($(this).find('img').attr('data') != "")
		{
			var lastDate = $(this).find('img').attr('date');
			  
			var localTime  = moment.utc(lastDate).toDate();
			localTime = moment(localTime).format('ll');
				
			$("#surveyModalPopup").modal("show");
			$("#modalText").text("The last Annual Wellness Visit was completed "+localTime+". For your convenience, the answers are carried over and you can update them as needed.");
			$("#surveyModalPopup").find('button').attr('data',valueOfcart);
		}	
		var hiddenField = $("<input type='hidden' name='surveyCard[]' value='"+valueOfcart+"'/>"); 
		$("#assign-form").append(hiddenField);
		}
		else
		{
		$('input[value='+valueOfcart+']').remove();
		var currentSrc=$(this).find('img').attr('src');
		var customSrc=$(this).find('img').attr('alt');
		$(this).find('img').attr('src',customSrc);
		$(this).find('img').attr('alt',currentSrc);	
		$('input[data='+valueOfcart+']').remove();
		}

	})
});
$("#SurveyYes,#SurveyNo").click(function()
{
	var valueOfcart  = $(this).attr('data');
	var surveyText  = $(this).text();
	if(surveyText == "Yes")
	{
		var survey = true;
	}
	else if(surveyText == "No")
	{
		var survey = false;
	}
	$('input[data='+valueOfcart+']').remove();
	var hiddenField = $("<input type='hidden' name='surveyStatus[]' data='"+valueOfcart+"'  value='"+valueOfcart+"_"+survey+"'/>"); 
	$("#assign-form").append(hiddenField);

	

	
});
</script>
<style>
.learn_patient_content_align{width:80%;}
</style>


<!-- Modal -->
  <div class="modal fade" id="surveyModalPopup" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="height:280px !important;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><img src="../images/close.jpg" align="right" class="close"></button>
          <h4 class="modal-title">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p id="modalText"></p>
        </div>
        <div class="modal-footer">
        				<button type="button" class="btn btn-default btnpatlist" id="surveyNo" data-dismiss="modal">No</button>
				<button type="button" class="btn btn-primary btnpatlist1" delete-id="12" id="SurveyYes"  data-dismiss="modal">Yes</button>
        </div>
      </div>
      
    </div>
  </div>