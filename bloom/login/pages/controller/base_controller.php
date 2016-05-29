<?php
//import com.vmc.core.api.AdminPortalWrapper;
include '../../common/util/APIUtil.php';
include '../../common/classes/EntityUtil.php';
include '../../common/classes/ProviderUtil.php';
include '../../common/classes/PatientUtil.php';
//include ('../../common/pages/set_status.php');
include '../../common/util/VMCAppResource.php';
include '../../common/util/VMCPortalConstants.php';

if($_COOKIE['status'])
{
	$status = $_COOKIE['status'];
	
	if($status == "UN" or $status == "" or $status == null)
	{
		$msg = "Please login again.";
		header("Location:../../login/pages/login_userName.php");
	}
}
 

?>
