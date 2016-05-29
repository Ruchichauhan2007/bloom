<?php
if(isset($_GET['selectedPatientTrue']))
{
	$selectedPatientTrue = $_GET['selectedPatientTrue'];
}
include 'controller/base_controller.php';
include('helper/portal_dashboard_helper.php');
include('../../common/util/CardFactory.php');
include('../../common/classes/EntityUtil.php');

$entityUtil = new EntityUtil();

$id = $_POST['id'];
 $data = explode("_",$id);
	   $ackInfo[0] = new stdClass;
	   $ackInfo[0]->dashboardDetailId = $data[0];
	   $ackInfo[0]->reviewNotes = $data[1];
	   $ackInfo[0]->viewed = true;
	   $paramArray = array() ;
	   $paramArray[0] = json_encode($ackInfo); 
	  // var_dump($paramArray);
	  $dashboardPatientCardInfo =$entityUtil->getObjectFromServer($paramArray,"acknowledgeDashboardNotification", VMCPortalConstants::$API_ADMIN);
	    if($dashboardPatientCardInfo )
	   {
			return TRUE;
	   }
	   else
	   {
			return TRUE;
	   }
//$entityUtil->acknowledgeDashboard($dashboardId);
//echo "acknowledgeDashboard_".$selectedPatientTrue;
?>
