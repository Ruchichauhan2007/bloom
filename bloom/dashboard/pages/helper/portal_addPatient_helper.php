<?php
$credential = new stdClass;
$patientInfo = new stdClass;
$msg = "";
if (isset ( $_POST['submit'] )) {

	$page_error = "Add Patient";
	$page="insert";
	try {
		// Set address in AddressInfo
		$addressinfo[0] = new stdClass;
		$addressinfo[0]->addressLine1 =  $_POST ["addressLine"] ;
		$addressinfo[0]->addressLine2 = $_POST ["addressLine2"] ;
		$addressinfo[0]->postalCode = $_POST ["zip"] ;
		$addressinfo[0]->city = $_POST ["city"] ;
		$addressinfo[0]->addressTypeDesc_i18nId = VMCPortalConstants::$ADDRESSI18ID ;
		$addressinfo[0]->addressType = "DELIVERY" ;
		$addressinfo[0]->stateId = $_POST ["state"] ;
		$addressinfo[0]->state = VMCPortalConstants::$INSERT  ;
		$addressinfo[0]->preferred = false ;
		$patientInfo->addressInfo = $addressinfo;
		
		// Set PhoneInfo
		$i = 0;
		foreach ($_POST["phone"] as $key => $value)
		{
			if($value['phoneNumber'] != "")
			{
				$phoneInfo[$i] = new stdClass;
				$phoneInfo[$i]->phoneNumber = $value['phoneNumber'];
				$phoneInfo[$i]->phoneType = $value['type'];
				$phoneInfo[$i]->phoneTypeDesc_i18nId = VMCPortalConstants::$PHONEI18ID ;
				$phoneInfo[$i]->state  = VMCPortalConstants::$INSERT  ;
				if($value['phonePrimary'])
				{
					$phoneInfo[$i]->preferred  = true  ;
				}
				else
				{
					$phoneInfo[$i]->preferred  = false  ;
				}
				
				$i++;
			}
		}

		$patientInfo->phoneInfo = $phoneInfo;
		
		// Set emailInfo
		$emailaddressinfo[0] = new stdClass;
		$emailaddressinfo[0]->emailAddress = $_POST ['email'];
		$emailaddressinfo[0]->state = VMCPortalConstants::$INSERT ;
		$emailaddressinfo[0]->emailType = "PRIMARY";
		$emailaddressinfo[0]->emailTypeDesc_18nId = VMCPortalConstants::$EMAILI18ID;
		$emailaddressinfo[0]->preferred = true ;
	
		$emailaddressinfo[1] = new stdClass;
		$emailaddressinfo[1]->emailAddress = $_POST ['sEmail'];
		$emailaddressinfo[1]->state = VMCPortalConstants::$INSERT ;
		$emailaddressinfo[1]->emailType = "SECONDARY";
		$emailaddressinfo[1]->emailTypeDesc_18nId = VMCPortalConstants::$EMAILI18ID;
		$emailaddressinfo[1]->preferred = false ;
		
		$patientInfo->emailAddressInfo = $emailaddressinfo;
		
		// Set CredentialInfo
		$credential->userName = $_POST ["email"];
		$credential->password = $_POST ["password"];
		
		$credential->isPasswordChangeReqd = true;
		$credential->userLoginMethodDesc = VMCPortalConstants::$AUTHENTICATION_METHOD_PASSWORD;
		$credential->state = VMCPortalConstants::$INSERT  ;

		// Set Patient Details
		$patientInfo->firstName = $_POST ['firstName'];
		$patientInfo->middleInitial = $_POST ['initName'];
		$patientInfo->lastName = $_POST ['lastName'];
		$patientInfo->programType = $_POST ['programType'] ;
		$patientInfo->preferredName = $_POST ['prefName'] ;
		$dob = $_POST ['dob'];

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
		$patientInfo->dateOfBirth = $calendarDob ;
		$patientInfo->userTimeZone = $_POST ['timeZone'];
		
		$patientInfo->state = VMCPortalConstants::$INSERT ;
		$patientInfo->genderCode = $_POST ['gender'];
		$patientInfo->isActive = $_POST ['isActive'] ;
		$patientInfo->preferredContactType = $_POST ['preferredContactType']; 

		$patientInfo->entityType = VMCPortalConstants::$ENTITYTYPE_PATIENT ;
		//$patientInfo->primaryDiagnosis = "RN";
		$patientInfo->avatar = "DEFAULT.PNG";

		$patientInfo->status = "AV";

		// set provider info

		$providerInfo[0]->providerId = $_POST ['primaryProv'];
		$providerInfo[0]->isPrimary = true;
		$providerInfo[0]->priorityNo = 1;

		$providerInfo[1]->providerId = $_POST ['secondaryProv'];
		$providerInfo[1]->isPrimary = false;
		$providerInfo[1]->priorityNo = 2;

		if($_POST ['tertiaryProv'] > 0)
		{
			$providerInfo[2]->providerId = $_POST ['tertiaryProv'];
			$providerInfo[2]->isPrimary = false;
			$providerInfo[2]->priorityNo = 3;
		}

		$patientInfo->patientProviderInfos = $providerInfo;

		// Set RoleInfo
		$entityUtil = new EntityUtil();
		$array = $entityUtil->getObjectFromServer("BLANK", "getRoles", VMCPortalConstants::$API_ADMIN);
		foreach ( $array as $value ) {			
			if (strtoupper($value->{description}) == "PATIENT") {
				$entityRoleInfo[0] = new stdClass();
				$entityRoleInfo[0]->roleId =  $value->{roleId};
				$entityRoleInfo[0]->state =  VMCPortalConstants::$INSERT;
				$patientInfo->entityRoleInfos = $entityRoleInfo;
				break;
			}
		}

		$paramArray = array();
		$paramArray[0] = json_encode($patientInfo);
		$paramArray[1] = json_encode($credential);
		
		$retPatient = $entityUtil->postObjectToServer($paramArray, "addPatient", VMCPortalConstants::$API_EMR);
		//header("Location:patient_moreDetails.php?patientId=".$retPatient->{patientId}."&type=EDIT&edit=true");

		$retVal = $retPatient->{patientId};
		?>
		<script>
		localStorage.clear();
		</script>
		<?php
		if($_POST["hasImage"] == false || $_POST["hasImage"] == "false")
		{
			header("Location:patient_moreDetails.php?patientId=".$retPatient->{patientId}."&type=EDIT&edit=true");
		}
		else
		{
			header("patientId:".$retPatient->{patientId});
		}

		} catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}
