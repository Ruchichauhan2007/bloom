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
		$learnList = $entityUtil->getObjectFromServer($paramArray, "getEducationalContentsForPatient", VMCPortalConstants::$API_EMR);
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
  	}
	
	try
	{
		$msg ="";
		// Populate Patient List for file upload
		if(!is_null($_REQUEST['contextPId']))
		{
			$patientId = $_REQUEST['contextPId']; 
		}
	
		$paramArray[0] = $patientId;
		$contentResp = $entityUtil->getObjectFromServer($paramArray, "getContentList", VMCPortalConstants::$API_EMR);
	}	
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}

	if($_REQUEST["delete"])
	{
		$paramArray = array();
		$educationContentId = $_REQUEST["contentId"];
		$patient_id=$_REQUEST['patient_id'];
		$contentRef=$_REQUEST['contentRef'];
			
		try
		{
			if($educationContentId > 0)
			{
				$loggedInUserId = $entityUtil->getLoggedInEntityId();
				
				if(!is_null($_REQUEST['contextPId']))
				{
					$contextPId = $_REQUEST['contextPId'];

				}
				
				$educationalContent[0] = new stdClass;
				$educationalContent[0]->state = VMCPortalConstants::$DELETE;
				$educationalContent[0]->educationalContentId = $educationContentId;
				$educationalContent[0]->userId = $loggedInUserId;
				$educationalContent[0]->patientId = $patient_id;
				$educationalContent[0]->contentId = $contentRef;
						
				$paramArray[0] = json_encode($educationalContent);
				
				$entityUtil->postObjectToServer($paramArray, "createUpdateEducationalContent", VMCPortalConstants::$API_EMR);
			}
		}	
		catch(Exception $e)
		{
			$msg = $e->getMessage();
		}
	}
?>