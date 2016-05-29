<?php
	$entityUtil = new EntityUtil();
	$fetched = false;

	try
	{
		$msg = "";
		$paramArray =array();
		$pendingApplicant = $entityUtil->getObjectFromServer($paramArray, "getPendingApplicantList", VMCPortalConstants::$API_EMR);
		$fetched = true;
		$command = $_REQUEST['command'];
		if($command != null)
		{
			$paramArray =array();
			$registrantId = $_REQUEST['registrantId'];
			if(isset($registrantId))
			{
				$selectedApplicant = "";
				foreach($pendingApplicant as $pendingApp)
				{
					$registrationInfo = $pendingApp->patientRegistrationInfo;
					

					if($registrationInfo->patientRegistrationId == $registrantId)
					{
						$selectedApplicant = $pendingApp;
					}
				}
				if($selectedApplicant != "")
				{
					if($command  == "insert")
					{
						if ($registrationInfo->patientId != "" )
						{
							$selectedApplicant->state = VMCPortalConstants::$UPDATE;
						}
						else
						{
						$selectedApplicant->state = VMCPortalConstants::$INSERT;
						}
					}
					elseif ($command == "delete")
					{
						$selectedApplicant->state = VMCPortalConstants::$DELETE;
					}
					else
					{
						
					}
					
					$paramArray[0] = json_encode($selectedApplicant);
					$retPatient = $entityUtil->postObjectToServer($paramArray, "createPatientForApplicant", VMCPortalConstants::$API_EMR);

					if($command  == "insert")
					{
						
						header("location:../../dashboard/pages/portal_addPatient.php?edit=true&patientId=".$retPatient);
						
						
					}
				}

			}
		}

	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}


?>