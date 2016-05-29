<?php
session_start();
include '../../common/util/VMCAppResource.php';
$patientInsInfo = new stdClass;
$patientRegInfo = new stdClass;
$msg = "";
$entityUtil = new EntityUtil();
if (isset ( $_POST['submit'] )) {
   	$page_error = "self registration insurance";
	try {
		if(!empty($_POST ["patientRegistrationId"]))
		{
			$patientRegInfo->addressLine1 = $_POST ["address1"] ;
			$patientRegInfo->addressLine2 = $_POST ["address2"] ;
			$patientRegInfo->postalCode = $_POST ["zip"] ;
			$patientRegInfo->city = $_POST ["city"] ;
			$patientRegInfo->patientRegistrationId = $_POST ["patientRegistrationId"] ;
			$patientRegInfo->stateId = $_POST ["stateId"];
			$patientRegInfo->preferred = 
			$patientRegInfo->state = VMCPortalConstants::$INSERT;			
		}
	
		$patientInsInfo->groupId =  $_POST ["groupId"] ;
		$patientInsInfo->memberId = $_POST ["memberId"] ;

		$patientInsInfo->patientRegistrationId = $_POST ["patientRegistrationId"] ;
		$patientInsInfo->state = VMCPortalConstants::$INSERT;
		$employerName = $_POST ["employerName"] ;

		$patientInsInfo->stateId = "1";

		$paramArray = array();
		$paramArray[0] = json_encode($patientInsInfo);
		$paramArray[1] = json_encode($patientRegInfo);

		$retpatientInsInfo = $entityUtil->postDataToregisterPatient($employerName,"createUpdatePatientRegWithInsurance",$paramArray, VMCPortalConstants::$API_EMR);
		$retValue = $retpatientInsInfo ->{PatientInsuranceInfo};
		
		unset($_COOKIE["employer"]);
		
		setcookie('employer', null, -1, '/');
		if(isset($_POST ["retPatientId"]) && $_POST ["retPatientId"]>0)
		{
			header("Location:../../login/pages/login_userName.php");
		}
		else
		{
			header("Location:../../login/pages/pendingRegMessage.php");
		}
	} catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}

?>
