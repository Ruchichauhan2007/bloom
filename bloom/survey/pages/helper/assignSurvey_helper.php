<?php
$surveyConfigDataInfo = new stdClass;
$surveyAssignmentListInfos = array();
try
	{
		$msg ="";
		
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
		$entityUtil = new EntityUtil();
		$paramArray[0] = $patientId;
		$surveyResp = $entityUtil->getObjectFromServer($paramArray, "getConfigSurveyList", VMCPortalConstants::$API_ADMIN);
		
		
	}	
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
// show existing

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
	


	if(isset($_POST['saveAssign']))
	{	
		try
		{
			$entityUtil = new EntityUtil();
			$msg = "";
			$paramArray = array();
			
			if(!is_null($_REQUEST['contextPId']))
			{
				$patientId = $_REQUEST['contextPId']; 
			}
			
			$loggedInUserId = $entityUtil->getLoggedInEntityId();
			$i = 0;
			if(isset($_POST["surveyStatus"]))
			{
				foreach ($_POST[surveyStatus] as $key => $value)
				{
					if (empty($value))
					{
						unset($_POST[surveyStatus][$key]);
					}
				}
				$setoptions = array_values($_POST[surveyStatus]);
				
				foreach($setoptions as $setoption)
				{
					$splitData = explode("_",$setoption);
					$surveyAssignmentListInfo = new stdClass;
					$surveyAssignmentListInfo->surveyConfigId = $splitData[0];
					$surveyAssignmentListInfo->keepExistingData = $splitData[1];
					$surveyAssignmentListInfos[$i] = $surveyAssignmentListInfo;
					$i++;
				}
			}
			else
			{
				foreach ($_POST[surveyCard] as $key => $value)
				{
					if (empty($value))
					{
						unset($_POST[surveyCard][$key]);
					}
				}
				$setIds = array_values($_POST[surveyCard]);
				$i = 0;
				$surveyAssignmentListInfos = "";
				$surveyAssignmentListInfos = array();
				foreach($setIds as $setId)
				{
					$surveyAssignmentListInfo = new stdClass;
					$surveyAssignmentListInfo->surveyConfigId = $setId;
					$surveyAssignmentListInfo->keepExistingData = false;
					$surveyAssignmentListInfos[$i] = $surveyAssignmentListInfo;
					
					$i++;
				}
				
				
			}
				
				$surveyConfigDataInfo = new stdClass;
				$surveyConfigDataInfo->entityId = $patientId;
				$surveyConfigDataInfo->surveyAssignmentListInfos = $surveyAssignmentListInfos;
				$surveyConfigDataInfo->state = VMCPortalConstants::$INSERT ;
				
				
			
			$paramArray[0] = json_encode($surveyConfigDataInfo);
			//$paramArray[1] = $patientId;
			
			$responseInfo = $entityUtil->postObjectToServer($paramArray, "assignSurvey", VMCPortalConstants::$API_ADMIN);
				
			header("Location:showSurvey.php?contextPId=".$patientId);
				
		}
		catch(Exception $e)
		{
			$msg = $e->getMessage();
		}
	}
?>