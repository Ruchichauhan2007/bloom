<?php
$categoryFilter = "";
$cardType = "";
$reviewed = "";
$categoryFilter = $_REQUEST["categoryFilter"];
$cardType = $_REQUEST["cardType"];
$reviewed = $_REQUEST["reviewed"];


$dashboardCardFilterInfo = new stdClass;
$endDate = "";
$startDate = "";
	try
	{
				$msg = "";
		$entityUtil = new EntityUtil();
		$patientUtil = new PatientUtil();
		$patientId = "";

		// get Patient from context
		if(isset($_POST["searchCard"]))
		{
			
			$categoryFilter = $_REQUEST["categoryFilter"];
			$cardType = $_REQUEST["cardType"];
			$reviewed = $_REQUEST["reviewed"];

			$endDate = $_POST["endDate"];
			$startDate = $_POST["startDate"];
			if($endDate == "")
			{
				$endDate = date("m/d/Y");
			}
			if($startDate == "")
			{
				$date = strtotime($endDate."-7 day");
				$startDate = date('M d, Y', $date);
			}
				$pos = strpos($startDate, "/");
			if($pos === FALSE)
			{
				$dateArray = explode("-", $startDate);
			}
			else
			{
				$dateArray = explode("/", $startDate);
			}

			$startDate = $dateArray[2]."-".$dateArray[0]."-".$dateArray[1];
			$calendarstartDate  = new DateTime($startDate);
			$calendarstartDate = $calendarstartDate->format('Y-m-d\TH:i:s.\0\0\0O\Z');		
			$pos = strpos($endDate, "/");
	
			if($pos === FALSE)
			{
				$dateArray = explode("-", $endDate);
			}
			else
			{
				$dateArray = explode("/", $endDate);
			}

			$endDate = $dateArray[2]."-".$dateArray[0]."-".$dateArray[1];
			$calendarEndDate  = new DateTime($endDate);
			$calendarEndDate = $calendarEndDate->format('Y-m-d\TH:i:s.\0\0\0O\Z');
			$dashboardCardFilterInfo->startDate = $calendarstartDate;
			$dashboardCardFilterInfo->endDate = $calendarEndDate;
		}
			
					/*$pageInfo = new stdClass;
			$filterInfo = new stdClass;
			$pageInfo->currentPageNo = 1;	
			$pageInfo->recordsPerPage = VMCPortalConstants::$RECORDS_PER_PAGE;*/

		if(isset($_COOKIE['type']) AND strtoupper($_COOKIE['type']) == "PATIENT")
		{
			$dashboardCardFilterInfo->entityType = "PATIENT";
			$dashboardCardFilterInfo->patientId = $_COOKIE['id'];
			$dashboardCardFilterInfo->cardFilterType[0] = $cardType;
			$dashboardCardFilterInfo->dashCardFilterCategory = "Select a Patient";
			$dashboardCardFilterInfo->reviewed = $reviewed;
			$paramArray = array();
			$paramArray[0] = json_encode($dashboardCardFilterInfo);
			//var_dump($paramArray);
			$dashboardCards = $entityUtil->getObjectFromServer($paramArray, "getDashboardCardsByFilter", VMCPortalConstants::$API_ADMIN);
			$moveNext = $dashboardCards[4]->{nextPage};
			//var_dump($dashboardCards);
		?><script>
		$("#getScroll").val('<?php echo $moveNext; ?>');
		$("#nextButton").val('<?php echo $moveNext; ?>');

		</script>
		<?php
		}
		else
		{
			$dashboardCardFilterInfo->entityType = "PROVIDER";
			$dashboardCardFilterInfo->providerId = $_COOKIE['id'];
			$dashboardCardFilterInfo->cardFilterType[0] = $cardType;
			$dashboardCardFilterInfo->dashCardFilterCategory = $categoryFilter;
			$dashboardCardFilterInfo->reviewed = $reviewed;
			if($categoryFilter == "Select a Patient")
			{
				$patientId =  $_REQUEST["contextPId"];
				$dashboardCardFilterInfo->patientId = $patientId;
			}
			$paramArray = array();
			$paramArray[0] = json_encode($dashboardCardFilterInfo);
			//var_dump($paramArray);
			$dashboardCards = $entityUtil->getObjectFromServer($paramArray, "getDashboardCardsByFilter", VMCPortalConstants::$API_ADMIN);
			//var_dump($dashboardCards);
			$moveNext = $dashboardCards[4]->{nextPage};
		?><script>
		$("#getScroll").val('<?php echo $moveNext; ?>');
		$("#nextButton").val('<?php echo $moveNext; ?>');
		</script>
		<?php
		}

	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}

?>