else if (isset ( $_POST['update'] ))
{
	$userTypeHelper = strtoupper($_COOKIE['type']);
	$page="Update";
	$page_error = "Update Patient";
	try {
		$entityUtil = new EntityUtil();
		$patientId = $_POST['patientId'];
		$paramArray[0] = $patientId;
		$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
		
		// Set address in AddressInfo
		 $addressinfo = $patientInfo->{addressInfo};
		 $emailaddressinfo = $patientInfo->{emailAddressInfo};
		 $phoneInfo = $patientInfo->{phoneInfo};
		if(count($addressinfo) == 1)
		{
		
				
			if($addressinfo[0]->{addressType} == "BILLING")
			{
				
				$addressinfo[0]->preferred = false ;
				$addressinfo[0]->state = VMCPortalConstants::$UPDATE  ;
				
				$addressinfo[1] = new stdClass;
				$addressinfo[1]->addressLine1 =  $_POST ["addressLine"] ;
				$addressinfo[1]->addressLine2 = $_POST ["addressLine2"] ;
				$addressinfo[1]->postalCode = $_POST ["zip"] ;
				$addressinfo[1]->city = $_POST ["city"] ;
				$addressinfo[1]->addressType = "DELIVERY" ;
				$addressinfo[1]->stateId = $_POST ["state"] ;
				$addressinfo[1]->addressTypeDesc_i18nId = VMCPortalConstants::$ADDRESSI18ID ;
				$addressinfo[1]->state = VMCPortalConstants::$INSERT  ;
				$addressinfo[1]->preferred = false ;
			}
			else
			{
				
				$addressinfo[0]->addressLine1 =  $_POST ["addressLine"] ;
				$addressinfo[0]->addressLine2 = $_POST ["addressLine2"] ;
				$addressinfo[0]->postalCode = $_POST ["zip"] ;
				$addressinfo[0]->city = $_POST ["city"] ;
				$addressinfo[0]->addressType = "DELIVERY" ;
				$addressinfo[0]->stateId = $_POST ["state"] ;
				$addressinfo[0]->state = VMCPortalConstants::$UPDATE  ;
				$addressinfo[0]->preferred = false ;
			}
			
		}
		else if(count($addressinfo) == 2)
		{
			
			if($addressinfo[0]->{addressType} == "BILLING")
			{
				
				$addressinfo[0]->preferred = false ;
				$addressinfo[0]->state = VMCPortalConstants::$UPDATE  ;
				
				$addressinfo[1]->addressLine1 =  $_POST ["addressLine"] ;
				$addressinfo[1]->addressLine2 = $_POST ["addressLine2"] ;
				$addressinfo[1]->postalCode = $_POST ["zip"] ;
				$addressinfo[1]->city = $_POST ["city"] ;
				$addressinfo[1]->addressType = "DELIVERY" ;
				$addressinfo[1]->stateId = $_POST ["state"] ;
				$addressinfo[1]->state = VMCPortalConstants::$UPDATE  ;
				$addressinfo[1]->preferred = false ;
			}
			else
			{
				
				$addressinfo[0]->addressLine1 =  $_POST ["addressLine"] ;
				$addressinfo[0]->addressLine2 = $_POST ["addressLine2"] ;
				$addressinfo[0]->postalCode = $_POST ["zip"] ;
				$addressinfo[0]->city = $_POST ["city"] ;
				$addressinfo[0]->addressType = "DELIVERY" ;
				$addressinfo[0]->stateId = $_POST ["state"] ;
				$addressinfo[0]->state = VMCPortalConstants::$UPDATE  ;
				$addressinfo[0]->preferred = false ;
			}
		}
		$patientInfo->addressInfo = $addressinfo;
			
		// Set PhoneInfo
		$i = 0;
		
		foreach ($_POST["phone"] as $key => $value)
		{
		 
		 $flag = false;
			/*if($value['phoneNumber'] != "")
			{*/
				foreach($phoneInfo as $phn)
				{
					
				
					if($phn->{phoneType} == $value['type'])
					{
					$newPhoneinfo[$i] = $phn;
					$flag = true;
					}
				}
				if($flag)
				{	
					if($value['phoneNumber'] == "")
					{
						$newPhoneinfo[$i]->state  = VMCPortalConstants::$DELETE;
					}
					else
					{
						$newPhoneinfo[$i]->state  = VMCPortalConstants::$UPDATE;
						$newPhoneinfo[$i]->phoneNumber = $value['phoneNumber'];
					}
				}
				else
				{
					if($value['phoneNumber'] != "")
					{
						$newPhoneinfo[$i] = new stdClass;
						$newPhoneinfo[$i]->phoneTypeDesc_i18nId = VMCPortalConstants::$PHONEI18ID ;
						$newPhoneinfo[$i]->phoneNumber = $value['phoneNumber'];
						$newPhoneinfo[$i]->state  = VMCPortalConstants::$INSERT ;
					}
				}
					
				
				$newPhoneinfo[$i]->phoneType = $value['type'];

				
				if($value['phonePrimary'])
				{
					$newPhoneinfo[$i]->preferred  = true  ;
				}
				else
				{
					$newPhoneinfo[$i]->preferred  = false  ;
				}
				
				$i++;
			}
	//}
	    
		$patientInfo->phoneInfo = $newPhoneinfo;
		if(count($emailaddressinfo) == 1)
		{
		  if($emailaddressinfo[0]->emailType == "PRIMARY")
			{
				if($emailaddressinfo[0]->{emailAddress} == $_POST ['email'])
				{
					
					$emailaddressinfo[0]->state = VMCPortalConstants::$NO_UPDATE ;
				}
				else
				{
					$emailaddressinfo[0]->state = VMCPortalConstants::$UPDATE ;
				}
				$emailaddressinfo[0]->emailAddress = $_POST ['email'];
				$emailaddressinfo[0]->emailType = "PRIMARY";
				$emailaddressinfo[0]->preferred = true ;
				
				$emailaddressinfo[1] = new stdClass;
				$emailaddressinfo[1]->state = VMCPortalConstants::$INSERT ;
				$emailaddressinfo[1]->emailTypeDesc_18nId = VMCPortalConstants::$EMAILI18ID;
				$emailaddressinfo[1]->emailAddress = $_POST ['sEmail'];
				$emailaddressinfo[1]->emailType = "SECONDARY";
				$emailaddressinfo[1]->preferred = false ;
				
			}
						
		}
		
		else if(count($emailaddressinfo) == 2)
		{
			
				if($emailaddressinfo[0]->{emailAddress} == $_POST ['email'])
				{
					$emailaddressinfo[0]->state = VMCPortalConstants::$NO_UPDATE ;	
				}
				else
				{
					$emailaddressinfo[0]->state = VMCPortalConstants::$UPDATE ;
				}
				$emailaddressinfo[0]->emailAddress = $_POST ['email'];
				$emailaddressinfo[0]->emailType = "PRIMARY";
				$emailaddressinfo[0]->preferred = true ;
		
				if($emailaddressinfo[1]->{emailAddress} == $_POST ['sEmail'])
				{
					
					$emailaddressinfo[1]->state = VMCPortalConstants::$NO_UPDATE ;
				}
				else if($_POST ['sEmail'] == "")
				{
					
					$emailaddressinfo[1]->state = VMCPortalConstants::$DELETE ;
					//$emailaddressinfo[1]->emailAddress = $_POST ['sEmail'];
				}
				else
				{
					$emailaddressinfo[1]->state = VMCPortalConstants::$UPDATE ;
					$emailaddressinfo[1]->emailAddress = $_POST ['sEmail'];
				}
				
				
				$emailaddressinfo[1]->emailType = "SECONDARY";
				$emailaddressinfo[1]->preferred = false ;
			
		}
		
		
		$patientInfo->emailAddressInfo = $emailaddressinfo;
		// Set Patient Details
		$patientInfo->firstName = $_POST ['firstName'];
		$patientInfo->middleInitial = $_POST ['initName'];
		$patientInfo->lastName = $_POST ['lastName'];
		$patientInfo->programType = $_POST ['programType'] ;
		$patientInfo->preferredName = $_POST ['prefName'] ;
		$dob = $_POST ['dob'];

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
		$patientInfo->dateOfBirth = $calendarDob ;
		$patientInfo->userTimeZone = $_POST ['timeZone'];		
		$patientInfo->genderCode = $_POST ['gender'];
		$patientInfo->isActive = $_POST ['isActive'] ;
		$patientInfo->preferredContactType = $_POST ['preferredContactType']; 
		$patientInfo->patientId = $_POST['patientId'];
		$patientInfo->entityId = $_POST['patientId'];
		$patientInfo->genderCode = $_POST ['gender'];
		$patientInfo->isActive = $_POST ['isActive'] ;
		$patientInfo->state  = VMCPortalConstants::$UPDATE  ;

		$patientInfo->entityType = VMCPortalConstants::$ENTITYTYPE_PATIENT ;

		// Set CredentialInfo
		$paramArray = array() ;
		$paramArray[0] = $_POST['patientId'];
		$credential = $entityUtil->getObjectFromServer($paramArray, "getCredentialInfoByEntityId", VMCPortalConstants::$API_ADMIN);
		$credential->userName = $_POST ["email"];
		$credential->state = VMCPortalConstants::$UPDATE;
		$credential->isPasswordChangeReqd = VMCPortalConstants::$PHP_FALSE;
		
		if((!($_POST ["password"] == "*********") AND $_POST ["password"] != ""))
		{
			$credential->password = $_POST ["password"];
			$credential->isPasswordChangeReqd = true;
			$credential->userLoginMethodDesc = VMCPortalConstants::$AUTHENTICATION_METHOD_PASSWORD;
			$credential->state = VMCPortalConstants::$UPDATE;
		}
	
		
		// set provider info

		$providerInfo[0]->providerId = $_POST ['primaryProv'];
		$providerInfo[0]->isPrimary = true;
		$providerInfo[0]->priorityNo = 1;

		$providerInfo[1]->providerId = $_POST ['secondaryProv'];
		$providerInfo[1]->isPrimary = false;
		$providerInfo[1]->priorityNo = 2;

		if($_POST ['tertiaryProv'] > 0)
		{
			$providerInfo[2]->providerId = $_POST ['tertiaryProv'];
			$providerInfo[2]->isPrimary = false;
			$providerInfo[2]->priorityNo = 3;
		}

		$patientInfo->patientProviderInfos = $providerInfo;
		$paramArray = array();
		$paramArray[0] = json_encode($patientInfo);
		$paramArray[1] = json_encode($credential);
		
		$retPatient = $entityUtil->postObjectToServer($paramArray, "createUpdatePatient", VMCPortalConstants::$API_EMR);
		header("Location:patient_moreDetails.php?patientId=".$_POST['patientId']."&type=EDIT&edit=true");
	}	
	catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}
?>
