<?php 
include('controller/portal_learn_controller.php');?>
<link rel="stylesheet" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/portalLearn/script/css/portal_learn.css"> 
<div class="col-md-8 padd-top20">
 <div class="portal_learn_rightpart card" style="overflow: hidden;">
    <div class="learn_patient_content">
      <div class="learn_patient_content_align">
		<h1 align="center">Select media to assign to <span id="patientNamess"></span></h1>
      </div>
    </div>
  <div class="scrollbar1 scroll-outer">
        <div class="content scroll-inner">
    <div id="PatientList_part_bg">
				<?php echo assignLearnCards($contentResp); ?>
      </div>
      <div class="button-content">
		<form id="assign-form"
  onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/portalLearn/pages/portal_learn_assign.php','assign-form','menu-content',event)">
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
    
<script>
$(document).ready(function(){ 
$('#patientNamess').html($('#contextPatientName').val());
			window.location.hash = '/learn';
			$("#assign").attr('disabled','disabled');
			$("#assign").fadeTo(100,0.33);
});
$(function() {
$('#cancel').click(function(e){
openPageWithAjax('../../portalLearn/pages/portal_learn.php?contextPId=<?php echo $_REQUEST['contextPId'];?>','','menu-content',e);
});
});
$(function(){
	//$('#patientName').html($('#contextPatientName').val());
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
		var hiddenField = $("<input type='hidden' name='learnCard[]' value='"+valueOfcart+"'/>"); 
		$("#assign-form").append(hiddenField);
		}
		else
		{
		$('input[value='+valueOfcart+']').remove();
		var currentSrc=$(this).find('img').attr('src');
		var customSrc=$(this).find('img').attr('alt');
		$(this).find('img').attr('src',customSrc);
		$(this).find('img').attr('alt',currentSrc);	
		}

	})
});

</script>
<style>
.learn_patient_content_align{width:80%;}
</style>