<?php
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
			
			foreach($_REQUEST["learnCard"] AS $card)
			{
				$educationalContentInfo[$i] = new stdClass;
				$educationalContentInfo[$i]->userId = $loggedInUserId;
				$educationalContentInfo[$i]->patientId = $patientId;
				$educationalContentInfo[$i]->contentId = $card;
				$educationalContentInfo[$i]->state = VMCPortalConstants::$INSERT ;
				$i++;
			}
			
			$paramArray[0] = json_encode($educationalContentInfo);
			
			$learnList = $entityUtil->postObjectToServer($paramArray, "createUpdateEducationalContent", VMCPortalConstants::$API_EMR);

			if($learnList)
			{
				header("Location:portal_learn.php?contextPId=".$patientId);
			}
		}
		catch(Exception $e)
		{
			$msg = $e->getMessage();
		}
	}
?>