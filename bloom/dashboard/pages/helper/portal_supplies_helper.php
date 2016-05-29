<?php
$credential = new stdClass;
$emr = new stdClass;
$admin = new stdClass;
$patientsupplyInfo = new stdClass;
$fetched = false;
	try
	{
		$entityUtil = new EntityUtil();
		$msg = "";		
		if($_COOKIE['type'] == 'Provider')
		{
			if(!is_null($_REQUEST['contextPId']))
			{
				$patientId = $_REQUEST['contextPId']; 

			}
			else{
			$patientId=$_REQUEST['contextPId'];
			}
		}
		else if($_COOKIE['type'] == 'Patient' || $_COOKIE['type'] == 'PATIENT')
		{
			$patientId = $entityUtil->getLoggedInEntityId();
		}
		$paramArray = array();
		$paramArray[0] = $patientId;
		$patientSuppliesListPatientDetails = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
		
		$paramArray = array();
		$paramArray[0] = $patientId;
		$data= $entityUtil->getObjectFromServer($paramArray, "getPatientSupplies", VMCPortalConstants::$API_EMR);
		
		$paramArray = array();
		$paramArray[0] = VMCPortalConstants::$PHP_EMPTY;
		$patientSuppliesList= $entityUtil->getObjectFromServer("BLANK", "getSupplyList", VMCPortalConstants::$API_EMR);
		
//Update Card

		
		$fetched = true;
		$command = $_REQUEST['command'];
		if($command != null)
		{
			
			$patientSupplyId = $_REQUEST['patientSupplyId'];
			if(isset($patientSupplyId))
			{
			foreach($data as $PatientSupply)
				{

				if($PatientSupply->patientSupplyId == $patientSupplyId)
					{
					
						$PatientSupply->remainingQuantity = $_REQUEST["remainingQuantity"];
						$PatientSupply->state = VMCPortalConstants::$UPDATE;
						$paramArray =array();						
						$paramArray[0] = json_encode($PatientSupply);
						$retPatientSuppliesInfo = $entityUtil->postObjectToServer($paramArray, "createUpdatePatientSupply", VMCPortalConstants::$API_EMR);
	
						
					}
				}

			}
			
		}
		
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
  	}

?>