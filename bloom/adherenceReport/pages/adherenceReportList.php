<?php
$extractType = $_REQUEST["extractType"];
$adherenceExtractContentId = $_REQUEST["adherenceExtractContentId"];
include('controller/adherenceReportList_controller.php');
?>
<link rel="stylesheet" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/adherenceReport/script/css/dashboard.css">

<style>
.activePage
{
font-weight:bold;
}
</style>
<script>
$(document).ready(function() { 

window.location.hash = '/adherenceReport';
	$("span.dates").each(function( index, element) {
	var time = moment($(element).html());
	//time.subtract(time.zone(), 'minutes');
	var localTime  = moment.utc($(element).text()).toDate();
    localTime = moment(localTime).format('MMM DD, YYYY');
	$(element).html(localTime);
});
});

$('.extractType li').each(function(i)
{
   var thisValue = $(this).attr('value');
   var getExtractType = '<?php echo $extractType; ?>'; 
   if(thisValue == getExtractType)
   {
   		$(this).addClass('active')
   }
});
</script>
<div class="col-md-8 padd-top20">
    <div class="dashboard_patient_rightpart" >
      <div class="dashboard_patient_rightpart_bg">
        <div class="learn_patient_content_align">

	     <span class=" custom-dropdown custom-dropdown--white" ></span>
        </div>
      </div>

<div class="compare_models mCustomScrollbar _mCS_1">
     <div class="mCustomScrollBox mCS-light-thin mCS-mouse-over" id="mCSB_1" style="position:relative; height:100%; max-width:100%;">
            <?php  echo getAdherenceReport($aReportList); ?>
       
      </div>
	  </div>
    </div>


  <div class="clear"></div>
</div>
<div class="col-md-4 padd-top50">
    <div class="sidebar-filter">
    <div class="card">
	 <div class="filter-tabs">
      <div class="card-content" id="cardTypeList">
        <ul class="nav nav-list extractType"> 
          <li onclick="openPageWithAjax('../../adherenceReport/pages/adherenceReportList.php','extractType=WEEKLY','menu-content',event,this)" value="WEEKLY"><a href="#">Weekly</a></li>
          <li  onclick="openPageWithAjax('../../adherenceReport/pages/adherenceReportList.php','extractType=MONTHLY','menu-content',event,this)"  value="MONTHLY" ><a href="#">Monthly</a></li>
          <li onclick="openPageWithAjax('../../adherenceReport/pages/adherenceReportList.php','extractType=QUERTERLY','menu-content',event,this)" value="QUERTERLY"><a href="#">Quarterly</a></li>
          </ul>
     </div>
     </div>
     </div>
    </div>
</div>
 