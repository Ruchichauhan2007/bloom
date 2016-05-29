<?php
if(isset($_POST['Delete']))
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
			}
		}


}	
 ?>