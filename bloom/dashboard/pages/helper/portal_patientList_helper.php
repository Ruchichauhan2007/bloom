<?php
 $entityUtil = new EntityUtil();
if (isset ( $_POST['delete'] ))
{
	try
	{
		$msg = "Delete Patient";
		$patientId = $_POST['patientId'];
		$paramArray[0] = $patientId;
		$entityUtil->getObjectFromServer($paramArray, "deletePatient", VMCPortalConstants::$API_EMR);
		//header("Location:portal_patientList.php");
		?>
		<script>openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_patientList.php','currentPage=1','menu-content','',this)</script>
		<?php
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
}
else if (isset ( $_POST['search'] ))
{
	try
	{
		$msg = "";
		$paramArray = array();
		$searchInfo = new stdClass();
		$searchInfo->searchValues = explode(" ",$_REQUEST['searchStr']);
		$paramArray[0] = json_encode($searchInfo);
		$patientList = $entityUtil->getObjectFromServer($paramArray, "searchPatients", VMCPortalConstants::$API_EMR);
		$entityDetailInfos= $patientList->{entityDetailInfos};
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
}
else
{
	try
	{
		$msg = "";
		//$patientList = $emr->getPatientList(VMCPortalConstants::$API_EMR);
// 		$patientUtil = new PatientUtil();
		$checkChar = "";
		if($_REQUEST["checkChar"])
		{
			$checkChar = $_REQUEST["checkChar"];
		}
		else
		{
			$checkChar = "";
		}
		$paramArray = array();
		$paramArray[0] = $checkChar;
		$patientList = $entityUtil->getObjectFromServer($paramArray, "getPatients", VMCPortalConstants::$API_EMR);
		$entityDetailInfos= $patientList->{entityDetailInfos};
		$moveNext = $entityDetailInfos[4]->{nextPage};
		?><script>
		$("#nextButton").val('<?php echo $moveNext; ?>');
		</script>
		<?php
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
}
?>