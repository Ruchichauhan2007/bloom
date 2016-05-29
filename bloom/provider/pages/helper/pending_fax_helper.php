<?php
if(isset($_POST["assign"]))
{
	try
	{
		$entityUtil = new EntityUtil();
		$paramArray = array() ;
		$paramArray[0] = $_POST ['faxId'];
		$paramArray[1] = $_POST ['patientId'];
		$assignPendingFax = $entityUtil->getObjectFromServer($paramArray, "assignPendingFax", VMCPortalConstants::$API_EMR);
		$msg = "Fax successfully assigned to patient";
		//Reload Page
		$endDate = date("m/d/Y");
		$date = strtotime("-7 day");
		$startDate = date('M d, Y', $date);
		$faxFilterType = "Pending Faxes";
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
		
		//$patientUtil = new PatientUtil();
		$getpatientId = $_POST["getpatientId"];
		
		if($getpatientId)
		{
			$faxFilterInfo->patientId = $getpatientId;
		}
		$faxFilterInfo->faxFilterType = $faxFilterType;
		$faxFilterInfo->startDate = $calendarstartDate;
		$faxFilterInfo->endDate = $calendarEndDate;
		
		
		$paramArray = array();
		$paramArray[0] = json_encode($faxFilterInfo);
		$getAllPendingFaxes = $entityUtil->getObjectFromServer($paramArray, "getAllFaxes", VMCPortalConstants::$API_EMR);

		$moveNext = $getAllPendingFaxes[4]->{nextPage};
		?><script>
		$("#nextButton").val('<?php echo $moveNext; ?>');
		</script>
		<?php
		//var_dump($getAllPendingFaxes);
	}
	catch ( Exception $e ) {
		
		$msg = $e->getMessage();
	}
}
else
{
$entityUtil = new EntityUtil();
$faxFilterInfo = new stdClass;

$startDate = "";
$endDate = "";
$faxFilterType = "";
if(isset($_POST["searchFax"]))
{
		$faxFilterType = $_POST["faxes"];
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
}	
else
{
	$endDate = date("m/d/Y");
	$date = strtotime("-7 day");
	$startDate = date('M d, Y', $date);
	$faxFilterType = "Pending Faxes";

}	
	try
	{
	
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
		
		//$patientUtil = new PatientUtil();
		$getpatientId = $_POST["getpatientId"];
		
		if($getpatientId)
		{
			$faxFilterInfo->patientId = $getpatientId;
		}
		$faxFilterInfo->faxFilterType = $faxFilterType;
		$faxFilterInfo->startDate = $calendarstartDate;
		$faxFilterInfo->endDate = $calendarEndDate;
		
		
		$paramArray = array();
		$paramArray[0] = json_encode($faxFilterInfo);
		$getAllPendingFaxes = $entityUtil->getObjectFromServer($paramArray, "getAllFaxes", VMCPortalConstants::$API_EMR);

		$moveNext = $getAllPendingFaxes[4]->{nextPage};
		?><script>
		$("#nextButton").val('<?php echo $moveNext; ?>');
		</script>
		<?php
		//var_dump($getAllPendingFaxes);
	
		

	}
	catch ( Exception $e ) {
		
		$msg = $e->getMessage();
	}
}
?>