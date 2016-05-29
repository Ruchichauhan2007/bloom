<?php


	try
	{
		$entityUtil = new EntityUtil();
		$msg = "";
		$paramArray = array();
		
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
		
		$paramArray[0] = $patientId;
		$surveyList = $entityUtil->getObjectFromServer($paramArray, "getPatientSurveys", VMCPortalConstants::$API_ADMIN);
		//var_dump($surveyList);
	}
	catch(Exception $e)
	{
		$showMsg = $e->getMessage();
  	}
	
	
	

?>