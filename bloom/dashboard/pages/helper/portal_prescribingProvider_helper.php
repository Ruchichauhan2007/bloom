<?php
	  $entityUtil = new EntityUtil();

 if (isset ( $_POST['pharmacySave'] )) {
		
		try
		{
			$paramArray = array();
			$paramArray[0] = $_POST["patientId"];
			$prescriptionDetailInfo = $entityUtil->getObjectFromServer($paramArray, "findPrescriptionDetailByPatientId", VMCPortalConstants::$API_EMR);
			if(!$prescriptionDetailInfo)
			{
			$prescriptionDetailInfo = new stdClass;
			$prescriptionDetailInfo->prescriberName = $_POST["Pname"];
			$prescriptionDetailInfo->taxonomies = $_POST["Ptaxonomies"];
			$prescriptionDetailInfo->addressLine1 = $_POST["PaddressLine1"];
			$prescriptionDetailInfo->phoneNumber = $_POST["PphoneNumber"];
			$prescriptionDetailInfo->faxNumber = $_POST["PfaxNumber"];
			$prescriptionDetailInfo->addressLine2 = $_POST["PaddressLine2"];
			$prescriptionDetailInfo->city = $_POST["Pcity"];
			$prescriptionDetailInfo->stateId = $_POST["Pstate"];
			$prescriptionDetailInfo->postalCode = $_POST["PzipCode"];
			$prescriptionDetailInfo->patientId = $_POST["patientId"];
			$prescriptionDetailInfo->prescriberType = "PHARMACY";
			$prescriptionDetailInfo->state = VMCPortalConstants::$INSERT ;
			$paramArray = array();
			$paramArray[0] = json_encode($prescriptionDetailInfo);
			}
			else 
			{
			foreach($prescriptionDetailInfo as $prescription)
			{
				if($prescription->{prescriberType} == "PHARMACY" && $prescription->{prescriptionDetailId} == $_POST["PprescriptionDetailId"])
				{
			
			$prescriptionDetailInfo->prescriberName = $_POST["Pname"];
			$prescriptionDetailInfo->taxonomies = $_POST["Ptaxonomies"];
			$prescriptionDetailInfo->addressLine1 = $_POST["PaddressLine1"];
			$prescriptionDetailInfo->phoneNumber = $_POST["PphoneNumber"];
			$prescriptionDetailInfo->faxNumber = $_POST["PfaxNumber"];
			$prescriptionDetailInfo->addressLine2 = $_POST["PaddressLine2"];
			$prescriptionDetailInfo->city = $_POST["Pcity"];
			$prescriptionDetailInfo->stateId = $_POST["Pstate"];
			$prescriptionDetailInfo->postalCode = $_POST["PzipCode"];
			$prescriptionDetailInfo->patientId = $_POST["patientId"];
			$prescriptionDetailInfo->prescriberType = "PHARMACY";
			$prescription->prescriptionDetailId = $_POST["PprescriptionDetailId"];
			$prescription->state = VMCPortalConstants::$UPDATE ;
			$paramArray = array();
			$paramArray[0] = json_encode($prescription);
				}
				else
				{
					$prescriptionDetailInfo = new stdClass;
			$prescriptionDetailInfo->prescriberName = $_POST["Pname"];
			$prescriptionDetailInfo->taxonomies = $_POST["Ptaxonomies"];
			$prescriptionDetailInfo->addressLine1 = $_POST["PaddressLine1"];
			$prescriptionDetailInfo->phoneNumber = $_POST["PphoneNumber"];
			$prescriptionDetailInfo->faxNumber = $_POST["PfaxNumber"];
			$prescriptionDetailInfo->addressLine2 = $_POST["PaddressLine2"];
			$prescriptionDetailInfo->city = $_POST["Pcity"];
			$prescriptionDetailInfo->stateId = $_POST["Pstate"];
			$prescriptionDetailInfo->postalCode = $_POST["PzipCode"];
			$prescriptionDetailInfo->patientId = $_POST["patientId"];
			$prescriptionDetailInfo->prescriberType = "PHARMACY";
			$prescriptionDetailInfo->state = VMCPortalConstants::$INSERT ;
			$paramArray = array();
			$paramArray[0] = json_encode($prescriptionDetailInfo);
				}
			}
			}
			
			
			
			$retPrescriptionDetailInfo = $entityUtil->postObjectToServer($paramArray, "createUpdatePrescriptionDetail", VMCPortalConstants::$API_EMR);
			header("Location:portal_prescribingProvider.php?patientId=".$_POST['patientId']."&type=EDIT&edit=true");
			
		} 
		catch ( Exception $e ) 
		{
			$msg = $e->getMessage();
		}
	}

