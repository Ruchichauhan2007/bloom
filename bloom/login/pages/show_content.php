<style>
header .container {
    float: left;
    width: 100%;
}
footer .container .footerlink_right a {
    bottom: 0;
    float: left;
    position: absolute !important;
    width: 100%;
    z-index: 9999;
}
</style>
<?php
include('../../common/pages/header.php');
include 'controller/portal_dashboard_controller.php';
include '../../common/classes/EntityUtil.php';
include '../../common/util/APIUtil.php';
include 'popup/error_popup.php';

	$content = false;
	if(isset($_REQUEST['contentId']))
	{
		$content = true;
		$contentId=$_REQUEST['contentId']; 
		$methodName = "getContentUrl";
	}
	elseif(isset($_REQUEST['reportContentId']))
	{
		$contentId = $_REQUEST['reportContentId']; 
		$methodName = "getReportContentUrl";
	}
	elseif(isset($_REQUEST['rxDetail']))
	{
		$contentId = $_REQUEST['rxDetail']; 
		$methodName = "getRxDetailUrl";

	
	}
	
	
	try
	{
		$msg ="";
		// Populate Patient List for file upload	
		$entityUtil = new EntityUtil();
		$paramArray = array();
		$paramArray[0] = $contentId;
				
		$contentUrl = $entityUtil->getObjectFromServer($paramArray, $methodName, VMCPortalConstants::$API_EMR);
	}	
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
	?>
 <center>
<div id="target" style="padding:10px;">
<div class="container" >
<?php
 $pdf=strpos($contentUrl,".pdf");
 if($pdf===false AND $content)
 {
 
 ?>
 <video autoplay="autoplay" controls="controls" autoplay="false" width="100%" height="80%" >
   <source src="<?php echo $contentUrl; ?>" type="video/mp4">
   <source src="<?php  echo $contentUrl;  ?>" type="video/hd">
   <source src="<?php  echo $contentUrl; ?>" type="video/mov">
</video>

 <?php
 }
 else
 {
 ?>
<object  data="<?php echo $contentUrl; ?>" width="100%" height="100%"></object >
 <?php
 }?>
 </div>
  </div>
 </center><?php
 include '../../common/pages/dashboard_footer.php'; ?>

