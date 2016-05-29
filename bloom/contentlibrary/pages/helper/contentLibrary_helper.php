<?php
	$entityUtil = new EntityUtil();
	$msg = "";
		try
	{
		$msg = "";
		//$patientList = $emr->getPatientList(VMCPortalConstants::$API_EMR);
		//$patientUtil = new PatientUtil();
		//$patientList = $patientUtil->getPatientList(VMCPortalConstants::$API_EMR);
		$paramArray = array();
		$paramArray[0] = "";
		$patientList = $entityUtil->getObjectFromServer($paramArray, "getPatients", VMCPortalConstants::$API_EMR);
		$entityDetailInfos= $patientList->{entityDetailInfos};
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}

	try
	{
		// Populate Patient List for file upload
		//$providerUtil = new ProviderUtil();
		$args[0] = 0;
		//$contentResp  = $providerUtil->getContentList($args);
		$contentResp = $entityUtil->getObjectFromServer($args, "getContentList", VMCPortalConstants::$API_EMR);

	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}

	try
	{
		if(isset($_REQUEST["Delete"]))
		{
			$contentInfo = new stdClass;
			$contentInfo->contentsId = $_REQUEST['deleteContentId'];
			$contentInfo->userId = $_REQUEST['userId'];
			$contentInfo->contentType = $_REQUEST['contentType'];
			$contentInfo->title = $_REQUEST['title'];
			$contentInfo->fileUploadDate = $_REQUEST['fileUploadDate'];
			$contentInfo->state = VMCPortalConstants::$DELETE;
			$entityUtil = new EntityUtil();
			$paramArray = array();
			$paramArray[0] = json_encode($contentInfo);
			$json_encode = $entityUtil->getObjectFromServer($paramArray, "createUpdateContent", VMCPortalConstants::$API_EMR);
		}
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
?>