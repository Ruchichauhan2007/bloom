<?php
include('../../common/util/CardFactory.php');
//include ('controller/portal_patientList_controller.php');

$patientList = $_POST["patList"];
$retVal =  addPatientsCards($entityDetailInfos, $patientList, FALSE);
echo $retVal;
?>
