<?php
	$entityUtil = new EntityUtil();
	$fetched = false;
if(isset($_POST['npiSearch']))
{
	try
	{
		foreach ($_POST['textinput'] as $key => $value)
		{
			if (empty($value))
			{
				unset($_POST['textinput'][$key]);
			}
		}
		$npiId = $_POST['textinput'];
		$setNPI = array_values($npiId);
		$paramArray[0] = json_encode($setNPI) ;
		$paramArray[1] = true ;
		$npiDetail = $entityUtil->getObjectFromServer($paramArray, "getNpiInfo", VMCPortalConstants::$API_EMR);
		
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
}

?>