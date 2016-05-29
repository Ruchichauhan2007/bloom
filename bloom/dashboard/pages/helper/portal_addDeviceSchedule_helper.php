<?php
$entityUtil = new EntityUtil();
$msg = "";
if (isset ( $_POST ['submitSchedule'] ))
 {
	$page_error = "Add Devices";
	try
	{
	$patDeviceDtlId = $_POST["patientDeviceDetailId"];
	$patientId = $_POST["patientId"];
	$startDate = $_POST["startDate"];

		$paramArray = array();
		$paramArray[0] = $patientId;

		// get devices by ptientId

		$devicelist = $entityUtil->postObjectToServer($paramArray, "getDevicesByPatientId", VMCPortalConstants::$API_EMR);
		foreach( $devicelist AS $device )
		{
			 if($device->{patientDeviceDetailId} == $patDeviceDtlId)
			 {
				$patientDeviceDetailInfo[0] = $device;
			 }
		}

		$patientVitalScheduleInfos = $patientDeviceDetailInfo[0]->patientVitalScheduleInfos;
		$i = 0;
			if(!empty($patientVitalScheduleInfos))
			{
				 foreach( $patientVitalScheduleInfos AS $patientVitalScheduleInfo )
				 {
					$patientVitalScheduleInfo->state = VMCPortalConstants::$DELETE;
					$i++;
				 }
			}

		// if everyday is cheched
		if( isset( $_POST["everyday"] ))
		{
			foreach($_POST["time"] AS $time)
				{
					$patientVitalScheduleInfos[$i] = new stdClass;

					//1:30-am
					$timeStr = explode("-",$time);
					$hourMin = explode(":",$timeStr[0] );
					$amPm = $timeStr[1];
					$hour = $hourMin[0];
					if($amPm == "pm")
					{
						$hour = $hour + 12;
					}

					$min = $hourMin[1];
					$patientVitalScheduleInfos[$i]->hour = $hour;
					$patientVitalScheduleInfos[$i]->minute = $min;
					$patientVitalScheduleInfos[$i]->day = "EVERYDAY";
					$patientVitalScheduleInfos[$i]->state = VMCPortalConstants::$INSERT;
					$patientVitalScheduleInfos[$i]->patientDeviceDetailId = $patDeviceDtlId;
					$i++;
				}
		}

		else if ( isset( $_POST["weekdays"] ) )
		{
			foreach( $_POST["weekdays"] AS $days )
			{
				foreach($_POST["time"] AS $time)
				{
					$patientVitalScheduleInfos[$i] = new stdClass;
					
					$timeStr = explode("-",$time);
					$hourMin = explode(":",$timeStr[0] );
					$amPm = $timeStr[1];
					$hour = $hourMin[0];
					if($amPm == "pm")
					{
						$hour = $hour + 12;
					}

					$min = $hourMin[1];
					$patientVitalScheduleInfos[$i]->hour = $hour;
					$patientVitalScheduleInfos[$i]->minute = $min;
					$patientVitalScheduleInfos[$i]->day = $days;
					$patientVitalScheduleInfos[$i]->state = VMCPortalConstants::$INSERT;
					$patientVitalScheduleInfos[$i]->patientDeviceDetailId = $patDeviceDtlId;

					$i++;
				}
			}
		}
			$paramArray = array();
			$paramArray[0] = $patDeviceDtlId;

			//$patientDeviceDetailInfo[0] = new stdClass;
			$patientDeviceDetailInfo[0]->patientDeviceDetailId = $patDeviceDtlId;
			$patientDeviceDetailInfo[0]->patientId = $patientId;
			$patientDeviceDetailInfo[0]->state = VMCPortalConstants::$UPDATE;
			$patientDeviceDetailInfo[0]->patientVitalScheduleInfos = $patientVitalScheduleInfos;
			$patientDeviceDetailInfo[0]->isActive = true;

			// set start date

			$startDate = $_POST ['startDate'];

		$pos = strpos($startDate, "/");

		if($pos === FALSE)
		{
			$dateArray = explode("-", $startDate);
		}
		else
		{
			$dateArray = explode("/", $startDate);
		}

		$startDate = $dateArray[2]."-".$dateArray[0]."-".$dateArray[1];
		$calendarDob = formatISO8601Date(strtotime($startDate));

		$patientDeviceDetailInfo[0]->startDate = $calendarDob ;

		$paramArray = array();
		$paramArray[0] = json_encode($patientDeviceDetailInfo);

		$entityUtil->postObjectToServer($paramArray, "createUpdatePatientDeviceDetail", VMCPortalConstants::$API_EMR);
		header("Location:portal_addDeviceSchedule.php?patientId=".$patientId);
	}
	catch ( Exception $e )
	{
		$msg = $e->getMessage ();
	}
}
else if (isset ( $_POST ['submitRange'] ))
{
	try
	{
		$patientId = $_POST["patientId"];
		$patDeviceDtlId = $_POST["patientDeviceDetailId"];
		$paramArray = array();
			$paramArray[0] = $patientId;

			// get devices by ptientId

		$devicelist = $entityUtil->postObjectToServer($paramArray, "getDevicesByPatientId", VMCPortalConstants::$API_EMR);
		foreach( $devicelist AS $device )
		{
			 if($device->{patientDeviceDetailId} == $patDeviceDtlId)
			 {
				$patientDeviceDetailInfo[0] = $device;
			 }
		}

		//	$patientDeviceDetailInfo[0] = $entityUtil->postObjectToServer($paramArray, "getPatientDeviceDetailByPatientDeviceDetailId", VMCPortalConstants::$API_EMR);
		//$patientDeviceDetailInfo[0]->setPatientDeviceDetailId($patDeviceDtlId);
		//$patientDeviceDetailInfo[0]->setPatientId($patientId);
		$frequencyReading = $_POST['frequencyReading'];
		if($frequencyReading =="")
		{
		$frequencyReading =0;
		}
		$patientDeviceDetailInfo[0]->state = VMCPortalConstants::$UPDATE;
		//$patientDeviceDetailInfo[0]->lowerRangeUnit1 = $_POST['range_low'];
		//$patientDeviceDetailInfo[0]->upperRangeUnit1 = $_POST['range_high'];
		if(isset($_POST['maxUnitValue2']) || isset($_POST['minUnitValue1']))
		{
			$patientDeviceDetailInfo[0]->upperRangeUnit2 = $_POST['maxUnitValue2'];
			$patientDeviceDetailInfo[0]->lowerRangeUnit1 = $_POST['minUnitValue1'];
		}
		$patientDeviceDetailInfo[0]->vendorDeviceId = $_POST['adapterId'];
		$patientDeviceDetailInfo[0]->frequencyReading = $frequencyReading;
		$paramArray = array();
		$paramArray[0] = json_encode($patientDeviceDetailInfo);
		$entityUtil->postObjectToServer($paramArray, "createUpdatePatientDeviceDetail", VMCPortalConstants::$API_EMR);
		header("Location:portal_addDeviceSchedule.php?patientId=".$patientId);
	}
	catch ( Exception $e )
	{
		$msg = $e->getMessage ();
	}
}

