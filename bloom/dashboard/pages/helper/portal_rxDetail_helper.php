<?php
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
		$prescriptionInfo->prescriberID = $_POST ['prescriberId'];

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
					$getPrescription->prescriberID = $_POST ['prescriberId'];
			
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
?>
