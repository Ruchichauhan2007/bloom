<?php
if (isset($_POST['saveStatus']))
 {
	$page_error = "Change Status";
	$page="Update";
	$msg = "";
	try {
		$entityUtil = new EntityUtil();
		$patientId = $_POST['patientId'];
		$paramArray[0] = $patientId;
		$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
		$paramArray[0] = $_POST['patientId'];
		$credential = $entityUtil->getObjectFromServer($paramArray, "getCredentialInfoByEntityId", VMCPortalConstants::$API_ADMIN);
		// Set Patient Details
		$patientInfo->patientType = $_POST ['patientType'];
		$patientInfo->stage = $_POST ['stage'];
		$patientInfo->coaching = $_POST ['coaching'];
		$patientInfo->state = VMCPortalConstants::$UPDATE ;
		$paramArray = array();
		$paramArray[0] = json_encode($patientInfo);
		$paramArray[1] = json_encode($credential);
		$retPatient = $entityUtil->postObjectToServer($paramArray, "createUpdatePatient", VMCPortalConstants::$API_EMR);
		header("Location:patient_moreDetails.php?patientId=".$patientId);
		} catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}

if (isset($_POST['saveTicket']))
 {
	$page_error = "Save Ticket";
	$page="insert";
	try {
		$entityUtil = new EntityUtil();
		$patientId = $_POST['patientId'];
		$paramArray = array() ;
		$paramArray[0] = $patientId;
		$patientMiscInfo = $entityUtil->getObjectFromServer($paramArray, "getPatientMiscByPatientId", VMCPortalConstants::$API_EMR);
		if($patientMiscInfo == "" || $patientMiscInfo == NULL)
		{
		$patientMiscInfo = new stdClass;
		$patientMiscInfo->state = VMCPortalConstants::$INSERT ;
		}
		else
		{
			$patientMiscInfo->state = VMCPortalConstants::$UPDATE ;
		}
		$patientMiscInfo->patientId = $patientId;
		$patientMiscInfo->openTicket = $_POST ['openTicket'];
		$patientMiscInfo->closedTicket = $_POST ['closedTicket'];
		$paramArray = array();
		$paramArray[0] = json_encode($patientMiscInfo);
		$patientMisc = $entityUtil->postObjectToServer($paramArray, "createUpdatePatientMisc", VMCPortalConstants::$API_EMR);
		header("Location:patient_moreDetails.php?patientId=".$patientId);
		} catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}

if (isset($_POST['saveEngagement']))
 {
	$page_error = "Save Engagement";
	$page="insert";
	try {
		$entityUtil = new EntityUtil();
		$patientId = $_POST['patientId'];
		$paramArray = array() ;
		$paramArray[0] = $patientId;
		$patientMiscInfo = $entityUtil->getObjectFromServer($paramArray, "getPatientMiscByPatientId", VMCPortalConstants::$API_EMR);
		if($patientMiscInfo == "" || $patientMiscInfo == NULL)
		{
		$patientMiscInfo = new stdClass;
		$patientMiscInfo->state = VMCPortalConstants::$INSERT ;
		}
		else
		{
			$patientMiscInfo->state = VMCPortalConstants::$UPDATE ;
		}
		$patientMiscInfo->patientId = $patientId;
		$patientMiscInfo->currentEngagement = $_POST ['month'];
		$patientMiscInfo->quarterEngagement = $_POST ['quarter'];
		$patientMiscInfo->prevQuarterEngagement = $_POST ['prequarter'];
		$paramArray = array();
		$paramArray[0] = json_encode($patientMiscInfo);
		$patientMisc = $entityUtil->postObjectToServer($paramArray, "createUpdatePatientMisc", VMCPortalConstants::$API_EMR);
		header("Location:patient_moreDetails.php?patientId=".$patientId);
		} catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}

if (isset($_POST['saveAdherence']))
 {
	$page_error = "Save Adherence";
	$page="update";
	try {
		$entityUtil = new EntityUtil();
		$patientId = $_POST['patientId'];
		$paramArray[0] = $patientId;
		$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
		$paramArray[0] = $_POST['patientId'];
		$credential = $entityUtil->getObjectFromServer($paramArray, "getCredentialInfoByEntityId", VMCPortalConstants::$API_ADMIN);
		// Set Patient Details
		$patientInfo->adherenceVariance = $_POST ['variance'];
		$patientInfo->state = VMCPortalConstants::$UPDATE ;
		$paramArray = array();
		$paramArray[0] = json_encode($patientInfo);
		$paramArray[1] = json_encode($credential);
		$retPatient = $entityUtil->postObjectToServer($paramArray, "createUpdatePatient", VMCPortalConstants::$API_EMR);
		header("Location:patient_moreDetails.php?patientId=".$patientId);
		} catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}

