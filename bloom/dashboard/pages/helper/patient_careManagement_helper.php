<?php
	if (isset($_POST['saveRisk']))
	 {
		$page_error = "Change Risk";
		$page="Update";
		$msg = "";
		try 
		{
			$entityUtil = new EntityUtil();
			$patientId = $_POST['patientId'];
			$paramArray[0] = $patientId;
			$getRiskEscalation = $entityUtil->getObjectFromServer($paramArray, "getRiskEscalationByPatientId", VMCPortalConstants::$API_EMR);
			if($getRiskEscalation == "")
			{
				$getRiskEscalation = new stdClass;
				$getRiskEscalation->state = VMCPortalConstants::$INSERT ;
			}
			else
			{
				$getRiskEscalation->state = VMCPortalConstants::$UPDATE ;
			}
			
			$getRiskEscalation->patientId = $_POST ['patientId'];
			$getRiskEscalation->comment = $_POST ['comment'];
			$getRiskEscalation->editUserId = $_COOKIE["id"];
			$getRiskEscalation->escalated = $_POST ['escalated'];
			$getRiskEscalation->risk = $_POST ['risk'];
			$getRiskEscalation->aTI = $_POST ['ati'];
			
			
			
			$paramArray = array();
			$paramArray[0] = json_encode($getRiskEscalation);
			$retPatient = $entityUtil->postObjectToServer($paramArray, "createUpdateRiskEscalation", VMCPortalConstants::$API_EMR);
			header("Location:portal_careManagement.php?patientId=".$patientId);
		} 
		catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
		}
}
// Care Plan
if (isset($_POST['saveCare']))
	 {
		$page_error = "Change Care Plan";
		$page="Update";
		$msg = "";
		try 
		{
			$entityUtil = new EntityUtil();
			$patientId = $_POST['patientId'];
			$paramArray[0] = $patientId;
			$oldActionPlan = $entityUtil->getObjectFromServer($paramArray, "findPatientActionPlanByPatientId", VMCPortalConstants::$API_EMR);
				
				if(!is_null($oldActionPlan))
				{
					$patActionPlan = $oldActionPlan;
					$patActionPlan->providerId = $entityUtil->getLoggedInEntityId();
					$patActionPlan->goals = $_POST ['carePlan'];
					$patActionPlan->state = VMCPortalConstants::$UPDATE;
				}
				else
				{
					$patActionPlan->patientId = $_POST['patientId'];
					$patActionPlan->providerId = $entityUtil->getLoggedInEntityId();
					$patActionPlan->goals = $_POST ['carePlan'];
					$patActionPlan->state = VMCPortalConstants::$INSERT;
				}
				
				
				
				$paramArray = array() ;
				$paramArray[0] = json_encode($patActionPlan);

				$patActionPlan=$entityUtil->postObjectToServer($paramArray, "createUpdatePatientActionPlan", VMCPortalConstants::$API_EMR);
			    header("Location:portal_careManagement.php?patientId=".$patientId);
		} 
		catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
		}
}
?>