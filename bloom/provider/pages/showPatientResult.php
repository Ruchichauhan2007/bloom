<?php
include('controller/pending_fax_controller.php');
$entityUtil = new EntityUtil();
$faxId = $_REQUEST['faxId'];

if (isset ( $_POST['searchStr'] ))
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
		//var_dump($entityDetailInfos);
		
		
	   echo  showPatientResult($entityDetailInfos); 		
	
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
}

if (isset ( $_POST['attach'] ))
{

	try
	{
		$patientId=$_POST['faxPID'];
		$entityUtil = new EntityUtil();
		$getAllPendingFaxes = $entityUtil->getObjectFromServer("BLANK", "getAllPendingFaxes", VMCPortalConstants::$API_EMR);
		
		
			foreach($getAllPendingFaxes as $getPendingFaxes)
		   {
		   	
				if($getPendingFaxes->{patientFaxId} == $faxId)
				{
				
					
					$getPendingFaxes->patientFaxId = $faxId;
					$getPendingFaxes->state = VMCPortalConstants::$UPDATE;
					$getPendingFaxes->patientId = $patientId ;
					$paramArray = array();
					$paramArray[0] = json_encode($getPendingFaxes);
					$retPendingFaxes = $entityUtil->postObjectToServer($paramArray, "createUpdatePatientFax", VMCPortalConstants::$API_EMR);
					
				}
			
		}


	
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
}

?>
<script>
$(document).ready(function()
{
$("#npiNameAttach").attr("disabled","disabled");
var faxPatientId = $("#faxPatientId").val();
 $("#faxPID").val(faxPatientId);
 $("#faxId").val('<?php echo $faxId;?>');
 $("#faxIds").val('<?php echo $faxId;?>');


});
</script>