if (isset($_POST['saveGoal']))
 {
	$msg = "";
	$page_error = "Save Goal";
	$page="update";
	try {
		$entityUtil = new EntityUtil();
		$patientId = $_POST['patientId'];
		
		$paramArray = array() ;
		$paramArray[0] = $patientId;
		$patientGoalInfos = $entityUtil->getObjectFromServer($paramArray, "getPatientGoalsByPatientId", VMCPortalConstants::$API_EMR);
		
		$i = 0;
		foreach ($_POST["goals"] as $key => $value)
		{
			if($value['goal'] != "")
			{
				$patientGoalInfos[$i] = new stdClass;
				$patientGoalInfos[$i]->goal = $value['goal'];
				$patientGoalInfos[$i]->target = $value['goalTarget'];
				$patientGoalInfos[$i]->progress = $value['goalProgress'];
				$patientGoalInfos[$i]->goalTypeId = $value['goalType'];
				$patientGoalInfos[$i]->patientId =$patientId ;
				$patientGoalInfos[$i]->state  = VMCPortalConstants::$INSERT;				
				
				$i++;
			}
			
		} 
		

		
		$paramArray = array();
		$paramArray[0] = json_encode($patientGoalInfos);
		$createUpdatePatientGoal = $entityUtil->postObjectToServer($paramArray, "createUpdatePatientGoals", VMCPortalConstants::$API_EMR);
		header("Location:patient_moreDetails.php?patientId=".$patientId);
		} catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}

//Update Goal
if (isset($_POST['editGoal']))
 {
	$msg = "";
	$page_error = "edit Goal";
	$page="update";
	try {
		$entityUtil = new EntityUtil();
		$patientId = $_POST['patientId'];
		
		$paramArray = array() ;
		$paramArray[0] = $patientId;
		$newPatientGoalInfos = $entityUtil->getObjectFromServer($paramArray, "getPatientGoalsByPatientId", VMCPortalConstants::$API_EMR);
		
		$i = 0;
		
	
		foreach ($_POST["goals"] as $key => $value)
		{
			$oldMached = false;
			if($value['goal'] != "")
			{
				foreach($newPatientGoalInfos as $patientGoalInfo)
				{
					if($patientGoalInfo->{goalTypeId} == $value['goalType'])
					{
						$oldMached = true;
						$patientGoalInfos[$i] = $patientGoalInfo;
					}
				}
				
				if($oldMached)
				{
				$patientGoalInfos[$i]->state  = VMCPortalConstants::$UPDATE  ;
				}
				else
				{
					$patientGoalInfos[$i]->state  = VMCPortalConstants::$INSERT ;
				}
					
				$patientGoalInfos[$i]->goal = $value['goal'];
				$patientGoalInfos[$i]->target = $value['goalTarget'];
				$patientGoalInfos[$i]->progress = $value['goalProgress'];
				$patientGoalInfos[$i]->goalTypeId = $value['goalType'];
				$patientGoalInfos[$i]->patientId =$patientId ;

	
				$i++;
			}
	}
		

		
		$paramArray = array();
		$paramArray[0] = json_encode($patientGoalInfos);
		$createUpdatePatientGoal = $entityUtil->postObjectToServer($paramArray, "createUpdatePatientGoals", VMCPortalConstants::$API_EMR);
		header("Location:patient_moreDetails.php?patientId=".$patientId);
		} catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}

