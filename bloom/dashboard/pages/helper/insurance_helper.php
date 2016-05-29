<?php
$emr = new stdClass;
$admin = new stdClass;
$patientInsInfo = new stdClass;
$credentialInfo = new stdClass;

$entityUtil = new EntityUtil();
$msg = "";
if (isset ( $_POST['saveinsurance'] ))
{
	$page_error = "Add insurance";
	try {
		$patientId = $_POST ["patientId"];
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
			
		// Set PhoneInfo
		
		 $phoneInfo = $patientInfo->{phoneInfo};
		
		
		  if(!$phoneInfo)
		  {
			 $phoneInfo[0] = new stdClass;
			 $phoneInfo[0]->phoneNumber = str_replace("-","",$_POST ["phone"]);
			 $phoneInfo[0]->phoneType = "BILLING";
			 $phoneInfo[0]->phoneTypeDesc_i18nId = 159 ;
			 $phoneInfo[0]->state  = VMCPortalConstants::$INSERT  ;
			 $phoneInfo[0]->preferred = false ;
		  }
		  else if(count($phoneInfo) == 1)
		  {
			  if($phoneInfo[0]->{phoneNumber} == $_POST ["phone"])
			 {
				$phoneInfo[0]->state  = VMCPortalConstants::$NO_UPDATE  ;
			 }
		  	 else if($phoneInfo[0]->{phoneType} == "DELIVERY")
			 {
				 $phoneInfo[0]->preferred = false ;
				 $phoneInfo[0]->state  = VMCPortalConstants::$UPDATE  ;
				 
				  $phoneInfo[1] = new stdClass;
				 $phoneInfo[1]->phoneNumber = str_replace("-","",$_POST ["phone"]);
				 $phoneInfo[1]->phoneType = "BILLING";
				 $phoneInfo[1]->phoneTypeDesc_i18nId = 159 ;
				 $phoneInfo[1]->state  = VMCPortalConstants::$INSERT  ;
				 $phoneInfo[1]->preferred = false ;
			 }
			 else
			 {
			 	$phoneInfo[1]->phoneNumber = str_replace("-","",$_POST ["phone"]);
				$phoneInfo[1]->phoneType = "BILLING";
				$phoneInfo[1]->state  = VMCPortalConstants::$UPDATE  ;
				$phoneInfo[1]->preferred = false ;
			 }
		  }
		  else if(count($phoneInfo) == 2)
		  {
		  		if($phoneInfo[0]->{phoneType} == "DELIVERY")
			 {
				 $phoneInfo[0]->preferred = false ;
				 $phoneInfo[0]->state  = VMCPortalConstants::$UPDATE  ;
				  
				 $phoneInfo[1]->phoneNumber = str_replace("-","",$_POST ["phone"]);
				 $phoneInfo[1]->phoneType = "BILLING";
				 $phoneInfo[1]->state  = VMCPortalConstants::$UPDATE  ;
				 $phoneInfo[1]->preferred = false ;
			 }
			 else
			 {
			 	$phoneInfo[0]->phoneNumber = str_replace("-","",$_POST ["phone"]);
				$phoneInfo[0]->phoneType = "BILLING";
				$phoneInfo[0]->state  = VMCPortalConstants::$UPDATE  ;
				$phoneInfo[0]->preferred = false ;
			 }
		  }
		 
		 $patientInfo->phoneInfo = $phoneInfo;
		
		$patientInsInfo->groupId =  $_POST ["groupId"] ;
		$patientInsInfo->memberId = $_POST ["memberId"] ;
		$patientInsInfo->patientId = $patientId;
		$patientInsInfo->employeeFirstName =  $_POST ["insuredFirstName"] ;
		$patientInsInfo->employeeLastName = $_POST ["insuredLastName"] ;
		$patientInsInfo->employeePhoneNumber = $_POST ["insuredPhone"] ;
		$patientInsInfo->employeeEmailAddress = $_POST ["insuredEmail"] ;		
		$patientInsInfo->state = VMCPortalConstants::$INSERT;	
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
		//$retValue = $retpatientInsInfo ->{PatientInsuranceInfo};
		header("Location:portal_addDevices.php?patientId=".$patientId);
	} catch ( Exception $e ) {
		$msg = $e->getMessage();
	}
}


