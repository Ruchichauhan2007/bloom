<?php
$surveyId = $_REQUEST['surveyId'];
$patientId = $_REQUEST['patientId'];
$uniqueSurveyId = $_REQUEST['uniqueSurveyId'];

		try
		{
			$entityUtil = new EntityUtil();
			$msg = "";
			
			if($_COOKIE['type'] == 'Patient' or $_COOKIE['type'] == 'PATIENT' or $_COOKIE['type'] == 'patient')
			{
				$patientId = $entityUtil->getLoggedInEntityId();
			}
			else
			{
				$patientId = $_REQUEST['patientId'];
			}
				//$paramArray array();
				$paramArray[0] = $patientId;			
				$survey = $entityUtil->getObjectFromServer($paramArray, "getPatientSurveys", VMCPortalConstants::$API_ADMIN);
		
		}
		catch(Exception $e)
		{
			$msg = $e->getMessage();
		}
		
if(isset($_POST['Reviewed']))
{
	$surveyId = $_POST['surveyId'];
	$patientId = $_POST['patientId'];
	$reviewed = $_POST['Reviewed'];
	$uniqueSurveyId = $_POST['uniqueSurveyId'];

	try
		{
			foreach($survey as $eachSurvey)
			{
				$m_SurveySummary = new stdClass;
				if($eachSurvey->{surveyId} == $_REQUEST['surveyId'])
				{
					$entityUtil = new EntityUtil();					
					$pages = $eachSurvey->surveySummary->{summaryPages};
					$m_SurveySummary->summaryPages = $pages;
					$m_SurveyResponseInfo->surveySummary = $m_SurveySummary;
					$m_SurveyResponseInfo->patientId = $patientId;
					$m_SurveyResponseInfo->survey_id = $surveyId;
					$m_SurveyResponseInfo->uniqueSurveyId = $uniqueSurveyId;

					$m_SurveyResponseInfo->surveyStatus  = $reviewed;
					$m_SurveyResponseInfo->state  = VMCPortalConstants::$UPDATE;
					$m_SurveyResponseInfo->reviewComplete = true;
								
					$paramArray = array();			
					$paramArray[0] = json_encode($m_SurveyResponseInfo);
					
					$responseInfo = $entityUtil->postObjectToServer($paramArray, "UpdatePatientSurvey", VMCPortalConstants::$API_ADMIN);
					header("Location:survey.php?patientId=".$patientId."&surveyId=".$surveyId."&uniqueSurveyId=".$uniqueSurveyId);
					//echo "success";
				}
			}
		}
		catch(Exception $e)
		{
			$msg = $e->getMessage();
		}




}		
			
?>