// update Insurance
if (isset ( $_POST['saveInsurance'] ))
{
	$page_error = "Add insurance";
	try {
		$patientId = $_POST ["patientId"];
		$entityUtil = new EntityUtil();
		$paramArray = array();
		$paramArray[0] = $patientId;
	    $patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
		
		$paramArray = array();
		$paramArray[0] = $patientId;
	    $credentialInfo = $entityUtil->getObjectFromServer($paramArray, "getCredentialInfoByEntityId", VMCPortalConstants::$API_ADMIN);
		$patientInsInfo = $patientInfo->{patientInsuranceInfo};
		
		$addressinfo = $patientInfo->{addressInfo};
			
		if(!$addressinfo)
		{
			
			$addressinfo[0] = new stdClass;
			$addressinfo[0]->addressLine1 =  $_POST ["address1"] ;
			
			$addressinfo[0]->addressLine2 = $_POST ["address2"] ;
			$addressinfo[0]->postalCode = $_POST ["zip"] ;
			$addressinfo[0]->city = $_POST ["city"] ;
			$addressinfo[0]->addressType = "BILLING" ;
			$addressinfo[0]->stateId = $_POST ["state"] ;
			$addressinfo[0]->addressTypeDesc_i18nId = 160 ;
			$addressinfo[0]->state = VMCPortalConstants::$INSERT  ;
			$addressinfo[0]->preferred = false ;
			
		}
		else if(count($addressinfo) == 1)
		{
		
		
			if($addressinfo[0]->{addressType} == "DELIVERY")
			{
				
				$addressinfo[0]->preferred = false ;
				$addressinfo[0]->state = VMCPortalConstants::$UPDATE  ;
				
				$addressinfo[1] = new stdClass;
				$addressinfo[1]->addressLine1 =  $_POST ["address1"] ;
				$addressinfo[1]->addressLine2 = $_POST ["address2"] ;
				$addressinfo[1]->postalCode = $_POST ["zip"] ;
				$addressinfo[1]->city = $_POST ["city"] ;
				$addressinfo[1]->addressType = "BILLING" ;
				$addressinfo[1]->stateId = $_POST ["state"] ;
				$addressinfo[1]->addressTypeDesc_i18nId = 160 ;
				$addressinfo[1]->state = VMCPortalConstants::$INSERT  ;
				$addressinfo[1]->preferred = false ;
			}
			else
			{
				
				$addressinfo[0]->addressLine1 =  $_POST ["address1"] ;
				$addressinfo[0]->addressLine2 = $_POST ["address2"] ;
				$addressinfo[0]->postalCode = $_POST ["zip"] ;
				$addressinfo[0]->city = $_POST ["city"] ;
				$addressinfo[0]->addressType = "BILLING" ;
				$addressinfo[0]->stateId = $_POST ["state"] ;
				$addressinfo[0]->state = VMCPortalConstants::$UPDATE  ;
				$addressinfo[0]->preferred = false ;
			}
			
		}
		else if(count($addressinfo) == 2)
		{
			
			if($addressinfo[0]->{addressType} == "DELIVERY")
			{
				
				$addressinfo[0]->preferred = false ;
				$addressinfo[0]->state = VMCPortalConstants::$UPDATE  ;
				
				
				$addressinfo[1]->addressLine1 =  $_POST ["address1"] ;
				$addressinfo[1]->addressLine2 = $_POST ["address2"] ;
				$addressinfo[1]->postalCode = $_POST ["zip"] ;
				$addressinfo[1]->city = $_POST ["city"] ;
				$addressinfo[1]->addressType = "BILLING" ;
				$addressinfo[1]->stateId = $_POST ["state"] ;
				$addressinfo[1]->state = VMCPortalConstants::$UPDATE  ;
				$addressinfo[1]->preferred = false ;
			}
			else
			{
				
				$addressinfo[0]->addressLine1 =  $_POST ["address1"] ;
				$addressinfo[0]->addressLine2 = $_POST ["address2"] ;
				$addressinfo[0]->postalCode = $_POST ["zip"] ;
				$addressinfo[0]->city = $_POST ["city"] ;
				$addressinfo[0]->addressType = "BILLING" ;
				$addressinfo[0]->stateId = $_POST ["state"] ;
				$addressinfo[0]->state = VMCPortalConstants::$UPDATE  ;
				$addressinfo[0]->preferred = false ;
			}
		}
		$patientInfo->addressInfo = $addressinfo;
		if($patientInsInfo == "" || $patientInsInfo == NULL)
		{
			$patientInsInfo = new stdClass;
			$patientInsInfo->state = VMCPortalConstants::$INSERT;
		}
		else
		{
			$patientInsInfo->state = VMCPortalConstants::$UPDATE;
		}	
		$patientInsInfo->groupId =  $_POST ["groupId"] ;
		$patientInsInfo->memberId = $_POST ["memberId"] ;
		$patientInsInfo->patientId = $patientId;
		$patientInsInfo->employeeFirstName =  $_POST ["insuredFirstName"] ;
		$patientInsInfo->employeeLastName = $_POST ["insuredLastName"] ;
		$patientInsInfo->employeeMiddleInitial = $_POST ["insuredInitial"];
		$patientInsInfo->employeePhoneNumber = $_POST ["insuredPhone"] ;
	
		 if($_POST ["insuredDob"] != "")
		 {
			
			$dob = $_POST ["insuredDob"] ;

			$pos = strpos($dob, "/");

			if($pos === FALSE)
			{
				$dateArray = explode("-", $dob);
			}
			else
			{
				$dateArray = explode("/", $dob);
			}

			$dob = $dateArray[2]."-".$dateArray[0]."-".$dateArray[1];
			$calendarDob  = new DateTime($dob);
			$calendarDob = $calendarDob->format('Y-m-d\TH:i:s.\0\0\0O\Z');
			$patientInsInfo->employeeDateofBirth = $calendarDob;
		}
		
        $patientInfo->patientInsuranceInfo = $patientInsInfo;
		$credentialInfo->state = VMCPortalConstants::$NO_UPDATE;
		$paramArray = array();
		$paramArray[0] = json_encode($patientInfo);
		$paramArray[1] = json_encode($credentialInfo);
		$retpatientInsInfo = $entityUtil->postObjectToServer($paramArray, "createUpdatePatient", VMCPortalConstants::$API_EMR);
		$retValue = $retpatientInsInfo ->{PatientInsuranceInfo};
		header("Location:patient_moreDetails.php?patientId=".$patientId);
	} catch ( Exception $e ) {
		$msg = $e->getMessage();
	}
}

