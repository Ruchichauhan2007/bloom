<?php
		
			$entityUtil = new EntityUtil();
			$msg = "";
			$paramArray = array();
			
			$userType = strtoupper($_COOKIE['type']);
			if($userType == "PATIENT")
			{
			$patientId = $_COOKIE['id'];
			}
			
			$paramArray[0] = $patientId;
			
			$survey = $entityUtil->getObjectFromServer($paramArray, "getPatientSurveys", VMCPortalConstants::$API_ADMIN);
			
?>