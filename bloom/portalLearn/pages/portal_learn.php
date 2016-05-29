<?php 
include('controller/portal_learn_controller.php');?>
<link rel="stylesheet" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/portalLearn/script/css/portal_learn.css" />
<!-- Set the viewport width to device width for mobile -->
<?php
	$contextPId = $_REQUEST['contextPId'];
?>
  <!--start wapper -->
  <input type="hidden" id="userType" value="<?php echo $_COOKIE['type']; ?>" />
 <div class="col-md-8 padd-top20"> 
  <div class="portal_learn_rightpart card" style="overflow: hidden;">
    <!--<div class="learn_patient_content" id="patientinfor">
      <div class="learn_patient_content_align">
        <div id="selectedPatient" class="learn_patient_contentimg" style="margin-left:0">
        <a href="#">
          <img  style="height:42px; border-radius:50%; width:42px; margin-right:10px; border:solid 2px #fff;" src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/portalLearn/images/learn_patient_img.jpg" alt="">
        </a>
        </div>
		    <h1>Smith , Joe</h1>
      </div>
    </div>-->
    <div class="scrollbar1 scroll-outer">
        <div class="content scroll-inner">
	  
        <div class="learn_content_bg" id="addContent">
          <div class=" learn_box">
            <!--<div class="col-md-2 learn_box_img"><a href="#" onclick="openPageWithAjax('../../portalLearn/pages/portal_learn_assign.php','contextPId=<?php echo $contextPId ?>','menu-content')"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/portalLearn/images/learn_patient_plus_img.jpg" alt=""></a></div>-->
            <div class="learn_box_content" id="click_btn">
			  <input type="hidden" id="patien_id" value="<?php echo $contextPId;?>" name="contextPId">
              <h2><a href="#" onclick="openPageWithAjax('../../portalLearn/pages/portal_learn_assign.php','contextPId=<?php echo $contextPId ?>','menu-content')"><?PHP echo  constantAppResource::$LEARN_TEXT_CLICKADD_CONTENT; ?></a></h2>
            </div>
          </div>
        </div>
		<div id="PatientList_part_bg">
		
<!-- <div id="delete16" class="learn_content_bg">
		<div class="col-md-2 learn_box_img"><a href="<?PHP echo  constantAppResource::$LEARN_WEBINAR_LINK; ?>"  target="_blank"><img alt="" src="/gladstone/portal/bloom/login/images/ProvCard_ViewedPDF_v5.png"></a></div>
		<div class="col-md-7 learn_box_content">
			<h2 style="margin-left:-17px;"><?PHP echo  constantAppResource::$LEARN_TEXT_UPCOMINGWEBINAR; ?></h2>
		</div>
		<div class="col-md-3 learn_box_content_button"></div>
</div> -->		
		
		
			<?php echo addLearnCards($learnList); ?>
        </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  
   <!-- Confirm Delete patient Modal ---> 
<div class="modal" id="patientDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="mainDiv">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/images/close_but.jpg" alt=""></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Learn</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to delete it.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="close" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" delete-content="0" id="content-delete-button">Delete</button>
      </div>
    </div>
  </div>
</div>
</div>
<!--start footer -->
<style>

#close{
background-color: #04AEFC;
border-radius: 5px;
border-bottom: solid 5px #0492D4;
color: #FFF;
font-size:16pt;
}
#content-delete-button
{
    background-color: #1ADB82;
    color: #FFF;
    border-radius: 5px;
    border-width: medium medium 5px;
    border-style: none none solid;
    border-color: -moz-use-text-color -moz-use-text-color #18AB67;
    text-align: center;
	font-size:16pt;
	border-bottom: solid 5px #18ab67;

}

</style>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>

<script>

$(document).ready(function()
{
$("span.learnTime" ).each(function( index ) {
	var utcTime=$( this ).text();
    var divLocal = $('#divLocal');  
    //put UTC time into divUTC  
    $(this).text(moment.utc().format('YYYY-MM-DD HH:mm:ss'));      
    //get text from divUTC and conver to local timezone  
    var localTime  = moment.utc(utcTime).toDate();
    localTime = moment(localTime).format('MMM DD hh:mm A');
    $(this).text(localTime);    
});
});



</script>

<script>
  	window.location.hash = '/learn';
$(function(){
	$('#selectedPatient').find('img').attr('src',$('#contextPatientImage').val());
	$('#selectedPatient').next().html($('#contextPatientName').val());
	
$(".delete").click(function()
{
		var contentId=$(this).attr('id');
		var contentRef=$(this).attr('name');
		$("#content-delete-button").attr('delete-content',contentId);
		$("#content-delete-button").attr('ref',contentRef);
		$('#patientDeleteModal').modal();

});	

$("#content-delete-button").click(function(e)
{		var content_Id=$("#content-delete-button").attr('delete-content');
		var contentRef=$("#content-delete-button").attr('ref');
		$('#delete'+content_Id).hide();
		var patientId=$("#patien_id").val();
		openWithAjaxAndClosePopup('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/portalLearn/pages/portal_learn.php','delete=true&patient_id='+patientId+'&contentId='+content_Id+'&contentRef='+contentRef,'ack-dashboard',e);
});
	
});

function contentOpen(contentId)
{
	var contentHref=$("#"+contentId).attr('class');
	window.open('show_content.php?contentId='+contentHref,'video','top=150, left=352, width=700, height=500, toolbar=no, menubar=no, location=no, scrollbars=no, resizable=no');
	return false;
}

$(function(){
var patientType=$("#userType").val();
	if(patientType.toUpperCase() =="PATIENT")
	{
	$("#patientinfor,#submit,#reset,#addContent,#submit").hide();
	$(".delete").hide();
	$("#userType").before("<br />");
	$(".learn_content_bg div a").css({"padding":"0px;"});
	}
});

	



</script>