<?php
include '../../common/util/APIUtil.php';
include '../../common/classes/EntityUtil.php';
include '../../common/util/VMCAppResource.php';
include '../../common/util/VMCPortalConstants.php';
include '../../common/util/Constants.php';

$entityUtil = new EntityUtil();

$apiUtil = new APIUtil();

$paramArray = array();

$patientDetail = file_get_contents('php://input'); //"Test,Test1,Test2,Test3,Test4,Test5,Test6";

apiUtil->logError($patientDetail);

$paramArray[0] = $_SERVER['SERVER_NAME'];
$paramArray[1] = json_decode($patientDetail);

$retVal = $entityUtil->getObjectFromServer($paramArray, "createGoodlifeVitalData", VMCPortalConstants::$API_EMR);
echo $retVal;
?>