if (isset ( $_POST['doctorSave'] )) {
		
		try
		{
			$paramArray = array();
			$paramArray[0] = $_POST["patientId"];
			$prescriptionDetailInfo = $entityUtil->getObjectFromServer($paramArray, "findPrescriptionDetailByPatientId", VMCPortalConstants::$API_EMR);
			if(!$prescriptionDetailInfo)
			{
			$prescriptionDetailInfo = new stdClass;
			$prescriptionDetailInfo->prescriberName = $_POST["name"];
			$prescriptionDetailInfo->taxonomies = $_POST["taxonomies"];
			$prescriptionDetailInfo->addressLine1 = $_POST["address"];
			$prescriptionDetailInfo->phoneNumber = $_POST["phoneNumber"];
			$prescriptionDetailInfo->faxNumber = $_POST["faxNumber"];
			$prescriptionDetailInfo->addressLine2 = $_POST["addressLine2"];
			$prescriptionDetailInfo->city = $_POST["city"];
			$prescriptionDetailInfo->stateId = $_POST["state"];
			$prescriptionDetailInfo->postalCode = $_POST["zip"];
			$prescriptionDetailInfo->patientId = $_POST["patientId"];
			$prescriptionDetailInfo->prescriberType = "DOCTOR";
			$prescriptionDetailInfo->state = VMCPortalConstants::$INSERT ;
			$prescriptionDetailInfo->nPINumber = $_POST["npiNumber"];
			$paramArray = array();
			$paramArray[0] = json_encode($prescriptionDetailInfo);
			}
			else
			{
			foreach($prescriptionDetailInfo as $prescription)
			{
				if($prescription->{prescriberType} == "DOCTOR" && $prescription->{prescriptionDetailId} == $_POST["DprescriptionDetailId"])
				{
			
			$prescription->prescriberName = $_POST["name"];
			$prescription->taxonomies = $_POST["taxonomies"];
			$prescription->addressLine1 = $_POST["address"];
			$prescription->phoneNumber = $_POST["phoneNumber"];
			$prescription->faxNumber = $_POST["faxNumber"];
			$prescription->addressLine2 = $_POST["addressLine2"];
			$prescription->city = $_POST["city"];
			$prescription->stateId = $_POST["state"];
			$prescription->postalCode = $_POST["zip"];
			$prescription->patientId = $_POST["patientId"];
			$prescription->prescriberType = "DOCTOR";
			$prescription->prescriptionDetailId = $_POST["DprescriptionDetailId"];
			$prescription->state = VMCPortalConstants::$UPDATE ;
			$prescription->nPINumber = $_POST["npiNumber"];
			$paramArray = array();
			$paramArray[0] = json_encode($prescription);
				}
				else
				{
					$prescriptionDetailInfo = new stdClass;
			$prescriptionDetailInfo->prescriberName = $_POST["name"];
			$prescriptionDetailInfo->taxonomies = $_POST["taxonomies"];
			$prescriptionDetailInfo->addressLine1 = $_POST["address"];
			$prescriptionDetailInfo->phoneNumber = $_POST["phoneNumber"];
			$prescriptionDetailInfo->faxNumber = $_POST["faxNumber"];
			$prescriptionDetailInfo->addressLine2 = $_POST["addressLine2"];
			$prescriptionDetailInfo->city = $_POST["city"];
			$prescriptionDetailInfo->stateId = $_POST["state"];
			$prescriptionDetailInfo->postalCode = $_POST["zip"];
			$prescriptionDetailInfo->patientId = $_POST["patientId"];
			$prescriptionDetailInfo->prescriberType = "DOCTOR";
			$prescriptionDetailInfo->state = VMCPortalConstants::$INSERT ;
			$prescriptionDetailInfo->nPINumber = $_POST["npiNumber"];
			$paramArray = array();
			$paramArray[0] = json_encode($prescriptionDetailInfo);
				}
			}
			}
			
			
			
			$retPrescriptionDetailInfo = $entityUtil->postObjectToServer($paramArray, "createUpdatePrescriptionDetail", VMCPortalConstants::$API_EMR);
			header("Location:portal_addSupplies.php?patientId=".$_POST['patientId']."&type=EDIT&edit=true");
	
		} 
		catch ( Exception $e ) 
		{
			$msg = $e->getMessage();
		}
	}

 if (isset ( $_POST['insert'] )) {
		$prescriptionInfo = new stdClass;
		$msg = "";
	 	$entityUtil = new EntityUtil();
		$dateUtil = new DateUtil();
		$page_error = "Add rxDetail";
		$page="insert";
		try {
			
			$prescriptionInfo->rxFileName = "sample.pdf";
			$prescriptionInfo->frequency = $_POST ['frequency'];
			$prescriptionInfo->length = $_POST ['length'] ;
			$acquiredDate = $_POST ['acquiredDate'];
	
			$pos = strpos($acquiredDate, "/");
	
			if($pos === FALSE)
			{
				$dateArray = explode("-", $acquiredDate);
			}
			else
			{
				$dateArray = explode("/", $acquiredDate);
			}
	
			$acquiredDate = $dateArray[2]."-".$dateArray[0]."-".$dateArray[1];
			$calendarAcquiredDate  = new DateTime($acquiredDate);
			$calendarAcquiredDate = $calendarAcquiredDate->format('Y-m-d\TH:i:s.\0\0\0O\Z');
			
			$renewalDate = $_POST ['renewalDate'];
	
			$pos = strpos($renewalDate, "/");
	
			if($pos === FALSE)
			{
				$dateArray = explode("-", $renewalDate);
			}
			else
			{
				$dateArray = explode("/", $renewalDate);
			}
	
			$renewalDate = $dateArray[2]."-".$dateArray[0]."-".$dateArray[1];
			$calendarRenewalDate  = new DateTime($renewalDate);
			$calendarRenewalDate = $calendarRenewalDate->format('Y-m-d\TH:i:s.\0\0\0O\Z');
			
			$prescriptionInfo->renewalDate = $calendarRenewalDate ;
			$prescriptionInfo->prescriptionDate = $calendarAcquiredDate ;
			$prescriptionInfo->patientId = $_POST ['patientId'];
			$prescriptionInfo->prescriberID = $_POST ['userId'];
	
			$prescriptionInfo->state = VMCPortalConstants::$INSERT ;
			
			$paramArray = array();
			$paramArray[0] = json_encode($prescriptionInfo);
			$retPrescription = $entityUtil->postObjectToServer($paramArray, "createUpdatePrescription", VMCPortalConstants::$API_EMR);
			} 
			catch ( Exception $e ) {
			
			$msg = $e->getMessage();
		}
	}


 if (isset ( $_POST['update'] )) {
	
		$dateUtil = new DateUtil();
		$entityUtil = new EntityUtil();
		$page_error = "Update rxDetail";
		$page="update";
		try {
		
				$patientId = $_POST ['patientId'];
				 $paramArray = array() ;
				$paramArray[0] = $patientId;
				$getAllPrescription = $entityUtil->getObjectFromServer($paramArray, "getAllPrescriptionByPatientId", VMCPortalConstants::$API_EMR);
				
				foreach($getAllPrescription as $getPrescription)
			   {	
					if($getPrescription->{prescriptionId} == $_POST ['prescriptionId'])
					{
					
						$getPrescription->rxFileName = $_POST ['newFileName'];
						$getPrescription->frequency = $_POST ['frequency'];
						$getPrescription->length = $_POST ['length'] ;
						$getPrescription->numberOfRefills = $_POST ['noOfRefills'] ;
						$getPrescription->refillsAllowed = $_POST ['refillAllowed'] ;
						$acquiredDate = $_POST ['acquiredDate'];
				
						$pos = strpos($acquiredDate, "/");
				
						if($pos === FALSE)
						{
							$dateArray = explode("-", $acquiredDate);
						}
						else
						{
							$dateArray = explode("/", $acquiredDate);
						}
				
						$acquiredDate = $dateArray[2]."-".$dateArray[0]."-".$dateArray[1];
						$calendarAcquiredDate  = new DateTime($acquiredDate);
						$calendarAcquiredDate = $calendarAcquiredDate->format('Y-m-d\TH:i:s.\0\0\0O\Z');
						
						$renewalDate = $_POST ['renewalDate'];
				
						$pos = strpos($renewalDate, "/");
				
						if($pos === FALSE)
						{
							$dateArray = explode("-", $renewalDate);
						}
						else
						{
							$dateArray = explode("/", $renewalDate);
						}
				
						$renewalDate = $dateArray[2]."-".$dateArray[0]."-".$dateArray[1];
						$calendarRenewalDate  = new DateTime($renewalDate);
						$calendarRenewalDate = $calendarRenewalDate->format('Y-m-d\TH:i:s.\0\0\0O\Z');
						
						$getPrescription->renewalDate = $calendarRenewalDate ;
						$getPrescription->prescriptionDate = $calendarAcquiredDate ;
						$getPrescription->prescriptionId = $_POST ['prescriptionId'];
						$getPrescription->patientId = $_POST ['patientId'];
						$getPrescription->prescriberID = $_POST ['userId'];
				
						$getPrescription->state = VMCPortalConstants::$UPDATE ;
						
						$paramArray = array();
						$paramArray[0] = json_encode($getPrescription);
						$retPrescription = $entityUtil->postObjectToServer($paramArray, "createUpdatePrescription", VMCPortalConstants::$API_EMR);
					}
					
				}
			} 
			catch ( Exception $e ) {
			
			$msg = $e->getMessage();
		}
}


	 if (isset ($_POST['Delete']))
	 {
	 			$entityUtil = new EntityUtil();
				$dateUtil = new DateUtil();
				
				$patientId = $_REQUEST ['patientId'];
				 $paramArray = array() ;
				$paramArray[0] = $patientId;
				$getAllPrescription = $entityUtil->getObjectFromServer($paramArray, "getAllPrescriptionByPatientId", VMCPortalConstants::$API_EMR);
				
				foreach($getAllPrescription as $getPrescription)
			   {	
					if($getPrescription->{prescriptionId} == $_REQUEST ['deleteRxId'])
					{
						//$getPrescription = new stdClass;
						$getPrescription->prescriptionId = $_REQUEST['deleteRxId'];
						$getPrescription->renewalDate = $_REQUEST['renewalDate1'];
						$getPrescription->prescriptionDate = $_REQUEST['acquireDate1'];
						$getPrescription->prescriberID = $_REQUEST['userId'];
						$getPrescription->rxFileName = "sample.pdf";
						$getPrescription->frequency = $_POST ['frequency1'];
						$getPrescription->length = $_POST ['length1'] ;
						$getPrescription->state = VMCPortalConstants::$DELETE;
						
					$paramArray = array();
					$paramArray[0] = json_encode($getPrescription);
					$retPrescription = $entityUtil->postObjectToServer($paramArray, "createUpdatePrescription", VMCPortalConstants::$API_EMR);
				}
			}
	}
	
	// start
