<?php 
	// auth url
	include 'controller/portal_addPatient_controller.php';
	
	$patientId=$_REQUEST['patientId'];
	try 
  	{
	$entityUtil = new EntityUtil();
  	$paramArray[0] = $patientId;
	$authUrl = $entityUtil->getObjectFromServer($paramArray, "generateAuthenticationUrl", VMCPortalConstants::$API_ADMIN);
	}
	catch ( Exception $e )
	{
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
	if($authUrl != "")
	{
?>
<p>Registration email has been sent successfully.</p>
<?php }
else
{
echo $msg;
}
?>