// update Insurance
if (isset ( $_POST['insurance'] ))
{
	$page_error = "Update Patient";
	try {
		$patientId = $_POST ["patientId"];
		$paramArray = array();
		$paramArray[0] = $patientId;
	    $patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
		
		$paramArray = array();
		$paramArray[0] = $patientId;
	    $credentialInfo = $entityUtil->getObjectFromServer($paramArray, "getCredentialInfoByEntityId", VMCPortalConstants::$API_ADMIN);
		$patientInsInfo = $patientInfo->{patientInsuranceInfo};
		
		//Set address in AddressInfo
		
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
			
		// Set PhoneInfo
		
		 $phoneInfo = $patientInfo->{phoneInfo};
		
		
		  if(!$phoneInfo)
		  {
		  	 $phoneInfo[0] = new stdClass;
			 $phoneInfo[0]->phoneNumber = str_replace("-","",$_POST ["phone"]);
			 $phoneInfo[0]->phoneType = "BILLING";
			 $phoneInfo[0]->state  = VMCPortalConstants::$INSERT  ;
			 $phoneInfo[0]->preferred = false ;
		  }
		  else if(count($phoneInfo) == 1)
		  {
			if($phoneInfo[0]->{phoneNumber} == $_POST ["phone"])
			 {
				$phoneInfo[0]->state  = VMCPortalConstants::$NO_UPDATE  ;
			 }
		  	 else if($phoneInfo[0]->{phoneType} == "DELIVERY")
			 {
				 $phoneInfo[0]->preferred = false ;
				 $phoneInfo[0]->state  = VMCPortalConstants::$UPDATE  ;
				  
				 $phoneInfo[1] = new stdClass;
				 $phoneInfo[1]->phoneNumber = str_replace("-","",$_POST ["phone"]);
				 $phoneInfo[1]->phoneType = "BILLING";
				 $phoneInfo[1]->state  = VMCPortalConstants::$INSERT  ;
				 $phoneInfo[1]->preferred = false ;
			 }
			 else
			 {
			 	$phoneInfo[1]->phoneNumber = str_replace("-","",$_POST ["phone"]);
				$phoneInfo[1]->phoneType = "BILLING";
				$phoneInfo[1]->state  = VMCPortalConstants::$UPDATE  ;
				$phoneInfo[1]->preferred = false ;
			 }
		  }
		  else if(count($phoneInfo) == 2)
		  {
		  		if($phoneInfo[0]->{phoneType} == "DELIVERY")
			 {
				 $phoneInfo[0]->preferred = false ;
				 $phoneInfo[0]->state  = VMCPortalConstants::$UPDATE  ;
				  
				 $phoneInfo[1]->phoneNumber = str_replace("-","",$_POST ["phone"]);
				 $phoneInfo[1]->phoneType = "BILLING";
				 $phoneInfo[1]->state  = VMCPortalConstants::$UPDATE  ;
				 $phoneInfo[1]->preferred = false ;
			 }
			 else
			 {
			 	$phoneInfo[0]->phoneNumber = str_replace("-","",$_POST ["phone"]);
				$phoneInfo[0]->phoneType = "BILLING";
				$phoneInfo[0]->state  = VMCPortalConstants::$UPDATE  ;
				$phoneInfo[0]->preferred = false ;
			 }
		  }
		 
		 $patientInfo->phoneInfo = $phoneInfo;
		
		$patientInsInfo->groupId =  $_POST ["groupId"] ;
		$patientInsInfo->memberId = $_POST ["memberId"] ;
		$patientInsInfo->patientId = $patientId;
		$patientInsInfo->patientInsuranceId =  $_POST ["patientInsuranceId"] ;
		$patientInsInfo->employeeFirstName =  $_POST ["insuredFirstName"] ;
		$patientInsInfo->employeeLastName = $_POST ["insuredLastName"] ;
		$patientInsInfo->employeePhoneNumber = $_POST ["insuredPhone"] ;
		$patientInsInfo->employeeEmailAddress = $_POST ["insuredEmail"] ;		
		$patientInsInfo->state = VMCPortalConstants::$UPDATE;
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
		//$retValue = $retpatientInsInfo ->{PatientInsuranceInfo};
		$userType = strtoupper($_COOKIE['type']);
		if($userType == "PATIENT")
		{
		echo "Your profile successfully updated";
		}
		else
		{
		header("Location:portal_addDevices.php?patientId=".$patientId);
		}
		
	} catch ( Exception $e ) {
		$msg = $e->getMessage();
	}
}
?>