if($_POST['deleteFaxId'])
{

		$deleteFaxId=$_POST['deleteFaxId'];
		$patientId=$_POST['patientId'];
 		$entityUtil = new EntityUtil();
		$dateUtil = new DateUtil();
			
			$patientId = $_REQUEST ['patientId'];
			 $paramArray = array() ;
			$paramArray[0] = $patientId;
			$getAllPatientFaxes = $entityUtil->getObjectFromServer($paramArray, "getAllPatientFaxes", VMCPortalConstants::$API_EMR);
			
		   foreach($getAllPatientFaxes as $getPatientFaxes)
		   {	
				if($getPatientFaxes->{patientFaxId} == $_REQUEST ['deleteFaxId'])
				{
					//$getPrescription = new stdClass;
					$getPatientFaxes->patientFaxId = $_REQUEST['deleteFaxId'];
					$getPatientFaxes->state = VMCPortalConstants::$UPDATE;
					$getPatientFaxes->patientId = 0 ;
					$paramArray = array();
					$paramArray[0] = json_encode($getPatientFaxes);
					$retPrescription = $entityUtil->postObjectToServer($paramArray, "createUpdatePatientFax", VMCPortalConstants::$API_EMR);
					header("Location:portal_prescribingProvider.php?patientId=".$_POST['patientId']."&type=EDIT&edit=true");
					
			}
		}


}	
// end
	
?>
