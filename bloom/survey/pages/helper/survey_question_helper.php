<?php
	if(isset($_POST['finish']))
	{
			
		try
		{
				
			$entityUtil = new EntityUtil();
			$paramArray = array();
			
			foreach($survey as $surveyHeader)
			{
					
				$count=0;
			    $surveyDetailsArray = array();
				if($surveyHeader->{surveyHeaderId} == $_REQUEST["surveyHeaderId"])
				{
					$surveyDetailsArray = $surveyHeader->{surveyDetailsInfo};	
					foreach($surveyDetailsArray as $surveyDetails)
					{		
						$surveyDetails->response =$_REQUEST["question".$count];
						$surveyDetails->state = VMCPortalConstants::$UPDATE ;
						$surveyHeader->surveyDetailsInfo[$count] = $surveyDetails;
						
						$count++;
						
				   }
				   
				}
				$surveyHeader->comments = $_REQUEST["comment"];
				$surveyHeader->state = VMCPortalConstants::$UPDATE ;
			}
			$paramArray[0] = json_encode($surveyHeader);
			//var_dump($surveyHeader);
			$surveyResp = $entityUtil->postObjectToServer($paramArray, "createUpdateSurvey", VMCPortalConstants::$API_ADMIN);
			header("location:survey_completed.php");
		}
		
		catch(Exception $e)
		{
			$msg = $e->getMessage();
		}
	}
?>