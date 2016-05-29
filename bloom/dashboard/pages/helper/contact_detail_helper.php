<?php
$credential = new stdClass;
$emr = new stdClass;
$admin = new stdClass;
$patientInfo = new stdClass;
$msg = "";
$entityUtil = new EntityUtil();
if (isset ( $_POST['submit'] )) {
	$page_error = "Add Contact Information";
	try {
		// Set address in AddressInfo
		//$patientInfo->patientId = $_POST['patientId'];
		$patientId = $_POST['patientId'];
		$paramArray[0] = $patientId;
		$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
		//address info
		$addressinfo[0] = new stdClass;
		$addressinfo[0]->addressLine1 =  $_POST ["address1"] ;
		$addressinfo[0]->addressLine2 = $_POST ["address2"] ;
		$addressinfo[0]->postalCode = $_POST ["zip"] ;
		$addressinfo[0]->city = $_POST ["city"] ;
		$addressinfo[0]->addressTypeDesc_i18nId = 160 ;
		$addressinfo[0]->addressType = "BILLING" ;
		$addressinfo[0]->stateId = $_POST ["state"] ;
		$addressinfo[0]->state = VMCPortalConstants::$INSERT  ;
		
		if(isset($_POST ["DeliveryAddress"]))
		{
			$addressinfo[0]->preferred = true ;
		}
		else
		{
			$addressinfo[0]->preferred = false ;
			
			$addressinfo[1] = new stdClass;
			$addressinfo[1]->addressLine1 =  $_POST ["Daddress1"] ;
			$addressinfo[1]->addressLine2 = $_POST ["Daddress2"] ;
			$addressinfo[1]->postalCode = $_POST ["Dzip"] ;
			$addressinfo[1]->city = $_POST ["Dcity"] ;
			$addressinfo[1]->addressTypeDesc_i18nId = 160 ;
			$addressinfo[1]->addressType = "DELIVERY" ;
			$addressinfo[1]->stateId = $_POST ["Dstate"] ;
			$addressinfo[1]->state = VMCPortalConstants::$INSERT  ;
			$addressinfo[1]->preferred = true ;
		}
		$patientInfo->addressInfo = $addressinfo;
		
		// phone info
		$phoneInfo[0] = new stdClass;
		$phoneInfo[0]->phoneNumber = $_POST ["phone"];
		$phoneInfo[0]->phoneType = "BILLING";
		$phoneInfo[0]->phoneTypeDesc_i18nId = 159 ;
		$phoneInfo[0]->state  = VMCPortalConstants::$INSERT  ;
		
		if(isset($_POST ["DeliveryPhone"]))
		{
			$phoneInfo[0]->preferred = true ;
		}
		else
		{
			$phoneInfo[0]->preferred = false ;

			$phoneInfo[1] = new stdClass;
			$phoneInfo[1]->phoneNumber = $_POST ["Dphone"];
			$phoneInfo[1]->phoneType = "DELIVERY";
			$phoneInfo[1]->phoneTypeDesc_i18nId = 159 ;
			$phoneInfo[1]->state  = VMCPortalConstants::$INSERT  ;
			$phoneInfo[1]->preferred = true ;
		}
		
		$patientInfo->phoneInfo = $phoneInfo;
		//email info
		$emailaddressinfo[0] = new stdClass;
		$emailaddressinfo[0]->emailAddress = $_POST ['email'];
		$emailaddressinfo[0]->emailType = "BILLING";
		$emailaddressinfo[0]->state = VMCPortalConstants::$INSERT ;
		//$emailaddressinfo[0]->emailType = VMCPortalConstants::$EMAIL_TYPE;
		$emailaddressinfo[0]->emailTypeDesc_18nId = 160;
		
		if(isset($_POST ["DeliveryEmail"]))
		{
			$emailaddressinfo[0]->preferred = true ;
		}
		else
		{
			$emailaddressinfo[0]->preferred = false ;
			
			$emailaddressinfo[1] = new stdClass;
			$emailaddressinfo[1]->emailAddress = $_POST ['Demail'];
			$emailaddressinfo[1]->emailType = "DELIVERY";
			$emailaddressinfo[1]->state = VMCPortalConstants::$INSERT ;
			//$emailaddressinfo[1]->emailType = VMCPortalConstants::$EMAIL_TYPE;
			$emailaddressinfo[1]->emailTypeDesc_18nId = 160;
			$emailaddressinfo[1]->preferred = true ;
		}
		$patientInfo->emailAddressInfo = $emailaddressinfo;
		
		$paramArray = array() ;
		$paramArray[0] = $_POST['patientId'];
		$credential = $entityUtil->getObjectFromServer($paramArray, "getCredentialInfoByEntityId", VMCPortalConstants::$API_ADMIN);
		$credential->state = VMCPortalConstants::$NO_UPDATE;
		$paramArray = array();
		$paramArray[0] = json_encode($patientInfo);
		$paramArray[1] = json_encode($credential);
		$retPatient = $entityUtil->postObjectToServer($paramArray, "addPatient", VMCPortalConstants::$API_EMR);
		header("Location:insurance.php?patientId=".$retPatient->{patientId}."&patientLastName=".$retPatient->{lastName}."&patientFirstName=".$retPatient->{firstName}."&dob=".$retPatient->{dateOfBirth}."&email=".$emailaddressinfo[0]->{emailAddress}."&phone=".$phoneInfo[0]->{phoneNumber}."&".$page);
		
	} catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}