//save family text
if (isset($_POST['addfamily']))
 {

	$msg = "";
	$page_error = "Add text";
	$page="update";
	try {
		$entityUtil = new EntityUtil();
		$patientId = $_POST['patientId'];

		$patientFamilyInfo = new stdClass;
		$patientFamilyInfo->patientId = $patientId;
		$patientFamilyInfo->name = $_POST['memberName'];
		$patientFamilyInfo->phoneNumber = $_POST['mobileNumber'];
		$patientFamilyInfo->emailAddress = $_POST['familyEmail'];
		$patientFamilyInfo->active = false;
		$patientFamilyInfo->state  = VMCPortalConstants::$INSERT;				
		

		
		$paramArray = array();
		$paramArray[0] = json_encode($patientFamilyInfo);
		$createUpdateFamilyText = $entityUtil->postObjectToServer($paramArray, "createUpdatePatientFamily", VMCPortalConstants::$API_EMR);
		var_dump($createUpdateFamilyText);
		header("Location:patient_moreDetails.php?patientId=".$patientId);
		} catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}

//Remove family contact
if (isset($_POST['confirmRemove']))
 {

	$msg = "";
	$page_error = "Delete";
	$page="delete";
	$entityUtil = new EntityUtil();
	$patientId = $_REQUEST['patientId'];
   try {
			$paramArray = array();
			$patDeleteInfo = new stdClass;
			$patientFamilyInfo = new stdClass;
			$patientFamilyInfo->patientId = $patientId;
			$patientFamilyInfo->patientFamilyId = 1;
			$patientFamilyInfo->name = "";
			$patientFamilyInfo->phoneNumber = "";
			$patientFamilyInfo->state  = VMCPortalConstants::$NO_UPDATE;
			$paramArray[0] = json_encode($patientFamilyInfo);
			$showFamilyText = $entityUtil->postObjectToServer($paramArray, "createUpdatePatientFamily", VMCPortalConstants::$API_EMR);
				foreach($showFamilyText as $showText)
				{
					if($showText->{patientFamilyId} == $_REQUEST["patientFamilyId"])
					{
						$patDeleteInfo = $showText;
						$patDeleteInfo->state  = VMCPortalConstants::$DELETE;
					}
				}
				$paramArray = array();
				$paramArray[0] = json_encode($patDeleteInfo);
				$createUpdateFamilyText = $entityUtil->postObjectToServer($paramArray, "createUpdatePatientFamily", VMCPortalConstants::$API_EMR);
				header("Location:patient_moreDetails.php?patientId=".$patientId);
		} catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}
//Patient Moniker
if (isset($_POST['addMoniker']))
 {
	$page_error = "Change Status";
	$page="Update";
	$msg = "";
	try {
		$entityUtil = new EntityUtil();
		$patientId = $_POST['patientId'];
		$paramArray[0] = $patientId;
		$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
		$paramArray[0] = $_POST['patientId'];
		$credential = $entityUtil->getObjectFromServer($paramArray, "getCredentialInfoByEntityId", VMCPortalConstants::$API_ADMIN);
		// Set Patient Details
		$patientInfo->patientMoniker = $_POST ['patientMoniker'];
		$patientInfo->state = VMCPortalConstants::$UPDATE ;
		$paramArray = array();
		$paramArray[0] = json_encode($patientInfo);
		$paramArray[1] = json_encode($credential);
		$retPatient = $entityUtil->postObjectToServer($paramArray, "createUpdatePatient", VMCPortalConstants::$API_EMR);
		header("Location:patient_moreDetails.php?patientId=".$patientId);
		} catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}
?>
