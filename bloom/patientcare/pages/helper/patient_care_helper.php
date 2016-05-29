<?php
	if (isset( $_POST['submit'] ))
	{
		$page_error = "Patient Care";		
		
		try {
				$page = $_POST ['page'];
				$entityUtil = new EntityUtil();
				$patientUtil = new PatientUtil();
				$patActionPlan = new stdClass;
				$observation = new stdClass;
				$notes = new stdClass;
				
			if($page === "PATIENT_CARE")
			{
				$paramArray = array() ;
				$paramArray[0] = $patientUtil->getPatientIdFromContext();
				
				$oldActionPlan = $entityUtil->getObjectFromServer($paramArray, "findPatientActionPlanByPatientId", VMCPortalConstants::$API_EMR);
				
				if(!is_null($oldActionPlan))
				{
					$patActionPlan = $oldActionPlan;
					$patActionPlan->providerId = $entityUtil->getLoggedInEntityId();
					$patActionPlan->goals = $_POST ['patient_care_title'];
					$patActionPlan->state = VMCPortalConstants::$UPDATE;
				}
				else
				{
					$patActionPlan->patientId = $patientUtil->getPatientIdFromContext();
					$patActionPlan->providerId = $entityUtil->getLoggedInEntityId();
					$patActionPlan->goals = $_POST ['patient_care_title'];
					$patActionPlan->state = VMCPortalConstants::$INSERT;
				}
				
				
				
				$paramArray = array() ;
				$paramArray[0] = json_encode($patActionPlan);

				$patActionPlan=$entityUtil->postObjectToServer($paramArray, "createUpdatePatientActionPlan", VMCPortalConstants::$API_EMR);
			}
			else if($page === "OBSERVATION")
			{
				$observation->patientId = $patientUtil->getPatientIdFromContext();
				$observation->userId= $entityUtil->getLoggedInEntityId();
				$observation->editUserId= $entityUtil->getLoggedInEntityId();
				$observation->description  = $_POST ['observation_title'];
				$observation->state = VMCPortalConstants::$INSERT;	
				$observation->noteType = "OBSERVATION" ;
				$entityUtil = new EntityUtil();
				$paramArray = array() ;
				$paramArray[0] = json_encode($observation);
				$observation=$entityUtil->postObjectToServer($paramArray, "createUpdateStickyNote", VMCPortalConstants::$API_EMR);
				
			}
			else
			{
				if(isset($_POST['draftId']) && !empty($_POST['draftId']))
				{	
					$notes->draftId = $_POST ['draftId'];
					$notes->state = VMCPortalConstants::$UPDATE;
				}
				else
				{
					$notes->state = VMCPortalConstants::$INSERT;
				}
				if(strtoupper($_COOKIE['type']) == "PATIENT")
					{
					 $notes->patientId = $entityUtil->getLoggedInEntityId();
					}
					else
					{
					 $notes->patientId = $patientUtil->getPatientIdFromContext();
					}	
				$notes->entityId = $entityUtil->getLoggedInEntityId();
				$notes->draftData = $_POST ['notes_description'];
				
				
				$entityUtil = new EntityUtil();
				$paramArray = array() ;
				$paramArray[0] = json_encode($notes);
				$notes=$entityUtil->postObjectToServer($paramArray, "createUpdateDraft", VMCPortalConstants::$API_EMR);
				
			}	
				
				
		} 
		catch ( Exception $e ) 
		{
			$msg = $e->getMessage ();
		}
	}
?>