// update patient
 else if (isset ( $_POST['update'] ))
 {
	 $page_error = "Update Patient";
	 try {
		 $entityUtil = new EntityUtil();
		 $patientId = $_POST['patientId'];
		 $paramArray[0] = $patientId;
		 $patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
		 
		 //Set address in AddressInfo
		 $addressinfo = $patientInfo->{addressInfo};
		 $addressinfo[0]->addressLine1 =  $_POST ["address1"] ;
		 $addressinfo[0]->addressLine2 = $_POST ["address2"] ;
		 $addressinfo[0]->postalCode = $_POST ["zip"] ;
		 $addressinfo[0]->city = $_POST ["city"] ;
		 $addressinfo[0]->stateId = $_POST ["state"] ;
		 $addressinfo[0]->addressType = "BILLING" ;
		 $addressinfo[0]->state = VMCPortalConstants::$UPDATE  ;
		 
		if(isset($_POST ["DeliveryAddress"]))
		{
			$addressinfo[0]->preferred = true ;
			if(count($addressinfo) == 2)
			{
				$addressinfo[1]->state = VMCPortalConstants::$DELETE ;
			}
		}
		else
		{
			$addressinfo[0]->preferred = false ;
			if(count($addressinfo) == 1)
			{
				$addressinfo[1]->state = VMCPortalConstants::$INSERT  ;
				$addressinfo[1]->addressTypeDesc_i18nId = 160 ;
			}
			else
			{
				$addressinfo[1]->state = VMCPortalConstants::$UPDATE  ;
			}
			
			$addressinfo[1]->addressLine1 =  $_POST ["Daddress1"] ;
			$addressinfo[1]->addressLine2 = $_POST ["Daddress2"] ;
			$addressinfo[1]->postalCode = $_POST ["Dzip"] ;
			$addressinfo[1]->city = $_POST ["Dcity"] ;
			$addressinfo[1]->addressType = "DELIVERY" ;
			$addressinfo[1]->stateId = $_POST ["Dstate"] ;
			$addressinfo[1]->preferred = true ;
		}
		 
		 $patientInfo->addressInfo = $addressinfo;

		 //Set PhoneInfo
		 $phoneInfo = $patientInfo->{phoneInfo};
		 $phoneInfo[0]->phoneNumber = str_replace("-","",$_POST ["phone"]);
		 $phoneInfo[0]->phoneType = "BILLING";
		 $phoneInfo[0]->state  = VMCPortalConstants::$UPDATE  ;
		 $phoneInfo[0]->entityId = $patientId;
		 
		if(isset($_POST ["DeliveryPhone"]))
		{
			$phoneInfo[0]->preferred = true ;
			if(count($phoneInfo) == 2)
			{
				$phoneInfo[1]->state = VMCPortalConstants::$DELETE ;
			}
		}
		else
		{
			$phoneInfo[0]->preferred = false ;

			if(count($phoneInfo) == 1)
			{
				$phoneInfo[1]->state = VMCPortalConstants::$INSERT  ;
				$phoneInfo[1]->phoneTypeDesc_i18nId = 159 ;
			}
			else
			{
				$phoneInfo[1]->state = VMCPortalConstants::$UPDATE  ;
			}
			
			$phoneInfo[1]->phoneNumber = str_replace("-","",$_POST ["Dphone"]);
			$phoneInfo[1]->phoneType = "DELIVERY";
			$phoneInfo[1]->preferred = true ;
		}
		 
		 $patientInfo->phoneInfo = $phoneInfo;

		 $patientInfo->entityType = VMCPortalConstants::$ENTITYTYPE_PATIENT ;
		 $patientInfo->primaryDiagnosis = "RN";

		 $emailaddressinfo = $patientInfo->{emailAddressInfo};
		
		 $emailaddressinfo[0]->emailAddress = $_POST ['email'];
		 $emailaddressinfo[0]->emailType = "BILLING";
		 if($emailaddressinfo[0]->{entityId} == NULL)
		 {
			$emailaddressinfo[0]->state = VMCPortalConstants::$INSERT ;
			$emailaddressinfo[0]->emailTypeDesc_18nId = 160;
		 } 
		 else
		 {
		 	$emailaddressinfo[0]->state = VMCPortalConstants::$UPDATE ;
		 }
		if(isset($_POST ["DeliveryEmail"]))
		{
			$emailaddressinfo[0]->preferred = true ;
			if(count($emailaddressinfo) == 2)
			{
				$emailaddressinfo[1]->state = VMCPortalConstants::$DELETE ;
			}
		}
		else
		{
			$emailaddressinfo[0]->preferred = false ;
			
			if(count($emailaddressinfo) == 1)
			{
				$emailaddressinfo[1]->state = VMCPortalConstants::$INSERT  ;
				$emailaddressinfo[1]->emailTypeDesc_18nId = 160;
			}
			else
			{
				$emailaddressinfo[1]->state = VMCPortalConstants::$UPDATE  ;
			}
			
			$emailaddressinfo[1]->emailAddress = $_POST ['Demail'];
			$emailaddressinfo[1]->emailType = "DELIVERY";
			//$emailaddressinfo[1]->emailType = VMCPortalConstants::$EMAIL_TYPE;
			$emailaddressinfo[1]->preferred = true ;
		}
		 
		 $patientInfo->emailAddressInfo = $emailaddressinfo;

		 $paramArray = array();
		 $paramArray[0] = json_encode($patientInfo);
		 $paramArray[1] = json_encode($credential);
		$retPatient = $entityUtil->postObjectToServer($paramArray, "addPatient", VMCPortalConstants::$API_EMR);
		 ?>
		 <script>
		 localStorage.clear();
		 </script>
		 <?php
		
			 header("Location:insurance.php?patientId=".$retPatient->{patientId}."&patientLastName=".$retPatient->{lastName}."&patientFirstName=".$retPatient->{firstName}."&dob=".$retPatient->{dateOfBirth}."&email=".$emailaddressinfo[0]->{emailAddress}."&phone=".$phoneInfo[0]->{phoneNumber}."&type=EDIT");
			 
	 } catch ( Exception $e ) {
		 $msg = $e->getMessage();
	 }
}
?>
