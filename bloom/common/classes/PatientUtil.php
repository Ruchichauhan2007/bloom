<?php
class PatientUtil {
 
	function getPatientIdFromContext() {
		if(!is_null($_POST['contextPId']))
		{
			$patientId = $_POST['contextPId']; 
		}

		if($patientId)
		{
			return $patientId;
		}
		
		return FALSE;
	}
	
	function getLoggedInEntityId() {
		if(!is_null($_COOKIES['type']))
		{
			$patientType = $_COOKIE['Type']; 
		}

		if($patientType)
		{
			return $patientType;
		}
		
		return FALSE;
	}
	
}
?>
