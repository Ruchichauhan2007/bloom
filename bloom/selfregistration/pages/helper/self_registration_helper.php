<?php
include '../../../common/util/APIUtil.php';
include '../../../common/util/DateUtil.php';
include '../../../common/classes/PatientUtil.php';
include '../../../common/classes/EntityUtil.php';
//include ('../set_status.php');
include '../../../common/util/VMCAppResource.php';
include '../../../common/util/VMCPortalConstants.php';
include '../../../common/util/Constants.php';
$entityUtil = new EntityUtil();
$patientRegInfo = new stdClass;
$msg = "";
if (isset ( $_POST['submit'] )) {
	$page_error = "Self Registration";

	try {
		
		if($_POST ["patientRegId"] != "" and $_POST ["patientRegId"] > 0)
		{
			$paramArray = array() ;
			$paramArray[0] = $_POST ["patientRegId"];
			$patientRegInfo = $entityUtil->postDataToregisterPatient($_POST ["employer"], "findPatientRegistrationById",$paramArray, VMCPortalConstants::$API_EMR);
			$patientRegInfo->state = VMCPortalConstants::$UPDATE;
		}
		else
		{
			$patientRegInfo->state = VMCPortalConstants::$INSERT;
		}
	
		// Set address in AddressInfo
		$patientRegInfo->firstName =  $_POST ["firstName"] ;
		$patientRegInfo->middleInitial = $_POST ["middle"] ;
		$patientRegInfo->lastName = $_POST ["lastName"] ;
		$patientRegInfo->phoneNumber = $_POST ["phone"] ;
		$patientRegInfo->emailAddress = $_POST ["email"] ;
		$patientRegInfo->employerName = $_POST ["employer"] ;
		$patientRegInfo->userName = $_POST ["username"];
		if(($_POST ["password"] != "*********") AND $_POST ["password"] != "")
		{
			$patientRegInfo->password = $_POST ["password"] ;
		}
		else
		{
			$patientRegInfo->password = $_POST ["oldpassword"] ;
		}
		$dob = $_POST["dob"];
		
		$pos = strpos($dob, "/");

		if($pos === FALSE)
		{
			$dateArray = explode("-", $dob);
		}
		else
		{
			$dateArray = explode("/", $dob);
		}

		$dob = $dateArray[2]."-".$dateArray[0]."-".$dateArray[1];
		$calendarDob  = new DateTime($dob);
		$calendarDob = $calendarDob->format('Y-m-d\TH:i:s.\0\0\0O\Z');

		$patientRegInfo->dob = $calendarDob;
		$paramArray = array();
		$paramArray[0] = json_encode($patientRegInfo);
		$retPatientInfo = $entityUtil->postDataToregisterPatient( $_POST ["employer"] ,"createUpdatePatientRegistration", $paramArray ,VMCPortalConstants::$API_EMR);
		$retValue = $retPatientInfo->{patientRegistrationId};
		$retPatientId = $retPatientInfo->{patientId};
		$employerName = $_POST ["employer"];
		$requestScheme = "http://";
		if(!empty($_SERVER['HTTPS']))
		{
			$requestScheme = "https://";
		}
	?>
	<script>
		$(document).ready(function(){
			postDataToins();
			localStorage.clear();
		});
		function postDataToins()
		{
		   var form = document.createElement("form");
			   document.body.appendChild(form);
			   form.method = "POST";
			   form.action = "<?php echo $requestScheme.$employerName?>/gladstone/portal/bloom/selfregistration/pages/self_registration_insurance.php";
			   var element1 = document.createElement("INPUT");
			    element1.name="employerName"
			    element1.value = '<?php echo $_POST ["employer"];?>';
			    element1.type = 'hidden'
			    form.appendChild(element1);
			    var element2 = document.createElement("INPUT");
			    element2.name="patientRegistrationId"
			    element2.value = '<?php echo $retValue;?>';
			    element2.type = 'hidden'
			    form.appendChild(element2);
			    // var element3 = document.createElement("INPUT");
			    // element3.name="patientRegistrationInfo"
			    // element3.value = '<?php echo $_POST ["firstName"]."=".$_POST ["lastName"]."=".$_POST ["phone"]."=".$_POST ["email"]."=". $_POST["dob"]?>';
			    // element3.type = 'hidden'
			    // form.appendChild(element3);
			    var element4 = document.createElement("INPUT");
			    element4.name="employer"
			    element4.value = '<?php echo $_POST ["employerName"]?>';
			    element4.type = 'hidden'
			    form.appendChild(element4);
				var element5 = document.createElement("INPUT");
			    element5.name="existingPatId"
			    element5.value = '<?php echo $retPatientId; ?>';
			    element5.type = 'hidden'
			    form.appendChild(element5);
			    form.submit();
			}
	</script>
	<?php
	} catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
}


?>
