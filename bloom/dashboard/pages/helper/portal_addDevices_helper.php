<?php
$msg = "";
echo $msg;
if (isset ( $_REQUEST['submit'] ))
 {
	$page_error = "Add Devices";
	try
	{
		$entityUtil = new EntityUtil();
		$patientId = $_REQUEST["patientId"];
		$paramArray = array();
		$paramArray[0] = $patientId;
		$assignedDevices = $entityUtil->postObjectToServer($paramArray, "getDevicesByPatientId", VMCPortalConstants::$API_EMR);
		$i = 0;
		$patDeviceDtlInfo =  array() ;

		if ( isset( $_REQUEST["deviceId"] ) )
		{
			
			// Enable once we have multiple devices to configure
			foreach($assignedDevices as $adevice)// 12
			{
				$found = false;
				foreach( $_REQUEST["deviceId"] AS $deviceId ) // 234
				{
					if($adevice->deviceConfigId == $deviceId)
					{
						$found = true;
						break;
					}
				}

				if($found)
				{
					$adevice->state = VMCPortalConstants::$NO_UPDATE;
				}
				else
				{
					$adevice->state = VMCPortalConstants::$DELETE;

				}
				
				$patDeviceDtlInfo[$i] = $adevice;
				$i++;
			}

			foreach( $_REQUEST["deviceId"] AS $deviceId ) // 234
			{
				$insert = false;
				foreach($assignedDevices as $adevice)// 12
				{
					if($adevice->fkdeviceConfigId == $deviceId)
					{
						$insert = true;
						break;
					}
				}

				if(!$insert)
				{
					$patDeviceDtlInfo[$i] = new stdClass();
					$patDeviceDtlInfo[$i]->fkdeviceConfigId = $deviceId;
					$patDeviceDtlInfo[$i]->patientId = $patientId;
					$patDeviceDtlInfo[$i]->state = VMCPortalConstants::$INSERT;
					$i++;
				}
			}

		}
		// if all devices are removed
		else{

			foreach($assignedDevices as $adevice)// 12
			{
				$adevice->state = VMCPortalConstants::$DELETE;
				$patDeviceDtlInfo[$i] = $adevice;
				$i++;
			}
		}

		$jsonString = json_encode($patDeviceDtlInfo) ;

		$args = array() ;
		$args[0] = $jsonString ;

		$retPatDeviceDtlList = $entityUtil->postObjectToServer($args, "createUpdatePatientDeviceDetail", VMCPortalConstants::$API_EMR);

		if(!is_null($retPatDeviceDtlList) )
		{
			header("Location:portal_addDeviceSchedule.php?patientId=".$patientId."&patientDeviceDetailId=".$retPatDeviceDtlList[0]->{patientDeviceDetailId}."&type=EDIT");
		}
		else
		{
			throw new Exception("Error occurred. Please contact to system administrator.");
		}
	}
	catch ( Exception $e )
	{
		$msg = $e->getMessage ();
	}
}
?>