else if (isset ( $_POST ['flowRangeSubmit'] ))
{
	try
	{
		$patientId = $_POST["patId"];
		$patDeviceDtlId = $_POST["patDeviceDetailId"];
		$paramArray = array();
			$paramArray[0] = $patientId;
			// get devices by ptientId

		$devicelist = $entityUtil->postObjectToServer($paramArray, "getDevicesByPatientId", VMCPortalConstants::$API_EMR);
		foreach( $devicelist AS $device )
		{
			 if($device->{patientDeviceDetailId} == $patDeviceDtlId)
			 {
				$patientDeviceDetailInfo[0] = $device;
			 }
		}

		$flowUnit = $_POST['flowUnit'];
		$flowUnit2 = $flowUnit / 2;
		$flowUpperUnit = round($flowUnit2,0);
		$patientDeviceDetailInfo[0]->state = VMCPortalConstants::$UPDATE;
		$patientDeviceDetailInfo[0]->upperRangeUnit1 = $flowUnit;
		$patientDeviceDetailInfo[0]->lowerRangeUnit1 = $flowUpperUnit;
		
		$paramArray = array();
		$paramArray[0] = json_encode($patientDeviceDetailInfo);
		//var_dump($paramArray[0]);
		$update = $entityUtil->postObjectToServer($paramArray, "createUpdatePatientDeviceDetail", VMCPortalConstants::$API_EMR);
		//var_dump($update);
		header("Location:portal_addDeviceSchedule.php?patientId=".$patientId);
	}
	catch ( Exception $e )
	{
		$msg = $e->getMessage ();
	}
}
?>
