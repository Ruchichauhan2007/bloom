<?php 
$dateUtil = new DateUtil();
$reviewtime = "";
if(isset($_POST['submit']))
	{
	if(!empty($_POST['reviewtime']))
		{
			$reviewtime = $dateUtil->formatDatetoPatientcareObservation($_POST['reviewtime'])."--";
		}
	else
		{
			$reviewtime = "";
		}
	
	$dashboardCardUtil = new DashboardCardUtil();
	$dashboardId = $_POST['reviewedID']."_".trim($_POST['observation_title'])." ". $_POST['oldReview'];
	$entityUtil = new EntityUtil();

	//$id = $_POST['id'];
 	$data = explode("_",$dashboardId);
	   $ackInfo[0] = new stdClass;
	   $ackInfo[0]->dashboardDetailId = $data[0];
	   $ackInfo[0]->reviewNotes = $data[1];
	   $ackInfo[0]->viewed = true;
	   $paramArray = array() ;
	   $paramArray[0] = json_encode($ackInfo); 
	  // var_dump($paramArray);
	  $dashboardPatientCardInfo =$entityUtil->getObjectFromServer($paramArray,"acknowledgeDashboardNotification", VMCPortalConstants::$API_ADMIN);
	  
	//$dashboardCardUtil->acknowledgeDashboard($dashboardId);
	?>
	<script>
  	location.reload();
    </script>
	<?php
	
	}
?>
				