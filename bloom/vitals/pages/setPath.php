<?php
  include '../../common/util/VMCPortalConstants.php';
  include '../../common/util/APIUtil.php';
  include '../../common/classes/EntityUtil.php';
	$data = "";
	$deviceId = "";
	$glucoseId = "";
	$pageName = "";
	$onClick = "";
	$entityUtil = new EntityUtil();
	if($_COOKIE['type'] == 'Provider' or $_COOKIE['type'] == 'provider' or $_COOKIE['type'] == 'PROVIDER')
		{
			if(!is_null($_REQUEST['contextPId']))
			{
				$patientId = $_REQUEST['contextPId']; 
			}
		}
		else if($_COOKIE['type'] == 'Patient' or $_COOKIE['type'] == 'PATIENT' or $_COOKIE['type'] == 'patient')
		{
			$patientId = $entityUtil->getLoggedInEntityId();
			
		}
	$checkDevice = false;
	
	$paramArray = array();
	$paramArray[0] = $patientId;
	$devicelist = $entityUtil->getObjectFromServer($paramArray, "getDevicesByPatientId", VMCPortalConstants::$API_EMR);
	$assignedDevices = $devicelist; 
	$count = count($assignedDevices);
	$deviceConfigId = "";
	$paramArray = array();
	$allDevices = $entityUtil->postObjectToServer($paramArray, "getDeviceList", VMCPortalConstants::$API_EMR);
	foreach($allDevices as $eachDevice)
	{	
		$device = $eachDevice->{deviceConfigId};
		
		foreach($assignedDevices as $devicedata)
		{
			if($device == $devicedata->{fkdeviceConfigId})
			{
				$checkDevice = true;
				$measurementName1 = $devicedata->{measurementName1};
				$deviceName = strtoupper($measurementName1);
				if($deviceName == VMCPortalConstants::$GLUCOSE)
				{
					$deviceId = $eachDevice->{deviceConfigId};
					$glucoseId = $deviceId;
					$pageName = "Blood-Glucose";
					$onClick = 'openPageWithAjax("../../vitals/pages/vitals_graphBG.php","deviceConfigId='.$deviceId.'&vitalType='.$pageName.'&contextPId='.$patientId.'","menu-content","",this)';
				}
				else if($deviceName == VMCPortalConstants::$DIASTOLIC)
				{
					$deviceId = $eachDevice->{deviceConfigId};
					$pageName = "Blood-Pressure";
					$onClick = 'openPageWithAjax("../../vitals/pages/vitals_graphBP.php","deviceConfigId='.$deviceId.'&vitalType='.$pageName.'&contextPId='.$patientId.'","menu-content","",this)';

				}
				else if($deviceName == VMCPortalConstants::$WEIGHT)
				{
					$deviceId = $eachDevice->{deviceConfigId};
					$pageName = "Body-Weight";
					$onClick = 'openPageWithAjax("../../vitals/pages/vitals_graphBP.php","deviceConfigId='.$deviceId.'&vitalType='.$pageName.'&contextPId='.$patientId.'","menu-content","",this)';
				}
				else if($deviceName == VMCPortalConstants::$PULSE)
				{
					 $deviceId = $eachDevice->{deviceConfigId};
					 $pageName = "Blood-Oxygen";
					 $onClick = 'openPageWithAjax("../../vitals/pages/vitals_graphBP.php","deviceConfigId='.$deviceId.'&vitalType='.$pageName.'&contextPId='.$patientId.'","menu-content","",this)';
				}
				
				else if($deviceName == VMCPortalConstants::$PEAKFLOW)
				{
					$deviceId = $eachDevice->{deviceConfigId};
					$pageName = "Peak-Flow";
					$onClick = 'openPageWithAjax("../../vitals/pages/vitals_graphPF.php","deviceConfigId='.$deviceId.'&vitalType='.$pageName.'&contextPId='.$patientId.'","menu-content","",this)';
				}
				
				
				
			}
		}
		if($checkDevice){break;}
		
	}
	?>
	<script>
	$(document).ready(function(){
	<?php if($onClick){ echo $onClick.";"}; ?>
setTimeout(function(){
	 $('.wrapper2').css('opacity', 0.2);
     $('.ajax-loading').show(); }, 10);	
	 
setTimeout(function(){
	 $('.wrapper2').css('opacity', 1);
     $('.ajax-loading').hide(); }, 5000);	
	})
	
	
	</script>
