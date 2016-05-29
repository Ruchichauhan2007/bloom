<?php
$msg = "";
if(isset($_POST["faxDoctor"]))
{
//echo "11111";
	try
	{
		$faxPrescriptionInfo = new stdClass;
		$physicianInfo = new stdClass;
		$faxPatientInfo = new stdClass;
		$patAddress = new stdClass;
		
		$paramArray = array();
		$entityUtil = new EntityUtil();
		$paramArray[0] = $_POST['patientId'];
		$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
		
		
		$faxPrescriptionInfo->patientInfo = $patientInfo;
		
		$addressinfo = new stdClass;
		$addressinfo->addressLine1 =  $_POST ["address"] ;
		$addressinfo->addressLine2 = $_POST ["addressLine2"] ;
		$addressinfo->postalCode = $_POST ["zip"] ;
		$addressinfo->city = $_POST ["city"] ;
		$addressinfo->stateId = $_POST ["state"] ;
		$physicianInfo->addressInfo = $addressinfo;
	
		$name = explode(" ",$_POST['name']);
		$physicianInfo->lastName=$name[1];	
		$physicianInfo->firstName=$name[0];
		$physicianInfo->phone = $_POST['phoneNumber'];
		$physicianInfo->fax = $_POST['faxNumber'];
		//$physicianInfo->fax =  "888-871-1878";   // This has to be removed Once we will go LIVE - FAX NUMBER
		$physicianInfo->npi =  $_POST['npiNumber'];
		$physicianInfo->upin =  "F80674";	// This has to be removed Once we will go LIVE - FAX NUMBER
		$faxPrescriptionInfo->physicianInfo = $physicianInfo;
		
		$faxPrescriptionInfo->initiatedBy = $_COOKIE["userName"];
		$faxPrescriptionInfo->type = "BGM";
		
		$faxPrescriptionInfo->state =  VMCPortalConstants::$INSERT;
		
			
		
		$entityUtil = new EntityUtil();
		$paramArray = array();
		$paramArray[0] = json_encode($faxPrescriptionInfo);
		//var_dump($paramArray);
		$sendFax = $entityUtil->postObjectToServer($paramArray, "sendFax", VMCPortalConstants::$API_EMR);
		$msg = "Fax sent successfully";
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
	
}


if(isset($_POST["pharmacyFax"]))
{
//echo "11111";
	try
	{
		$faxPrescriptionInfo = new stdClass;
		$physicianInfo = new stdClass;
		$faxPatientInfo = new stdClass;
		$patAddress = new stdClass;
		
		$paramArray = array();
		$entityUtil = new EntityUtil();
		$paramArray[0] = $_POST['patientId'];
		$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
		
		
		$faxPrescriptionInfo->patientInfo = $patientInfo;
		
		$addressinfo = new stdClass;
		$addressinfo->addressLine1 =  $_POST ["Paddress"] ;
		$addressinfo->addressLine2 = $_POST ["PaddressLine2"] ;
		$addressinfo->postalCode = $_POST ["Pzip"] ;
		$addressinfo->city = $_POST ["Pcity"] ;
		$addressinfo->stateId = $_POST ["Pstate"] ;
		$physicianInfo->addressInfo = $addressinfo;
	
		$name = explode(" ",$_POST['Pname']);
		$physicianInfo->lastName=$name[1];	
		$physicianInfo->firstName=$name[0];
		$physicianInfo->phone = $_POST['PphoneNumber'];
		$physicianInfo->fax = $_POST['PfaxNumber'];
		//$physicianInfo->fax =  "888-871-1878";   // This has to be removed Once we will go LIVE - FAX NUMBER
		$physicianInfo->npi =  $_POST['PnpiNumber'];
		$physicianInfo->upin =  "F80674";	// This has to be removed Once we will go LIVE - FAX NUMBER
		$faxPrescriptionInfo->physicianInfo = $physicianInfo;
		
		$faxPrescriptionInfo->initiatedBy = $_COOKIE["userName"];
		$faxPrescriptionInfo->type = "BGM_PHARMA";
		
		$faxPrescriptionInfo->state =  VMCPortalConstants::$INSERT;
		
			
		
		$entityUtil = new EntityUtil();
		$paramArray = array();
		$paramArray[0] = json_encode($faxPrescriptionInfo);
		//var_dump($paramArray);
		$sendFax = $entityUtil->postObjectToServer($paramArray, "sendFax", VMCPortalConstants::$API_EMR);
		$msg = "Fax sent successfully";
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
	
}
?>